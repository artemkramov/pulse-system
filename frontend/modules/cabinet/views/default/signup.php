<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\i18n\Module;

$this->title = \common\modules\i18n\Module::t('Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id'      => 'form-signup',
                'options' => [
                    'class' => 'signup-form'
                ]
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'class'     => 'form-input'
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'class' => 'form-input'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'form-input'
            ]) ?>

            <?= $form->field($model, 'subscription')->checkbox([
                'class' => 'icheckbox'
            ])->label(Module::t('I would like to receive news from Jenadin')) ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Signup'), ['class' => 'btn btn-black btn-signup', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
