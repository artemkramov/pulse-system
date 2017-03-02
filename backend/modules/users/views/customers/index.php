<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Customer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \common\models\Customer::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= \backend\widgets\FormButtons::widget([
            'model'      => false,
            'type'       => 'create',
            'modelLabel' => $labels['singular']
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'mac_address',
            [
                'attribute' => 'user_id',
                'value'     => function ($model) {
                    /**
                     * @var \common\models\Customer $model
                     */
                    $user = $model->user;
                    return isset($user) ? $user->username : '';
                }
            ],
            [
                'attribute' => 'isOnline',
                'label'     => \common\modules\i18n\Module::t('Status'),
                'format'    => 'raw',
                'value'     => function ($model) {
                    /**
                     * @var \common\models\Customer $model
                     */
                    $class = $model->isOnline() ? 'online' : 'offline';
                    return Html::tag('span', '', [
                        'class' => 'customer-status fa fa-dot-circle-o ' . $class
                    ]);
                },
                'filter'    => Html::activeDropDownList($searchModel, 'isOnlineFlag', [
                        '' => '',
                        0  => Module::t('Offline'),
                        1  => Module::t('Online')
                    ],
                    [
                        'class' => 'form-control'
                    ])
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'buttons'  => [
                    'heart-beat'        => function ($url, $model) {
                        $icon = "heartbeat";
                        return Html::a('<span class="fa fa-' . $icon . '"></span> ', $url);
                    },
                    'heart-beat-report' => function ($url, $model) {
                        $icon = "stats";
                        return Html::a('<span class="glyphicon glyphicon-' . $icon . '"></span> ', $url);
                    }
                ],
                'template' => \backend\components\SiteHelper::getListTemplate([
                    'heart-beat', 'heart-beat-report', 'view', 'update', 'delete'
                ])
            ],
        ],
    ]); ?>
</div>
