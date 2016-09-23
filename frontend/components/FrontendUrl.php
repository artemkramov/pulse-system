<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/6/2016
 * Time: 3:17 PM
 */

namespace frontend\components;


use common\models\Lang;
use yii\helpers\Url;

/**
 * Class FrontendUrl
 * @package frontend\components
 */
class FrontendUrl extends Url
{

    /**
     * @param string $url
     * @param bool $scheme
     * @return string
     */
    public static function to($url = '', $scheme = false)
    {
        return parent::to($url, $scheme);
    }

}