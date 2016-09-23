<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\i18n\Module;

$this->title = \common\modules\i18n\Module::t('Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Module::t('Enter to the cabinet') ?></h1>

    <div class="">
        <div class="">
            <?php $form = ActiveForm::begin([
                'id'      => 'login-form',
                'options' => [
                    'class' => 'login-form'
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus'   => true,
                'class'       => 'form-input',
                'placeholder' => Module::t('Login'),
            ])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class'       => 'form-input',
                'placeholder' => Module::t('Password'),
            ])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'class' => 'icheckbox'
            ]) ?>

            <div class="forget-password">
                <?= Html::a(Module::t('Forget password?'), ['/cabinet/default/request-password-reset'], [
                ]) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Enter'), ['class' => 'btn btn-black btn-login', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
