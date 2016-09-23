<?php
use yii\helpers\Html;
use common\modules\i18n\Module;
/* @var $this yii\web\View */
/* @var $user common\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['cabinet/default/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Module::t('Hello') ?> <?= Html::encode($user->username) ?>,</p>

    <p><?= Module::t('Follow the link below to reset your password:')?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>