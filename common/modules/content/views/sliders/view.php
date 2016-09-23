<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(backend\models\Slider::getLabels(), [
    'type' => 'view'
]), $model);
?>
<div class="slider-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model' => $model
    ]) ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'name',
            'alias',
        ],
    ]) ?>

</div>
