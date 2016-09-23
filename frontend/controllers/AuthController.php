<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/18/2016
 * Time: 5:53 PM
 */

namespace frontend\controllers;

use common\models\Lang;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class AuthController
 * @package frontend\controllers
 */
class AuthController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $route = '/' . Lang::getCurrent()->url . '/cabinet/default/login';
                    $this->redirect(Url::to($route));
                },
                'except' => ['login', 'signup', 'request-password-reset', 'reset-password', 'logout']
            ]
        ];
        return $behaviors;
    }
}