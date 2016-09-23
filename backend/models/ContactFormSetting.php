<?php

namespace backend\models;

use common\models\Bean;
use common\modules\i18n\Module;
use Yii;

/**
 * This is the model class for table "contact_form_setting".
 *
 * @property integer $id
 * @property string $to
 * @property string $from
 * @property string $subject
 * @property string $body
 */
class ContactFormSetting extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_form_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['to', 'from', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => Module::t('Id'),
            'to'      => Module::t('To'),
            'from'    => Module::t('From'),
            'subject' => Module::t('Subject'),
            'body'    => Module::t('Message'),
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
            'singular' => 'Contact form setting',
            'multiple' => 'Contact form settings'
        ];
    }

}
