<?php

namespace backend\components;
use backend\health\Bradycardia;
use backend\health\IDisease;
use backend\health\Tachycardia;
use common\models\Customer;
use common\models\Threat;

/**
 * Class for handling and running of all crontab jobs
 * @author Artem Kramov
 * */
class CronComponent
{

    /**
     * Detect the threat for the disease
     */
    public function crDetectDisease()
    {
        $customers = Customer::find()->all();
        $diseases = [new Tachycardia(), new Bradycardia()];
        foreach ($customers as $customer) {
            /**
             * @var Customer $customer
             */
            $pulseData = $customer->getPulseDataForDisease();
            $pulseData = $customer->testGetPulseDataForTachycardia();
            //$pulseData = $customer->testGetPulseDataForBradycardia();
            if (empty($pulseData)) {
                continue;
            }
            foreach ($diseases as $disease) {
                /**
                 * @var IDisease $disease
                 */
                if ($disease->isDiseaseAvailable($customer, $pulseData)) {
                    $threat = new Threat();
                    $threat->customer_id = $customer->id;
                    $threat->alias = $disease->getAlias();
                    $threat->bpm = $disease->getBPM($pulseData);
                    $threat->save();
                }
            }
        }
    }


}