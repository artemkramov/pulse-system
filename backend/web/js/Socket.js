var site_url = window.location.hostname;
var positions = ["bottomRight", "bottomLeft", "bottomCenter"];
var counter = 0;
var Socket = (function () {
    var socket;
    var notice_list = $("#user-notice-list");

    return {
        init: function () {
            var server = "ws://" + site_url + ":9000/echobot";
            socket = new WebSocket(server);
            socket.onopen = this.onOpen;
            socket.onmessage = this.onMessageReceive;
            this.event();
        },
        onOpen: function () {
            var data = {
                method: 'confirm',
                userID: currentUserID
            };
            Socket.sendMessage(JSON.stringify(data));
        },
        onMessageReceive: function (message) {
            var response = $.parseJSON(message.data);
            console.log('receive');
            if (response.type == 'notice') {
                var position_index = Math.floor(counter / 2);
                Socket.showPanel(response.data, positions[position_index]);
                counter++;
                /*$.ajax({
                 url: 'index.php?module=Calls&action=EditView&return_module=Calls&return_action=DetailView',
                 type: 'get',
                 beforeSend: function() {
                 SUGAR.ajaxUI.showLoadingPanel();
                 },
                 error: function() {
                 SUGAR.ajaxUI.hideLoadingPanel();
                 },
                 success: function(html_response) {
                 SUGAR.ajaxUI.hideLoadingPanel();
                 var html = $.parseHTML(html_response);
                 var textarea_text = "";
                 for(var propertyName in response.data) {
                 textarea_text += propertyName.toString() + ": " + response['data'][propertyName]+ "\r\n";
                 }
                 $(html).find("#description").text(textarea_text);

                 YAHOO.SUGAR.MessageBox.show({
                 msg: $(html).find('#EditView').html().toString(),
                 width: '900px'
                 });
                 }
                 });*/

            }
            //console.dir(response);

        },
        sendMessage: function (message) {
            socket.send(message);
        },
        event: function () {
            $(document).ready(function () {
                $(document).on('click', '.create_new_link', function () {
                    var popup_id = $(this).attr('data-item').toString();
                    open_popup("Accounts", 600, 400, "", true, false, {
                        "call_back_function": "Socket.setReturn",
                        "form_name": "#" + popup_id,
                        "field_to_name_array": {
                            "id": "account_id_advanced",
                            "name": "account_name_advanced"
                        }
                    }, "single", true);
                    return false;
                });
            });
        },
        showNotFoundData: function (data, text) {
            /*var datatable = $(text).find('.notify-table');
             $(datatable).find('tr').first().remove();
             var create_new_link = $("<a />").attr('href','').text('Relate to').addClass('create_new_link');
             var tr = $("<tr />");
             $(tr).append($("<td />").append($(create_new_link)));
             $(datatable).find('tbody').prepend($(tr));*/
        },
        setReturn: function (popup_reply_data) {
            var text = $(popup_reply_data.form_name);
            var notify_body = $(text).find('.notify-body');
            Socket.clearParentData(notify_body);
            //console.dir($(popup_reply_data));
            Socket.appendParentData(notify_body, popup_reply_data.name_to_value_array.account_id_advanced, 'Accounts');
            var account_link = $("<a />").attr('target', '_blank').attr('href', '/index.php?module=Accounts&action=DetailView&record=' + popup_reply_data.name_to_value_array.account_id_advanced).text(popup_reply_data.name_to_value_array.account_name_advanced);
            $(notify_body).find('tr').first().children().last().empty();
            $(notify_body).find('tr').first().children().last().append($(account_link));
        },
        clearParentData: function (notify_body) {
            $(notify_body).find('#parent_id').remove();
            $(notify_body).find('#parent_type').remove();
            $(notify_body).find('.account_name').remove();
        },
        appendParentData: function (block, parent_id, parent_type) {
            $(block).append($("<input />").attr('type', 'hidden').attr('id', 'parent_id').val(parent_id));
            $(block).append($("<input />").attr('type', 'hidden').attr('id', 'parent_type').val(parent_type));
        },
        pickParentData: function (text, data) {
            console.log($(text).find('#parent_id'));
            data.phone_data.parent_id = $(text).find('#parent_id').val();
            data.phone_data.parent_type = $(text).find('#parent_type').val();
        },
        showPanel: function (data, layout) {
            var text = $("#notify-block").clone();
            //$(text).attr('id','popup-data');
            var call_type = data.type == "in" ? "Inbound" : "Outbound";
            //console.dir(data);
            $(text).find("#call-type").text(SUGAR.language.languages.app_list_strings['call_direction_dom'][call_type]);
            $(text).find("[data-item=phone]").text(data.phone);
            $(text).find('.notify-body').append($("<input />").attr('name', 'call_id').attr('type', 'hidden').val(data.call_id));
            data.phone_data.call_id = data.call_id;
            if (!data.new_phone) {
                $(text).find("[data-item=related-link]").text(data.name).attr('href', data.link);
                this.appendParentData($(text).find(".notify-body"), data.phone_data.parent_id, data.phone_data.parent_type);

                $(text).find('.notify-body').append($("<input />").attr('name', 'mango_id').attr('type', 'hidden').val(data.phone_data.mango_id));
                //data.phone_data.mango_id = data.mango_id;

            }
            else {

                this.showNotFoundData(data, text);
            }
            var $this = this;
            var n = noty({
                text: $(text).html(),
                type: 'alert',
                dismissQueue: true,
                closeWith: ['button', 'click'],
                layout: layout,
                theme: 'defaultTheme1',
                buttons: [
                    {
                        addClass: 'btn btn-primary btn-noty-save',
                        text: SUGAR.language.languages.app_strings['LBL_CALL_SAVE_BTN'],
                        onClick: function ($noty) {

                            data.phone_data.description = $(this).closest('.noty_buttons').prev().find('textarea').val();
                            $this.pickParentData($("#" + n.options.id.toString()), data);
                            if (!data.phone_data.parent_id || !data.phone_data.parent_type) {
                                var noty_error = noty({
                                    text: SUGAR.language.languages.app_strings['LBL_ERROR_POPUP'],
                                    type: 'alert',
                                    layout: 'topCenter',
                                    theme: 'defaultTheme'

                                });
                                return;
                            }
                            $noty.close();
                            console.dir(data);
                            counter--;

                            $.ajax({
                                url: "index.php?module=Calls&action=savePopupCall",
                                data: data.phone_data,
                                type: "post",
                                beforeSend: function () {
                                    SUGAR.ajaxUI.showLoadingPanel();
                                },
                                error: function () {
                                    SUGAR.ajaxUI.hideLoadingPanel();
                                },
                                success: function (response) {
                                    SUGAR.ajaxUI.hideLoadingPanel();
                                    var result = $.parseJSON(response);
                                    if (result.success) {
                                        if (result.url) {
                                            window.open(result.url, "_blank");
                                        }
                                        noty({
                                            dismissQueue: true,
                                            force: true,
                                            layout: layout,
                                            theme: 'defaultTheme',
                                            text: SUGAR.language.languages.app_strings['LBL_CALL_SAVE_SUCCESS'],
                                            type: 'success'
                                        });
                                    }
                                }
                            });
                        }
                    },
                    {
                        addClass: 'btn-noty-close', text: '', onClick: function ($noty) {
                        $noty.close();
                        counter--;
                    }
                    }
                ]
            });
            $("#" + n.options.id).find('.create_new_link').attr('data-item', n.options.id);
            console.log('html: ' + n.options.id);
        }

    };
})();
if (currentUserID)
    Socket.init();