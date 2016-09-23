<?php

use yii\helpers\Html;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactFormSetting */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\backend\models\ContactFormSetting::getLabels(), [
    'type'        => 'update',
    'customTitle' => \common\modules\i18n\Module::t('Contact form')
]), $model);
?>
<div class="contact-form-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
