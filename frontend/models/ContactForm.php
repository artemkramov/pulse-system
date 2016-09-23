<?php

namespace frontend\models;

use backend\models\ContactFormSetting;
use backend\models\Template;
use common\components\Mailer;
use common\modules\i18n\Module;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{

    const DEFAULT_FORM_ID = 1;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'message'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'    => Module::t('Your name'),
            'email'   => Module::t('Your email'),
            'message' => Module::t('Your message')
        ];
    }

    /**
     * Send email from the contact form
     */
    public function sendEmail()
    {
        $setting = ContactFormSetting::findOne(self::DEFAULT_FORM_ID);
        $attributeData = $this->attributes;
        $data = [
            'contact_form' => $attributeData
        ];
        $body = Template::replaceTemplates($setting->body, $data);
        $mailer = Mailer::get($setting->to, $setting->subject, $body, $setting->from);
        $mailer->send();
    }



}
