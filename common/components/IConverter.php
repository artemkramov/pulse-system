<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/22/16
 * Time: 5:51 PM
 */

namespace common\components;

/**
 * Interface for converting of the data from and to database format
 * */
interface IConverter
{
    /**
     * @param $data
     * @return mixed
     */
    public static function convertToDB($data);

    /**
     * @param $data
     * @return mixed
     */
    public static function convertFromDB($data);

}