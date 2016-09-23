var Basket = (function () {

    /**
     * Url of the product add ot cart
     * @type {string}
     */
    var urlAddToBasket = '/basket/add';

    /**
     * Url of the add to favourite
     * @type {string}
     */
    var urlAddToFavourite = '/cabinet/account/add-to-favourite';

    /**
     * Form of the product
     * @type {string}
     */
    var form = '#product-form';

    /**
     * Icon of the cart
     * @type {string}
     */
    var iconCart = '#basket-item-count';

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

                $(document).on('beforeSubmit', form, function () {
                    var data = App.serializeObject($(this));
                    self.addProduct(data);
                    return false;
                });

                $('.btn-add-to-basket').click(function () {
                    self.appendAction(urlAddToBasket);
                });

                $('.btn-add-to-wishlist').click(function () {
                    var productID = $(this).data('product');
                    self.addToFavourite(productID);
                });

            });

        },
        /**
         * Add product method
         * @param postData
         */
        addProduct: function (postData) {
            var btnWrap = $('.btn-add-to-basket').closest('.product-details-button-wrap');
            if (!$(btnWrap).hasClass('active')) {
                $(btnWrap).addClass('active');
                App.sendAjax({
                    url: siteUrl + urlAddToBasket,
                    type: 'post',
                    data: postData,
                    success: function (response) {
                        $(btnWrap).removeClass('active');
                        $(iconCart).text(response.global.count);
                        App.alert(response.html, App.getTranslation('Basket'));
                    }
                });
            }
        },
        /**
         * Add to favourite
         * @param productID
         */
        addToFavourite: function (productID) {
            var btnWrap = $('.btn-add-to-wishlist').closest('.product-details-button-wrap');
            if (!$(btnWrap).hasClass('active') && !$(btnWrap).hasClass('added')) {
                $(btnWrap).addClass('active');
                App.sendAjax({
                    url: siteUrl + urlAddToFavourite,
                    type: 'post',
                    data: {
                        productID: productID
                    },
                    success: function (response) {
                        $(btnWrap).removeClass('active');
                        $(btnWrap).addClass('added');
                        setTimeout(function () {
                            $(btnWrap).removeClass('added');
                        }, 4000);
                    }
                });
            }
        },
        /**
         * Append hidden action input
         * @param url
         */
        appendAction: function (url) {
            $(form).find('.action').remove();
            $(form).append($('<input />').addClass('action').attr('name', 'action').attr('type', 'hidden').val(url));
        }
    };
})();
Basket.init();