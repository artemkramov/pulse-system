<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \backend\models\Slider::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="slider-index">

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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'alias',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
