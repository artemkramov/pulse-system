<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use common\models\Message;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 * @property integer $currency_id
 *
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * @var null
     */
    static $current = null;

    /**
     * @var null
     */
    static $defaultLanguage = null;

    /**
     * @var null
     */
    static $languages = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @return array
     */
    public static function getLanguageSlugs()
    {
        return ArrayHelper::getColumn(self::getLanguages(), 'url');
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Translation',
            'multiple' => 'Translations'
        ];
    }

    /**
     * Method for getting of javascript translation
     * @return array
     */
    public static function getJavascriptLabels()
    {
        $messageTable = Message::tableName();
        $sourceMessageTable = SourceMessage::tableName();
        $items = (new Query())
            ->select($sourceMessageTable . ".message, " . $messageTable . ".translation")
            ->from($sourceMessageTable)
            ->join('inner join', $messageTable, $sourceMessageTable . '.id = ' . $messageTable . '.id')
            ->where(['language' => self::getCurrent()->url, 'category' => SourceMessage::CATEGORY_JAVASCRIPT])
            ->all();
        return ArrayHelper::map($items, 'message', 'translation');
    }

    /**
     * Get current language
     * @return null
     */
    static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }

        return self::$current;
    }

    /**
     * Set current language to user
     * @param null $url
     */
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

    /**
     * Get language by slug name
     * @param null $url Slug name like 'en','nl'
     * @return array|null|\yii\db\ActiveRecord
     */
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ($language === null) {
                return null;
            } else {
                return $language;
            }
        }
    }

    /**
     * Getting default language in the system
     * @return array|null|\yii\db\ActiveRecord
     */
    static function getDefaultLang()
    {
        if (!isset(self::$defaultLanguage)) {
            self::$defaultLanguage = Lang::find()->where('`default` = :default', [':default' => 1])->one();
        }
        return self::$defaultLanguage;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['default', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'url'         => 'Url',
            'local'       => 'Local',
            'name'        => 'Name',
            'default'     => 'Default',
            'date_update' => 'Date Update',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public static function getLanguages()
    {
        if (!isset(self::$languages)) {
            self::$languages = self::find()->all();
        }
        return self::$languages;
    }

}
