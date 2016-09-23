<?php

namespace frontend\payments;

use backend\models\Currency;
use common\models\Lang;
use common\models\Order;
use common\modules\i18n\Module;
use frontend\components\FrontendHelper;
use frontend\payments\lib\LiqpayApi;

class Liqpay implements IPaymentSystem
{

    const VERSION = 3;

    const STATUS_SUCCESS = 'success';

    private $liqpayApi;

    private $publicKey = 'i23888613508';

    private $privateKey = 'jvhOBtRmWpQouUWencNDaHBGskKmGvKjPRyptUcx';

    private $testMode = true;

    public function __construct()
    {
        $this->liqpayApi = new LiqpayApi($this->publicKey, $this->privateKey);
    }

    public function checkout($order)
    {
        /**
         * @var Currency $currentCurrency
         * @var Lang $currentLanguage
         */
        $currentCurrency = Currency::getCurrentCurrency();
        $currentLanguage = Lang::getCurrent();

        $callbackUrl = FrontendHelper::getPaymentCallback('liqpay');

        $data = [
            'version'     => self::VERSION,
            'action'      => 'pay',
            'amount'      => Currency::convertFromDefault($order->getTotalPrice(), $currentCurrency),
            'currency'    => $currentCurrency->iso_4217,
            'description' => Module::t('Order') . ' #' . $order->id,
            'order_id'    => $order->id,
            'language'    => $currentLanguage->url,
            'server_url'  => $callbackUrl,
        ];
        if ($this->testMode) {
            $data['sandbox'] = 1;
        }
        $html = $this->liqpayApi->cnb_form($data);
        return $html;
    }

    /**
     * @param $postData
     * @return null
     */
    public function handleCallback($postData)
    {
        $data = (array)json_decode(base64_decode($postData['data']));
        if (is_array($data) && array_key_exists('order_id', $data)) {
            /**
             * @var Order $order
             */
            $order = Order::findOne($data['order_id']);
            $order->scenario = Order::SCENARIO_STATUS;
            if (!empty($order) && $data['status'] == self::STATUS_SUCCESS) {
                $order->status = Order::STATUS_PAID;
                $order->save();
            }
        }
    }

}