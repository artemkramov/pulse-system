var Menu = (function () {

    var iconMenu = '.side-nav-toggle';

    var navLinkItem = '.nav-links > li > a';

    var navBackItem = '.nav-level-back';

    var iconSearch = '.site-search .icon-search';

    var formSearchMobile = '.mobile-product-search';

    return {
        init: function () {
            this.event();
        },
        event: function () {
            $(document).ready(function () {

                $(iconMenu).click(function () {
                    if ($('body').hasClass('side-nav-open')) {
                        $('body').removeClass('side-nav-open');
                        $(this).find('.icon').removeClass('icon-menu_close');
                        $(this).find('.icon').addClass('icon-menu_burger');
                        $('.nav-level-2').removeClass('open');
                        $('.nav-links-container').removeClass('open');
                    }
                    else {
                        $('body').addClass('side-nav-open');
                        $(this).find('.icon').removeClass('icon-menu_burger');
                        $(this).find('.icon').addClass('icon-menu_close');
                    }

                });

                $(navLinkItem).click(function () {
                    if ($('body').hasClass('side-nav-open') && $(this).parent().find('.nav-level-2').length) {
                        $(this).parent().find('.nav-level-2').addClass('open');
                        $(this).closest('.nav-links-container').addClass('open');
                        $(this).closest('.main-nav').addClass('open');
                        return false;
                    }

                });

                $(navBackItem).click(function () {
                    $('.nav-level-2').removeClass('open');
                    $('.nav-links-container').removeClass('open');
                    $(this).closest('.main-nav').removeClass('open');
                });

                $(iconSearch).click(function () {
                    $(formSearchMobile).addClass('active');
                    $(formSearchMobile).find('.search-field').focus();
                    $('body').scrollTop(0);
                });

                $(formSearchMobile).find('.close').click(function () {
                    $(formSearchMobile).removeClass('active');
                });

            });
        }
    };
})();
Menu.init();