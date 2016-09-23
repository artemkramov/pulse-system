<?php

namespace common\models;

use common\components\MultilingualBehavior;
use common\modules\i18n\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $phone
 */
class Setting extends Bean
{

    /**
     * @var string
     */
    protected $tableLang = 'settinglang';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * Initialize multilingual fields
     */
    public function init()
    {
        $this->multiLanguageFields = [];
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                       => Module::t('Id'),
            'phone'                    => Module::t('Phone'),
        ];
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Settings',
            'multiple' => 'Settings'
        ];
    }


}
