<?php

namespace backend\models;

use common\models\Bean;
use common\modules\i18n\Module;

/**
 * This is the model class for table "slider_item".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property string $image
 * @property string $url
 * @property integer $sort
 *
 * @property Slider $slider
 */
class SliderItem extends Bean
{

    /**
     * Variable for file storing while data saving
     * @var mixed
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slider_id', 'image'], 'required'],
            [['slider_id', 'sort'], 'integer'],
            [['image', 'url'], 'string', 'max' => 255],
            [['slider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slider::className(), 'targetAttribute' => ['slider_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Module::t('Id'),
            'slider_id' => Module::t('Slider'),
            'image'     => Module::t('Image'),
            'url'       => 'Url',
            'sort'      => Module::t('Sort')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlider()
    {
        return $this->hasOne(Slider::className(), ['id' => 'slider_id']);
    }
}
