<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/* @var $this yii\web\View */
/* @var $model backend\models\Currency */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\backend\models\Currency::getLabels(), [
    'type' => 'view'
]), $model);
?>
<div class="currency-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\widgets\DetailViewButtons::widget([
        'model' => $model
    ]) ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'name',
            'iso_4217',
            'sign',
            [
                'attribute' => 'is_default',
                'label' => Module::t('Default'),
                'value' => \backend\components\SiteHelper::getCheckboxSign($model->is_default)
            ],
        ],
    ]) ?>

</div>
