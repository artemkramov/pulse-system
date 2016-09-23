<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= \common\widgets\MultiLanguageInput::widget([
        'form'       => $form,
        'model'      => $model,
        'field'      => 'title',
        'parameters' => [

        ],
        'title'      => \common\modules\i18n\Module::t('Title')
    ]); ?>

    <?= \common\widgets\MultiLanguageInput::widget([
        'form'       => $form,
        'model'      => $model,
        'field'      => 'content',
        'parameters' => [
            'textarea' => [
                'data-group' => 'common'
            ]
        ],
        'title'      => \common\modules\i18n\Module::t('Text')
    ]); ?>

    <?= $form->field($model, 'template')->dropDownList(\common\models\Post::getTemplates()) ?>

    <?= $form->field($model, 'alias')->textInput() ?>

    <?= $form->field($model, 'enabled')->checkbox() ?>

    <?= $form->field($model, 'default')->checkbox() ?>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
