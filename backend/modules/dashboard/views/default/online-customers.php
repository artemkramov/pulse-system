<?

use common\modules\i18n\Module;

/**
 * @var \common\models\Customer[] $customers
 */

?>

<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?= Module::t('Online customers') ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <div class="box-body">

        <? if (count($customers) > 0): ?>
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th><?= Module::t('Id') ?></th>
                    <th><?= Module::t('Name') ?></th>
                    <th><?= Module::t('Age') ?></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($customers as $customer): ?>
                    <tr>
                        <td>
                            <a href="<?= $customer->getMonitorLink() ?>"><?= $customer->id ?></a>
                        </td>
                        <td><?= $customer->name ?></td>
                        <td><?= $customer->age ?></td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>
        <? else: ?>
            <p><?= Module::t('There is no available online customer.') ?></p>
        <? endif; ?>



    </div>

    <? if (count($customers) > 0): ?>
    <div class="box-footer clearfix">
        <a href="<?= \yii\helpers\Url::to(['/users/customers/index', 'Customer[isOnlineFlag]' => 1]) ?>" class="btn btn-sm btn-default btn-flat pull-left"><?= Module::t('View all') ?></a>
    </div>
    <? endif; ?>

</div>