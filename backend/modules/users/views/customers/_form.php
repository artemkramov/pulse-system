<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\i18n\Module;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
/**
 * @var \common\models\User $user
 * @var \common\models\Address $address
 */

if (!isset($user)) {
    $user = new \common\models\User();
}
if (!isset($address)) {
    $address = new \common\models\Address();
}

?>

<div class="customer-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
        'id'                     => 'customer-form',
        'validationUrl'          => \yii\helpers\Url::to(['validate', 'id' => $model->id]),
        'options'                => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'mac_address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'date_registrated')->widget(\yii\jui\DatePicker::className(),
                [
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]
            )->label(Module::t('Dateregistrated')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($user, 'username')->textInput()->label(Module::t('Username')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($user, 'email')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($user, 'new_password')->passwordInput()->label(Module::t('New Password')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($user, 'new_password_repeat')->passwordInput()->label(Module::t('New Password Repeat')) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($address, 'country_id')->dropDownList(\common\models\Country::getDropdownList()) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($address, 'city')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($address, 'region')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($address, 'street')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($address, 'building')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($address, 'flat')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($address, 'phone')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($address, 'zip')->textInput() ?>
        </div>
    </div>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
