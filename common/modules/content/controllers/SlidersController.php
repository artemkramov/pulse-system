<?php

namespace common\modules\content\controllers;

use backend\controllers\CRUDController;
use backend\models\Slider;
use backend\models\search\SliderSearch;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

/**
 * SlidersController implements the CRUD actions for Slider model.
 */
class SlidersController extends CRUDController
{

    /**
     * Init bean class
     */
    public function init()
    {
        $this->beanClass = Slider::className();
        $this->beanSearchClass = SliderSearch::className();
        parent::init();
    }

    /**
     * Ajax validation of the Slider
     * Return JSON Response
     * @param null $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionValidate($id = null)
    {
        $beanClass = $this->beanClass;
        $model = new $beanClass();
        if (isset($id)) {
            $model = $this->findModel($id);
        }
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $errors = ActiveForm::validate($model);
            return $errors;
        }
    }


}
