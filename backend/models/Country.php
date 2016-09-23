<?php

namespace backend\models;

use common\models\Bean;
use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $country_name
 *
 * @property Address[] $addresses
 * @property Vat[] $vats
 */
class Country extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code'], 'string', 'max' => 2],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVats()
    {
        return $this->hasMany(Vat::className(), ['country_id' => 'id']);
    }
}
