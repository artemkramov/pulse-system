<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\i18n\Module;

$this->title = Module::t('Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \common\widgets\Alert::widget() ?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('Please choose your new password:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'form-input'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Save'), ['class' => 'btn btn-black btn-uppercase']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>