<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
        'id'                     => 'slider-form',
        'validationUrl'          => \yii\helpers\Url::to(['validate', 'id' => $model->id]),
        'options'                => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php
    echo $form->field($model, 'sliderItems')->widget(\backend\widgets\multiple_bean\MultipleBean::className(), [
        'title' => \common\modules\i18n\Module::t('Images'),
        'min'   => 0
    ])->label(false);
    ?>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
