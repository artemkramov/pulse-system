<?php

namespace backend\modules\settings\controllers;

use backend\controllers\CRUDController;
use Yii;
use common\models\Setting;
use common\models\Search\SettingSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for Setting model.
 */
class SettingsController extends CRUDController
{

    /**
     * Init bean class
     */
    public function init()
    {
        $this->beanClass = Setting::className();
        $this->beanSearchClass = SettingSearch::className();
        parent::init();
    }

    /**
     * @param array $extraParams
     * @throws ForbiddenHttpException
     * @return null
     */
    public function actionCreate($extraParams = [])
    {
        throw new ForbiddenHttpException();
    }

    /**
     * @param $id
     * @param bool $returnModel
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id, $returnModel = false)
    {
        throw new ForbiddenHttpException();
    }

}
