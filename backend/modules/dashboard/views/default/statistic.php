<?

/**
 * @var array $statistic
 */

?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-md"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= \common\modules\i18n\Module::t('Doctors') ?></span>
                <span class="info-box-number"><?= $statistic['doctors'] ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->


    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= \common\modules\i18n\Module::t('Customers') ?></span>
                <span class="info-box-number"><?= $statistic['customers'] ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-heartbeat"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?= \common\modules\i18n\Module::t('Online customers') ?></span>
                <span class="info-box-number"><?= $statistic['online'] ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

</div>