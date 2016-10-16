<?php

namespace common\models;

use common\components\Mailer;
use common\modules\i18n\Module;
use Yii;

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

    public function sendNotification()
    {
        $operators = $this->customer->operators;
        foreach ($operators as $operator) {
            Yii::$app->controller->renderPartial(__DIR__ . '/_test.php');
            /**
             * @var User $operator
             */
            $mailer = Mailer::get($operator->email, Module::t('Threat from ') . ' ' . $this->customer->name, 'ssss');
            $mailer->send();
        }

    }

}