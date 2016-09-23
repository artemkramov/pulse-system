<?php

use common\modules\i18n\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\FrontendHelper;

/**
 * @var \common\models\User $user
 */

echo \frontend\components\SeoHelper::setTitle($this, [
    'type' => 'account'
], null);
?>
<div>
    <h1><?= Module::t('Profile') ?></h1>
    <div class="">
        <?= sprintf(Module::t('Hello, %s%. (%s). In your account you can see your orders.'),
            Html::tag('strong', $user->username), Html::a(Module::t('Exit'), \yii\helpers\Url::to('/cabinet/default/logout'))) ?>
    </div>
    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-6 profile-block-index">
            <a href="<?= FrontendHelper::formLink('/cabinet/account/profile') ?>" class="profile-index-link">
                <h2><?= Module::t('Account details') ?></h2>
                <p><?= Module::t('View or change your sign-in information.') ?></p>
            </a>
        </div>
        <div class="wpb_column vc_column_container vc_col-sm-6 profile-block-index">
            <a href="<?= FrontendHelper::formLink('/cabinet/account/address') ?>" class="profile-index-link">
                <h2><?= Module::t('Address book') ?></h2>
                <p><?= Module::t('Edit address data.') ?></p>
            </a>
        </div>
    </div>
</div>
