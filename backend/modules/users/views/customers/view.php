<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Customer::getLabels(), [
    'type'  => 'view',
]), $model);
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model' => $model
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mac_address',
            'name',
            'age',
            [
                'attribute' => 'operators',
                'value'     => $model->getOperatorsToString(),
                'label'     => \common\modules\i18n\Module::t('Operators')
            ],
        ],
    ]) ?>

</div>
