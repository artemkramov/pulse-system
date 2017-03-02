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

    /**
     * Button for printing of the plot
     * @type {string}
     */
    var btnPrintPlot = ".btn-print-plot";

    /**
     * Template for the plot printing
     * @type {string}
     */
    var templatePrintPlot = "#template-print-plot";

    /**
     * Block with the bpm data
     * @type {string}
     */
    var bpmBlock = ".chart-report-bpm-block";

    /**
     * BPM DOM element
     * @type {string}
     */
    var bpmValue = "#beats-per-minute";

    /**
     * Customer ID
     */
    var customerID = undefined;

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
                    $(bpmBlock).hide();
                    App.sendAjax({
                        url: '/admin/ajax/load-graph-data',
                        data: data,
                        success: function (response) {
                            $("body").removeClass('loading');
                            $(bpmBlock).show();
                            dataPoints = response;
                            self.initDataPoints();
                            self.updateChart();

                        }
                    });
                    return false;
                });

                $(btnPrintPlot).click(function () {
                    self.printChart();
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
                });
                var startTime = firstDate.getTime() / 1000;
                var endTime = lastDate.getTime() / 1000;
                this.refreshBPM(startTime, endTime, this.getCustomerID());
            }
        },
        /**
         * Add point to the chart
         */
        updateChart: function () {
            var self = this;
            var customerName = $("#chart-container").data("customer-name");
            var chart = new CanvasJS.Chart("chart-container", {
                title: {
                    text: customerName
                },
                data: [{
                    type: "line",
                    dataPoints: dataPoints
                }],
                axisY: {
                    viewportMinimum: -1,
                    viewportMaximum: 1.5
                },
                zoomEnabled: true,
                rangeChanged: function (e) {
                    var startTime = e.axisX[0].viewportMinimum;
                    var endTime = e.axisX[0].viewportMaximum;
                    if (e.trigger == "reset") {
                        startTime = e.chart.axisX[0].minimum;
                        endTime = e.chart.axisX[0].maximum;
                    }
                    startTime /= 1000;
                    endTime /= 1000;
                    self.refreshBPM(startTime, endTime, self.getCustomerID());
                }
            });
            chart.render();
        },
        /**
         * Print plot
         */
        printChart: function () {
            var dataUrl = document.getElementsByClassName('canvasjs-chart-canvas')[0].toDataURL();
            var compiled = _.template($(templatePrintPlot).html());
            var windowContent = compiled({
                img: {
                    src: dataUrl
                }
            });
            var windowWidth = $(window).width() / 2;
            var windowHeight = $(window).height() / 2;
            var printWindow = window.open('', '', 'width=' + windowWidth.toString() + ',height=' + windowHeight.toString());
            printWindow.document.open();
            printWindow.document.write(windowContent);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        },
        /**
         * Refresh BPM value
         * @param startTime
         * @param endTime
         * @param customerID
         */
        refreshBPM: function (startTime, endTime, customerID) {
            App.sendAjax({
                url: '/admin/ajax/get-bpm-in-range',
                type: 'get',
                data: {
                    startTime: startTime,
                    endTime: endTime,
                    customerID: customerID
                },
                success: function (response) {
                    $(bpmValue).html(response.bpm);
                }
            }, false);
        },
        /**
         * Get current customer ID
         * @returns {undefined}
         */
        getCustomerID: function () {
            if (_.isUndefined(customerID)) {
                customerID = $("#customer-id").val();
            }
            return customerID;
        }
    };
})();
Report.init();