<?php

namespace common\models;

use common\modules\i18n\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $mac_address
 * @property string $name
 * @property string $notes
 * @property string $date_registrated
 *
 * @property User $user
 */
class Customer extends Bean
{

    const ROLE_NAME = 'customer';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['mac_address', 'name', 'date_registrated'], 'required'],
            [['notes'], 'string'],
            [['date_registrated'], 'safe'],
            [['mac_address', 'name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => Module::t('Id'),
            'user_id'          => Module::t('User'),
            'mac_address'      => Module::t('MAC'),
            'name'             => Module::t('Name'),
            'notes'            => Module::t('Notes'),
            'date_registrated' => Module::t('Dateregistrated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Customer',
            'multiple' => 'Customers'
        ];
    }

    /**
     * Get users for customer dropdown
     * @return array
     */
    public static function getUnlinkedUsers()
    {
        $items = User::find()
            ->join('LEFT JOIN', 'auth_assignment', 'auth_assignment.user_id = user.id')
            ->join('LEFT JOIN', 'customer', 'customer.user_id = user.id')
            ->all();
        return ["" => ""] + ArrayHelper::map($items, 'id', function ($model, $defaultValue) {
            return $model['username'] . "/" . $model["email"];
        });
    }

    /**
     * After delete hook to clear related data
     */
    public function afterDelete()
    {
        $user = $this->user;
        if (isset($user)) {
            $user->delete();
        }
        parent::afterDelete();
    }

    /**
     * @return integer
     */
    public function getBeatsPerMinute()
    {
        $rows = HeartBeat::find()
            ->where("FROM_UNIXTIME(`created_at`) > (NOW() - INTERVAL 1 MINUTE)")
            ->andWhere([
                'user_id' => !empty($this) ? $this->user_id : null,
            ])
            ->all();
        $count = 0;
        $bpm = 0;
        $ibi = 0;
        $startTime = 0;
        foreach ($rows as $heartBeat) {
            /**
             * @var HeartBeat $heartBeat
             */
            if (!empty($startTime)) {
                $ibi += $heartBeat->updated_at - $startTime;
                $count++;
            }
            $startTime = $heartBeat->updated_at;
        }
        if ($ibi > 0) {
            $bpm = round(60 * $count / $ibi);
        }
        return $bpm;
    }
}
