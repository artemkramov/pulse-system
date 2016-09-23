/**
 * Created by artem on 4/6/16.
 */
var Graph = (function() {
    var graph = "#w3";
    var url_extended_data = "/ajax/load-graph-point-data";
    var check_projects = "#checkbox-projects";
    var url_project_data = "/ajax/load-graph-point-project";

    return {
        init: function() {
            this.event();
        },
        loadExtendedData: function (g, e) {
            if (typeof employee_id !== 'undefined') {
                var date = e.point.category;
                var graph_number = e.point.series.index;
                switch (graph_number) {
                    /* Load data for entry/exit event */
                    case 1:
                        this.loadDateData(date);
                        break;
                    /* Load projects data for day */
                    case 0:
                        this.loadDateDataProject(date);
                        break;
                }


            }
            //console.dir(e.point.category);
        },
        loadDateData: function(date) {
            $.ajax({
                url: site_url+url_extended_data,
                type: 'get',
                data: {
                    date: date,
                    employee_id: employee_id
                },
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                error: function() {
                    $("body").removeClass("loading");
                },
                success: function(response) {
                    window.setTimeout(function() {
                        $("body").removeClass("loading");
                        App.alert(response,"Movements "+date.toString(), function () {

                        });
                    },0);

                }
            });
        },
        loadDateDataProject: function(date) {
            $.ajax({
                url: site_url+url_project_data,
                type: 'get',
                data: {
                    date: date,
                    employee_id: employee_id
                },
                beforeSend: function() {
                    $("body").addClass("loading");
                },
                error: function() {
                    $("body").removeClass("loading");
                },
                success: function(response) {
                    window.setTimeout(function() {
                        $("body").removeClass("loading");
                        App.alert(response,"Projects "+date.toString(), function () {

                        });
                    },0);

                }
            });
        },
        event: function () {

            $(document).ready(function() {

                $(check_projects).click(function() {
                    var chart = $(graph).highcharts();
                    if ($(this).prop('checked')) {
                        chart.series[0].show();
                    }
                    else {
                        chart.series[0].hide();
                    }
                });

            });
        }
    }
})();
Graph.init();