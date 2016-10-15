<?php

namespace backend\modules\settings\controllers;

use backend\controllers\CRUDController;
use backend\models\HeartBeatRange;
use common\models\HeartBeatRate;
use common\modules\i18n\Module;
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

    public function actionHeartBeatRate()
    {
        $postData = Yii::$app->request->post();
        if (!empty($postData)) {
            HeartBeatRate::deleteAll();
            if (array_key_exists('data', $postData)) {
                foreach ($postData['data'] as $data) {
                    $rate = new HeartBeatRate();
                    $loadData = [
                        'HeartBeatRate' => $data
                    ];
                    if ($rate->load($loadData)) {
                        $rate->save();
                    }
                }
            }
            \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
            return $this->redirect(['heart-beat-rate']);
        }

        return $this->render('heart-beat-rate', [

        ]);
    }

}
