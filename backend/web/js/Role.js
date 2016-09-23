/**
 * Object for managing of the role permissions functionality
 * @type {{init, event}}
 */
var Role = (function () {

    /**
     * Checkbox for the setting of the mass check/uncheck
     * @type {string}
     */
    var checkbox_mass = ".checkbox-mass";

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

            $(document).ready(function () {

                var self = this;

                $(checkbox_mass).click(function () {
                    var identifier = $(this).data('item');
                    var checkbox = this;
                    $("[data-parent='"+ identifier.toString() + "']").each(function () {
                         $(this).prop('checked', $(checkbox).prop('checked'));
                    });
                });
            });

        }
    };

})();
Role.init();