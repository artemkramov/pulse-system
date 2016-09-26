var site_url = window.location.hostname;
var positions = ["bottomRight", "bottomLeft", "bottomCenter"];
var counter = 0;
var Socket = (function () {
    var socket;
    var dataPoints = [];
    var dataLength = 200; // number of dataPoints visible at any point
    var chart;
    var blockBeatPerMinute = ".block-beat-per-minute";
    var spanBeatPerMinute = ".beat-per-minute";

    return {
        init: function () {
            var server = "ws://" + site_url + ":9000/echobot";
            socket = new WebSocket(server);
            socket.onopen = this.onOpen;
            socket.onmessage = this.onMessageReceive;
            this.event();
        },
        onOpen: function () {
            var data = {
                method: 'confirm',
                userID: currentUserID
            };
            Socket.sendMessage(JSON.stringify(data));
        },
        onMessageReceive: function (message) {
            var response = $.parseJSON(message.data);
            if (response.type == 'notice') {
                if (response.data.customer.id == customerID) {
                    response.data.point.x = Date.now();
                    Socket.updateChart(response.data.point);
                }
            }

        },
        sendMessage: function (message) {
            socket.send(message);
        },
        event: function () {

            var self = this;

            $(document).ready(function () {
                self.updateChart();

                setInterval(function () {
                    self.updateBeatPerMinute();
                }, 2000);

            });

        },
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
        updateHeartBeat: function () {
            $(blockBeatPerMinute).addClass('active');
            setTimeout(function () {
                $(blockBeatPerMinute).removeClass('active');
            }, 100);
        },
        updateBeatPerMinute: function () {
            App.sendAjax({
                url: backendUrl + '/ajax/load-beats-per-minute',
                data: {
                    customerID: customerID
                },
                type: "get",
                success: function (response) {
                    $(spanBeatPerMinute).text(response.count);
                }
            }, false)
        }
    };
})();
if (currentUserID)
    Socket.init();