<?php
use yii\helpers\Html;

/** @var $current \common\models\Lang
 * @var $langs array
 */
?>
<ul class="nav navbar-left navbar-lang">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
           aria-expanded="false">
            <i class="lang-sm lang-sm-<?= $current->url ?>"></i>
            <?= $current->name ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <? foreach ($langs as $lang) { ?>
                <li>
                    <a href="<?= '/' . $lang->url . Yii::$app->getRequest()->getLangUrl() ?>" class="lang-switcher">
                        <i class="lang-sm lang-sm-<?= $lang->url ?>"></i>
                        <?= $lang->name ?>
                    </a>
                </li>
            <? } ?>
        </ul>
    </li>
</ul>