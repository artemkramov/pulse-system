<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MenuTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \backend\models\MenuType::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="menu-type-index">

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
            'alias',

            [
                'class'    => 'yii\grid\ActionColumn',
                'buttons'  => [
                    'sort' => function ($url, $model) {
                        $icon = "sort";
                        return Html::a('<span class="fa fa-' . $icon . '"></span> ', $url);
                    }
                ],
                'template' => '{sort} {view} {update} {delete}'
            ],
        ],
    ]); ?>
</div>
