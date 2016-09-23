<?php

namespace common\models;

use common\modules\i18n\Module;
use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property integer $country_id
 * @property string $city
 * @property string $region
 * @property string $street
 * @property string $building
 * @property string $flat
 * @property string $zip
 * @property integer $user_id
 *
 * @property User $user
 * @property Country $country
 */
class Address extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'country_id', 'city', 'region', 'street', 'building', 'zip'], 'required'],
            [['country_id', 'user_id'], 'integer'],
            [['street'], 'string'],
            [['first_name', 'last_name', 'phone', 'city', 'region'], 'string', 'max' => 255],
            [['building', 'flat', 'zip'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('Id'),
            'first_name' => Module::t('First name'),
            'last_name'  => Module::t('Last name'),
            'phone'      => Module::t('Phone'),
            'country_id' => Module::t('Country'),
            'city'       => Module::t('City'),
            'region'     => Module::t('Region'),
            'street'     => Module::t('Street'),
            'building'   => Module::t('Building'),
            'flat'       => Module::t('Flat'),
            'zip'        => Module::t('Zip'),
            'user_id'    => Module::t('User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * Load data from user profile
     */
    public function loadUserData()
    {
        if (!Yii::$app->user->isGuest) {
            /**
             * @var Address $address
             */
            $address = self::find()
                ->where([
                    'user_id' => Yii::$app->user->id
                ])
                ->one();
            if (!empty($address)) {
                $attributes = $address->attributes;
                foreach ($attributes as $attributeName => $value) {
                    $this->{$attributeName} = $value;
                }
                $this->id = null;
            }
        }
    }
}
