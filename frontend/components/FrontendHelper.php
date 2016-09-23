<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/11/2016
 * Time: 2:20 PM
 */

namespace frontend\components;
use common\models\Lang;
use yii\helpers\Url;

/**
 * Class FrontendHelper
 * @package frontend\components
 */
class FrontendHelper
{

    /**
     * @return string
     */
    public static function getDefaultImage()
    {
        return "/uploads/no-image.png";
    }

    /**
     * @param $link
     * @return string
     */
    public static function formLink($link)
    {
        return Url::to('/' . Lang::getCurrent()->url . $link);
    }

    /**
     * @param $alias
     * @return string
     */
    public static function getPaymentCallback($alias)
    {
        return Url::to(['/basket/payment-callback', 'paymentSystemAlias' => $alias], true);
    }

}