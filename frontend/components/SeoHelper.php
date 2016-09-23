<?php

namespace frontend\components;
use backend\models\Category;
use backend\models\Product;
use common\models\Magazine;
use common\models\Order;
use common\models\Setting;
use common\modules\i18n\Module;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * Class SeoHelper
 * @package frontend\components
 * Helper for the setting of the SEO features
 */
class SeoHelper
{

    /**
     * Setting of the title based on the type of the given bean
     * @param $viewData
     * @param $extraData
     * @param $model
     */
    public static function setTitle($viewData, $extraData, $model)
    {
        if (!array_key_exists('type', $extraData)) {
            throw new Exception("Please provide the type of the breadcrumb");
        }
        $actionName = "handle" . ucfirst($extraData['type']);
        if (!method_exists(__CLASS__, $actionName)) {
            throw new Exception("No such method {$actionName} in the helper");
        }
        self::$actionName($viewData, $extraData, $model);
    }

    /**
     * Set SEO data for the posts
     * @param View $viewData
     * @param $extraData
     * @param $post
     */
    private static function handlePost($viewData, $extraData, $post)
    {
        $viewData->title = $post->title . ' : ' . \Yii::$app->name;
    }

    /**
     * @param $viewData
     * @param $extraData
     * @param $product
     */
    private static function handleAccount($viewData, $extraData, $product)
    {
        $viewData->title = Module::t('Profile') . ' : ' . \Yii::$app->name;
    }

    /**
     * @param $viewData
     * @param $extraData
     * @param $collection
     */
    private static function handleSearch($viewData, $extraData, $collection)
    {
        $viewData->title = Module::t('Search') . ' : ' . \Yii::$app->name;
    }

}