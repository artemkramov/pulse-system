<?

use backend\components\BreadcrumbHelper;

$this->registerJsFile('/admin/js/Sort.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$labels = \common\models\Menu::getLabels();

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge($labels, [
    'type' => 'sort'
]));
?>
<div class="menu-view">
    <div id="tree1" class="form-group">

    </div>
    <? $form = \yii\bootstrap\ActiveForm::begin([
        'options' => [
            'class' => 'form-sort'
        ]
    ]); ?>

    <div class="form-group">
        <?
        $fakeModel = new \common\models\Menu();
        $fakeModel->isNewRecord = false;
        echo \backend\widgets\FormButtons::widget([
            'model' => $fakeModel
        ]); ?>
    </div>
    <? \yii\bootstrap\ActiveForm::end(); ?>
</div>