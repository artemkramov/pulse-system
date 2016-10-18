<?php

namespace backend\modules\users\controllers;

use backend\controllers\CRUDController;
use common\models\Threat;
use common\models\Search\ThreatSearch;
use yii\web\ForbiddenHttpException;

/**
 * ThreatsController implements the CRUD actions for Threat model.
 */
class ThreatsController extends CRUDController
{

    public function init()
    {
        $this->beanClass = Threat::className();
        $this->beanSearchClass = ThreatSearch::className();
        parent::init();
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
