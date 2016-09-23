<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso_4217')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_default')->checkbox(['label' => false])->label(Module::t('Default')) ?>

    <?= $form->field($model, 'show_after_price')->checkbox(['label' => false])->label(Module::t('Show after price')) ?>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
