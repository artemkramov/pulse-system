<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/1/2016
 * Time: 12:11 AM
 */

namespace backend\components;


use common\models\Lang;
use yii\web\UrlManager;

/**
 * Class UrlManagerExtend
 * @package backend\components
 * Extended UrlManager for admin purpose
 */
class UrlManagerExtend extends UrlManager
{

    /**
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        return \Yii::$app->request->hostInfo . '/' . Lang::getCurrent()->url . \Yii::$app->homeUrl . parent::createUrl($params);
        //return \Yii::$app->request->baseUrl .  parent::createUrl($params);
    }

}