/**
 * Product object
 * @type {{init, event}}
 */
var Product = (function () {

    /**
     * @type {string}
     */
    var selectProductType = '#product-type';

    /**
     * @type {string}
     */
    var blockProductType = '.product-type';

    /**
     * @type {string}
     */
    var btnVideoRemove = '.btn-remove-video';

    /**
     * @type {string}
     */
    var hiddenProductVideo = '#product-video';

    return {
        /**
         * Init events
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

                $(selectProductType).change(function () {
                    var productType = $(this).val();
                    $(blockProductType).addClass('hidden');
                    $(blockProductType).find('.sortable').find('.panel').remove();
                    $("[data-group=" + productType.toString() + "]" + blockProductType).removeClass('hidden');
                });

                $(btnVideoRemove).click(function () {
                    $(this).next().remove();
                    $(hiddenProductVideo).val('');
                });


            });

        },
    };
})();
Product.init();
