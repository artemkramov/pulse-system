<?php

namespace backend\models;

use common\components\Number;
use common\models\Bean;
use common\models\Lang;
use common\models\User;
use Yii;
use common\modules\i18n\Module;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $name
 * @property string $iso_4217
 * @property string $sign
 * @property integer $is_default
 * @property integer $show_after_price
 */
class Currency extends Bean
{

    const STATUS_DEFAULT = 1;

    public static $currentCurrency;

    public static $defaultCurrency;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Currency',
            'multiple' => 'Currencies'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'iso_4217', 'sign', 'is_default'], 'required'],
            [['is_default', 'show_after_price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['iso_4217', 'sign'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Module::t('Id'),
            'name'             => Module::t('Name'),
            'iso_4217'         => Module::t('ISO 4217'),
            'sign'             => Module::t('Sign'),
            'is_default'       => Module::t('Default'),
            'show_after_price' => Module::t('Show after price')
        ];
    }

    /**
     * @param $price
     * @param $currency
     * @return string
     */
    public static function showFormattedPrice($price, $currency)
    {
        if ($currency->show_after_price) {
            if (is_numeric($price)) {
                $price = number_format($price, 0, Number::DECIMAL_SEPARATOR, Number::THOUSAND_SEPARATOR);
            }
            return $price . " " . $currency->sign;
        }
        else {
            return $currency->sign . " " . $price;
        }

    }

    /**
     * @param $price
     * @return string
     */
    public static function showPrice($price)
    {
        $currentCurrency = self::getCurrentCurrency();
        $price = self::convertFromDefault($price, $currentCurrency);
        return self::showFormattedPrice($price, $currentCurrency);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getDefaultCurrency()
    {
        if (!isset(self::$defaultCurrency)) {
            self::$defaultCurrency = self::find()->where([
                'is_default' => self::STATUS_DEFAULT
            ])->one();
        }
        return self::$defaultCurrency;
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getCurrentCurrency()
    {
        if (!isset(self::$currentCurrency)) {
            $currentCountry = User::getCurrentCountry();
            self::$currentCurrency = (!empty($currentCountry->currency)) ? $currentCountry->currency : self::getDefaultCurrency();
        }
        return self::$currentCurrency;
    }

    /**
     * @param $price
     * @param $currency
     * @return float
     */
    public static function convertToDefaultCurrency($price, $currency)
    {
        $defaultCurrency = self::getDefaultCurrency();
        $exchangeRate = ExchangeRate::find()
            ->where([
                'base_ccy' => $defaultCurrency->iso_4217,
                'ccy'      => $currency->iso_4217
            ])
            ->orderBy('id desc')
            ->one();
        if (!empty($exchangeRate)) {
            return round($price * $exchangeRate->buy);
        }
        return $price;
    }

    /**
     * @param $price
     * @param $currency
     * @return float
     */
    public static function convertFromDefault($price, $currency)
    {
        $defaultCurrency = self::getDefaultCurrency();
        $exchangeRate = ExchangeRate::find()
            ->where([
                'base_ccy' => $defaultCurrency->iso_4217,
                'ccy'      => $currency->iso_4217
            ])
            ->orderBy('id desc')
            ->one();
        if (!empty($exchangeRate)) {
            return round($price / $exchangeRate->buy);
        }
        return $price;
    }

    /**
     * @param $price
     * @param $fromCurrency
     * @param $toCurrency
     * @return float
     */
    public static function convertPrice($price, $fromCurrency, $toCurrency)
    {
        if ($fromCurrency->id == $toCurrency->id) {
            return $price;
        }
        if (!$fromCurrency->is_default) {
            $price = self::convertToDefaultCurrency($price, $fromCurrency);
        }
        return $toCurrency->is_default ? $price : self::convertFromDefault($price, $toCurrency);
    }


}
