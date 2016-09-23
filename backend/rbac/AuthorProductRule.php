<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/16/16
 * Time: 11:41 AM
 */

namespace app\rbac;


use backend\models\Customer;
use common\models\User;
use yii\rbac\Rule;

class AuthorProductRule extends Rule
{
    public $name = 'isAuthorProduct';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (User::isAdmin()) {
            return true;
        }
        if (!array_key_exists('check', $params)) return true;
        $current_user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($current_user->id);
        if (array_key_exists('customer', $roles)) {
            $customer = Customer::find()->where(['user_id'  =>  $current_user->id])->one();
            $isOwner = Customer::checkProductOwn($params['bean']->id, $customer->id);
            return $isOwner;
        }
        return false;
    }

}