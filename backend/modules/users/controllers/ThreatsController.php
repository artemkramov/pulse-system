<?php

namespace backend\modules\users\controllers;

use backend\components\AccessHelper;
use backend\controllers\CRUDController;
use common\models\Threat;
use common\models\Search\ThreatSearch;
use common\models\User;
use yii\web\ForbiddenHttpException;

/**
 * ThreatsController implements the CRUD actions for Threat model.
 */
class ThreatsController extends CRUDController
{

    /**
     * Init bean class
     */
    public function init()
    {
        $this->beanClass = Threat::className();
        $this->beanSearchClass = ThreatSearch::className();
        parent::init();
    }

    /**
     * @param int $id
     * @param bool $returnModel
     * @param array $extraParams
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id, $returnModel = false, $extraParams = [])
    {
        /**
         * @var Threat $threat
         */
        $threat = $this->findModel($id);
        $accessHelper = new AccessHelper();
        $customerIds = $accessHelper->getFilter();
        if (!in_array($threat->customer_id, $customerIds) && !User::isAdmin()) {
            throw new ForbiddenHttpException();
        }
        return parent::actionView($id, $returnModel, $extraParams);
    }

    /**
     * @param array $extraParams
     * @throws ForbiddenHttpException
     * @return null
     */
    public function actionCreate($extraParams = [])
    {
        throw new ForbiddenHttpException();
    }

    /**
     * @param $id
     * @param bool $returnModel
     * @param array $extraParams
     * @throws ForbiddenHttpException
     * @return null
     */
    public function actionUpdate($id, $returnModel = false, $extraParams = [])
    {
        throw new ForbiddenHttpException();
    }

}
