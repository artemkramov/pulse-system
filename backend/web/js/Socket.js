/**
 * Site url
 * @type {string}
 */
var site_url = window.location.hostname;

/**
 *
 * @type {{init, onOpen, onMessageReceive, sendMessage, event, updateChart, updateHeartBeat, updateBeatPerMinute, pushZeroToChart}}
 */
var Socket = (function () {
    /**
     * Socket object
     */
    var socket;

    /**
     * Array of points on plot
     * @type {Array}
     */
    var dataPoints = [];

    /**
     * Number of dataPoints visible at any point
     * @type {number}
     */
    var dataLength = 150;

    /**
     * Chart object
     */
    var chart;

    /**
     * Block with the heart icon
     * @type {string}
     */
    var blockBeatPerMinute = ".block-beat-per-minute";

    /**
     * Label to show beats per minute
     * @type {string}
     */
    var spanBeatPerMinute = ".beat-per-minute";

    /**
     * Interval for pushing the zero
     * @type {number}
     */
    var interval = 100;

    /**
     * Flag if the heart beat happened
     * @type {boolean}
     */
    var isHeartBeat = false;

    /**
     * Max response time from server
     * @type {number}
     */
    var maxResponseInterval = interval * 40;

    /**
     * Time of the last server respond
     * @type {number}
     */
    var intervalCounter = 0;

    return {
        /**
         * Init events
         */
        init: function () {
            var server = "ws://" + site_url + ":9000/echobot";
            socket = new WebSocket(server);
            socket.onopen = this.onOpen;
            socket.onmessage = this.onMessageReceive;
            this.event();
        },
        /**
         * On socket open function
         */
        onOpen: function () {
            var data = {
                method: 'confirm',
                userID: currentUserID
            };
            Socket.sendMessage(JSON.stringify(data));
        },
        /**
         * On receive function
         * @param message
         */
        onMessageReceive: function (message) {
            var response = $.parseJSON(message.data);
            if (response.type == 'notice') {
                if (response.data.customer.id == customerID) {
                    response.data.point.x = Date.now();
                    isHeartBeat = true;
                    Socket.pushZeroToChart();
                    Socket.updateChart(response.data.point);
                    Socket.pushZeroToChart();
                    isHeartBeat = false;
                    intervalCounter = 0;
                    Socket.updateBeatPerMinute(response.data.bpm);
                }
            }

        },
        /**
         * Send message function
         * @param message
         */
        sendMessage: function (message) {
            socket.send(message);
        },
        /**
         * Register events
         */
        event: function () {

            var self = this;

            $(document).ready(function () {
                self.updateChart();

                /**
                 * Push zero data to the plot
                 */
                setInterval(function () {
                    if (!isHeartBeat) {
                        if (intervalCounter > maxResponseInterval) {
                            self.updateBeatPerMinute('-');
                        }
                        else {
                            intervalCounter += interval;
                        }
                        self.pushZeroToChart();
                    }

                }, interval);

            });

        },
        /**
         * Add point to the chart
         * @param point
         */
        updateChart: function (point) {
            chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Pulse"
                },
                data: [{
                    type: "line",
                    xValueType: "dateTime",
                    dataPoints: dataPoints
                }]
            });
            if (typeof point != 'undefined') {
                dataPoints.push({
                    x: point.x,
                    y: point.y
                });
                if (point.y) {
                    this.updateHeartBeat();
                }
                if (dataPoints.length > dataLength) {
                    dataPoints.shift();
                }
            }
            chart.render();
        },
        /**
         * Make the heart beat effect
         */
        updateHeartBeat: function () {
            $(blockBeatPerMinute).addClass('active');
            setTimeout(function () {
                $(blockBeatPerMinute).removeClass('active');
            }, 100);
        },
        /**
         * Update the BPM label
         * @param bpm
         */
        updateBeatPerMinute: function (bpm) {
            $(spanBeatPerMinute).text(bpm);
        },
        /**
         * Push zero point to the chart
         */
        pushZeroToChart: function () {
            this.updateChart({
                x: Date.now(),
                y: 0
            });
        }
    };
})();
if (currentUserID)
    Socket.init();