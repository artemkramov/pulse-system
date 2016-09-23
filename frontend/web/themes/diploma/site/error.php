<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = \common\modules\i18n\Module::t($name);
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= \common\modules\i18n\Module::t('The above error occurred while the Web server was processing your request.')?>
    </p>
    <p>
        <?= \common\modules\i18n\Module::t('Please contact us if you think this is a server error. Thank you.') ?>
    </p>

</div>
