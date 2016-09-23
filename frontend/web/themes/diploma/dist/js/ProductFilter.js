var ProductFilter = (function () {

    /**
     * Filtering checkboxes
     * @type {string}
     */
    var checkboxFilter = '.checkbox-filter';

    /**
     * Block which contains products and pagination data
     * @type {string}
     */
    var productsContainer = '.products-container';

    /**
     * Products list block
     * @type {string}
     */
    var productsList = 'ul.products';

    /**
     * Pagination buttons
     * @type {string}
     */
    var paginationButtons = '.products-container .page-numbers li a, .page-numbers-top li a';

    /**
     * Clear filter button
     * @type {string}
     */
    var btnClear = '.clear-filter';

    /**
     * Dropdown for the sorting of the products
     * @type {string}
     */
    var selectSort = '.form-sort';

    /**
     * Get total numbers of product
     * @type {string}
     */
    var totalNumbersOfProduct = '.total-number-of-products';

    /**
     * Pagination top block
     * @type {string}
     */
    var paginationTop = '.pagination-top';

    /**
     * Sidebar spoiler button
     * @type {string}
     */
    var btnFilterSpoiler = '.sidebar-widget-spoiler';

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

                $(checkboxFilter).click(function () {
                    var filterID = $(this).data('item');
                    var filterType = self.prepareSearchData($(this).data('type'));
                    var directURL = self.removeAllParamFromUrl('page');
                    if ($(this).prop('checked')) {
                        self.addParamToUrl(filterID, filterType, directURL);
                    }
                    else {
                        self.removeParamFromUrl(filterID, filterType, directURL);
                    }
                });

                $(document).on('click', paginationButtons, function () {
                    var page = $(this).data('page') + 1;
                    var pageParam = 'page';
                    var updatedUrl = self.removeAllParamFromUrl(pageParam);
                    self.addParamToUrl(page, pageParam, updatedUrl);
                    return false;
                });

                $(btnClear).click(function () {
                    var group = $(this).data('clear').toString();
                    $('[data-type=' + group.toString() + ']').prop('checked', false);
                    var filterType = self.prepareSearchData(group);
                    var newUrl = self.removeAllParamFromUrl(filterType);
                    self.changeUrl(newUrl);
                    return false;
                });

                $(selectSort).change(function () {
                    var sortField = $(this).val();
                    var directURL = self.removeAllParamFromUrl('page');
                    directURL = self.removeAllParamFromUrl('sort', directURL);
                    if (sortField) {
                        self.addParamToUrl(sortField, 'sort', directURL);
                    }
                    else {
                        self.changeUrl(directURL);
                    }
                });

                $(btnFilterSpoiler).click(function () {
                    var sidebar = $('.sidebar-widget');
                    var icon = $(this).find('.icon');
                    if ($(sidebar).is(':visible')) {
                        $(icon).removeClass('icon-arrow_down');
                        $(icon).addClass('icon-menu_burger');
                        $(sidebar).slideUp();
                    }
                    else {
                        $(icon).removeClass('icon-menu_burger');
                        $(icon).addClass('icon-arrow_down');
                        $(sidebar).slideDown();
                    }
                });

            });

        },
        /**
         * Add filter parameter to URL
         * @param filterID
         * @param filterType
         * @param directURL
         */
        addParamToUrl: function (filterID, filterType, directURL) {
            if (typeof directURL == 'undefined') {
                directURL = window.location.href;
            }
            var url = URI(directURL)
                .addSearch(filterType, filterID);
            this.changeUrl(url.toString());
        },
        /**
         * Remove filter parameter from URL
         * @param filterID
         * @param filterType
         * @param directURL
         */
        removeParamFromUrl: function (filterID, filterType, directURL) {
            if (typeof directURL == 'undefined') {
                directURL = window.location.href;
            }
            var url = URI(directURL)
                .removeSearch(filterType, filterID);
            this.changeUrl(url.toString());
        },
        /**
         * Remove all params by name
         * @param param
         * @returns {*}
         */
        removeAllParamFromUrl: function (param, directUrl) {
            if (typeof directUrl == 'undefined') {
                directUrl = window.location.href;
            }
            var url = URI(directUrl)
                .removeSearch(param);
            return url.toString();
        },
        /**
         * Prepare search GET parameter name
         * @param filterType
         * @returns {string}
         */
        prepareSearchData: function (filterType) {
            return filterObject + "[" + filterType + "][]";
        },
        /**
         * Update the url with new URL
         * @param url
         */
        changeUrl: function (url) {
            if (typeof (history.pushState) != "undefined") {
                var obj = { title: '', url: url };
                history.pushState(obj, obj.title, obj.url);
                history.pathname = obj.url;
                this.refreshPageData();
            } else {
                window.location.reload(url);
            }
        },
        /**
         * Refresh products list based on the filter and pagination
         */
        refreshPageData: function () {
            var url = window.location.href;
            App.sendAjax({
                url: url,
                dataType: 'json',
                beforeSend: function () {
                    $(productsList).addClass('hide_products');
                    $(productsList).append('<div class="berocket_aapf_widget_loading" />');
                },
                error: function (xhr, status, error) {
                    $(productsList).removeClass('hide_products');
                },
                success: function (response) {
                    $(productsList).removeClass('hide_products');
                    $(productsContainer).html(response.html);
                    $(totalNumbersOfProduct).text(response.count);
                    $(paginationTop).html(response.paginationTop);
                    /**
                     * If we have a mobile size that screen to the product list
                     */
                    if ($('header').css('position') == 'fixed') {
                        $('html, body').animate({
                            scrollTop: $(productsContainer).offset().top - $('header').outerHeight() - 20
                        }, 1000);
                    }
                }
            });
        }
    };
})();
ProductFilter.init();