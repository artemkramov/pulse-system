<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/16/16
 * Time: 11:41 AM
 */

namespace app\rbac;


use backend\components\AccessHelper;
use common\models\User;
use yii\rbac\Rule;

class AuthorManyToManyRule extends Rule
{
    public $name = 'isAuthorManyToMany';

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
        return $accessHelper->checkUserAccessManyToMany($params['bean'], $params['extraAccessParams']);
    }

}