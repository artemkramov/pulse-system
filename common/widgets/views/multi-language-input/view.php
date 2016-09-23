<?php

use common\models\Lang;

?>
<label><?= $title ?></label>
<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($languages as $language) : ?>
        <li role="presentation" class="<? if ($language->url == Lang::getCurrent()->url) echo 'active' ?>">
            <? $tab = $language->url . $field; ?>
            <a href="#<?= $tab ?>" aria-controls="<?= $tab ?>" role="tab" data-toggle="tab">
                <i class="lang-sm lang-sm-<?= $language->url ?>"></i>
                <?= $language->name ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<div class="tab-content">
    <? foreach ($languages as $language): ?>
        <? $tab = $language->url . $field; ?>
        <div role="tabpanel"
             class="tab-pane <? if ($language->url == Lang::getCurrent()->url) echo 'active' ?>"
             id="<?= $tab ?>">
            <?
            $fieldData = $form->field($model, \common\models\Bean::getMultiAttributeName($field, $language->url))->label(false);
            foreach ($parameters as $function => $options) {
                $fieldData = $fieldData->{$function}($options);
            }
            echo $fieldData;
            ?>
        </div>
    <? endforeach; ?>
</div>