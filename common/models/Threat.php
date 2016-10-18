<?php

namespace common\models;

use common\components\Mailer;
use common\components\WebsocketClient;
use common\modules\i18n\Module;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "threat".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $created_at
 * @property string $alias
 * @property integer $bpm
 *
 * @property Customer $customer
 */
class Threat extends Bean
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'threat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'alias', 'bpm'], 'required'],
            [['customer_id', 'bpm'], 'integer'],
            [['created_at'], 'safe'],
            [['alias'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Module::t('Id'),
            'customer_id' => Module::t('Customer'),
            'created_at'  => Module::t('Createdat'),
            'alias'       => Module::t('Alias'),
            'bpm'         => Module::t('BPM'),
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
            'singular' => 'Threat',
            'multiple' => 'Threats'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->sendNotification();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Send notification of the threat to related customer's operators
     */
    public function sendNotification()
    {
        $urlWs = 'ws://' . \Yii::$app->params['serverHost'] . ':9000/echobot';
        $wsClient = new WebsocketClient($urlWs);
        $updatedThreat = self::findOne($this->id);
        $operators = $this->customer->operators;
        $emailViewPath = \Yii::getAlias('@backend/modules/users/views/customers/');
        \Yii::$app->controller->viewPath = $emailViewPath;
        foreach ($operators as $operator) {
            $data = json_encode([
                'method' => 'pushAttention',
                'data'   => [
                    'userID' => $operator->id,
                    'threat' => [
                        'id'       => $this->id,
                        'name'     => Module::t($this->alias),
                        'customer' => $this->customer->name,
                        'link'     => Url::to(['/users/threats/view', 'id' => $this->id])
                    ],
                ]
            ]);
            $wsClient->send($data);
//            $body = Yii::$app->controller->renderPartial('notification', [
//                'threat' => $updatedThreat
//            ]);
//            /**
//             * @var User $operator
//             */
//            $mailer = Mailer::get($operator->email, Module::t('Threat from ') . ' ' . $this->customer->name, $body);
//            $mailer->send();
        }

    }

}
