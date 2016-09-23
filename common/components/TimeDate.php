<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/27/16
 * Time: 4:46 PM
 */

namespace common\components;


class TimeDate implements IConverter
{
    CONST PHP_PREFFIX = 'php:';


    /**
     * @param $dateString
     * @param bool $short
     * @return bool|string
     */
    public static function convertToDB($dateString, $short = false)
    {
        $defaultType = self::getDefaultDateType($short);
        $convertedField = \DateTime::createFromFormat($defaultType, $dateString);
        if (!empty($convertedField) && is_object($convertedField)) {
            return $convertedField->format('Y-m-d');
        }
        return false;
    }

    /**
     * @param bool $short
     * @return string
     */
    public static function getDefaultDateType($short = false)
    {
        $format =  \Yii::$app->formatter->dateFormat;
        if ($short) {
            $format = str_replace('Y', 'y', $format);
        }
        return str_replace(self::PHP_PREFFIX, '',$format);
    }

    /**
     * @param $dateString
     * @param $short
     * @return string
     */
    public static function convertFromDB($dateString, $short = false)
    {
        $format = self::PHP_PREFFIX . self::getDefaultDateType($short);
        return \Yii::$app->formatter->asDate($dateString, $format);
    }

}