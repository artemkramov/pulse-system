var HeartBeatRate = (function () {

    var btnAddRow = ".btn-add-row";

    var btnRemoveRow = ".btn-remove-row";

    var templateRow = "#template-row";

    var rowCount = 0;

    var tableRate = ".table-heart-beat-rate";

    return {
        init: function () {
            this.event();
        },
        event: function () {
            var self = this;
            $(document).ready(function () {

                self.loadData();

                $(btnAddRow).click(function () {
                    self.addRow();
                });

                $(document).on('click', btnRemoveRow, function () {
                    self.removeRow($(this).data('item'));
                })

            });
        },
        addRow: function (model) {
            if (!model) {
                model = {};
            }
            rowCount++;
            model.row = rowCount;
            var compiled = _.template($(templateRow).html());
            var htmlRow = compiled({
                model: model
            });
            $(tableRate).find("tbody").append(htmlRow);
        },
        removeRow: function (rowID) {
            $(tableRate).find("tr[data-row=" + rowID + "]").remove();
        },
        loadData: function () {
            var self = this;
            App.sendAjax({
                url: '/admin/ajax/load-rate-data',
                success: function (items) {
                    $("body").removeClass("loading");
                    _.each(items, function (model) {
                         self.addRow(model);
                    });
                }
            })
        }
    };

})();
HeartBeatRate.init();