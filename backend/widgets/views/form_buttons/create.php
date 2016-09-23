<?
use common\modules\i18n\Module;
use \backend\components\SiteHelper;


if (SiteHelper::checkActionPermission(['create'])) {
    echo \yii\helpers\Html::a(Module::t('Create ') . ' ' . Module::t($modelLabel),
        \backend\components\AccessHelper::formPrimaryUrl('create'), ['class' => 'btn btn-success']);
}