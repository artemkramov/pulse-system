<?php

use common\modules\i18n\Module;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\Profile $model
 */

echo \frontend\components\SeoHelper::setTitle($this, [
    'type' => 'account'
], null);

echo \common\widgets\Alert::widget();
?>
<h1><?= Module::t('Profile') ?></h1>
<? $form = ActiveForm::begin(); ?>
<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'username')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'email')->textInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>
<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'newPassword')->passwordInput([
            'class' => 'form-input'
        ]) ?>
    </div>
    <div class="wpb_column vc_column_container vc_col-sm-6">
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
            'class' => 'form-input'
        ]) ?>
    </div>
</div>
<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-12">
        <?= $form->field($model, 'subscription')->checkbox([
            'class' => 'icheckbox'
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
