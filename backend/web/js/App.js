/**
 * Dictionary collection of available js translations
 * @type {{}}
 */
var dictionary = {};
/**
 * Commonly used object with the useful general methods
 * @type {{alert, hideModal, confirm, init, events, sleep, reinitWidgets, reinitDate, sendAjax, pushSelect, setTranslation, getTranslation, parseTranslation, convertToCamelCase}}
 */
var App = (function () {
    return {
        /**
         * Show alert message. Can manage with autoclose time and callback function
         * @param message
         * @param title
         * @param autoCloseTimeout
         * @param callback
         */
        alert: function (message, title, autoCloseTimeout, callback) {
            var $alert = $("#alert");

            if (title) {
                $alert.find(".modal-header :header").html(title);
            } else {
                $alert.find(".modal-header").hide();
            }
            $alert.find(".modal-body").html(message);
            $($alert).modal();
            $($alert).unbind("hide");
            if ($.isFunction(callback))
                $($alert).bind("hide", callback);

            if (autoCloseTimeout && typeof autoCloseTimeout == "number")
                setTimeout(function () {
                    $($alert).modal("hide");
                }, autoCloseTimeout);
        },
        /**
         * Hide all modal windows
         */
        hideModal: function () {
            $(".modal").hide();
        },
        /**
         * Shows confirm message with Yes/No.
         * @param message
         * @param title
         * @param callback - callback for the button click 'Yes'
         * @param callback_close - callback for the button click 'No' or closing the window
         */
        confirm: function (message, title, callback, callback_close) {
            var $confirm = $("#confirm");
            if (title) {
                $confirm.find(".modal-header :header").html(title);
            } else {
                $confirm.find(".modal-header").hide();
            }
            $confirm.find(".modal-body").html(message);
            $("#confirm").modal();
            $("#confirm button.confirm").unbind("click").click(callback);
            if (callback_close) {
                $("#confirm button.disclaim").unbind("click").click(callback_close);
            }
        },
        /**
         * Load all events of the current object
         */
        init: function () {
            $(document).ready(function () {
                App.parseTranslation();
                App.events();
            });
        },
        /**
         * Call all registrated events
         */
        events: function () {

            var self = this;

            $(document).ready(function () {
                /**
                 * Reinit all widgets on the onload event
                 */
                App.reinitWidgets();

                $(document).on("click", '[data-toggle="popover"]', function () {
                    App.alert($(this).attr('data-content').toString(), "Comment", function () {

                    });
                });

                /**
                 * Event for checkbox spoiler
                 */
                $(document).on("click", ".spoiler-checkbox", function () {
                    var category = $(this).data('toggle').toString();
                    var container = $("[data-container=" + category + "]");
                    if ($(this).prop('checked')) {
                        $(container).removeClass('hidden');
                    }
                    else {
                        $(container).addClass('hidden');
                    }
                });

                /**
                 * Init fancybox gallery
                 */
                $('.fancybox').fancybox();

                /**
                 * Init sortable plugin
                 */
                $('.sortable').sortable({
                    stop: function (event, ui) {
                        var currentItem = ui.item[0];
                        var parent = $(currentItem).closest('.ui-sortable');
                        var sortCounter = 0;
                        $(parent).find('.ui-state-default').each(function () {
                            $(this).find('.field-sort').val(sortCounter);
                            sortCounter++;
                        })
                    }
                });

                /**
                 * Init checkbox tree
                 */
                $('.auto-checkboxes').bonsai({
                    expandAll: true,
                    //checkboxes: true,
                });

                /**
                 * Clear image preview and input field
                 */
                $('.btn-remove-image').click(function () {
                    $(this).next().remove();
                    var group = $(this).data('remove').toString();
                    $('[data-input=' + group + ']').val('');
                });

                $(document).on('keyup', '.kit-product-input', function () {
                    var url = '/admin/ajax/load-product-data';
                    var productID = $(this).val();
                    var input = this;
                    self.sendAjax({
                        url: url,
                        data: {
                            id: productID
                        },
                        success: function (response) {
                            var title = typeof response.title == 'undefined' ? '' : response.title;
                            var link = $(input).parent().next().find('a');
                            $(link).text(title);
                            $(link).attr('href', response.url);
                        }
                    }, false);
                });

            });

        },
        /**
         * Manually set the delay
         * @param ms
         */
        sleep: function (ms) {
            ms += new Date().getTime();
            while (new Date() < ms) {
            }
        },
        /**
         * Reinit all widgets like datepicker, select e.t.c
         */
        reinitWidgets: function () {
            var self = this;
            $('.chosen-select').chosen();
            self.reinitDate();
        },
        /**
         * Reinit datepicker by selector with custom params
         * @param selector
         * @param params
         */
        reinitDate: function (selector, params) {
            if (typeof selector == 'undefined') {
                selector = ".datepicker";
            }
            var defaultParams = {
                dateFormat: dateFormat
            };
            if (typeof params !== 'undefined') {
                for (var property in params) {
                    defaultParams[property] = params[property];
                }
            }
            $("body").on('focus', selector, function () {
                $(this).datepicker(defaultParams);
            });
        },
        /**
         * Method for calling of ajax.
         * @param params - custom params for ajax
         * @param showLoadingPage - check if show the preloader or no
         */
        sendAjax: function (params, showLoadingPage) {
            var showLoading = true;
            if (typeof showLoadingPage != 'undefined') {
                showLoading = showLoadingPage;
            }
            var defaultParams = {
                dataType: "json",
                beforeSend: function () {
                    if (showLoading) {
                        $("body").addClass("loading");
                    }
                },
                error: function () {
                    if (showLoading) {
                        $("body").removeClass("loading");
                    }
                }
            };
            for (var property in params) {
                defaultParams[property] = params[property];
            }
            $.ajax(defaultParams);
        },
        /**
         * Hide ajax preloader background
         */
        hideAjaxloader: function () {
            $("body").removeClass('loading');
        },
        /**
         * Push all items to select
         * @param select
         * @param array items
         */
        pushSelect: function (select, items) {
            for (var i = 0; i < items.length; i++) {
                $("<option />").val(items[i].id).html(items[i].name).appendTo(select);
            }
        },
        /**
         * Get the translation string by key
         * @param key
         * @returns string
         */
        getTranslation: function (key) {
            return dictionary[key];
        },
        /**
         * Load all translations from JSON to the dictionary
         */
        parseTranslation: function () {
            dictionary = $.parseJSON(javascriptJSONLabels);
        },
        /**
         * Get the converted to camelCase style string
         * Is used to transform variable like 'invoice-confirm' to 'invoiceConfirm'
         * @param value
         * @returns {*}
         */
        convertToCamelCase: function (value) {
            return value.replace(/-([a-z])/g, function (g) {
                return g[1].toUpperCase();
            });
        },
        s4: function () {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        },
        generateGUID: function () {
            return this.s4() + this.s4() + '-' + this.s4() + '-' + this.s4() + '-' +
                this.s4() + '-' + this.s4() + this.s4() + this.s4();
        }
    }
})();
App.init();
