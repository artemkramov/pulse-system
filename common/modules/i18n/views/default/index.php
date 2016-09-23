<?
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use common\modules\i18n\Module;
use backend\components\BreadcrumbHelper;

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Lang::getLabels(), [
    'type' => 'index'
]));
?>
<div class="message-index">
    <h3><?= Html::encode($this->title) ?></h3>
    <?php
    //Pjax::begin();
    echo GridView::widget([
        'filterModel'  => $searchModel,
        'dataProvider' => $dataProvider,
        'columns'      => [
            [
                'attribute' => 'id',
                'value'     => function ($model, $index, $dataColumn) {
                    return $model->id;
                },
                'label'     => Module::t('Id'),
                'filter'    => false
            ],
            [
                'attribute' => 'message',
                'label'     => Module::t('Message'),
                'format'    => 'raw',
                'value'     => function ($model, $index, $widget) {
                    return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
                }
            ],
            [
                'attribute' => 'category',
                'label'     => Module::t('Category'),
                'value'     => function ($model, $index, $dataColumn) {
                    return $model->category;
                },
                'filter'    => ArrayHelper::map($searchModel::getCategories(), 'category', 'category')
            ],
            [
                'attribute' => 'status',
                'label'     => Module::t('Status'),
                'value'     => function ($model, $index, $widget) {
                    /** @var SourceMessage $model */
                    return $model->isTranslated() ? Module::t('Translated') : Module::t('Not translated');
                },
                'filter'    => $searchModel->getStatus()
            ],
            ['class' => \yii\grid\ActionColumn::className(), 'template' => '{update}',

            ],
        ]
    ]);
    //Pjax::end();
    ?>
</div>