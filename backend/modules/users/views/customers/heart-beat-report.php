<?php

use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/**
 * @var \common\models\Customer $model
 * @var \backend\models\HeartBeatRange $rangeModel
 * @var array $dataPoints
 */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Customer::getLabels(), [
    'type' => 'view',
]), $model);

$this->registerJsFile(\yii\helpers\Url::home() . '/js/Report.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<? $form = \yii\bootstrap\ActiveForm::begin([
    'enableAjaxValidation'   => true,
    'enableClientValidation' => false,
    'id'                     => 'range-form',
    'validationUrl'          => \yii\helpers\Url::to(['validate-heart-beat-range', 'id' => $model->id]),
    'options'                => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row">
    <div class="col-sm-6">
        <?= \yii\helpers\Html::hiddenInput('', $model->id, [
            'id' => 'customer-id'
        ])?>
        <?= $form->field($rangeModel, 'startTime')->widget(\kartik\datetime\DateTimePicker::className(),
            [
                'options' => [
                    'class' => 'form-control'
                ]
            ]
        )->label(Module::t('Start time')) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($rangeModel, 'endTime')->widget(\kartik\datetime\DateTimePicker::className(),
            [
                'options' => [
                    'class' => 'form-control'
                ]
            ]
        )->label(Module::t('End time')) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?= \yii\helpers\Html::submitButton(Module::t('Show plot'), [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>

<? \yii\bootstrap\ActiveForm::end(); ?>

<div id="chart-container" style="height: 300px; width: 100%;"></div>

<div class="row">
    <div class="col-sm-12">
        <?= \yii\helpers\Html::a(Module::t("Back to list"), \yii\helpers\Url::to(['index']), [
            'class' => 'btn btn-default'
        ]) ?>
    </div>
</div>
