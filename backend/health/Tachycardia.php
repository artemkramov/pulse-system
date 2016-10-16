<?php

namespace backend\health;

use common\models\Customer;
use common\models\HeartBeatRate;

/**
 * Class Tachycardia
 * @package backend\health
 */
class Tachycardia extends IDisease
{

    /**
     * @var string
     */
    protected $alias = 'tachycardia';

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
        $pulseCount = $this->getBPM($pulseData);
        if ($pulseCount > $rate->max_beat) {
            $isDisease = true;
        }
        return $isDisease;
    }

}