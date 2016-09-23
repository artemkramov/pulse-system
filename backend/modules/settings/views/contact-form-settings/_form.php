<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactFormSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form-setting-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => 1
        ]
    ]); ?>

    <?= $form->field($model, 'to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea([
        'rows'       => 6,
        'data-group' => 'contactForm',
        'class'      => 'form-control textarea-common'
    ]) ?>

    <?= Html::hiddenInput('', json_encode([
        'contactForm' => [
            '[CONTACT_FORM_NAME]'    => \common\modules\i18n\Module::t('Name'),
            '[CONTACT_FORM_EMAIL]'   => 'Email',
            '[CONTACT_FORM_MESSAGE]' => \common\modules\i18n\Module::t('Message')
        ]
    ]), [
        'id' => 'json-templates',
    ]) ?>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
