<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ContactFormSetting */

$this->title = 'Create Contact Form Setting';
$this->params['breadcrumbs'][] = ['label' => 'Contact Form Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-form-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
