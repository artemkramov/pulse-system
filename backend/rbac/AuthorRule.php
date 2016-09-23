<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/26/16
 * Time: 5:12 PM
 */

namespace app\rbac;


use backend\components\AccessHelper;
use backend\models\Customer;
use common\models\User;
use yii\rbac\Rule;

class AuthorRule extends Rule
{

    public $name = 'isAuthor';

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
        $accessHelper = new AccessHelper();
        return $accessHelper->checkUserAccessBean($params['bean'], 'customer_id');
    }

}