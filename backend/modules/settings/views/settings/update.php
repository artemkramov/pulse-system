<?php

use yii\helpers\Html;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Setting::getLabels(), [
    'type'        => 'update',
    'customTitle' => \common\modules\i18n\Module::t('Settings'),
]), $model);
?>
<div class="setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
