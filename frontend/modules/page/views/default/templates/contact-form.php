<? $form = \yii\bootstrap\ActiveForm::begin([
    'options' => [
        'class' => 'wpcf7-form'
    ]
]); ?>
<?= \common\widgets\Alert::widget(); ?>
<h2><?= mb_strtoupper(\common\modules\i18n\Module::t('Contact us'), 'UTF-8') ?></h2>

<?= $form->field($model, 'name')->textInput(['class' => 'wpcf7-form-control wpcf7-text']); ?>

<?= $form->field($model, 'email')->textInput(['class' => 'wpcf7-form-control wpcf7-text']); ?>

<?= $form->field($model, 'message')->textarea([
    'class' => 'wpcf7-form-control wpcf7-textarea',
    'cols'  => 40,
    'rows'  => 10
]) ?>

<?= \yii\helpers\Html::submitInput(\common\modules\i18n\Module::t('Send'), ['class' => 'wpcf7-form-control wpcf7-submit'])?>

<? \yii\bootstrap\ActiveForm::end(); ?>