<?php
namespace backend\modules\permit\views\access;

use Yii;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\i18n\Module;

$this->title = Module::t('Role management');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Module::t('Add role'), ['create-role'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $dataProvider = new ArrayDataProvider([
        'allModels'  => Yii::$app->authManager->getRoles(),
        'sort'       => [
            'attributes' => ['name', 'description'],
        ],
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'name',
                'label'     => Module::t('Role')
            ],
            [
                'class'     => DataColumn::className(),
                'attribute' => 'description',
                'label'     => Module::t('Description')
            ],
            [
                'class'  => DataColumn::className(),
                'label'  => Module::t('Allowed accesses'),
                'format' => ['html'],
                'value'  => function ($data) {
                    return implode('<br>', array_keys(ArrayHelper::map(Yii::$app->authManager->getPermissionsByRole($data->name), 'description', 'description')));
                }
            ],
            ['class'    => 'yii\grid\ActionColumn',
             'template' => '{update} {delete}',
             'buttons'  =>
                 [
                     'update' => function ($url, $model) {
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-role', 'name' => $model->name]), [
                             'title'     => Module::t('Update'),
                             'data-pjax' => '0',
                         ]);
                     },
                     'delete' => function ($url, $model) {
                         return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete-role', 'name' => $model->name]), [
                             'title'        => Module::t('Delete'),
                             'data-confirm' => Module::t('Are you sure you want to delete this item?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                         ]);
                     }
                 ]
            ],
        ]
    ]);
    ?>
</div>