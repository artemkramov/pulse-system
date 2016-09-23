<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/16/16
 * Time: 1:03 PM
 */

namespace common\components;

use common\models\Lang;
use yii\base\InvalidConfigException;
use yii\i18n\DbMessageSource;

class I18N extends \yii\i18n\I18N
{
    /** @var string */
    public $sourceMessageTable = '{{%source_message}}';
    /** @var string */
    public $messageTable = '{{%message}}';
    /** @var array */
    public $languages;
    /** @var array */
    public $missingTranslationHandler = ['common\modules\i18n\Module', 'missingTranslation'];
    public $db = 'db';

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->languages = Lang::getLanguageSlugs();
        if (!$this->languages) {
            throw new InvalidConfigException('You should configure i18n component [language]');
        }
        if (!isset($this->translations['*'])) {
            $this->translations['*'] = [
                'class'                 => DbMessageSource::className(),
                'db'                    => $this->db,
                'sourceMessageTable'    => $this->sourceMessageTable,
                'messageTable'          => $this->messageTable,
                'on missingTranslation' => $this->missingTranslationHandler
            ];
        }
        if (!isset($this->translations['app']) && !isset($this->translations['app*'])) {
            $this->translations['app'] = [
                'class'                 => DbMessageSource::className(),
                'db'                    => $this->db,
                'sourceMessageTable'    => $this->sourceMessageTable,
                'messageTable'          => $this->messageTable,
                'on missingTranslation' => $this->missingTranslationHandler
            ];
        }
        parent::init();
    }
}