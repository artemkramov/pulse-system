<?php

namespace common\models;

use backend\models\Currency;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 * @property string $title_be
 * @property string $title_en
 * @property string $title_es
 * @property string $title_pt
 * @property string $title_de
 * @property string $title_fr
 * @property string $title_it
 * @property string $title_pl
 * @property string $title_ja
 * @property string $title_lt
 * @property string $title_lv
 * @property string $title_cz
 * @property string $iso
 * @property integer $currency_id
 *
 * @property Currency $currency
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
            [['title_ru', 'title_ua', 'title_be', 'title_en', 'title_es', 'title_pt', 'title_de', 'title_fr', 'title_it', 'title_pl', 'title_ja', 'title_lt', 'title_lv', 'title_cz'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title Ru',
            'title_ua' => 'Title Ua',
            'title_be' => 'Title Be',
            'title_en' => 'Title En',
            'title_es' => 'Title Es',
            'title_pt' => 'Title Pt',
            'title_de' => 'Title De',
            'title_fr' => 'Title Fr',
            'title_it' => 'Title It',
            'title_pl' => 'Title Pl',
            'title_ja' => 'Title Ja',
            'title_lt' => 'Title Lt',
            'title_lv' => 'Title Lv',
            'title_cz' => 'Title Cz',
        ];
    }

    /**
     * @return array
     */
    public static function getDropdownList()
    {
        $collection = self::getAllRecords();
        $field = 'title_' . Lang::getCurrent()->url;
        return ArrayHelper::map($collection, 'id', $field);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), [
            'id' => 'currency_id'
        ]);
    }

}
