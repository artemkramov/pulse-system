/**
 * MultipleBean object is used to manage with multiline functionality (add/remove line)
 * @author Artem Kramov
 * @type {{init, event, registerBean}}
 */
var MultipleBean = (function() {
    /**
     * @type {string}
     */
    var btn_add = ".btn-add-bean";
    /**
     * @type {string}
     */
    var btn_delete = ".btn-delete-bean";
    /**
     * @type {string}
     */
    var item = ".panel-item";

    return {
        /**
         * @fires MultipleBean#event
         */
        init: function() {
            this.event();
        },
        /**
         * @fires MultipleBean#registerBean
         */
        event: function() {
            var $this = this;

            $(window).on("load",function() {

                /**
                 * Add line event. Copy the line from the template
                 * and register all new inputs
                 */
                $(btn_add).click(function() {
                    var attribute = $(this).data('attr').toString();
                    var template = $("[data-template="+attribute+"]").clone();
                    var counter = App.generateGUID();
                    var form = $(this).closest("form");
                    template = $this.registerBean(template, form, counter, true);
                    $("[data-container="+attribute+"]").append($(template).html());
                });

                /**
                 * Remove line event
                 */
                $("body").on("click",btn_delete,function() {
                    $(this).closest(".panel-item").remove();
                });

                /**
                 * Disable all fields from template line
                 */
                $(".template-bean").find("select,input,textarea").attr('disabled',true);

                /**
                 * Register all available lines into the form validation
                 */
                $(item).each(function() {
                    var form = $(this).closest('form');
                    var counter = $(this).data('counter');
                    if (!($(this).parent().hasClass('template-bean'))) {
                        $this.registerBean($(this), form, counter, false);
                    }
                });

            });
        },
        /**
         * Register all new fields into the form validation rules
         * @param template
         * @param form
         * @param counter
         * @param isNew
         * @returns {*}
         */
        registerBean: function (template, form, counter, isNew) {
            $(template).find("[name]").each(function() {
                if (isNew) {
                    var newName = $(this).attr('name').toString().replace(templateReplaceKeyword,counter.toString());
                    var newId = $(this).attr('id').toString().replace(templateReplaceKeyword,counter.toString());
                    var newClass = $(this).parent().attr('class').toString().replace(templateReplaceKeyword,counter.toString());
                    $(this).removeAttr('disabled');
                    $(this).attr('name',newName);
                    $(this).attr('id',newId);
                    $(this).parent().attr('class',newClass);
                }
                /**
                 * Add new field to the form validation
                 */
                form.yiiActiveForm('add', {
                    cancelled: false,
                    container: '.field-' + $(this).attr('id'),
                    enableAjaxValidation: true,
                    encodeError: true,
                    error: '.help-block',
                    id: $(this).attr('id'),
                    input: '#' + $(this).attr('id'),
                    name: $(this).attr('name'),
                    status: 0,
                    validateOnBlur: true,
                    validateOnChange: true,
                    validateOnType: false,
                    validationDelay: 500,
                    value: ""
                });
            });
            return template;
        }
    };
})();
MultipleBean.init();