/**
 * Sort object for sorting and position management
 * @type {{init, event, loadData}}
 */
var Sort = (function () {

    /**
     * Container block of the tree
     * @type {string}
     */
    var container = "#tree1";

    /**
     * Url for async data uploading
     * @type {string}
     */
    var urlLoadMenuItems = 'admin/ajax/load-menu-items';

    /**
     * Hidden input with the url for getting of the items
     * @type {string}
     */
    var inputUrlItems = '#url-load-items';

    /**
     * Form selector
     * @type {string}
     */
    var form = '.form-sort';

    return {
        /**
         * Init event
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
                self.loadData();

                $(form).submit(function () {
                    var jsonTree = $(container).tree('toJson');
                    $(this).append($('<input />').attr('name', 'jsonTree').attr('type', 'hidden').val(jsonTree));
                    return true;
                });

            });
        },
        /**
         * Load tree data
         */
        loadData: function () {
            var urlLoadItems = urlLoadMenuItems;
            if ($(inputUrlItems).length) {
                urlLoadItems = $(inputUrlItems).val();
            }
            App.sendAjax({
                url: site_url + urlLoadItems,
                success: function (data) {
                    App.hideAjaxloader();
                    $(container).tree({
                        data: data,
                        dragAndDrop: true,
                        autoOpen: true,
                    });
                }
            }, true);
        }
    };

})();
Sort.init();