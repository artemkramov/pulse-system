<?php

namespace backend\health;
use common\modules\i18n\Module;

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

    /**
     * @return array
     */
    public static function getDiseaseList()
    {
        return [new Tachycardia(), new Bradycardia()];
    }

    /**
     * @return array
     */
    public static function getDiseaseDropdown()
    {
        $response = ['' => ''];
        $diseases = self::getDiseaseList();
        foreach ($diseases as $disease) {
            /**
             * @var IDisease $disease
             */
            $response[$disease->getAlias()] = Module::t($disease->getAlias());
        }
        return $response;
    }

}