<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/11/2016
 * Time: 3:41 PM
 */

namespace backend\components;


use backend\models\ExchangeRate;

/**
 * Class ExchangeRateApi
 * @package backend\components
 * Api for updating of the exchange rate
 */
class ExchangeRateApi
{

    /**
     * Entry point of the api
     * @var string
     */
    public $url = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=3';

    /**
     * Method for running of the update process
     */
    public function run()
    {
        $jsonResponse = file_get_contents($this->url);
        $rates = json_decode($jsonResponse);
        if (!empty($rates) && is_array($rates)) {
            foreach ($rates as $rate) {
                $postData = [
                    'ExchangeRate' => (array)$rate
                ];
                $exchangeRate = new ExchangeRate();
                $exchangeRate->load($postData);
                $exchangeRate->save();
            }
        }
    }

}