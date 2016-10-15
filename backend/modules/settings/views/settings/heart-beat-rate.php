<?php

use common\modules\i18n\Module;
use yii\helpers\Html;

$this->title = \common\modules\i18n\Module::t('Heart beat table');

$this->registerJsFile(\yii\helpers\Url::home() . '/js/HeartBeatRate.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$inputName = "data"

?>

<button type="button" class="btn btn-default btn-add-row">
    <span class="glyphicon glyphicon-plus"></span>
</button>
<form action="" method="post">
    <table class="table table-striped table-heart-beat-rate">
        <thead>
        <tr>
            <th><?= Module::t('Min age') ?></th>
            <th><?= Module::t('Max age') ?></th>
            <th><?= Module::t('Min beat') ?></th>
            <th><?= Module::t('Max beat') ?></th>
            <th><?= Module::t('Remove') ?></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton(Module::t('Save'), [
            'class' => 'btn btn-primary',
            'name'  => 'submit'
        ])?>
    </div>

</form>

<!-- TEMPLATE ROW -->
<script type="text/template" id="template-row">
    <tr data-row="<%= model.row %>">
        <td>
            <input type="text" name="data[<%= model.row %>][min_age]" class="form-control"
                   value="<%= model.min_age %>"/>
        </td>
        <td>
            <input type="text" name="data[<%= model.row %>][max_age]" class="form-control"
                   value="<%= model.max_age %>"/>
        </td>
        <td>
            <input type="text" name="data[<%= model.row %>][min_beat]" class="form-control"
                   value="<%= model.min_beat %>"/>
        </td>
        <td>
            <input type="text" name="data[<%= model.row %>][max_beat]" class="form-control"
                   value="<%= model.max_beat %>"/>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-remove-row" data-item="<%= model.row %>">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </td>
    </tr>
</script>
