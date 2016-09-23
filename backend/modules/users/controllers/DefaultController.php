<?php

namespace backend\modules\users\controllers;

use yii\web\Controller;

class DefaultController extends \backend\controllers\AuthController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
