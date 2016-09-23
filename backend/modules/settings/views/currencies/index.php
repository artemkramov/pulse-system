<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \backend\models\Currency::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="currency-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= \backend\widgets\FormButtons::widget([
            'model' =>  false,
            'type'  =>  'create',
            'modelLabel'    =>  $labels['singular']
        ]);?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'iso_4217',
            'sign',
            [
                'attribute' => 'is_default',
                'label' => Module::t('Default'),
                'value' => function ($model) {
                    return \backend\components\SiteHelper::getCheckboxSign($model->is_default);
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_default', \backend\components\SiteHelper::getCheckboxDropdown(),
                    [
                        'class' => 'form-control'
                    ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
