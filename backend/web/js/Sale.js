var Sale = (function () {

    var selectCollection = '.select-collection';

    var urlLoadCollectionProducts = '/admin/ajax/load-collection-products';

    return {
        init: function () {
            this.event();
        },
        event: function () {

            $(document).ready(function () {
                $(selectCollection).change(function () {
                    var collectionID = $(this).val();
                    if (collectionID) {
                        App.confirm(App.getTranslation('Are you sure you want to add this collection?'), 'Warning', function () {
                            App.sendAjax({
                                url: urlLoadCollectionProducts,
                                data: {
                                    collectionID: collectionID
                                },
                                success: function (response) {
                                    $('body').removeClass('loading');
                                    var items = $(response.data).filter('.panel-item');
                                    var attribute = 'saleProducts';
                                    $(items).each(function () {
                                        var counter = $("[data-item="+attribute+"]").length + 1;
                                        var form = $('#sale-form');
                                        var template = MultipleBean.registerBean(this, form, counter, true);
                                        $("[data-container="+attribute+"]").append($(template).wrap('<p>').parent().html());
                                    });
                                }

                            })
                        });
                    }
                });
            });

        }
    };
})();
Sale.init();