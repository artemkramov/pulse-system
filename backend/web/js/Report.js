/**
 * Object for building of the JS report diagrams
 * @type {{init, event, reportPerDate, reportPerCustomer, reportPerMetal}}
 */
var Report = (function () {
    /**
     * Wrapper of the diagram
     * @type {string}
     */
    var reportContainer = '.report-content';

    /**
     * Url for getting of the date-to-weight dependency
     * @type {string}
     */
    var urlReportWeight = 'ajax/get-report-date-weight';

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

                /**
                 * For each container we get the report type by ID
                 * Search then the handler and call it if it's found
                 */
                $(reportContainer).each(function () {
                    var id = $(this).attr('id');
                    var handler = App.convertToCamelCase(id);
                    if (typeof(self[handler]) == 'function') {
                        self[handler](this);
                    }
                });


            });
        },
        /**
         * Build the line diagram with the dependency date-to-weight
         * @param container
         */
        reportPerDate: function (container) {
            var langData = $.datepicker.regional[lang];
            Highcharts.setOptions({
                lang: {
                    months: langData.monthNames,
                    weekdays: langData.dayNames,
                    shortMonths: langData.monthNamesShort,
                    resetZoom: App.getTranslation('Reset zoom'),
                    resetZoomTitle: App.getTranslation('Reset zoom')
                }
            });
            App.sendAjax({
                url: site_url + urlReportWeight,
                success: function (data) {
                    $("body").removeClass('loading');
                    $(container).highcharts({
                        chart: {
                            zoomType: 'x'
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: document.ontouchstart === undefined ?
                                App.getTranslation('Click and drag in the plot area to zoom in') : App.getTranslation('Pinch the chart to zoom in')
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: App.getTranslation('Weight amount')
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            area: {
                                fillColor: {
                                    linearGradient: {
                                        x1: 0,
                                        y1: 0,
                                        x2: 0,
                                        y2: 1
                                    },
                                    stops: [
                                        [0, Highcharts.getOptions().colors[0]],
                                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                    ]
                                },
                                marker: {
                                    radius: 2
                                },
                                lineWidth: 1,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                threshold: null
                            }
                        },

                        series: [{
                            type: 'area',
                            name: '',
                            data: data
                        }]
                    });
                }
            });
        },
        /**
         * Build the pie diagram which shows the dependency on the customer by the total value
         * @param container
         */
        reportPerCustomer: function (container) {
            if (typeof jsonReportData != 'undefined') {
                var data = $.parseJSON(jsonReportData);
                $(container).highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: App.getTranslation('Value'),
                        colorByPoint: true,
                        data: data
                    }]
                });
            }
        },
        /**
         * Build the pie diagram which shows the dependency on the metal by the total value
         * @param container
         */
        reportPerMetal: function (container) {
            if (typeof jsonReportData != 'undefined') {
                var data = $.parseJSON(jsonReportData);
                $(container).highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        name: App.getTranslation('Value'),
                        colorByPoint: true,
                        data: data
                    }]
                });
            }

        }
    };
})();
Report.init();