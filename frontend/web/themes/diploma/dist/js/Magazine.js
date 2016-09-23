var Magazine = (function () {

    var flipbook = '.magazine';

    var flipbookContainer = '.magazine-viewport';

    var canvas = '#canvas';

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
                self.loadApp();

                $('.zoom-icon').bind('mouseover', function () {

                    if ($(this).hasClass('zoom-icon-in'))
                        $(this).addClass('zoom-icon-in-hover');

                    if ($(this).hasClass('zoom-icon-out'))
                        $(this).addClass('zoom-icon-out-hover');

                }).bind('mouseout', function () {

                    if ($(this).hasClass('zoom-icon-in'))
                        $(this).removeClass('zoom-icon-in-hover');

                    if ($(this).hasClass('zoom-icon-out'))
                        $(this).removeClass('zoom-icon-out-hover');

                }).bind('click', function () {

                    if ($(this).hasClass('zoom-icon-in'))
                        $(flipbookContainer).zoom('zoomIn');
                    else if ($(this).hasClass('zoom-icon-out'))
                        $(flipbookContainer).zoom('zoomOut');
                });
            });
        },
        loadApp: function () {
            $(canvas).fadeIn(1000);
            var book = $(flipbook);
            if (book.width() == 0 || book.height() == 0) {
                setTimeout(loadApp, 10);
                return;
            }
            book.turn({
                width: 922,
                height: 600,
                duration: 1000,
                acceleration: !isChrome(),
                gradients: true,
                autoCenter: true,
                elevation: 50,
                when: {
                    turning: function (event, page, view) {
                        var book = $(this),
                            currentPage = book.turn('page'),
                            pages = book.turn('pages');
                        Hash.go('page/' + page).update();
                        disableControls(page);
                    },
                    turned: function (event, page, view) {
                        disableControls(page);
                        $(this).turn('center');
                        if (page == 1) {
                            $(this).turn('peel', 'br');
                        }
                    }
                }
            });

            $(flipbook).bind("zooming", function(event,  newZoomValue, currentZoomValue) {
                var a = 4;

            });

            $(flipbookContainer).zoom({
                flipbook: $(flipbook),
                max: function () {
                    return largeMagazineWidth() / $(flipbook).width();
                },
                when: {
                    swipeLeft: function () {
                        $(this).zoom(flipbook).turn('next');
                    },
                    swipeRight: function () {
                        $(this).zoom(flipbook).turn('previous');
                    },
                    zoomIn: function () {
                        $('.made').hide();
                        $(flipbook).removeClass('animated').addClass('zoom-in');
                        $('.zoom-icon').removeClass('zoom-icon-in').addClass('zoom-icon-out');

                        if (!window.escTip && !$.isTouch) {
                            escTip = true;
                        }
                    },

                    zoomOut: function () {

                        $('.exit-message').hide();
                        $('.made').fadeIn();
                        $('.zoom-icon').removeClass('zoom-icon-out').addClass('zoom-icon-in');

                        setTimeout(function () {
                            $(flipbook).addClass('animated').removeClass('zoom-in');
                            resizeViewport();
                        }, 0);

                    }
                }
            });

            if ($.isTouch)
                $(flipbookContainer).bind('zoom.doubleTap', zoomTo);
            else
                $(flipbookContainer).bind('zoom.tap', zoomTo);

            $(document).keydown(function (e) {
                var previous = 37, next = 39, esc = 27;
                switch (e.keyCode) {
                    case previous:
                        // left arrow
                        $(flipbook).turn('previous');
                        e.preventDefault();
                        break;
                    case next:
                        //right arrow
                        $(flipbook).turn('next');
                        e.preventDefault();

                        break;
                    case esc:
                        $(flipbookContainer).zoom('zoomOut');
                        e.preventDefault();
                        break;
                }
            });

            Hash.on('^page\/([0-9]*)$', {
                yep: function (path, parts) {
                    var page = parts[1];
                    if (page !== undefined) {
                        if ($(flipbook).turn('is'))
                            $(flipbook).turn('page', page);
                    }
                },
                nop: function (path) {
                    if ($(flipbook).turn('is'))
                        $(flipbook).turn('page', 1);
                }
            });

            $(window).resize(function () {
                resizeViewport();
            }).bind('orientationchange', function () {
                resizeViewport();
            });

            $('.thumbnails').click(function (event) {
                var page;
                if (event.target && (page = /page-([0-9]+)/.exec($(event.target).attr('class')))) {
                    $(flipbook).turn('page', page[1]);
                }
            });

            $('.thumbnails li').bind($.mouseEvents.over, function () {
                $(this).addClass('thumb-hover');
            }).bind($.mouseEvents.out, function () {
                $(this).removeClass('thumb-hover');
            });

            if ($.isTouch) {
                $('.thumbnails').addClass('thumbanils-touch').bind($.mouseEvents.move, function (event) {
                    event.preventDefault();
                });
            } else {
                $('.thumbnails ul').mouseover(function () {
                    $('.thumbnails').addClass('thumbnails-hover');
                }).mousedown(function () {
                    return false;
                }).mouseout(function () {
                    $('.thumbnails').removeClass('thumbnails-hover');
                });
            }

            if ($.isTouch) {
                $(flipbook).bind('touchstart', regionClick);
            } else {
                $(flipbook).click(regionClick);
            }

            $('.next-button').bind($.mouseEvents.over, function () {
                $(this).addClass('next-button-hover');
            }).bind($.mouseEvents.out, function () {
                $(this).removeClass('next-button-hover');
            }).bind($.mouseEvents.down, function () {
                $(this).addClass('next-button-down');
            }).bind($.mouseEvents.up, function () {
                $(this).removeClass('next-button-down');
            }).click(function () {
                $(flipbook).turn('next');
            });

            $('.previous-button').bind($.mouseEvents.over, function () {
                $(this).addClass('previous-button-hover');
            }).bind($.mouseEvents.out, function () {
                $(this).removeClass('previous-button-hover');
            }).bind($.mouseEvents.down, function () {
                $(this).addClass('previous-button-down');
            }).bind($.mouseEvents.up, function () {
                $(this).removeClass('previous-button-down');
            }).click(function () {
                $(flipbook).turn('previous');
            });

            resizeViewport();

            $(flipbook).addClass('animated');

        }
    };
})();
Magazine.init();
