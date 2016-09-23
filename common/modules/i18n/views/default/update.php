<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */
use yii\helpers\Html;
use yii\web\View;
use common\models\SourceMessage;
use common\models\Lang;
use backend\components\BreadcrumbHelper;

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(Lang::getLabels(), [
    'type'  => 'update',
    'field' => 'message'
]), $model);
$suffix = "-message";
?>
<div class="message-update">
    <div class="message-form">
        <?php $form = \yii\widgets\ActiveForm::begin(); ?>
        <div class="field">
            <div class="ui grid">
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($model->messages as $language => $message) : ?>
                        <li role="presentation" class="<? if ($language == Lang::getCurrent()->url) echo 'active' ?>">
                            <? $tab = $language . $suffix; ?>
                            <a href="#<?= $tab ?>" aria-controls="<?= $tab ?>" role="tab" data-toggle="tab">
                                <i class="lang-sm lang-sm-<?= $language ?>"></i>
                                <?= Lang::getLangByUrl($language)->name ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <? foreach ($model->messages as $language => $message): ?>
                        <? $tab = $language . $suffix; ?>
                        <div role="tabpanel"
                             class="tab-pane <? if ($language == Lang::getCurrent()->url) echo 'active' ?>"
                             id="<?= $tab ?>">
                            <?= $form->field($model->messages[$language], '[' . $language . ']translation') ?>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <?= \backend\widgets\FormButtons::widget([
            'model' => $model
        ]); ?>
        <?php $form::end(); ?>
    </div>