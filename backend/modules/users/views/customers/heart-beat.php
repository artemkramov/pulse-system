<?php

use backend\components\BreadcrumbHelper;
use common\modules\i18n\Module;

/**
 * @var \common\models\Customer $model
 */


BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Customer::getLabels(), [
    'type' => 'view',
]), $model);

?>
<script type="text/javascript">
    var customerID = '<?php echo $model->id ?>';
</script>
<?php

$this->registerJsFile(\yii\helpers\Url::home() . '/js/Socket.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>

<div class="block-beat-per-minute">
    <img class="" src="<?= \yii\helpers\Url::home()?>/uploads/images/heart.png" />
    <span class="beat-per-minute">-</span>
</div>

<?= \yii\helpers\Html::a(Module::t("Back to list"), \yii\helpers\Url::to(['index']), [
    'class' => 'btn btn-default'
])?>
