var Footer = (function () {

    /**
     * Spoiler container
     * @type {string}
     */
    var footerSpoiler = '.footer-links-title-wrap';

    /**
     * Spoiler icon
     * @type {string}
     */
    var iconSpoiler = '.footer-menu-icon';

    /**
     * Footer links menu wrapper
     * @type {string}
     */
    var footerMenuWrapper = '.footer-links-menu-wrap';

    /**
     * Footer link
     * @type {string}
     */
    var footerMenuLinks = '.footer-links-title';

    /**
     * Subscription input
     * @type {string}
     */
    var footerSubscriptionInput = '.form-input-subscribe';

    /**
     * Subscription submit
     * @type {string}
     */
    var footerSubscriptionSubmit = '.email-submit';

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
                $(footerSpoiler).click(function () {
                    if ($(iconSpoiler).is(':visible')) {
                        if ($(footerMenuWrapper).is(':visible')) {
                            $(footerMenuLinks).removeClass('vc_toggle_active');
                            $(footerMenuWrapper).slideUp();
                        }
                        else {
                            $(footerMenuLinks).addClass('vc_toggle_active');
                            $(footerMenuWrapper).slideDown();
                        }
                    }
                });

                $(footerSubscriptionInput).keyup(function () {
                    var currentValue = $(this).val();
                    if (self.isEmail(currentValue)) {
                        $(footerSubscriptionSubmit).removeClass('invalid');
                        $(footerSubscriptionSubmit).addClass('valid');
                    }
                    else {
                        $(footerSubscriptionSubmit).removeClass('valid');
                        $(footerSubscriptionSubmit).addClass('invalid');
                    }
                });

            });

        },
        isEmail: function (email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
    };
})();
Footer.init();