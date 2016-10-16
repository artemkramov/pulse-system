<?php

namespace backend\health;

/**
 * Interface IDisease
 * @package backend\health
 */
abstract class IDisease
{

    /**
     * Count of the minutes during that the pulse data was got
     */
    const INPUT_MINUTES = 3;

    /**
     * Count of the beats from which we begin to detect threat
     */
    const MIN_BEAT_THRESHOLD = 20;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @param $customer
     * @param $pulseData
     * @return bool
     */
    public abstract function isDiseaseAvailable($customer, $pulseData);

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param $pulseData
     * @return float
     */
    public function getBPM($pulseData)
    {
        return round(count($pulseData) / self::INPUT_MINUTES);
    }

}