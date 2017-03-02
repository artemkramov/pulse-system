<?
use common\modules\i18n\Module;

/**
 * @var \common\models\Customer[] $customers
 * @var array $statistic
 * @var array $diseaseData
 */

$this->title = Module::t('Dashboard');
\backend\components\BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge([
    'multiple' => Module::t('Dashboard')
], [
    'type' => 'index'
]));


?>
<div class="dashboard-default-index">

    <?= $this->render('statistic', [
        'statistic' => $statistic
    ]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?=  $this->render('online-customers', [
                'customers' => $customers
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $this->render('graph-disease', [
                'statistic' => $statistic['diseaseData']
            ]) ?>
        </div>
    </div>
</div>
