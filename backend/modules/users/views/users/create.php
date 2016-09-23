<?php

use yii\helpers\Html;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\User::getLabels(), [
    'type' => 'create'
]), $model);
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'user_permit' => $user_permit,
        'roles'       => $roles
    ]) ?>

</div>
