<?php

namespace frontend\models;

use common\models\User;
use common\modules\i18n\Module;
use yii\base\Model;

/**
 * Class Profile
 * @package frontend\models
 */
class Profile extends Model
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $newPasswordRepeat;

    /**
     * @var bool
     */
    public $subscription;

    /**
     * @var User
     */
    private $user;

    /**
     * Init user entity
     */
    public function init()
    {
        $this->user = \Yii::$app->user->identity;
        parent::init();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username'], 'unique', 'targetClass' => User::className(), 'when' => function ($model) {
                return $model->username != \Yii::$app->user->identity->username;
            }],
            [['email'], 'unique', 'targetClass' => User::className(), 'when' => function ($model) {
                return $model->email != \Yii::$app->user->identity->email;
            }],
            ['email', 'email'],
            ['newPassword', 'string', 'length' => [6]],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'skipOnEmpty' => false],
            ['subscription', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'          => Module::t('Login'),
            'newPassword'       => Module::t('New Password'),
            'newPasswordRepeat' => Module::t('New Password Repeat'),
            'subscription'      => Module::t('Subscription'),
        ];
    }

    /**
     * Load user data to entity
     */
    public function loadUserData()
    {
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->subscription = $this->user->subscription;
    }

    /**
     * Save user data
     */
    public function save()
    {
        $user = User::findOne($this->user->id);
        $user->scenario = User::SCENARIO_PROFILE;
        $user->email = $this->email;
        $user->username = $this->username;
        $user->subscription = $this->subscription;
        if (!empty($this->newPassword)) {
            $user->setPassword($this->newPassword);
        }
        $user->save();
    }

}