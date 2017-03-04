<?php

namespace backend\health;

use common\models\Customer;
use common\models\HeartBeatRate;

/**
 * Class Bradycardia
 * @package backend\health
 */
class Bradycardia extends IDisease
{

    /**
     * @var string
     */
    protected $alias = 'bradycardia';

    /**
     * @param Customer $customer
     * @param $pulseData
     * @return bool
     */
    public function isDiseaseAvailable($customer, $pulseData)
    {
        /**
         * @var HeartBeatRate $rate
         */
        $isDisease = false;
        $rate = $customer->getBoundaryConditions();
        $pulseCount = $customer->getBeatsPerMinute();
        if ($pulseCount < $rate->min_beat) {
            $isDisease = true;
        }
        return $isDisease;
    }

}