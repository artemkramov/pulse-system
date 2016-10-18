<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\ThreatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \common\models\Threat::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="threat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'customer_id',
                'value'     => function ($model) {
                    /**
                     * @var \common\models\Threat $model
                     */
                    return $model->customer->name;
                },
                'filter'    => Html::activeDropDownList($searchModel, 'customer_id', ['' => ''] + \common\models\Customer::listAll(),
                    [
                        'class' => 'form-control'
                    ])
            ],
            [
                'attribute' => 'alias',
                'value'     => function ($model) {
                    /**
                     * @var \common\models\Threat $model
                     */
                    return \common\modules\i18n\Module::t($model->alias);
                },
                'filter'   => Html::activeDropDownList($searchModel, 'alias', \backend\health\IDisease::getDiseaseDropdown(), [
                    'class' => 'form-control'
                ])
            ],
            'created_at',
            'bpm',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => \backend\components\SiteHelper::getListTemplate([
                    'view', 'delete'
                ])
            ],
        ],
    ]); ?>
</div>
