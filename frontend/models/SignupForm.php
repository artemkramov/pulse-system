<?php
namespace frontend\models;

use common\models\User;
use common\modules\i18n\Module;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
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
    public $password;

    /**
     * @var boolean
     */
    public $subscription = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Module::t('This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Module::t('This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['subscription', 'integer'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->scenario = User::SCENARIO_REGISTRATION;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->subscription = $this->subscription;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save();
        
        return $user->save() ? $user : null;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('Login'),
            'password' => Module::t('Password'),
        ];
    }

}
