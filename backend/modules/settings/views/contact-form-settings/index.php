<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContactFormSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$labels = \backend\models\ContactFormSetting::getLabels();
BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'index'
]));
?>
<div class="contact-form-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'to',
            'from',
            'subject',

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => \backend\components\SiteHelper::getListTemplate([
                    'view', 'update', 'delete'
                ])
            ],
        ],
    ]); ?>
</div>
