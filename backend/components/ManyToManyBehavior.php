<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/2/16
 * Time: 11:35 AM
 */

namespace backend\components;


use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\ErrorException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * Many to many relation behavior
 * Was copied from the following project https://github.com/voskobovich/yii2-many-to-many-behavior
 * Extended to rewrite the saving mechanism (to avoid deleting at each time)
 * */
class ManyToManyBehavior extends Behavior
{
    /**
     * Stores a list of relations, affected by the behavior. Configurable property.
     * @var array
     */
    public $relations = [];

    /**
     * Stores values of relation attributes. All entries in this array are considered
     * dirty (changed) attributes and will be saved in saveRelations().
     * @var array
     */
    private $_values = [];

    /**
     * Used to store fields that this behavior creates. Each field refers to a relation
     * and has optional getters and setters.
     * @var array
     */
    private $_fields = [];

    /**
     * Events list
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveRelations',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveRelations',
        ];
    }

    /**
     * Invokes init of parent class and assigns proper values to internal _fields variable
     */
    public function init()
    {
        parent::init();

        //configure _fields
        foreach ($this->relations as $attributeName => $params) {

            //add primary field
            $this->_fields[$attributeName] = [
                'attribute' => $attributeName,
            ];
            if (isset($params['get'])) {
                $this->_fields[$attributeName]['get'] = $params['get'];
            }
            if (isset($params['set'])) {
                $this->_fields[$attributeName]['set'] = $params['set'];
            }

            //add secondary fields
            if (isset($params['fields'])) {
                foreach ($params['fields'] as $fieldName => $params) {
                    $fullFieldName = $attributeName . '_' . $fieldName;
                    if (isset($this->_fields[$fullFieldName])) {
                        throw new ErrorException("Ambiguous field name definition: {$fullFieldName}");
                    }

                    $this->_fields[$fullFieldName] = [
                        'attribute' => $attributeName,
                    ];
                    if (isset($params['get'])) {
                        $this->_fields[$fullFieldName]['get'] = $params['get'];
                    }
                    if (isset($params['set'])) {
                        $this->_fields[$fullFieldName]['set'] = $params['set'];
                    }
                }
            }
        }
    }

    /**
     * Save all dirty (changed) relation values ($this->_values) to the database
     * @param $event
     * @throws ErrorException
     * @throws Exception
     */
    public function saveRelations($event)
    {
        /**
         * @var $primaryModel \yii\db\ActiveRecord
         */
        $primaryModel = $this->owner;

        if (is_array($primaryModelPk = $primaryModel->getPrimaryKey())) {
            throw new ErrorException("This behavior does not support composite primary keys");
        }

        // Save relations data
        foreach ($this->relations as $attributeName => $params) {

            $relationName = $this->getRelationName($attributeName);
            $relation = $primaryModel->getRelation($relationName);

            if (!$this->hasNewValue($attributeName)) {
                continue;
            }

            $newValue = $this->getNewValue($attributeName);

            $bindingKeys = $newValue;

            // many-to-many
            if (!empty($relation->via) && $relation->multiple) {

                //Assuming junction column is visible from the primary model connection
                if (is_array($relation->via)) {
                    //via()
                    $via = $relation->via[1];
                    $junctionModelClass = $via->modelClass;
                    $junctionTable = $junctionModelClass::tableName();
                    list($junctionColumn) = array_keys($via->link);
                } else {
                    //viaTable()
                    list($junctionTable) = array_values($relation->via->from);
                    list($junctionColumn) = array_keys($relation->via->link);
                }
                list($relatedColumn) = array_values($relation->link);

                $connection = $primaryModel::getDb();
                $transaction = $connection->beginTransaction();

                try {
                    //Get old relations
                    $sql = "SELECT * FROM " . $junctionTable . " WHERE " . $junctionColumn . "=:modelID";
                    $oldRelations = ArrayHelper::getColumn($connection->createCommand($sql)
                        ->bindValue(':modelID', $primaryModelPk)
                        ->queryAll(), 'id');


                    $viaTableParams = $this->getViaTableParams($attributeName);
                    if (!empty($bindingKeys)) {
                        $junctionRows = [];
                        foreach ($bindingKeys as $relatedPk) {
                            $sqlRow = "SELECT * FROM " . $junctionTable . " WHERE " . $junctionColumn . "=:modelID AND
                                " . $relatedColumn . "=:relatedID";
                            $rowExists = $connection->createCommand($sqlRow)
                                ->bindValue(':modelID', $primaryModelPk)
                                ->bindValue(':relatedID', $relatedPk)
                                ->queryOne();
                            if (empty($rowExists)) {
                                $row = [$primaryModelPk, $relatedPk];
                                // calculate additional viaTable values
                                foreach (array_keys($viaTableParams) as $viaTableColumn) {
                                    $row[] = $this->getViaTableValue($attributeName, $viaTableColumn, $relatedPk);
                                }
                                array_push($junctionRows, $row);
                            } else {
                                if (($key = array_search($rowExists['id'], $oldRelations)) !== false) {
                                    unset($oldRelations[$key]);
                                }
                            }
                        }
                        $cols = [$junctionColumn, $relatedColumn];

                        // additional viaTable columns
                        foreach (array_keys($viaTableParams) as $viaTableColumn) {
                            $cols[] = $viaTableColumn;
                        }

                        if (!empty($junctionRows)) {
                            $connection->createCommand()
                                ->batchInsert($junctionTable, $cols, $junctionRows)
                                ->execute();
                        }


                    }
                    foreach ($oldRelations as $relationId) {
                        $connection->createCommand()
                            ->delete($junctionTable, [
                                'id' => $relationId
                            ])
                            ->execute();
                    }
                    $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollback();
                    throw $ex;
                }

                // one-to-many on the many side
            } elseif (!empty($relation->link) && $relation->multiple) {

                //HasMany, primary model HAS MANY foreign models, must update foreign model table
                $foreignModel = new $relation->modelClass();
                $manyTable = $foreignModel->tableName();
                list($manyTableFkColumn) = array_keys($relation->link);
                $manyTableFkValue = $primaryModelPk;
                list($manyTablePkColumn) = ($foreignModel->primaryKey());

                $connection = $foreignModel::getDb();
                $transaction = $connection->beginTransaction();

                $defaultValue = $this->getDefaultValue($attributeName);

                try {
                    // Remove old relations
                    $connection->createCommand()
                        ->update(
                            $manyTable,
                            [$manyTableFkColumn => $defaultValue],
                            [$manyTableFkColumn => $manyTableFkValue])
                        ->execute();

                    // Write new relations
                    if (!empty($bindingKeys)) {
                        $connection->createCommand()
                            ->update(
                                $manyTable,
                                [$manyTableFkColumn => $manyTableFkValue],
                                ['in', $manyTablePkColumn, $bindingKeys])
                            ->execute();
                    }
                    $transaction->commit();
                } catch (Exception $ex) {
                    $transaction->rollback();
                    throw $ex;
                }

            } else {
                throw new ErrorException('Relationship type not supported.');
            }
        }
    }

    /**
     * Get name of a relation
     * @param string $attributeName
     * @return null
     */
    private function getRelationName($attributeName)
    {
        $params = $this->getRelationParams($attributeName);

        if (is_string($params)) {
            return $params;
        } elseif (is_array($params) && !empty($params[0])) {
            return $params[0];
        }

        return null;
    }

    /**
     * Get parameters of a relation
     * @param string $attributeName
     * @return mixed
     * @throws ErrorException
     */
    private function getRelationParams($attributeName)
    {
        if (empty($this->relations[$attributeName])) {
            throw new ErrorException("Parameter \"{$attributeName}\" does not exist");
        }

        return $this->relations[$attributeName];
    }

    /**
     * Check if an attribute is dirty and must be saved (its new value exists)
     * @param string $attributeName
     * @return null
     */
    private function hasNewValue($attributeName)
    {
        return isset($this->_values[$attributeName]);
    }

    /**
     * Get value of a dirty attribute by name
     * @param string $attributeName
     * @return null
     */
    private function getNewValue($attributeName)
    {
        return $this->_values[$attributeName];
    }

    /**
     * Get additional parameters of viaTable
     * @param string $attributeName
     * @return array
     */
    private function getViaTableParams($attributeName)
    {
        $params = $this->getRelationParams($attributeName);
        return isset($params['viaTableValues']) ? $params['viaTableValues'] : [];
    }

    /**
     * Calculate additional value of viaTable
     * @param string $attributeName
     * @param string $viaTableAttribute
     * @param integer $relatedPk
     * @return mixed
     */
    private function getViaTableValue($attributeName, $viaTableAttribute, $relatedPk)
    {
        $viaTableParams = $this->getViaTableParams($attributeName);

        if (!isset($viaTableParams[$viaTableAttribute])) {
            return null;
        } elseif ($viaTableParams[$viaTableAttribute] instanceof \Closure) {
            $closure = $viaTableParams[$viaTableAttribute];
            $relationName = $this->getRelationName($attributeName);
            return call_user_func($closure, $this->owner, $relationName, $attributeName, $relatedPk);
        }

        return $viaTableParams[$viaTableAttribute];
    }

    /**
     * Get default value for an attribute (used for 1-N relations)
     * @param string $attributeName
     * @return mixed
     */
    private function getDefaultValue($attributeName)
    {
        $relationParams = $this->getRelationParams($attributeName);
        if (!isset($relationParams['default'])) {
            return null;
        } elseif ($relationParams['default'] instanceof \Closure) {
            $function = $relationParams['default'];
            $relationName = $this->getRelationName($attributeName);
            return call_user_func($function, $this->owner, $relationName, $attributeName);
        } else {
            return $relationParams['default'];
        }
    }

    /**
     * Returns a value indicating whether a property can be read.
     * We return true if it is one of our properties and pass the
     * params on to the parent class otherwise.
     * TODO: Make it honor $checkVars ??
     *
     * @param string $name the property name
     * @param boolean $checkVars whether to treat member variables as properties
     * @return boolean whether the property can be read
     * @see canSetProperty()
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return array_key_exists($name, $this->_fields) ?
            true : parent::canGetProperty($name, $checkVars);
    }

    /**
     * Returns a value indicating whether a property can be set.
     * We return true if it is one of our properties and pass the
     * params on to the parent class otherwise.
     * TODO: Make it honor $checkVars and $checkBehaviors ??
     *
     * @param string $name the property name
     * @param boolean $checkVars whether to treat member variables as properties
     * @param boolean $checkBehaviors whether to treat behaviors' properties as properties of this component
     * @return boolean whether the property can be written
     * @see canGetProperty()
     */
    public function canSetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        return array_key_exists($name, $this->_fields) ?
            true : parent::canSetProperty($name, $checkVars, $checkBehaviors);
    }

    /**
     * Returns the value of an object property.
     * Get it from our local temporary variable if we have it,
     * get if from DB otherwise.
     *
     * @param string $name the property name
     * @return mixed the property value
     * @see __set()
     */
    public function __get($name)
    {
        $fieldParams = $this->getFieldParams($name);
        $attributeName = $fieldParams['attribute'];

        $relationName = $this->getRelationName($attributeName);

        if ($this->hasNewValue($attributeName)) {
            $value = $this->getNewValue($attributeName);
        } else {
            $relation = $this->owner->getRelation($relationName);
            $foreignModel = new $relation->modelClass();
            $value = $relation->select($foreignModel->getPrimaryKey())->column();
        }

        if (empty($fieldParams['get'])) {
            return $value;
        } else {
            return $this->callUserFunction($fieldParams['get'], $value);
        }
    }

    /**
     * Sets the value of a component property. The data is passed
     *
     * @param string $name the property name or the event name
     * @param mixed $value the property value
     * @see __get()
     */
    public function __set($name, $value)
    {
        $fieldParams = $this->getFieldParams($name);
        $attributeName = $fieldParams['attribute'];

        if (!empty($fieldParams['set'])) {
            $this->_values[$attributeName] = $this->callUserFunction($fieldParams['set'], $value);
        } else {
            $this->_values[$attributeName] = $value;
        }
    }

    /**
     * Get parameters of a field
     * @param string $fieldName
     * @return mixed
     * @throws ErrorException
     */
    private function getFieldParams($fieldName)
    {
        if (empty($this->_fields[$fieldName])) {
            throw new ErrorException("Parameter \"{$fieldName}\" does not exist");
        }

        return $this->_fields[$fieldName];
    }

    /**
     * Call user function
     * @param $function
     * @param $value
     * @return mixed
     * @throws ErrorException
     */
    private function callUserFunction($function, $value)
    {
        if (!is_array($function) && !$function instanceof \Closure) {
            throw new ErrorException("This value is not a function");
        }

        return call_user_func($function, $value);
    }

    /**
     * Get custom condition used to delete old records.
     * @param string $attributeName
     * @return array
     */
    private function getCustomDeleteCondition($attributeName)
    {
        $params = $this->getRelationParams($attributeName);
        return isset($params['customDeleteCondition']) ? $params['customDeleteCondition'] : [];
    }

}