var Search = (function () {

    var submitIcon = $('.searchbox-icon');
    var inputBox = $('.searchbox-input');
    var searchBox = $('.searchbox');
    var isOpen = false;

    return {
        init: function () {
            this.event();
        },
        event: function () {

            var self = this;

            $(document).ready(function () {

                submitIcon.click(function () {
                    if (isOpen == false) {
                        searchBox.addClass('searchbox-open');
                        inputBox.focus();
                        isOpen = true;
                    } else {
                        if ($(inputBox).val()) {
                            $(this).closest('form').trigger('submit');
                            return;
                        }
                        searchBox.removeClass('searchbox-open');

                        inputBox.focusout();
                        isOpen = false;
                    }
                });

                submitIcon.mouseup(function () {
                    return false;
                });

                searchBox.mouseup(function () {
                    return false;
                });

                $(document).mouseup(function () {
                    if (isOpen == true) {
                        $('.searchbox-icon').css('display', 'block');
                        submitIcon.click();
                    }
                });

            });
        }
    };
})();
Search.init();