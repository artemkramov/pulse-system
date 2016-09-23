<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

\backend\components\BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Setting::getLabels(), [
    'type'        => 'view',
    'customTitle' => \common\modules\i18n\Module::t('Settings')
]), $model);
?>
<div class="setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model' => $model
    ]) ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'phone',
        ],
    ]) ?>

</div>
