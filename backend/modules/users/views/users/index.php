<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\i18n\Module;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \common\models\User::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
            [
                'label'     => Module::t('Id'),
                'attribute' => 'id',
            ],
            [
                'label'     => Module::t('Username'),
                'attribute' => 'username',
                //'header'    => '55'
            ],
            [
                'label'     => Module::t('Email'),
                'attribute' => 'email',
            ],
            [
                'attribute' => 'subscription',
                'value'     => function ($model) {
                    return \backend\components\SiteHelper::getCheckboxSign($model->subscription);
                },
                'filter'    => Html::activeDropDownList($searchModel, 'subscription', \backend\components\SiteHelper::getCheckboxDropdown(),
                    [
                        'class' => 'form-control'
                    ])
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => \backend\components\SiteHelper::getListTemplate([
                    'view', 'update', 'delete'
                ])
            ],

        ],
    ]); ?>

</div>
