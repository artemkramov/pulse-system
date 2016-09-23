<div class="row">
    <div class="col-sm-6">
        <?= $form->field($user, 'username')->textInput(['class' => 'form-control']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($user, 'email')->textInput() ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($user, 'new_password')->passwordInput() ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($user, 'new_password_repeat')->passwordInput() ?>
    </div>
</div>