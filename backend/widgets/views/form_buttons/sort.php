<?
use common\modules\i18n\Module;
use \backend\components\SiteHelper;


if (SiteHelper::checkActionPermission(['sort'])) {
    echo \yii\helpers\Html::a('<i class="fa fa-sort"></i> ' . Module::t('Sort action'),
        \backend\components\AccessHelper::formPrimaryUrl('sort'), ['class' => 'btn btn-primary']);
}