<?php

use common\modules\i18n\Module;

/**
 * @var \yii\bootstrap\ActiveForm $form
 * @var \common\models\Bean $model
 * @var string $attribute
 * @var string $fileAttribute
 */

?>
<div class="form-group">
    <?= $form->field($model, $fileAttribute)->fileInput() ?>
    <? if (!empty($model->{$attribute})): ?>
        <?= $form->field($model, $attribute)->hiddenInput([
            'data-input' => $fileAttribute
        ])->label(false) ?>
        <button type="button" data-remove="<?= $fileAttribute ?>" class="btn btn-danger btn-remove-image"><?= Module::t('Remove') ?></button>
        <a class="fancybox" rel="group" href="<?= $model->{$attribute} ?>">
            <img src="<?= $model->{$attribute} ?>" class="image-preview" />
        </a>
    <? endif; ?>
</div>