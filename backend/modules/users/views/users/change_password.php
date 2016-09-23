<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\modules\i18n\Module;

$this->title = Module::t('Change password') . ': ' . ' ' . $model->username;
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['options'                => ['enctype' => 'multipart/form-data'],
                                     'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>

    <div class="form-group" style="margin-top: 10px">
        <?= Html::submitButton($model->isNewRecord ? Module::t('Create') : Module::t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div> 
