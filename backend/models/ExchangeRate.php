<?php

namespace backend\models;

use common\models\Bean;
use Yii;

/**
 * This is the model class for table "exchange_rate".
 *
 * @property integer $id
 * @property string $ccy
 * @property string $base_ccy
 * @property double $buy
 * @property double $sale
 */
class ExchangeRate extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccy', 'base_ccy', 'buy', 'sale'], 'required'],
            [['buy', 'sale'], 'number'],
            [['ccy', 'base_ccy'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'ccy'      => 'Ccy',
            'base_ccy' => 'Base Ccy',
            'buy'      => 'Buy',
            'sale'     => 'Sale',
        ];
    }
}
