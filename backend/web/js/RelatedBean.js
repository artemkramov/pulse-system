var RelatedBean = (function () {

    var btnAddRelatedBean = '.btn-add-related-bean';

    var btnRemoveRelatedBean = '.btn-remove-related-bean';

    var btnBackToInput = '.btn-to-relation-input';

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

                $(document).on('click', btnAddRelatedBean, function () {
                    var relatedBean = $(this).closest('.related-bean-row').find('.related-bean-value');
                    var urlOpener = $(this).data('href') + '&openerID=' + $(relatedBean).attr('id');

                    $(this).closest('.related-bean-row').attr('data-row', $(relatedBean).attr('id'));

                    var scale = 0.8;
                    var width = ($(window).width() * scale).toString();
                    var height = ($(window).height() * scale).toString();
                    window.open(urlOpener, '_blank', 'width=' + width + ', height=' + height + ', scrollbars=yes');
                });

                $(document).on('click', btnRemoveRelatedBean, function () {
                    var parentRow = $(this).closest('.related-bean-row');
                    var label = $(parentRow).find('.related-title').val();
                    $(parentRow).find('a.related-bean-link').text(label).attr('href', '#');
                    $(parentRow).find('input.related-bean-value').val('');
                    $(parentRow).find('.related-bean-image').remove();
                });

                $(btnBackToInput).click(function () {
                    var response = $(this).data();
                    window.opener.RelatedBean.handleRequest(response);
                    window.close();
                    return false;
                });



            });
        },
        handleRequest: function (response) {
            var block = $('[data-row=' + response.opener + ']');
            $(block).find('a.related-bean-link').text(response.label).attr('href', response.url);
            $(block).find('input.related-bean-value').val(response.id);
            if (response.image) {
                $(block).find('img.related-bean-image').remove();
                $('<img />').addClass('related-bean-image').attr('src', response.image).insertBefore($(block).find('a.related-bean-link'));
            }
        }
    };

})();
RelatedBean.init();