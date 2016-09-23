<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\modules\i18n\Module;

/**
 * @var \common\models\Address $model
 */

echo \frontend\components\SeoHelper::setTitle($this, [
    'type' => 'account'
], null);
echo \common\widgets\Alert::widget();
?>
<h1><?= Module::t('Address book') ?></h1>
<? $form = ActiveForm::begin(); ?>

<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'first_name')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'last_name')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>

<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'phone')->textInput([
            'class'       => 'form-input',
            'data-type'   => 'phone',
            'placeholder' => '(###) ###-##-##',
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'country_id')->dropDownList(\common\models\Country::getDropdownList(), [
            'class' => 'form-input'
        ]) ?>
    </div>
</div>

<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'region')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'city')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>

<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'street')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'building')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>

<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'flat')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'zip')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>

<div class="form-group profile-buttons">

    <?= \yii\helpers\Html::submitButton(Module::t('Save'), [
        'class' => 'btn btn-black btn-uppercase btn-profile-save'
    ]) ?>

    <?= \yii\helpers\Html::a(Module::t('Back to profile view'), \yii\helpers\Url::to('index'), [
        'class' => 'btn btn-white btn-uppercase'
    ]) ?>

</div>

<? ActiveForm::end(); ?>
