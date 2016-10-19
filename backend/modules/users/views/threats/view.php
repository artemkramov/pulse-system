<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $model common\models\Threat */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Threat::getLabels(), [
    'type'        => 'view',
    'customTitle' => Module::t('Threat') . ': ' . Module::t($model->alias)
]), $model);
?>
<div class="threat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model'        => $model,
        'excludeViews' => ['update']
    ]) ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'customer_id',
                'value'     => $model->customer->name
            ],
            'created_at',
            'bpm',
        ],
    ]) ?>

</div>
