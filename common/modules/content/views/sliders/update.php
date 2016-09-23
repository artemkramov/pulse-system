<?php

use yii\helpers\Html;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\backend\models\Slider::getLabels(), [
    'type' => 'update'
]), $model);
?>
<div class="slider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
