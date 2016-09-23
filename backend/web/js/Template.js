/**
 * Make a string's first character uppercase
 * @returns {string}
 */
String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
/**
 * Object for managing of the templates editing
 * @type {{init, event, parseTemplateData, reinitPlugin, initConfirm, initCommon, initInvoiceEmail, initInvoice}}
 */
var Template = (function () {

    /**
     * Selector for the all editable textareas
     * @type {string}
     */
    var selector = "textarea.textarea-common";

    /**
     * Selector which contains all template keywords
     * @type {string}
     */
    var templates = "#json-templates";

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
            var $this = this;
            $(document).ready(function () {
                $this.parseTemplateData();
                $this.reinitPlugin();
            });
        },
        /**
         * Parse JSON keyword string and then push all keywords based on the template type
         */
        parseTemplateData: function () {
            if ($(templates).length) {
                var jsonData = $(templates).val();
                var data = $.parseJSON(jsonData);
                window['templates'] = {};
                for (var templateType in data) {
                    var templateObject = data[templateType];
                    var parsedData = [];
                    for (var propertyKey in templateObject) {
                        parsedData.push({
                            text: templateObject[propertyKey],
                            value: propertyKey
                        });
                    }
                    window['templates'][templateType] = parsedData;
                }
            }
        },
        /**
         * Initialize all common and specific textareas
         */
        reinitPlugin: function () {
            var $this = this;
            var selectors = ['common'];
            $(selector).each(function () {
                var group = $(this).data('group');
                if (group && ($.inArray(group, selectors) == -1)) {
                    selectors.push(group);
                }
            });
            $.each(selectors, function () {
                if (typeof this !== 'undefined') {
                    var handler = "init" + this.capitalize();
                    if (typeof($this[handler]) == 'function') {
                        $this[handler]();
                    }
                }
            });
        },
        /**
         * Initialsize confirm template
         */
        initConfirm: function () {
            tinymce.init({
                selector: 'textarea[data-group=confirm]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect code | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | templates',
                setup: function (editor) {
                    editor.addButton('templates', {
                        type: 'listbox',
                        text: 'Templates',
                        icon: false,
                        onselect: function (e) {
                            editor.insertContent(this.value());
                        },
                        values: window['templates']['confirmTemplate']
                    });
                }
            });
        },
        /**
         * Initialize commonly used templates
         */
        initCommon: function () {
            tinymce.init({
                selector: 'textarea[data-group=common]',
                content_css: frontendDirectoryAsset + '/css/js_composer.css',
                height: "480",
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code responsivefilemanager'
                ],
                toolbar: 'responsivefilemanager insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                external_filemanager_path: "/admin/filemanager/",
            });
        },
        /**
         * Initialize template for invoice email
         */
        initInvoiceEmail: function () {
            tinymce.init({
                selector: 'textarea[data-group=invoiceEmail]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image templates',
                setup: function (editor) {
                    editor.addButton('templates', {
                        type: 'listbox',
                        text: 'Templates',
                        icon: false,
                        onselect: function (e) {
                            editor.insertContent(this.value());
                        },
                        values: window['templates']['invoiceEmail']
                    });
                }
            });
        },
        /**
         * Initialize template for invoice template
         */
        initInvoice: function () {
            tinymce.init({
                selector: 'textarea[data-group=invoice]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image templates',
                setup: function (editor) {
                    editor.addButton('templates', {
                        type: 'listbox',
                        text: 'Templates',
                        icon: false,
                        onselect: function (e) {
                            editor.insertContent(this.value());
                        },
                        values: window['templates']['invoice']
                    });
                }
            });
        },
        /**
         * Load data for the contact form
         */
        initContactForm: function () {
            tinymce.init({
                selector: 'textarea[data-group=contactForm]',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image templates',
                setup: function (editor) {
                    editor.addButton('templates', {
                        type: 'listbox',
                        text: 'Templates',
                        icon: false,
                        onselect: function (e) {
                            editor.insertContent(this.value());
                        },
                        values: window['templates']['contactForm']
                    });
                }
            });
        }
    };
})();
Template.init();