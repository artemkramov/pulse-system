<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\i18n\Module;

$this->title = Module::t('Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \common\widgets\Alert::widget() ?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Module::t('A link to reset password will be sent there.') ?></p>

    <div class="">
        <div class="">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput([
                'class' => 'form-input'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton(Module::t('Send'), ['class' => 'btn btn-black btn-uppercase']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
