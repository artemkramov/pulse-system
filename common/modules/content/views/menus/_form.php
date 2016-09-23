<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(\Yii::$app->homeUrl . "/js/Menu.js", [
    'depends' => [
        'yii\web\JqueryAsset'
    ]
]);

?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= \common\widgets\MultiLanguageInput::widget([
        'form'       => $form,
        'model'      => $model,
        'field'      => 'title',
        'parameters' => [

        ],
        'title'      => \common\modules\i18n\Module::t('Title')
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'parent_id')->dropDownList(\common\models\Menu::getMenuDropdown($model->id), ['class' => 'form-control']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'bean_id')->dropDownList(\common\models\Post::listAllLocalized()) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'enabled')->checkbox() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'menu_type_id')->dropDownList(\backend\models\MenuType::listAll()) ?>
        </div>
    </div>

    <? $isCustomUrl = isset($model->url);
    $class = $isCustomUrl ? '' : 'hidden';
    ?>
    <?= $form->field($model, 'isCustomUrl')->checkbox(['class' => 'spoiler-checkbox', 'data-toggle' => 'isCustomUrl']) ?>
    <div class="<?= $class?>" data-container="isCustomUrl">
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'bean_type')->hiddenInput(['value' => 'post'])->label(false) ?>

    <?= \backend\widgets\FormButtons::widget([
        'model' => $model
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
