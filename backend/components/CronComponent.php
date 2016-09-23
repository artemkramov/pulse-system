<?php

namespace backend\components;
use backend\models\Customer;
use backend\models\DateWeight;
use backend\models\Invoice;
use backend\models\InvoiceLine;
use backend\models\InvoiceSentQueue;
use backend\models\Novelty;
use backend\models\Template;
use common\components\Mailer;
use common\modules\i18n\Module;

/**
 * Class for handling and running of all crontab jobs
 * @author Artem Kramov
 * */
class CronComponent
{

    /**
     * Update exchange rate
     */
    public function crUpdateExchangeRate()
    {
        $api = new ExchangeRateApi();
        $api->run();
        return true;
    }

    /**
     * Send all queued novelties
     */
    public function crSendQueuedNovelties()
    {
        Novelty::sendQueuedNovelties();
        return true;
    }


}