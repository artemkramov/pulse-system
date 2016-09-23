<?

use frontend\components\FrontendHelper;
use common\modules\i18n\Module;

/**
 * @var \common\models\Address $address
 */

?>
<ul class="my-account status-signed-<?= Yii::$app->user->isGuest ? 'out' : 'in' ?>">
    <div class="cube">
        <? if (isset($address) && !empty($address) && !empty($address->first_name) && !empty($address->last_name)): ?>
            <li class="customer-details">

                <a href="<?= FrontendHelper::formLink('/cabinet/account/index') ?>">
                                    <span
                                        class="first-name"><?= $address->first_name . ' ' ?></span>
                    <span class="surname"><?= $address->last_name ?></span>
                </a>

            </li>
        <? else: ?>
            <li class="my-account-link">
                <a href="<?= FrontendHelper::formLink('/cabinet/account/index') ?>">
                    <?= Module::t('Profile') ?>
                </a>
            </li>
        <? endif; ?>
    </div>
    <div class="profile-mobile-account">
        <li class="">
            <a href="<?= FrontendHelper::formLink('/cabinet/account/index') ?>">
                <?= Module::t('My account') ?>
            </a>
        </li>
    </div>
    <li class="register">
        <a href="<?= FrontendHelper::formLink('/cabinet/default/signup') ?>">
            <?= Module::t('Signup') ?>
        </a>
    </li>
    <div class="separator"></div>
    <li class="sign-in">
        <a href="<?= FrontendHelper::formLink('/cabinet/default/login') ?>">
            <?= Module::t('Sign in') ?>
        </a>
    </li>
    <li class="wishlist">
        <a href="<?= FrontendHelper::formLink('/cabinet/account/favourite') ?>">
            <?= Module::t('Wish list') ?>
        </a>
    </li>
</ul>