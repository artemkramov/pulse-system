/**
 * Object for building of the JS report diagrams
 */
var Report = (function () {

    var jsonDataPoints = "#data-points";

    var dataPoints = [];

    return {
        /**
         * Init all events
         */
        init: function () {
            this.event();
        },
        /**
         * Register all events
         */
        event: function () {
            var self = this;

            $(document).ready(function () {

                self.initDataPoints();
                self.updateChart();


            });
        },
        initDataPoints: function () {
            dataPoints = $.parseJSON($(jsonDataPoints).val());
            if (dataPoints) {
                dataPoints.forEach(function (point) {
                    point.x = new Date(point.x);
                })
            }
        },
        /**
         * Add point to the chart
         */
        updateChart: function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Pulse"
                },
                data: [{
                    type: "line",
                    dataPoints: dataPoints
                }],
                axisY: {
                    viewportMinimum: -1,
                    viewportMaximum: 1.5
                },
                zoomEnabled:true,
            });
            chart.render();
        },
    };
})();
Report.init();