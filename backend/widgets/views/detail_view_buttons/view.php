<?php

use yii\helpers\Html;
use common\modules\i18n\Module;
use \backend\components\SiteHelper;
use \backend\components\AccessHelper;

/** @var $model \common\models\Bean */
/**
 * @var array $excludeViews
 */
?>
<p>
    <?
    if (SiteHelper::checkActionPermission(['update']) && !in_array('update', $excludeViews)) {
        echo Html::a(Module::t('Update'),
            \yii\helpers\Url::to([AccessHelper::formPrimaryUrl('update'), 'id' => $model->id]),
            ['class' => 'btn btn-primary']);
    }
    ?>
    <?
    if (SiteHelper::checkActionPermission(['delete']) && !in_array('delete', $excludeViews)) {
        echo Html::a(Module::t('Delete'),
            \yii\helpers\Url::to([AccessHelper::formPrimaryUrl('delete'), 'id' => $model->id]), [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Module::t('Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]);
    }
    ?>
    <?
    if (SiteHelper::checkActionPermission(['index']) && !in_array('index', $excludeViews)) {
        echo Html::a(Module::t('Back to list'), AccessHelper::formPrimaryUrl('index'), ['class' => 'btn btn-default']);
    }
    ?>
</p>