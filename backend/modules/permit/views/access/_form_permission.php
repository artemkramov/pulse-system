<?php
namespace backend\modules\permit\views\access;

use Yii;
use yii\helpers\Html;
use yii\rbac\Permission;
use yii\widgets\ActiveForm;
use common\modules\i18n\Module;

/* @var Permission $permit
 * @var array $permissions
 * @var array $extraData
 */

$this->title = empty($permit->name)? Module::t('Create rule') : Module::t('Edit rule: ') . ' ' . $permit->description;
$this->params['breadcrumbs'][] = ['label' => Module::t('Access rules'), 'url' => ['permission']];
$this->params['breadcrumbs'][] = Module::t('Edit rule');
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="links-form">

        <?php
        if (!empty($error)) {
            ?>
            <div class="error-summary">
                <?php
                echo implode('<br>', $error);
                ?>
            </div>
            <?php
        }
        ?>

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?= Html::label(Module::t('Text description')); ?>
                    <?= Html::textInput('description', $permit->description, ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?= Html::label(Module::t('Allowed access')); ?>
                    <?= Html::textInput('name', $permit->name, ['class' => 'form-control']); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?= Html::label(Module::t('Parent permission'));  ?>
                    <?= Html::dropDownList('parent_id', array_key_exists('parent_id', $extraData) ? $extraData['parent_id'] : '', $permissions, ['class' => 'form-control'])?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success']) ?>
            <?= Html::a(Module::t('Back to list'), ['permission'], ['class' => 'btn btn-default'])?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>