<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Threat */

$this->title = 'Update Threat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Threats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="threat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
