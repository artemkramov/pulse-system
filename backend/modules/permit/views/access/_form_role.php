<?php
namespace developeruz\db_rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\rbac\Role;
use yii\widgets\ActiveForm;
use common\modules\i18n\Module;

/** @var Role $role
 * @var array $role_permit
 * @var array $permissions
 */

$this->title = empty($role->name) ? Module::t('Create role') : Module::t('Edit role: ') . ' ' . $role->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('db_rbac', 'Role management'), 'url' => ['role']];
$this->params['breadcrumbs'][] = Yii::t('db_rbac', 'Edit');
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
                    <?= Html::label(Module::t('Role name')); ?>
                    <?= Html::textInput('name', $role->name, ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?= Html::label(Module::t('Description')); ?>
                    <?= Html::textInput('description', $role->description, ['class' => 'form-control']); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::label(Module::t('Allowed accesses')); ?>
            <? foreach ($permissions as $permission): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= $permission['description'] ?> <?= Html::checkbox('permissions[]',
                            in_array($permission['name'], $role_permit) ? true : false, [
                                'value'     => $permission['name'],
                                'class'     => 'checkbox-mass',
                                'data-item' => $permission['name']
                            ]) ?>
                    </div>
                    <? if (array_key_exists('children', $permission)): ?>
                        <div class="panel-body">
                            <ul class="child-roles-list">
                                <? foreach ($permission['children'] as $child): ?>
                                    <li><?= $child['description'] ?> <?= Html::checkbox('permissions[]', in_array($child['name'], $role_permit) ? true : false,
                                            [
                                                'value'       => $child['name'],
                                                'data-parent' => $permission['name']
                                            ]) ?></li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    <? endif; ?>
                </div>
            <? endforeach; ?>
            <? //= Html::checkboxList('permissions', $role_permit, $permissions, ['separator' => '<br>']);
            ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success']) ?>
            <?= Html::a(Module::t('Back to list'), ['role'], ['class' => 'btn btn-default'])?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
