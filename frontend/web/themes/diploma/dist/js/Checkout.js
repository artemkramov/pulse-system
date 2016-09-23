var Checkout = (function () {

    var checkboxPaymentType = '.checkout-payment-type-list label > input';

    return {

        /**
         * Init events
         */
        init: function () {
            this.event();
        },
        /**
         * Regsiter events
         */
        event: function () {

            var self = this;

            $(document).ready(function () {

                $(checkboxPaymentType).click(function () {
                    var value = $(this).val();
                    var descriptionBlock = $('[data-item=payment-type-' + value.toString() + ']');
                    $('.payment-type-description').remove();
                    var newBlock = $('<div />').addClass('payment-type-description').html($(descriptionBlock).html()).hide();
                    $(this).parent().append(newBlock);
                    $(newBlock).show('normal');
                });

                $(checkboxPaymentType).each(function () {
                    if ($(this).is(':checked')) {
                        $(this).trigger('click');
                    }
                })

            });
        }
    };

})();
Checkout.init();