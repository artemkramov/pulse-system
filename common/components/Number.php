<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/22/16
 * Time: 5:50 PM
 */

namespace common\components;


class Number implements IConverter
{

    const THOUSAND_SEPARATOR = ",";
    const DECIMAL_SEPARATOR = ".";
    const DECIMAL_COUNT = 2;

    /**
     * @param double $number
     * @return mixed
     */
    public static function convertFromDB($number)
    {
        return number_format($number, self::DECIMAL_COUNT, self::DECIMAL_SEPARATOR, self::THOUSAND_SEPARATOR);
    }

    /**
     * @param $number
     * @return double
     */
    public static function convertToDB($number)
    {
        // TODO: Implement convertToDB() method.
    }
}