<?php

namespace frontend\modules\api\actions;

use common\components\WebsocketClient;
use common\models\Customer;
use common\models\HeartBeat;
use yii\rest\CreateAction;
use Yii;
use yii\web\ServerErrorHttpException;
use yii\helpers\Url;

class CreateHeartBeatAction extends CreateAction
{

    /**
     * @var string
     */
    public $macAddressKey = "";

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model HeartBeat */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $requestBody = Yii::$app->getRequest()->getBodyParams();
        $model->load($requestBody, '');

        /**
         * @var Customer $customer
         */
        $customer = Customer::find()->where([
            'mac_address' => $requestBody[$this->macAddressKey]
        ])
            ->one();
        $model->user_id = $customer->user_id;

        $url = "ws://" . $_SERVER['HTTP_HOST'] . ":9000/echobot";
        $wsClient = new WebsocketClient($url);
        $data = json_encode([
            'method' => 'pushNotification',
            'data'   => [
                'userID' => 1,
                'data'   => [
                    'text' => 5
                ]
            ]
        ]);
        $wsClient->send($data);

        echo "Send notice";
        exit;

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}