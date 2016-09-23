<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options'                => ['enctype' => 'multipart/form-data'],
                                     'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'username')->textInput()->label(Module::t('Username')) ?>
    <?= $form->field($model, 'email')->textInput()->label(Module::t('Email')) ?>
    <?= $form->field($model, 'new_password')->passwordInput()->label(Module::t('New Password')) ?>
    <?= $form->field($model, 'new_password_repeat')->passwordInput()->label(Module::t('New Password Repeat')) ?>
    <?= $form->field($model, 'subscription')->checkbox()->label(false) ?>


    <?
    //        echo $form->field($model, 'logo')->widget(InputFile::className(), [
    //            'language'      => 'ru',
    //            'controller'    => 'users/elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    //            'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    //            'template'      => '<div class="wrap-image"><img src="{image}" width="160" data-rel="logo" /></div><div class="input-group">{input}<span class="input-group-btn">{button}{button_remove}</span></div>',
    //            'options'       => ['class' => 'form-control form-image','data-text'=>'logo','type'=>'hidden'],
    //            'buttonOptions' => ['class' => 'btn btn-default'],
    //            //'buttonOptionsRemove' => ['class' => 'btn btn-danger btn-image-remove'],
    //            'multiple'      => false       // возможность выбора нескольких файлов
    //        ])->label(Module::t('Logo'));

    ?>
    <div class="form-group">
        <label><?= Module::t('Role') ?></label>
        <?= Html::dropDownList('roles[]', $user_permit, ['' => ''] + $roles, ['class' => 'form-control']) ?>
    </div>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
