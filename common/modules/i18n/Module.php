<?php

namespace common\modules\i18n;

use common\models\Lang;
use common\models\SourceMessage;
use Yii;
use yii\i18n\MissingTranslationEvent;

/**
 * i18n module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\i18n\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public $pageSize = 50;

    public static function t($message, $params = [], $language = null)
    {
        if (!isset($language)) {
            $language = Lang::getCurrent()->url;
        }
        return Yii::t('common/modules/i18n', $message, $params, $language);
    }

    /**
     * @param MissingTranslationEvent $event
     */
    public static function missingTranslation(MissingTranslationEvent $event)
    {
        $driver = Yii::$app->getDb()->getDriverName();
        $caseInsensitivePrefix = $driver === 'mysql' ? 'binary' : '';
        $sourceMessage = SourceMessage::find()
            ->where('category = :category and message = ' . $caseInsensitivePrefix . ' :message', [
                ':category' => $event->category,
                ':message'  => $event->message
            ])
            ->with('messages')
            ->one();
        if (!$sourceMessage) {
            $sourceMessage = new SourceMessage;
            $sourceMessage->setAttributes([
                'category' => $event->category,
                'message'  => $event->message
            ], false);
            $sourceMessage->save(false);
        }
        $sourceMessage->initMessages();
        $sourceMessage->saveMessages();
    }
}
