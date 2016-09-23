<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/15/16
 * Time: 10:50 AM
 */

namespace backend\components;


use yii\base\Event;

class DataEvent extends Event
{

    private $customData;

    public function setCustomData($newCustomData)
    {
        $this->customData = $newCustomData;
    }

    public function getCustomData()
    {
        return $this->customData;
    }

}