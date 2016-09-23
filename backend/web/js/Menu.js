/**
 * Object for management of the menu item
 * @type {{init, event, updateMenu}}
 */
var Menu = (function () {

    /**
     * Menu types select
     * @type {string}
     */
    var selectMenuType = '#menu-menu_type_id';

    /**
     * Menu items select
     * @type {string}
     */
    var selectMenu = '#menu-parent_id';

    /**
     * Url for loading of menu items
     * @type {string}
     */
    var urlLoadMenu = '/admin/ajax/load-menu-dropdown';

    return {
        /**
         * Init events
         */
        init: function () {
            this.event();
        },
        /**
         * Register events
         */
        event: function () {
            var self = this;

            $(document).ready(function () {

                $(selectMenuType).change(function () {
                    self.updateMenu($(this).val());
                });

                self.updateMenu($(selectMenuType).val());

            });

        },
        /**
         * Update menu by the given menu type
         * @param menuTypeID
         */
        updateMenu: function (menuTypeID) {
            App.sendAjax({
                url: urlLoadMenu,
                data: {
                    menuTypeID : menuTypeID
                },
                success: function (items) {
                    App.hideAjaxloader();
                    $(selectMenu).find("option").remove();
                    App.pushSelect(selectMenu, items);
                }
            }, false)
        }
    };

})();
Menu.init();