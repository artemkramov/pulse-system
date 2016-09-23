<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactFormSetting */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\backend\models\ContactFormSetting::getLabels(), [
    'type'        => 'view',
    'customTitle' => \common\modules\i18n\Module::t('Contact form')
]), $model);
?>
<div class="contact-form-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model' => $model
    ]) ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'to',
            'from',
            'subject',
        ],
    ]) ?>

</div>
