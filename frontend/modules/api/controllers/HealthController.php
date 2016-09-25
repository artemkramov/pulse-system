<?php

namespace frontend\modules\api\controllers;


use common\models\Customer;
use common\models\HeartBeat;
use frontend\modules\api\actions\CreateHeartBeatAction;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

/**
 * Class HealthController
 * @package frontend\modules\api\controllers
 */
class HealthController extends ActiveController
{

    /**
     * @var string
     */
    public $macAddressKey = 'mac_address';

    /**
     * Init model class
     */
    public function init()
    {
        $this->modelClass = HeartBeat::className();
        parent::init();
    }

    /**
     * Unset unnecessary actions
     * @return array
     */
    public function actions()
    {
        return [
            'create'  => [
                'class'         => CreateHeartBeatAction::className(),
                'modelClass'    => $this->modelClass,
                'checkAccess'   => [$this, 'checkAccess'],
                'scenario'      => $this->createScenario,
                'macAddressKey' => $this->macAddressKey,
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        $requestBody = \Yii::$app->getRequest()->getBodyParams();
        $isForbidden = true;
        switch ($action) {
            case 'create':
                if (array_key_exists($this->macAddressKey, $requestBody)) {
                    $macAddress = $requestBody[$this->macAddressKey];
                    if (!empty($macAddress)) {
                        $customer = Customer::find()->where([
                            'mac_address' => $macAddress
                        ])
                            ->one();
                        if (!empty($customer)) {
                            $isForbidden = false;
                        }
                    }
                }
                if ($isForbidden) {
                    throw new ForbiddenHttpException();
                }
                break;
            default:
                parent::checkAccess($action, $model, $params);
                break;
        }
    }


}