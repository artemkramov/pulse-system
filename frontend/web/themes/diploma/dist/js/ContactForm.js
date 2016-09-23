/**
 * Object for contact form management
 * @type {{init, event}}
 */
var ContactForm = (function () {

    /**
     * Message block
     * @type {string}
     */
    var message = '#w1-success-0';

    /**
     * Header block
     * @type {string}
     */
    var header = '.header';

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
                /**
                 * if we find the alert element then scroll to it
                 */
                if ((typeof contactForm !== 'undefined') && $(message).length) {
                    $('html, body').animate({
                        scrollTop: $(message).offset().top - $(header).outerHeight()
                    }, 1000);
                }

            });

        }
    };
})();
ContactForm.init();