<?php

namespace common\models;

use common\modules\i18n\Module;
use Yii;

/**
 * This is the model class for table "heart_beat_rate".
 *
 * @property integer $id
 * @property integer $min_age
 * @property integer $max_age
 * @property integer $min_beat
 * @property integer $max_beat
 */
class HeartBeatRate extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heart_beat_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_age', 'max_age', 'min_beat', 'max_beat'], 'required'],
            [['min_age', 'max_age', 'min_beat', 'max_beat'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Module::t('Id'),
            'min_age'  => Module::t('Min age'),
            'max_age'  => Module::t('Max age'),
            'min_beat' => Module::t('Min beat'),
            'max_beat' => Module::t('Max beat'),
        ];
    }
}
