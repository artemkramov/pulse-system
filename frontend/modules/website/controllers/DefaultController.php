<?php

namespace frontend\modules\website\controllers;

use backend\models\Country;
use common\models\Lang;
use common\models\User;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `website` module
 */
class DefaultController extends Controller
{

    /**
     * Disable CSRF validation
     */
    public function init()
    {
        $this->enableCsrfValidation = false;
        parent::init();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionGetCountries()
    {
        $countries = Country::find()->all();
        return $this->renderPartial('countries', [
            'countries' => $countries,
        ]);
    }

    /**
     * @return string
     */
    public function actionGetLanguages()
    {
        $languages = Lang::find()->where(
            ['!=', 'id', Lang::getCurrent()->id]
        )->all();
        return $this->renderPartial('languages', [
            'languages' => $languages
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionChangeCountry()
    {
        $postData = \Yii::$app->request->post();
        if (!empty($postData) && array_key_exists('selCountry', $postData)) {
            User::setCurrentCountry($postData['selCountry']);
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionChangeLanguage()
    {
        $postData = \Yii::$app->request->post();
        if (!empty($postData) && array_key_exists('selLanguage', $postData) && array_key_exists('pathInfo', $postData)) {
            $path = '/' . $postData['selLanguage'] . '/' . $postData['pathInfo'];
            return $this->redirect($path);
        }
    }
}
