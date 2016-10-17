<?php

namespace backend\modules\users\controllers;

use backend\controllers\CRUDController;
use backend\models\HeartBeatRange;
use common\components\WebsocketClient;
use common\models\Address;
use common\models\Customer;
use common\models\HeartBeat;
use common\models\search\Customer as CustomerSearch;
use common\models\User;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * CustomersController implements the CRUD actions for Customer model.
 */
class CustomersController extends CRUDController
{

    /**
     * Init bean class
     */
    public function init()
    {
        $this->beanClass = Customer::className();
        $this->beanSearchClass = CustomerSearch::className();
        $this->extraAccessParams = [
            'viaTable'     => Customer::TABLE_CUSTOMER_OPERATOR,
            'primaryField' => 'customer_id',
            'relateField'  => 'operator_id'
        ];
        parent::init();
    }

    /**
     * @param array $extraParams
     * @return string|\yii\web\Response
     */
    public function actionCreate($extraParams = [])
    {
        /**
         * @var Customer $model
         * @var User $user
         */
        $extraParams = [
            'users'   => Customer::getUnlinkedUsers(),
            'user'    => null,
            'address' => null,
        ];
        $model = new Customer();
        $user = new User();
        $address = new Address();
        $user->scenario = User::SCENARIO_UPDATE_PROFILE;
        $extraParams['user'] = $user;
        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            $model->user_id = $user->id;
            $model->load(Yii::$app->request->post());
            $model->save();
            $address->user_id = $user->id;
            $address->load(Yii::$app->request->post());
            $address->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', ArrayHelper::merge([
                'model' => $model,
            ], $extraParams));
        }
    }

    /**
     * @param $id
     * @param bool $returnModel
     * @param array $extraParams
     * @return mixed
     */
    public function actionUpdate($id, $returnModel = false, $extraParams = [])
    {
        /**
         * @var Customer $model
         * @var User $user
         */
        $extraParams = [
            'users'   => Customer::getUnlinkedUsers(),
            'user'    => null,
            'address' => null,
        ];
        $model = $this->getModel($id);
        $user = $model->user;
        $address = $user->getAddress();
        $user->scenario = User::SCENARIO_UPDATE_PROFILE;
        $extraParams['user'] = $user;
        $extraParams['address'] = $address;
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $user->load(Yii::$app->request->post());
            $user->save();
            $address->load(Yii::$app->request->post());
            $address->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', ArrayHelper::merge([
                'model' => $model,
            ], $extraParams));
        }
    }

    /**
     * @param null $id
     * @return array
     */
    public function actionValidate($id = null)
    {
        /**
         * @var Customer $model
         * @var User $user
         */
        $model = new Customer();
        $user = new User();
        $address = new Address();
        if (isset($id)) {
            $model = $this->findModel($id);
            $user = User::findOne($model->user_id);
            $address = $user->getAddress();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $user->load(Yii::$app->request->post());
            $user->scenario = User::SCENARIO_UPDATE_PROFILE;
            $address->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $errors = ArrayHelper::merge(ActiveForm::validate($model), ActiveForm::validate($user), ActiveForm::validate($address));
            return $errors;
        }
        return [];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionHeartBeat($id)
    {
        $customer = $this->getModel($id);

        return $this->render("heart-beat", [
            'model' => $customer,
        ]);
    }

    /**
     * Action for the validation of the form for the graph building
     * @return array
     */
    public function actionValidateHeartBeatRange()
    {
        $model = new HeartBeatRange();
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $errors = ActiveForm::validate($model);
            return $errors;
        }
    }

    /**
     * Build the heart beat report
     * @param $id
     * @return string
     */
    public function actionHeartBeatReport($id)
    {
        /**
         * @var Customer $customer
         */
        $customer = $this->getModel($id);
        $rangeModel = new HeartBeatRange();

        return $this->render("heart-beat-report", [
            'model'      => $customer,
            'rangeModel' => $rangeModel,
        ]);
    }


    public function actionHeartBeatBot($id)
    {
        /**
         * @var Customer $customer
         */
        $customer = $this->findModel($id);
        echo "Bot................." . PHP_EOL;
        $counter = 2400;
        ini_set('max_execution_time', 10);
        /**
         * Create bot pulse
         */
        $url = "ws://" . $_SERVER['HTTP_HOST'] . ":9000/echobot";
        $wsClient = new WebsocketClient($url);
        $operators = $customer->getPulseDataReceivers();
        while ($counter--) {
            $value = 1;
            $hModel = new HeartBeat();
            $hModel->user_id = $customer->user_id;
            $hModel->save();
            foreach ($operators as $operator) {
                $data = json_encode([
                    'method' => 'pushNotification',
                    'data'   => [
                        'userID'   => $operator->id,
                        'customer' => $customer->attributes,
                        'point'    => [
                            'x' => false,
                            'y' => $value
                        ],
                        'bpm'      => $customer->getBeatsPerMinute(),
                        'beatID'   => $hModel->id,
                    ]
                ]);
                $wsClient->send($data);
            }
            usleep(500000);
        }
    }


}
