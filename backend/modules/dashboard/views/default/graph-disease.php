<?php

use common\modules\i18n\Module;

/**
 * @var array $statistic
 */

?>

<script type="text/javascript">
    window.onload = function () {
        var statisticData = $.parseJSON('<?= json_encode($statistic) ?>');
        console.log('statistic', statisticData);
        var chart = new CanvasJS.Chart("chart-disease",
            {
                legend: {
                    verticalAlign: "bottom",
                    horizontalAlign: "center"
                },
                data: [
                    {
                        indexLabelFontSize: 20,
                        indexLabelFontColor: "black",
                        indexLabelLineColor: "black",
                        indexLabelPlacement: "outside",
                        type: "pie",
                        dataPoints: statisticData
                    }
                ]
            });

        chart.render();
    }
</script>

<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?= Module::t('Disease statistic') ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>

    <div class="box-body">
        <div id="chart-disease" style="height: 300px; width: 100%;">
        </div>
    </div>
</div>