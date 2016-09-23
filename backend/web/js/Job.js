var Job = (function() {
    
    var template = ".job-template";
    
    var table_jobs = "#table-jobs";
    var table_project_employee_wrap = ".table-project-employee-wrap";
    
    var message_empty = ".message-empty";
    
    var btn_add_line = ".btn-job-add";
    var btn_remove_line = ".btn-job-remove";
    var btn_task = ".btn-task";
    var btn_total_per_period = "#btn-total-per-period";

    var dropdown_periods = ".dropdown-period";
    var dropdown_employees = ".dropdown-employee";
    var dropdown_project = ".dropdown-project";

    var form_employee = "#form-employee";
    var form_project = "#form-project";
    
    return {
        init: function() {
            this.events();
        },
        
        events: function() {
            
            $(document).ready(function() {
                
                $(btn_add_line).click(function() {
//                    var template_data = $(template).clone();
//                    $(template_data).removeClass('job-template');
//                    $(table_jobs).find("tbody").append($("<div />").append(template_data).html());
                    $.ajax({
                       url: site_url+"/ajax/load-job-line",
                       beforeSend: function() {
                           
                       },
                       error: function() {
                           
                       },
                       success: function(response) {
                            $(table_jobs).find("tbody").append(response);
                           App.reinitWidgets();
                       }
                    });
                    $(table_jobs).removeClass('hidden');
                    $(message_empty).addClass('hidden');
                    return false;
                });
                
                $(document).on("click",btn_remove_line,function() {
                    $(this).closest('tr').remove();
                    if ($(table_jobs).find('tbody tr').length == 1) {
                        $(table_jobs).addClass('hidden');
                        $(message_empty).removeClass('hidden');
                    }
                    return false;
                });

                $(dropdown_periods).change(function () {
                    var periodString = $(this).val();
                    $.ajax({
                        url: '',
                        type: 'post',
                        data: {
                            period: periodString
                        },
                        beforeSend: function() {
                            $("body").addClass("loading");
                        },
                        error: function() {
                            $("body").removeClass("loading");
                        },
                        success: function(response) {
                            window.setTimeout(function() {
                                $("body").removeClass("loading");
                                $(table_project_employee_wrap).html(response);
                            },500);

                        }
                    });
                });

                $(dropdown_employees).change(function () {
                    $(form_employee).trigger('submit');
                });

                $(dropdown_project).change(function () {
                    $(form_project).trigger('submit');
                });

                $(document).on("click",btn_task, function () {
                    var project_id = $(this).attr('data-project');
                    var date = $(this).attr('data-date');
                    var employee_id = $(dropdown_employees).find('option:selected').val();
                    var employeeAttr = $(this).attr('data-employee');
                    if (typeof employeeAttr !== 'undefined') {
                        employee_id = employeeAttr;
                    }
                    $.ajax({
                        url: site_url+"/ajax/load-project-date-tasks",
                        type: 'get',
                        data: {
                            project_id: project_id,
                            date: date,
                            employee_id: employee_id
                        },
                        beforeSend: function() {
                            $("body").addClass("loading");
                        },
                        error: function() {
                            $("body").removeClass("loading");
                        },
                        success: function(response) {
                            window.setTimeout(function() {
                                $("body").removeClass("loading");
                                App.alert(response,"Tasks", function () {

                                });
                                //$(table_project_employee_wrap).html(response);
                            },500);

                        }
                    });
                });

                $(btn_total_per_period).click(function() {
                    var project_id = $("#project-id").val();
                    var start_date = $("#start-date").val();
                    var end_date = $("#end-date").val();
                    var employee_id = $("#employee-id").val();
                    $.ajax({
                        url: site_url + "/ajax/get-hours-per-period",
                        type: 'get',
                        data: {
                            project_id: project_id,
                            start_date: start_date,
                            end_date: end_date,
                            employee_id: employee_id
                        },
                        beforeSend: function () {
                            $("body").addClass("loading");
                        },
                        error: function () {
                            $("body").removeClass("loading");
                        },
                        success: function (json_response) {
                            window.setTimeout(function () {
                                $("body").removeClass("loading");
                                var response = $.parseJSON(json_response);
                                var template = $("#template-hours").clone();
                                var subject = "Period: "+response.start_date + " - "+response.end_date;
                                for (var property in response) {
                                    if (response.hasOwnProperty(property)) {
                                        $(template).find("#"+property.toString()).text(response[property]);
                                    }
                                }
                                App.alert($(template).html(),subject);
                                //$(table_project_employee_wrap).html(response);
                            }, 500);

                        }
                    });
                });
                
            });
        }
    };
})();
Job.init();