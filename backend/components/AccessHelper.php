<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/2/16
 * Time: 3:11 PM
 */

namespace backend\components;


use backend\models\Customer;
use backend\models\Manager;
use common\models\Bean;
use common\models\User;
use yii\db\Query;

/**
 * Class for helping in access management
 * It filters data on selecting data
 * @author Artem Kramov
 * */
class AccessHelper
{

    private $filterRoles;

    public function __construct()
    {
        $this->filterRoles = [];
    }

    /**
     * @param $query
     * @param array $params
     */
    public function filterSearchMultiple($query, $params = [])
    {
        if (!User::isAdmin()) {
            $query->join('inner join', $params['viaTable'], $params['primaryTable'] . '.id = ' . $params['primaryField']);
            $query->andWhere(['in', $params['viaTable'] . '.' . $params['relateField'], $this->getFilter()]);
        }
    }

    /**
     * @param $query
     * @param array $params
     */
    public function filterSearchSingle($query, $params = [])
    {
        if (!User::isAdmin()) {
            $query->andWhere(['in', $params['field'], $this->getFilter()]);
        }
    }

    /**
     * @return array
     */
    public function getFilter()
    {
        $role = $this->getUserType();
        $bean = $this->getUserData();
        $possibleIds = [];
        switch ($role) {
            case 'customer':
                $possibleIds[] = $bean->id;
                break;
            case 'manager':
                foreach ($bean->customers as $customer) {
                    $possibleIds[] = $customer->id;
                }
                break;
            default:
                $possibleIds[] = -1;
                break;
        }
        return $possibleIds;
    }

    /**
     * @param Bean $bean
     * @param string $fieldName
     * @return bool
     */
    public function checkUserAccessBean($bean, $fieldName = 'customer_id')
    {
        $possibleIds = $this->getFilter();
        foreach ($possibleIds as $id) {
            if ($bean->{$fieldName} == $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $bean
     * @param $params
     * @return bool
     */
    public function checkUserAccessManyToMany($bean, $params)
    {
        $query = (new Query())
            ->select('*')
            ->from($params['viaTable'])
            ->where([$params['primaryField'] => $bean->id])
            ->andWhere(['in', $params['relateField'], $this->getFilter()])
            ->all();
        return !empty($query);
    }

    /**
     * Get user extra data depends on it type
     * @return mixed
     */
    public function getUserData()
    {
        if (User::isAdmin()) {
            return \Yii::$app->user;
        }
        $current_user = \Yii::$app->user;
        $roleName = $this->getUserType();
        $className = $this->filterRoles[$roleName];
        $bean = $className::find(['user_id' => $current_user->id])->one();
        return $bean;
    }

    /**
     * @return bool|string
     */
    public function getUserType()
    {
        $current_user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($current_user->id);
        if (!User::isAdmin()) {
            foreach ($roles as $role) {
                if (array_key_exists($role->name, $this->filterRoles)) {
                    return $role->name;
                }
            }
        }
        return false;
    }

    /**
     * Form admin ulr based on the given action name
     * @param $action
     * @return string
     */
    public static function formPrimaryUrl($action)
    {
        return $action;
    }

    public static function formSortUrl($attribute)
    {

    }

}