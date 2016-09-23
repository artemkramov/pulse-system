<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/16/16
 * Time: 3:53 PM
 */

namespace common\models;


use common\components\MultilingualQuery;
use common\components\TimeDate;
use common\modules\i18n\Module;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Bean extends ActiveRecord
{

    /**
     * @var array
     */
    protected $multiLanguageFields = [];

    /**
     * @var null|array
     */
    private static $records = null;

    /**
     * @return array
     */
    public function getMultiLanguageFields()
    {
        return $this->multiLanguageFields;
    }

    /**
     * Method for automatic translation of the field labels
     * @return array
     */
    public function attributeLabels()
    {
        $fields = $this->getAttributes();
        $labels = [];
        foreach ($fields as $fieldName => $value) {
            $formattedField = ucfirst(str_replace('_', '', $fieldName));
            $labels[] = Module::t($formattedField);
        }
        return $labels;
    }

    /**
     * Extend to handle date fields
     * @param bool $runValidation
     * @param null $attributeNames
     * @param bool $ignoreDate
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function save($runValidation = true, $attributeNames = null, $ignoreDate = false)
    {
        $fields = $this->getTableSchema()->columns;
        foreach ($fields as $fieldName => $field) {
            if ($field->type == 'date' && !$ignoreDate) {
                $this->$fieldName = TimeDate::convertToDB($this->$fieldName);
            }
        }
        return parent::save($runValidation, $attributeNames);
    }

    /**
     * Extend this method to change automatically the date display
     * @param mixed $condition
     * @return ActiveRecord
     */
    public static function findOne($condition)
    {
        $bean = parent::findOne($condition);
        if (isset($bean) && is_object($bean)) {
            $fields = $bean->getTableSchema()->columns;
            foreach ($fields as $fieldName => $field) {
                if ($field->type == 'date') {
                    $bean->$fieldName = TimeDate::convertFromDB($bean->$fieldName);
                }
            }
        }
        return $bean;
    }

    /**
     * Method which bundles the related entity from the POST data
     * @param string $className
     * @param array $postData
     * @return array
     */
    protected function bundleMultipleBean($className, $postData)
    {
        $items = [];
        $attributes = [];
        foreach ($postData as $fieldName => $fieldData) {
            $attributes[] = $fieldName;
            foreach ($fieldData as $key => $fieldValue) {
                if (!array_key_exists($key, $items)) {
                    $items[$key] = new $className();
                }
                $items[$key]->$fieldName = $fieldValue;
            }
        }
        return [
            'items'      => $items,
            'attributes' => $attributes
        ];
    }

    /**
     * Email validation.
     *
     * @param $attribute
     * @param $params
     */
    public function validateRelatedBeans($attribute, $params)
    {
        $postData = \Yii::$app->request->post();
        $shortClassName = (new \ReflectionClass($this))->getShortName();
        if (array_key_exists($shortClassName, $postData) && array_key_exists($attribute, $postData[$shortClassName])) {
            $postDataItems = $postData[$shortClassName][$attribute];
            $data = $this->bundleMultipleBean($params['beanClass'], $postDataItems);
            $relatedField = $params['beanRelatedField'];
            foreach ($data['items'] as $key => $bean) {
                if (!empty($relatedField)) {
                    $bean->$relatedField = $this->id;
                }
                foreach ($data['attributes'] as $fieldName) {
                    if (!$bean->validate()) {
                        $fieldKey = $attribute . '[' . $fieldName . '][' . $key . ']';
                        if (array_key_exists($fieldName, $bean->errors)) {
                            $this->addError($fieldKey, $bean->errors[$fieldName][0]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Method for forming of dropdown list to the form
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return mixed
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }
        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * @param $property
     * @param string $fieldName
     * @return string
     */
    public function showManyToMany($property, $fieldName = "name")
    {
        $collection = [];
        foreach ($this->{$property} as $item) {
            $collection[] = $item->{$fieldName};
        }
        return implode(', ', $collection);
    }

    /**
     * @return array
     */
    public function formMultiLanguageFields()
    {
        $response = [];
        foreach ($this->multiLanguageFields as $field) {
            $response[$field] = [];
            foreach (Lang::getLanguages() as $language) {
                $response[$field][] = self::getMultiAttributeName($field, $language->url);
            }
        }
        return $response;
    }

    /**
     * @param $attribute
     * @param $languageUrl
     * @return string
     */
    public static function getMultiAttributeName($attribute, $languageUrl)
    {
        if ($languageUrl == Lang::getDefaultLang()->url) {
            return $attribute;
        }
        return $attribute . '_' . $languageUrl;
    }

    /**
     * @return MultilingualQuery
     */
    public static function find()
    {
        $className = get_called_class();
        /**
         * @var Bean $row
         */
        $row = new $className();
        $query = new MultilingualQuery(get_called_class());
        if (!empty($row->getMultiLanguageFields())) {
            $query->localized(Lang::getCurrent()->url);
        }
        return $query;
    }

    /**
     * @param array $labels
     * @return array
     */
    public function formMultilingualLabels($labels)
    {
        foreach ($this->multiLanguageFields as $field) {
            foreach (Lang::getLanguages() as $language) {
                $labels[self::getMultiAttributeName($field, $language->url)] = $labels[$field] . '(' . $language->name . ')';
            }
        }
        return $labels;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findAllLocalized()
    {
        $query = self::find()->localized(Lang::getCurrent()->url);
        return $query->all();
    }

    /**
     * @param string $id
     * @param string $field
     * @return array
     */
    public static function listAllLocalized($id = 'id', $field = 'title')
    {
        $response = [];
        $collection = self::findAllLocalized();
        foreach ($collection as $item) {
            $response[$item->{$id}] = $item->{$field};
        }
        return $response;
    }

    /**
     * @param string $jsonTree
     */
    public static function saveSortPositions($jsonTree)
    {
        $collection = json_decode($jsonTree);
        if (is_array($collection)) {
            foreach ($collection as $key => $item) {
                $socialLink = self::findOne($item->id);
                $socialLink->sort = $key;
                $socialLink->save();
            }
        }
    }

    /**
     * @param int $excludeID
     * @param $type
     * @return array
     */
    public static function findAllWithTitle($excludeID, $type = null)
    {
        $query = self::find()->localized(Lang::getCurrent()->url);
        if (isset($excludeID)) {
            $query = $query->where(['!=', 'id', $excludeID]);
        }
        if (isset($type)) {
            $query = $query->andWhere([
                'menu_type_id' => $type
            ]);
        }
        return $query->orderBy('sort')->all();
    }

    /**
     * Save menu data by the given collection
     * @param array $collection
     * @param null|integer $parentID
     */
    public static function saveTree($collection, $parentID = null)
    {
        foreach ($collection as $key => $item) {
            $menuItem = self::findOne($item->id);
            $menuItem->sort = $key;
            $menuItem->parent_id = $parentID;
            $menuItem->save();
            if (isset($item->children) && !empty($item->children)) {
                self::saveTree($item->children, $item->id);
            }
        }
    }

    /**
     * Save the menu structure based on the JSON string
     * @param string $jsonTree
     */
    public static function saveSortData($jsonTree)
    {
        $collection = json_decode($jsonTree);
        if (is_array($collection)) {
            self::saveTree($collection);
        }
    }

    /**
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public static function getAllRecords()
    {
        if (!isset(self::$records)) {
            self::$records = self::find()->all();
        }
        return self::$records;
    }


}