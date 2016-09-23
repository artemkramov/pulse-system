<?php

use common\modules\i18n\Module;
use yii\helpers\Html;

/**
 * @var string $label
 * @var string $inputName
 * @var string $controllerPopup
 * @var string $controllerView
 * @var string $labelField
 * @var \common\models\Bean $relatedBean
 * @var array $options
 * @var string $counter
 */

$uniqueRow = \backend\components\SiteHelper::generateUUID();

?>

<div class="form-group related-bean-row clearfix" data-row="<?= $uniqueRow ?>">
    <label class="control-label"><?= $label ?></label>
    <div class="<?= array_key_exists('id', $options) ? 'form-group field-' . $options['id'] : '' ?>">
        <?= Html::hiddenInput($inputName, isset($relatedBean) ? $relatedBean->id : '', \yii\helpers\ArrayHelper::merge([
            'id' => $uniqueRow
        ],$options, [
            'class' => 'related-bean-value'
        ])) ?>
        <div class="help-block"></div>
        <?
        $options = [
            'class'  => 'related-bean-link',
            'target' => '_blank',
        ];
        if (isset($relatedBean)) {
            if (method_exists($relatedBean, 'getDefaultImage')) {
                echo Html::img($relatedBean->getDefaultImage(), [
                    'class' => 'related-bean-image'
                ]);
            }
            echo Html::a($relatedBean->{$labelField}, \yii\helpers\Url::to([$controllerView, 'id' => $relatedBean->id]), $options);

        } else {
            echo Html::a(Module::t('Nothing is selected'), '#', $options);
        } ?>
        <?= Html::hiddenInput('', Module::t('Nothing is selected'), [
            'class' => 'related-title',
            'id'    => 'related-title-' . $uniqueRow,
        ]) ?>
        <div class="related-bean-controls">
            <button type="button" class="btn btn-default btn-add-related-bean"
                    data-href="<?= \yii\helpers\Url::to([$controllerPopup, 'labelField' => $labelField]) ?>">
                <i class="glyphicon glyphicon-plus"></i>
            </button>
            <button type="button" class="btn btn-danger btn-remove-related-bean">
                <i class="glyphicon glyphicon-remove"></i>
            </button>
        </div>
    </div>
</div>