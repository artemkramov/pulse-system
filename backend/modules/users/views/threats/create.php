<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Threat */

$this->title = 'Create Threat';
$this->params['breadcrumbs'][] = ['label' => 'Threats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="threat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
