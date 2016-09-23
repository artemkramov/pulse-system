<?php

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/16/16
 * Time: 11:30 AM
 */

namespace common\components;

use yii\web\UrlManager;
use common\models\Lang;

/**
 * Class LangUrlManager
 * @package common\components
 */
class LangUrlManager extends UrlManager
{
    /**
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        if (isset($params['lang_id'])) {
            //If we have the ID of the lang that try to work with it
            //another work with default language
            $lang = Lang::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            //If the param isn't set then we work with current language
            $lang = Lang::getCurrent();
        }

        //Get formed URL (without language slug)
        $url = str_replace("*", "", parent::createUrl($params));
        //Add the prefix to that URL
        if ($url == '/') {
            return '/' . $lang->url;
        } else {
            return '/' . $lang->url . $url;
        }
    }

}