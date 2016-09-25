<?php

namespace common\models;

use common\modules\i18n\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "heart_beat".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $value
 *
 * @property User $user
 */
class HeartBeat extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heart_beat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'value'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('Id'),
            'created_at' => Module::t('Createdat'),
            'updated_at' => Module::t('Updatedat'),
            'user_id'    => Module::t('User'),
            'value'      => Module::t('Value'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
