<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/2/16
 * Time: 4:21 PM
 */

namespace app\rbac;


use backend\components\AccessHelper;
use common\models\User;
use yii\rbac\Rule;

class ItselfRule extends Rule
{

    public $name = 'isItself';

    /**
     * @param int|string $user
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (User::isAdmin()) {
            return true;
        }
        if (!array_key_exists('check', $params)) return true;
        $accessHelper = new AccessHelper();
        return $accessHelper->checkUserAccessBean($params['bean'], 'id');
    }

}