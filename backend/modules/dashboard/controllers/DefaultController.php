<?php

namespace backend\modules\dashboard\controllers;

use backend\controllers\CRUDController;
use common\models\search\Customer;
use common\models\Threat;
use common\models\User;
use yii\web\Controller;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends CRUDController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $onlineCustomers = Customer::getOnlineCustomers();
        $statistic = $this->getStatistic();
        return $this->render('index', [
            'customers' => $onlineCustomers,
            'statistic' => $statistic
        ]);
    }

    /**
     * @return array
     */
    private function getStatistic()
    {
        $data = [
            'doctors'     => count(User::getOperators()),
            'customers'   => Customer::find()->count(),
            'online'      => count(Customer::getOnlineCustomers(true)),
            'diseaseData' => Threat::getDiseaseStatistic()
        ];

        return $data;
    }
}
