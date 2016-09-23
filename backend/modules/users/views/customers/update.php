<?php

use yii\helpers\Html;
use backend\components\BreadcrumbHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/**
 * @var \common\models\User $user
 * @var \common\models\Address $address
 */

BreadcrumbHelper::set($this, \yii\helpers\ArrayHelper::merge(\common\models\Customer::getLabels(), [
    'type' => 'update',
]), $model);
?>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'   => $model,
        'user'    => $user,
        'address' => $address,
    ]) ?>

</div>
