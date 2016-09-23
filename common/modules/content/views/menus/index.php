<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \common\models\Menu::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="menu-index">

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

            [
                'attribute' => 'title',
                'label'     => \common\modules\i18n\Module::t('Title')
            ],
            [
                'attribute' => 'updated_at',
                'format'    => 'datetime'
            ],

            [
                'attribute' => 'menu_type_id',
                'value'     => function ($model) {
                    return isset($model->menuType) ? $model->menuType->name : '';
                },
                'filter'    => Html::activeDropDownList($searchModel, 'menu_type_id', ['' => ''] + \backend\models\MenuType::listAll(),
                    [
                        'class' => 'form-control'
                    ])
            ],

            [
                'attribute' => 'enabled',
                'value'     => function ($model) {
                    return \backend\components\SiteHelper::getCheckboxSign($model->enabled);
                },
                'filter'    => Html::activeDropDownList($searchModel, 'enabled', \backend\components\SiteHelper::getCheckboxDropdown(),
                    [
                        'class' => 'form-control'
                    ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
