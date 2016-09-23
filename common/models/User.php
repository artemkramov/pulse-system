<?php
namespace common\models;

use backend\models\Customer;
use backend\models\Product;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\IdentityInterface;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use developeruz\db_rbac\interfaces\UserRbacInterface;
use backend\models\Employee;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $logo
 * @property integer $subscription
 *
 * @property Customer $customer
 */
class User extends Bean implements IdentityInterface, UserRbacInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const IS_SUBSCRIBED = 1;

    const ROLE_ADMIN = "admin";
    const ROLE_CUSTOMER = "customer";
    const ROLE_MANAGER = "manager";

    const SCENARIO_CHANGE_PASSWORD = 'changePassword';
    const SCENARIO_UPDATE_PROFILE = 'updateProfile';
    const SCENARIO_REGISTRATION = 'registration';
    const SCENARIO_PROFILE = 'profile';

    const SESSION_COUNTRY = 'country';

    private static $self_updated = false;
    public $new_password;
    public $new_password_repeat;
    public $employee_id;

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        $current_user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($current_user->id);
        return array_key_exists(self::ROLE_ADMIN, $roles);
    }

    /**
     * @return bool
     */
    public static function isCustomer()
    {
        $current_user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($current_user->id);
        return array_key_exists(self::ROLE_CUSTOMER, $roles);
    }

    /**
     * @return bool
     */
    public static function isManager()
    {
        $current_user = \Yii::$app->user;
        $roles = \Yii::$app->authManager->getRolesByUser($current_user->id);
        return array_key_exists(self::ROLE_MANAGER, $roles);
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'User',
            'multiple' => 'Users'
        ];
    }

    /**
     * Method for getting of the current user's logo
     * @return string
     */
    public static function getUserLogoPath()
    {
        return !empty(\Yii::$app->user->identity->logo) ? \Yii::$app->user->identity->logo : \Yii::$app->params['noImageSrc'];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Returns user list by role name
     * @param $roleSlug
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findByRole($roleSlug)
    {
        return static::find()
            ->join('LEFT JOIN', 'auth_assignment', 'auth_assignment.user_id = id')
            ->where(['auth_assignment.item_name' => $roleSlug])
            ->all();
    }

    public function getOriginalTableName()
    {
        return \Yii::$app->db->tablePrefix . str_replace(array('{{', '}}', '%'), '', $this->tableName());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CHANGE_PASSWORD => ['new_password', 'new_password_repeat'],
            parent::SCENARIO_DEFAULT       => ['username', 'email', 'new_password', 'new_password_repeat', 'status', 'logo', 'subscription'],
            self::SCENARIO_UPDATE_PROFILE  => ['username', 'email', 'new_password', 'new_password_repeat'],
            self::SCENARIO_REGISTRATION    => ['username', 'email', 'subscription'],
            self::SCENARIO_PROFILE         => ['username', 'email', 'subscription']
        ];
    }

    /**
     * @return string
     */
    public static function getUpdateProfileView()
    {

        return '@backend' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR .
        'views' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'update_profile';
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFavouriteProducts()
    {
        $items = Product::find()
            ->join('inner join', Product::TABLE_USER_FAVOURITE, Product::TABLE_USER_FAVOURITE . '.product_id = ' . Product::tableName() . '.id')
            ->where([
                Product::TABLE_USER_FAVOURITE . '.user_id' => $this->id
            ])
            ->distinct()
            ->all();
        return $items;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['new_password', 'string', 'length' => [6]],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password', 'skipOnEmpty' => false],
            ['new_password', 'required', 'when' => function ($model) {
                return (bool)($model->isNewRecord || $model->scenario == "changePassword");
            }],
            ['logo', 'safe'],
            ['subscription', 'integer'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->new_password)) {
                $this->setPassword($this->new_password);
                $this->new_password = "";
            }
            return true;
        }
        return false;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!self::$self_updated) {
            $file = \Yii::getAlias('@root') . $this->logo;
            if (!empty($this->logo)) {
                Image::thumbnail($file, 160, 160)
                    ->save($file);
            }
        }
        if ($this->scenario == parent::SCENARIO_DEFAULT) {
            $this->assignRoles($this->id);
        }
        if ($this->scenario == self::SCENARIO_REGISTRATION) {
            \Yii::$app->authManager->revokeAll($this->id);
        }
    }

    /**
     * @param $user_id
     */
    private function assignRoles($user_id)
    {
        \Yii::$app->authManager->revokeAll($user_id);
        if (\Yii::$app->request->post('roles')) {
            foreach (\Yii::$app->request->post('roles') as $role) {
                if (!empty($role)) {
                    $new_role = \Yii::$app->authManager->getRole($role);
                    \Yii::$app->authManager->assign($new_role, $user_id);
                }
            }
        }
    }

    /**
     * @return Country
     */
    public static function getCurrentCountry()
    {
        $countryID = Yii::$app->session->get(self::SESSION_COUNTRY, null);
        if (!isset($countryID)) {
            $countryID = 1; //Default country will be Ukraine
            if (!Yii::$app->user->isGuest) {
                /**
                 * @var Address $address
                 */
                $address = Address::find()
                    ->where([
                        'user_id' => Yii::$app->user->id
                    ])
                    ->one();
                if (!empty($address)) {
                    $countryID = $address->country_id;
                }
            }
            Yii::$app->session->set(self::SESSION_COUNTRY, $countryID);
        }
        return Country::findOne($countryID);
    }

    /**
     * @param $countryID
     */
    public static function setCurrentCountry($countryID)
    {
        $country = Country::findOne($countryID);
        if (!empty($country)) {
            Yii::$app->session->set(self::SESSION_COUNTRY, $countryID);
        }
    }

    /**
     * @return array|null|ActiveRecord
     */
    public function getAddress()
    {
        return Address::find()->where([
            'user_id' => $this->id
        ])->one();

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
