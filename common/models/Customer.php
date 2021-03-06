<?php

namespace common\models;

use backend\components\AccessHelper;
use backend\components\ManyToManyBehavior;
use backend\health\IDisease;
use common\modules\i18n\Module;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $mac_address
 * @property string $name
 * @property string $notes
 * @property string $date_registrated
 * @property integer $gender_id
 * @property integer $age
 * @property integer $min_beat
 * @property integer $max_beat
 *
 * @property User $user
 * @property Gender $gender
 * @property User[] $operators
 */
class Customer extends Bean
{

    const ROLE_NAME = 'customer';

    const TABLE_CUSTOMER_OPERATOR = 'customer_operator';

    /**
     * @var bool
     */
    public $isOnlineFlag;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class'     => ManyToManyBehavior::className(),
                'relations' => [
                    'operator_ids' => 'operators'
                ]
            ]
        ]);
    }

    public function getOperators()
    {
        return $this->hasMany(User::className(), ['id' => 'operator_id'])
            ->viaTable('{{%' . self::TABLE_CUSTOMER_OPERATOR . '}}', ['customer_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getOperatorsToString()
    {
        $items = ArrayHelper::getColumn($this->operators, 'username');
        return implode(', ', $items);
    }

    /**
     * @return array
     */
    public function getPulseDataReceivers()
    {
        return ArrayHelper::merge($this->operators, User::getAdministrators());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id', 'min_beat', 'max_beat'], 'integer'],
            [['mac_address', 'name', 'date_registrated', 'age', 'min_beat', 'max_beat'], 'required'],
            [['notes'], 'string'],
            [['date_registrated'], 'safe'],
            [['mac_address', 'name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['operator_ids'], 'each', 'rule' => ['integer']]
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
            'gender_id'        => Module::t('Gender'),
            'age'              => Module::t('Age'),
            'min_beat'         => Module::t('Min beat'),
            'max_beat'         => Module::t('Max beat')
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
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
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
            ->where("`ibi` > (NOW() - INTERVAL 1 MINUTE)")
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
                $ibi += HeartBeat::getTimeBetweenBeats($startTime, $heartBeat);
                $count++;
            }
            $startTime = $heartBeat;
        }
        if ($ibi > 0) {
            $bpm = round(60 * $count / ($ibi / HeartBeat::COEFFICIENT_MILLISECONDS));
        }
        return $bpm;
    }

    /**
     * Get pulse data for the disease detection
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getPulseDataForDisease()
    {
        $rows = HeartBeat::find()
            ->where(sprintf("`ibi` > (NOW() - INTERVAL %d MINUTE)", IDisease::INPUT_MINUTES))
            ->andWhere([
                'user_id' => !empty($this) ? $this->user_id : null,
            ])
            ->all();
        if (count($rows) <= IDisease::MIN_BEAT_THRESHOLD) {
            $rows = [];
        }
        return $rows;
    }

    public function testGetPulseDataForTachycardia()
    {
        $path = dirname(dirname(__DIR__)) . '/backend/web/uploads/disease/tachicard.json';
        $data = file_get_contents($path);
        $items = json_decode($data);
        return $items;
    }

    public function testGetPulseDataForBradycardia()
    {
        $path = dirname(dirname(__DIR__)) . '/backend/web/uploads/disease/bradicard.json';
        $data = file_get_contents($path);
        $items = json_decode($data);
        return $items;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function getGraphData($startTime, $endTime)
    {
        $beats = HeartBeat::find()
            ->where([
                '>', 'ibi', $startTime
            ])
            ->andWhere([
                '<', 'ibi', $endTime
            ])
            ->andWhere([
                'user_id' => $this->user_id
            ])
            ->all();
        return HeartBeat::getDataPointsFromBeats($beats);
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        $numRows = HeartBeat::find()
            ->where([
                'user_id' => $this->user_id
            ])
            ->andWhere(self::isOnlineCondition())
            ->count();
        return $numRows > 0 ? true : false;
    }

    /**
     * @return string
     */
    protected static function isOnlineCondition()
    {
        return "`ibi` BETWEEN DATE_SUB(NOW(),INTERVAL 10 SECOND) AND NOW()";
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getBoundaryConditions()
    {
        $data = new HeartBeatRate();
        $data->min_beat = $this->min_beat;
        $data->max_beat = $this->max_beat;
        return $data;
    }

    /**
     * @return string
     */
    public function getMonitorLink()
    {
        return Url::to(['/users/customers/heart-beat', 'id' => $this->id]);
    }

    /**
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $accessHelper = new AccessHelper();
        $customerIds = $accessHelper->getFilter();

        $query = static::find();
        if (!User::isAdmin()) {
            $query->where([
                'in', 'id', $customerIds
            ]);
        }

        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }
        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * @param $all
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getOnlineCustomers($all = false)
    {
        $query = self::find()
            ->innerJoin(HeartBeat::tableName(), HeartBeat::tableName() . '.user_id = ' . self::tableName() . '.user_id')
            ->where(self::isOnlineCondition())
            ->distinct();
         if (!$all) {
             $query->limit(5);
         }
         return $query->all();
    }
}
