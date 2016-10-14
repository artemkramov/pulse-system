/**
 * Object for building of the JS report diagrams
 */
var Report = (function () {

    /**
     * Data points array
     * @type {Array}
     */
    var dataPoints = [];

    /**
     * Form with range form
     * @type {string}
     */
    var form = "#range-form";

    /**
     * Input with start time
     * @type {string}
     */
    var inputStartTime = "#heartbeatrange-starttime";

    /**
     * Input with end time
     * @type {string}
     */
    var inputEndTime = "#heartbeatrange-endtime";

    /**
     * Input with customer ID
     * @type {string}
     */
    var inputCustomerID = "#customer-id";

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

                self.updateChart();

                $(form).on("beforeSubmit", function () {
                    var data = {
                        startTime: $(this).find(inputStartTime).val(),
                        endTime: $(this).find(inputEndTime).val(),
                        customerID: $(this).find(inputCustomerID).val()
                    };
                    App.sendAjax({
                        url: '/admin/ajax/load-graph-data',
                        data: data,
                        success: function (response) {
                            $("body").removeClass('loading');
                            dataPoints = response;
                            self.initDataPoints();
                            self.updateChart();
                        }
                    });
                    return false;
                });


            });
        },
        /**
         * Reinit data points due to JS format
         */
        initDataPoints: function () {
            if (dataPoints && dataPoints.length > 0) {
                var jsDateFormat = "yyyy-MM-dd H:mm";
                var firstDate = new Date(dataPoints[0].x);
                var lastDate = new Date(dataPoints[dataPoints.length - 1].x);
                $(inputStartTime).val(firstDate.toString(jsDateFormat));
                $(inputEndTime).val(lastDate.toString(jsDateFormat));
                dataPoints.forEach(function (point) {
                    point.x = new Date(point.x);
                })
            }
        },
        /**
         * Add point to the chart
         */
        updateChart: function () {
            var chart = new CanvasJS.Chart("chart-container", {
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
                zoomEnabled:true
            });
            chart.render();
        },
        printChart: function () {

        }
    };
})();
Report.init();