<?php
    if(isset($bring) && $bring == "templates")
    {
        if(isset($templates) && $templates)
        {
            $i = 0;
            foreach($templates AS $k => $row)
            {
                $i++;
                ?>
                <tr id="t1_row_<?php echo $row["id"]; ?>">
                    <td><?php echo $i; ?></td>
                    <td align="left"><?php echo $row["template_name"]; ?></td>
                    <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$row["updated_at"]); ?></td>
                    <td align="center">
                        <a data-tooltip="<?php echo ___("needs/button-edit"); ?>" class="blue sbtn" href="<?php echo $links["controller"]; ?>?show=edit_campaign&id=<?php echo $row["id"]; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a data-tooltip="<?php echo ___("needs/button-delete"); ?>" class="red sbtn" href="javascript:void 0;" onclick="remove_template(<?php echo $row["id"]; ?>,this);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        return false;
    }
    elseif(isset($bring) && $bring == "tasks")
    {
        if(isset($templates) && $templates) foreach($templates AS $k =>$v) if(!$v["auto_submission"]) unset($templates[$k]);
        if(isset($templates) && $templates)
        {
            $i=0;
            foreach($templates AS $row)
            {
                $i++;
                $zero_month     = $row["period_month"];
                $zero_day       = $row["period_day"];
                $zero_hour      = $row["period_hour"];
                $zero_minute    = $row["period_minute"];

                if($row["period_month"]>-1 && $row["period_month"] < 10) $zero_month = "0".$row["period_month"];
                if($row["period_day"]>-1 && $row["period_day"] < 10) $zero_day = "0".$row["period_day"];
                if($row["period_hour"]>-1 && $row["period_hour"] < 10) $zero_hour = "0".$row["period_hour"];
                if($row["period_minute"]>-1 && $row["period_minute"] < 10) $zero_minute = "0".$row["period_minute"];

                $period             = __("admin/tools/reminders-period-".$row["period"]);

                if($row["period"] == "onetime" || !$row["period"]){
                    if(substr($row["period_datetime"],0,4) == "1881" || substr($row["period_datetime"],0,4) == "0000")
                        $period = __("admin/tools/bulk-undefined");
                    else
                    {
                        $period .= "<br>";
                        $period .= DateManager::format(Config::get("options/date-format")." H:i",$row["period_datetime"]);
                    }
                }
                elseif($row["period"] == "recurring"){
                    $period .= "<br>";
                    if($zero_month == -1)
                        $period .= ___("date/every-month");
                    else
                        $period .= DateManager::month_name($zero_month);

                    $period .= " / ";

                    if($zero_day == -1)
                        $period .= ___("date/every-day");
                    else
                        $period .= $zero_day.". ".___("date/day");

                    $period .= " / ";

                    $period .= $zero_hour.":".$zero_minute;

                }

                if($row["period_hour"]>-1 && $row["period_minute"]>-1)
                    $hour_minute = $zero_hour.":".$zero_minute;
                else
                    $hour_minute = '';
                ?>
                <tr id="auto_submission_<?php echo $row["id"]; ?>" style="<?php echo $row["auto_submission"] ? '' : 'display:none;'; ?>">
                    <td><?php echo $i; ?></td>
                    <td align="left"><?php echo $row["template_name"]; ?></td>
                    <td align="center"><?php echo $period; ?></td>
                    <td align="center">
                        <?php
                            $inputs              = '<input type="hidden" name="period" value="'.$row["period"].'">';
                            $inputs              .= '<input type="hidden" name="period_datetime" value="'.(substr($row["period_datetime"],0,4) == "1881" ? '' : str_replace(" ","T",substr($row["period_datetime"],0,-3)) ).'">';
                            $inputs              .= '<input type="hidden" name="period_month" value="'.$row["period_month"].'">';
                            $inputs              .= '<input type="hidden" name="period_day" value="'.$row["period_day"].'">';
                            $inputs              .= '<input type="hidden" name="period_hour_minute" value="'.$hour_minute.'">';
                            echo $inputs;
                        ?>
                        <a data-tooltip="<?php echo ___("needs/button-edit"); ?>" href="javascript:edit_scheduled_task(<?php echo $row["id"]; ?>);void 0;" class="blue sbtn"><i class="fa fa-pencil"></i></a>
                        <a data-tooltip="<?php echo ___("needs/button-delete"); ?>" href="javascript:void 0;" onclick="remove_template_task(<?php echo $row["id"]; ?>,this);" class="sbtn red"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        return false;
    }
?><!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables','select2','tinymce-1','jQtags'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        let send_data = {};
        let template_name = '';
        var
            newsletter_old_data = {},
            s_count=0;
        var templates = <?php echo isset($templates) && $templates ? Utility::jencode($templates) : '[]'; ?>;
        var table1,table2;

        $(document).ready(function(){
            $(".select2-element").select2({width:"100%"});

            setInterval(function(){
                reload_contact_list();
            },500);

            $("#load-template")
                .select2({
                    width:'100%',
                    placeholder: "<?php echo ___("needs/none"); ?>"
                })
                .change(function(){
                    var el = $(this);
                    var value = $(this).val();
                    if(value === '0')
                    {
                        $("#template_name_wrap").css("display","none");
                        $("#template_name").val('');
                        if(_GET("show") === "send")
                        {
                            $("#save_as_template_wrap").css("display","block");
                            $("#update_template").prop('checked',false);
                            $("#update_template_wrap").css("display","none");
                        }
                    }
                    else
                    {

                        if(_GET("show") === "send")
                        {
                            $("#save_as_template_wrap").css("display","none");
                            $("#save_as_template").prop('checked',false);
                            $("#update_template_wrap").css("display","block");
                            $("#update_template").prop('checked',true);
                        }

                        var data = templates[value];


                        if(_GET("show") !== "send") $("#template_name_wrap").css("display","block");
                        $("#template_name").val(data.template_name);


                        $('input[name=user_type]').prop('checked',false);
                        $('#type-'+data.type).prop('checked',true).trigger("change");

                        $('input[name=criteria]').prop('checked',false);
                        $('#criteria-'+data.criteria).prop('checked',true).trigger("change");

                        $("input[name='user_groups[]']").prop('checked',false);

                        if(data.user_groups !== null && data.user_groups.length > 0)
                        {
                            $(data.user_groups).each(function(k,v){
                                $('#user_group_'+v).prop('checked',true);
                            });
                        }

                        $("input[name='departments[]']").prop('checked',false);

                        if(data.departments !== null && data.departments.length > 0)
                        {
                            $(data.departments).each(function(k,v){
                                $('#department_'+v).prop('checked',true);
                            });
                        }

                        $('input[name=select_newsletter]').prop('checked',false).trigger('change');

                        if(data.newsletter.length > 0)
                            $('#newsletter-'+data.newsletter).prop('checked',true).trigger("change");

                        $("select[name='countries[]'] option").removeAttr('selected');
                        $("select[name='countries[]']").trigger('change');


                        if(data.countries !== null && data.countries.length > 0)
                        {
                            $(data.countries).each(function(k,v){
                                $("select[name='countries[]'] option[value="+v+"]").attr("selected",true);
                            });
                            $("select[name='countries[]']").trigger('change');
                        }

                        $("select[name='languages[]'] option").removeAttr('selected');
                        $("select[name='languages[]']").trigger('change');

                        if(data.languages !== null && data.languages.length > 0)
                        {
                            $(data.languages).each(function(k,v){
                                $("select[name='languages[]'] option[value="+v+"]").attr("selected",true);
                            });
                            $("select[name='languages[]']").trigger('change');
                        }

                        $("select[name='client_status[]'] option").removeAttr('selected');
                        $("select[name='client_status[]']").trigger('change');

                        if(data.client_status !== null && data.client_status.length > 0)
                        {
                            $(data.client_status).each(function(k,v){
                                $("select[name='client_status[]'] option[value="+v+"]").attr("selected",true);
                            });
                            $("select[name='client_status[]']").trigger('change');
                        }

                        $('#without-products').prop('checked',false);
                        $('#birthday-marketing').prop('checked',false);

                        if(data.without_products !== undefined && parseInt(data.without_products) === 1)
                            $('#without-products').prop('checked',true);

                        if(data.birthday_marketing !== undefined && parseInt(data.birthday_marketing) === 1)
                            $('#birthday-marketing').prop('checked',true);

                        $("select[name='services[]'] option").removeAttr('selected');

                        if(data.services !== null && data.services.length > 0)
                        {
                            $(data.services).each(function(k,v){
                                $("select[name='services[]'] option[value='"+v+"']").attr("selected",true);
                            });
                        }

                        $("select[name='servers[]'] option").removeAttr('selected');

                        if(data.servers !== null && data.servers.length > 0)
                        {
                            $(data.servers).each(function(k,v){
                                $("select[name='servers[]'] option[value='"+v+"']").attr("selected",true);
                            });
                        }


                        $("select[name='addons[]'] option").removeAttr('selected');

                        if(data.addons !== null && data.addons.length > 0)
                        {
                            $(data.addons).each(function(k,v){
                                $("select[name='addons[]'] option[value='"+v+"']").attr("selected",true);
                            });
                        }


                        $("select[name='services_status[]'] option").removeAttr('selected');
                        $("select[name='services_status[]']").trigger('change');

                        if(data.services_status !== null && data.services_status.length > 0)
                        {
                            $(data.services_status).each(function(k,v){
                                $("select[name='services_status[]'] option[value="+v+"]").attr("selected",true);
                            });
                            $("select[name='services_status[]']").trigger('change');
                        }

                        if(data.cc !== null && data.cc.length > 0) $('textarea[name=cc]').val(data.cc);
                        if(data.subject !== null && data.subject.length > 0) $('input[name=subject]').val(data.subject);
                        if(data.message !== undefined && data.message.length > 0)
                        {
                            $('#message').val(data.message);
                            tinymce.get("message").setContent(data.message);
                        }

                        $("input[name='submission-type']").prop('checked',false);
                        $("#send-"+data.submission_type).prop('checked',true);

                        reload_contact_list();
                    }
                });

            $('input[name=user_type]').change(function(){
                $('.type-contents').css('display','none');
                $('.type-contents input,.type-contents select').attr('disabled',true);
                $('.show-type-'+$(this).val()).css('display','block');
                $('.show-type-'+$(this).val()+' input,.show-type-'+$(this).val()+' select').removeAttr('disabled');
            });

            $('input[name=criteria]').change(function(){
                $('.criteria-contents').css('display','none');
                $('.criteria-contents input,.criteria-contents select').attr('disabled',true);
                $('.show-criteria-'+$(this).val()).css('display','block');
                $('.show-criteria-'+$(this).val()+' input,.show-criteria-'+$(this).val()+' select').removeAttr('disabled');
            });

            $("select[name='users[]']").change(function(){
                var content     = $(this).val();
                var count       = s_count+content.length;
                var resultCon   = '<?php echo __("admin/tools/filter-result-gsm"); ?>';

                $(".result_count").html(resultCon.replace("{count}",'<strong>'+count+'</strong>'));

            });


            table1 = $("#table1").DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
            table2 = $("#table2").DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            reload_templates();
            reload_tasks();

            if(_GET("show") === "create_campaign") CreateTemplate();
            else if(_GET("show") === "edit_campaign") EditTemplate(_GET("id"));
            else if(_GET("show") === "send") SendNotification();

        });

        function editAutoSubmission(template_id)
        {

            if($("#auto_submission_"+template_id).length > 0)
            {
                $("#create_task_btn").css("display","none");
                $("#save_task_btn").css("display","block");
            }
            else
            {
                $("#create_task_btn").css("display","block");
                $("#save_task_btn").css("display","none");
            }

            $("#auto_submissions_modal #modify_auto_submission input[name=period]").removeAttr('checked');
            $("#auto_submissions_modal #modify_auto_submission #period_onetime").prop('checked',true);
            $("#auto_submissions_modal #modify_auto_submission input[name=period_datetime]").val('');
            $("#auto_submissions_modal #modify_auto_submission input[name=period_hour_minute]").val('');
            $("#auto_submissions_modal #modify_auto_submission select[name=period_month]").val('-1');
            $("#auto_submissions_modal #modify_auto_submission select[name=period_day]").val('-1');
            $("#period_recurring_contents").css("display","none");
            $("#period_onetime_contents").css("display","block");

            if(template_id > 0)
            {
                $('#select_template').val(template_id);

                var period = $("#auto_submission_"+template_id+" input[name=period]").val();

                if(period.length  < 1) period = 'onetime';

                $("#auto_submissions_modal #modify_auto_submission input[name=period]").prop("checked",false);
                $("#auto_submissions_modal #modify_auto_submission #period_"+period).prop("checked",true).trigger("change");

                $("#auto_submissions_modal #modify_auto_submission input[name=period_datetime]").val($("#auto_submission_"+template_id+" input[name=period_datetime]").val());
                $("#auto_submissions_modal #modify_auto_submission input[name=period_hour_minute]").val($("#auto_submission_"+template_id+" input[name=period_hour_minute]").val());

                if($("#auto_submission_"+template_id+" input[name=period_day]").val() > -1)
                    $("#auto_submissions_modal #modify_auto_submission select[name=period_day] option[value="+$("#auto_submission_"+template_id+" input[name=period_day]").val()+"]").prop('selected',true);

                if($("#auto_submission_"+template_id+" input[name=period_month]").val() > -1)
                    $("#auto_submissions_modal #modify_auto_submission select[name=period_month] option[value="+$("#auto_submission_"+template_id+" input[name=period_month]").val()+"]").prop('selected',true);
            }
            else
                $('#select_template').val(0);
        }

        function save_template(el,auto_submission)
        {
            var template_id         = $("#load-template").val();

            if(auto_submission !== undefined && auto_submission)
                template_id = $("#auto_submissions_modal #select_template").val();


            var just_submission = auto_submission !== undefined && auto_submission ? 1 : 0;

            if(_GET("show") !== "create_campaign" && just_submission === 0 && parseInt(template_id) < 1)
            {
                if(template_name === '') return false;
            }
            else
                template_name           = $("#template_name").val();


            var el_wrap         = $(el).parent().parent();
            var period          = $('input[name=period]:checked',el_wrap).val();
            var period_dt       = $('input[name=period_datetime]',el_wrap).val();
            var period_month    = $('select[name=period_month]',el_wrap).val();
            var period_day      = $('select[name=period_day]',el_wrap).val();
            var period_hi       = $('input[name=period_hour_minute]',el_wrap).val();


            var type            = $('input[name=user_type]:checked').val();
            var criteria        = $('input[name=criteria]:checked:not(:disabled)').val();
            var user_groups     = $("input[name='user_groups[]']:checked:not(:disabled)").map(function(){return $(this).val();}).get();
            var newsletter      = $('input[name=select_newsletter]:checked:not(:disabled)').val();
            var departments     = $("input[name='departments[]']:checked:not(:disabled)").map(function(){return $(this).val();}).get();
            var countries       = $("select[name='countries[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var languages       = $("select[name='languages[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var services        = $("select[name='services[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();

            var client_status   = $("select[name='client_status[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var without_products = $("#without-products:not(:disabled)").prop('checked') ? 1 : 0;
            var birthday_marketing = $("#birthday-marketing:not(:disabled)").prop('checked') ? 1 : 0;
            var services_status    = $("select[name='services_status[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var servers            = $("select[name='servers[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var addons             = $("select[name='addons[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var cc                  = $("textarea[name=cc]").val();
            var subject             = $("input[name=subject]").val();
            var message             = $("textarea[name=message]").val();
            var submission_type     = $('input[name="submission-type"]:checked').val();

            var request = MioAjax({
                button_element:el,
                waiting_text:"<?php echo __("website/others/button1-pending"); ?>",
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"save_notification_template",
                    just_submission: just_submission,
                    auto_submission: 1,
                    period:period,
                    period_datetime:period_dt,
                    period_month:period_month,
                    period_day:period_day,
                    period_hour_minute:period_hi,
                    template_id:template_id,
                    template_name:template_name,
                    template_type:"mail",
                    type:type,
                    criteria:criteria,
                    user_groups:user_groups,
                    newsletter:newsletter,
                    departments:departments,
                    countries:countries,
                    languages:languages,
                    services:services,
                    servers:servers,
                    client_status:client_status,
                    without_products:without_products,
                    birthday_marketing:birthday_marketing,
                    services_status:services_status,
                    addons:addons,
                    cc:cc,
                    subject:subject,
                    message:message,
                    submission_type:submission_type,
                },
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        if(solve.status === "error")
                        {
                            if(_GET("show") === "send" || (auto_submission !== undefined && auto_submission))
                                swal(
                                    solve.message,
                                    '',
                                    'error'
                                );
                            else
                                alert_error(solve.message,{timer:3000});
                        }
                        else if(solve.status === "successful")
                        {
                            if(_GET("show") !== "send")
                            {
                                alert_success(solve.message,{timer:3000});

                                if(auto_submission)
                                {
                                    reload_tasks();
                                }
                                else
                                {
                                    setTimeout(function (){
                                        window.location.href = '<?php echo $links["controller"]; ?>';
                                    },3000);
                                }

                            }
                        }

                    }else
                        console.log(result);
                }
            });

            return true;
        }

        function remove_template(template_id,el)
        {
            if(!confirm("<?php echo ___("needs/delete-are-you-sure"); ?>")) return false;
            var request = MioAjax({
                button_element:el,
                waiting_text:"<i class='fa fa-spinner' style='-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;'></i>",
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"remove_notification_template",
                    template_id:template_id,
                },
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status === "error")
                            alert_error(solve.message,{timer:3000});
                        else if(solve.status === "successful")
                        {
                            alert_success(solve.message,{timer:3000});
                            reload_templates();
                        }
                    }else
                        console.log(result);
                }
            });
        }
        function remove_template_task(template_id,el)
        {
            if(!confirm("<?php echo ___("needs/delete-are-you-sure"); ?>")) return false;
            var request = MioAjax({
                button_element:el,
                waiting_text:"<i class='fa fa-spinner' style='-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;'></i>",
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"save_notification_template",
                    template_id:template_id,
                    just_submission: 1,
                    period:"onetime",
                    period_datetime: "0000-00-00 00:00:00"
                },
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        if(solve.status === "error")
                            swal(solve.message,'','error');
                        else if(solve.status === "successful")
                        {
                            reload_tasks();
                        }

                    }else
                        console.log(result);
                }
            });
        }

        function reload_templates()
        {
            table1.clear();
            $.get("<?php echo $links["controller"]; ?>?bring=templates",function(data){
                $(data).each(function(){
                    if($(this)[0].outerHTML !== undefined)
                    {
                        table1.row.add($(this)[0]);
                    }
                });
                table1.draw();
            });
        }

        function reload_tasks()
        {
            table2.clear();
            $.get("<?php echo $links["controller"]; ?>?bring=tasks",function(data){
                $(data).each(function(){
                    if($(this)[0].outerHTML !== undefined)
                    {
                        table2.row.add($(this)[0]);
                    }
                });
                table2.draw();
            });
        }

        function reload_contact_list(){
            var user_type            = $('input[name=user_type]:checked').val();
            var user_groups = $("input[name='user_groups[]']:checked:not(:disabled)").map(function(){return $(this).val();}).get();
            var departments = $("input[name='departments[]']:checked:not(:disabled)").map(function(){return $(this).val();}).get();
            var countries   = $("select[name='countries[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var languages   = $("select[name='languages[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var services    = $("select[name='services[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();

            var client_status = $("select[name='client_status[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var without_products = $("#without-products:not(:disabled)").prop('checked') ? 1 : 0;
            var birthday_marketing = $("#birthday-marketing:not(:disabled)").prop('checked') ? 1 : 0;
            var services_status    = $("select[name='services_status[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var servers            = $("select[name='servers[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();
            var addons             = $("select[name='addons[]']:not(:disabled) option:selected").map(function() {return $(this).val();}).get();


            var cc          = $("textarea[name=cc]").val();
            if(cc != ''){
                var ccSplit     = cc.split("\n");
                var count       = ccSplit.length;
            }else{
                var count       = 0;
            }

            var newsletter      = $("textarea[name=newsletter]").val();
            if(newsletter != ''){
                var ntSplit     = newsletter.split("\n");
                count           += ntSplit.length;
            }

            s_count = count;

            var resultCon   = '<?php echo __("admin/tools/filter-result-email"); ?>';

            send_data   = {
                operation:"get_contact_list",
                user_type:user_type,
                type:"email",
                user_groups:user_groups,
                departments:departments,
                countries:countries,
                languages:languages,
                services:services,
                client_status:client_status,
                without_products:without_products,
                birthday_marketing:birthday_marketing,
                services_status:services_status,
                servers:servers,
                addons:addons,
            };

            if(localStorage.getItem("contact_list_request") === json_encode(send_data)) return false;

            localStorage.setItem("contact_list_request",json_encode(send_data));

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:send_data,
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        if(solve.result){
                            var values      = solve.result;
                            var keys        = Object.keys(values);
                            var size        = keys.length;
                            var sizee       = size;
                            count           += size;
                            size            -= -1;
                            var ids         = [];
                            for(var i = 0; i<= size; i++) {
                                var key = keys[i];
                                if(key != undefined) ids.push(key);
                            }
                        }

                        if(count === 0)
                            $("#users").val('');
                        else
                            $("#users").val(ids.join());
                        $("#users_count").html(sizee);

                        if(count > 0)
                        {
                            $("#send_btn").css("display","block");
                            $("#send_inactive_btn").css("display","none");
                        }
                        else
                        {
                            $("#send_btn").css("display","none");
                            $("#send_inactive_btn").css("display","block");
                        }

                        $(".result_count").html(resultCon.replace("{count}",'<strong>'+count+'</strong>'));
                    }else
                        console.log(result);
                }
            });
        }

        function changed_newsletter(){
            reload_contact_list();
        }

        function change_newsletter(elem){
            var lang = $(elem).val();
            if(lang == 'none')
                $("#BulkMailForm textarea[name=newsletter]").val('').trigger("change");
            else
                $("#BulkMailForm textarea[name=newsletter]").val($("#newsletter_modal textarea[name='data["+lang+"]']").val()).trigger("change");
        }

        function open_newsletter_modal(lang){
            open_modal("newsletter_modal",{title:"<?php echo __("admin/tools/bulk-newsletter"); ?> ["+lang.toUpperCase()+"]"});
            $("#newsletter_modal input[name=lang]").val(lang);
            $("#newsletter_modal textarea").css("display","none").attr("disabled",true);
            $("#newsletter_modal textarea[name='data["+lang+"]']").css("display","block").attr("disabled",false);
            if(newsletter_old_data[lang] != undefined)
                $("#newsletter_modal textarea[name='data["+lang+"]']").val(newsletter_old_data[lang]);
        }

        function SendNotification()
        {
            localStorage.removeItem("contact_list_request");
            $("#select-template-wrap").css("display","block");
            $("#submit_btn_wrap").css("display","block");
            $("#save_template_btn_wrap").css("display","none");
            $("#save_as_template_wrap").css("display","block");
        }

        function CreateTemplate()
        {
            localStorage.removeItem("contact_list_request");
            $("#select-template-wrap").css("display","none");
            $("#template_name_wrap").css("display","block");
            $("#submit_btn_wrap").css("display","none");
            $("#save_template_btn_wrap").css({
                display:"block",
                float:"right"
            });
            $("#save_template_btn_wrap .gonderbtn").html("<?php echo __("admin/tools/bulk-create-template"); ?>");
        }

        function EditTemplate(id)
        {
            localStorage.removeItem("contact_list_request");
            $("#load-template").val(id).trigger('change');
            $("#select-template-wrap").css("display","none");
            $("#template_name_wrap").css("display","block");
            $("#submit_btn_wrap").css("display","none");
            $("#save_template_btn_wrap").css({
                display:"block",
                float:"right"
            });
            $("#save_template_btn_wrap .gonderbtn").html("<?php echo __("admin/tools/bulk-template-save"); ?>");
        }

        function create_scheduled_task()
        {
            open_modal('auto_submissions_modal');
            editAutoSubmission(0);
        }

        function edit_scheduled_task(id)
        {
            open_modal('auto_submissions_modal');
            editAutoSubmission(id);
        }

        function PreviewBtn()
        {
            open_modal('Preview_modal',{width:'70%'});

            $("#subject_output").html($('input[name=subject]').val());
            $("#users_count_output").html($('#users_count').html());
            $("#message_output").html($('textarea[name=message]').val());

        }

        function test_send(el)
        {
            var request = MioAjax({
                button_element:el,
                waiting_text:"<?php echo __("website/others/button1-pending"); ?>",
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data:{
                    operation:"submit_bulk_mail",
                    test_mode: 1,
                    subject: $("input[name=subject]").val(),
                    message: $("textarea[name=message]").val(),
                    departments: $("input[name='test_departments[]']:checked").map(function(){return $(this).val();}).get(),
                    cc: $('textarea[name=test_cc]').val(),
                    'submission-type': $("input[name='submission-type']:checked").val(),
                }
            },true,true);
            request.done(function(result)
            {
                result = getJson(result);
                if(result !== false)
                {
                    swal(
                        result.status === "error" ? result.message : "<?php echo __("admin/tools/bulk-test-send-success"); ?>",
                        '',
                        result.status === "error" ? 'error' : 'success'
                    );
                }
            });
        }
    </script>
</head>
<body>

<div id="Preview_modal" style="display: none" data-izimodal-title="<?php echo __("admin/products/software-licensing-25"); ?>">
    <div class="padding20">

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/tools/subject"); ?></div>
            <div class="yuzde70" id="subject_output">...</div>
        </div>

        <div class="formcon" style="display: none">
            <div class="yuzde30"><?php echo __("admin/tools/bulk-number-of-people-to-send"); ?></div>
            <div class="yuzde70" id="users_count_output">
                0
            </div>
        </div>

        <div class="formcon" id="message_output">...</div>

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/tools/bulk-test-send"); ?></div>
            <div class="yuzde70">

                <?php
                    if(isset($departments) && $departments)
                    {
                        foreach($departments AS $d)
                        {
                            ?>
                            <input type="checkbox" name="test_departments[]" value="<?php echo $d["id"]; ?>" class="checkbox-custom" id="test-department-<?php echo $d["id"]; ?>">
                            <label class="checkbox-custom-label" for="test-department-<?php echo $d["id"]; ?>" style="margin-right: 10px;"><?php echo $d["name"]; ?> (<?php echo $d["user_count"]; ?>)</label>
                            <?php
                        }
                    }
                ?>

                <textarea name="test_cc" rows="2" placeholder="<?php echo "name1@example.com\nname2@example.com"; ?>"></textarea>

                <div class="clear"></div>
                <div class="line"></div>
                <a class="lbtn" href="javascript:void 0;" onclick="test_send(this);" id="test_send_btn" style="float: right;"><i class="fa fa-paper-plane"></i> <?php echo __("admin/tools/bulk-test-send-2"); ?></a>
            </div>
        </div>


        <div class="clear"></div>
    </div>
</div>

<div id="auto_submissions_modal" style="display: none;" data-izimodal-title="<?php echo __("admin/tools/bulk-auto-submissions"); ?>">
    <div class="padding20">

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/tools/bulk-template"); ?></div>
            <div class="yuzde70">
                <select id="select_template" onchange="editAutoSubmission($(this).val());">
                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        if(isset($templates) && $templates)
                        {
                            foreach($templates AS $row)
                            {
                                ?>
                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["template_name"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>


        <div id="modify_auto_submission">
            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/tools/reminders-period"); ?></div>
                <div class="yuzde70">

                    <input checked type="radio" class="radio-custom" name="period" value="onetime" id="period_onetime" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_onetime_contents').css('display','block');">
                    <label class="radio-custom-label" for="period_onetime" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-onetime"); ?></label>

                    <input type="radio" class="radio-custom" name="period" value="recurring" id="period_recurring" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_recurring_contents').css('display','block');">
                    <label class="radio-custom-label" for="period_recurring" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-recurring"); ?></label>

                </div>
            </div>

            <div id="period_onetime_contents" class="period_contents">
                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/bulk-submission-time"); ?></div>
                    <div class="yuzde70">
                        <input type="datetime-local" name="period_datetime" value="">
                    </div>
                </div>
            </div>

            <div id="period_recurring_contents" class="period_contents" style="display: none;">
                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/bulk-submission-time"); ?></div>
                    <div class="yuzde70">
                        <select name="period_month" class="yuzde20">
                            <option value="-1"><?php echo ___("date/every-month"); ?></option>
                            <?php
                                foreach(range(1,12) AS $num){
                                    $num_zero   = $num>9 ? $num : "0".$num;
                                    $month_name = DateManager::month_name($num_zero);
                                    ?>
                                    <option value="<?php echo $num; ?>"><?php echo $month_name; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <select name="period_day" class="yuzde20">
                            <option value="-1"><?php echo ___("date/every-day"); ?></option>
                            <?php
                                foreach(range(1,31) AS $num){
                                    ?>
                                    <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <input type="time" name="period_hour_minute" value="" class="yuzde20">
                    </div>
                </div>
            </div>



            <div class="guncellebtn yuzde30" style="float: right;">
                <a class="gonderbtn yesilbtn" onclick="save_template(this,true);" id="create_task_btn"><?php echo ___("needs/button-create"); ?></a>
                <a class="gonderbtn yesilbtn" style="display: none" id="save_task_btn" onclick="save_template(this,true);"><?php echo ___("needs/button-update"); ?></a>
            </div>

        </div>


        <div id="load_templates_table"></div>

        <div class="clear"></div>
    </div>
</div>

<div style="display: none;" id="newsletter_modal">
    <div class="padding20">
        <script type="text/javascript">
            $(document).ready(function(){
                $("#newsletter_form_submit").click(function(){
                    var request = MioAjax({
                        button_element:this,
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        form:$("#newsletter_form"),
                    },true,true);

                    request.done(function(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#newsletter_form "+solve.for).focus();
                                        $("#newsletter_form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#newsletter_form "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#newsletter_modal textarea").val('');
                                    if(solve.data != undefined && solve.data){
                                        var h_lang = $("#newsletter_modal input[name=lang]").val();
                                        var count = solve.data.length;
                                        $("#newsletter-"+h_lang+"_count").html("("+count+")");
                                        var data   = solve.data.join("\n");
                                        $("#newsletter_modal textarea[name='data["+h_lang+"]']").val(data);
                                        newsletter_old_data[h_lang] = data;
                                        if($("#newsletter-"+h_lang).prop("checked")) $("#BulkMailForm textarea[name=newsletter]").val(data).trigger("change");
                                    }
                                    alert_success(solve.message,{timer:2000});
                                }
                            }else
                                console.log(result);
                        }
                    });

                });

            });
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="newsletter_form">
            <input type="hidden" name="operation" value="change_newsletter">
            <input type="hidden" name="lang" value="none">
            <input type="hidden" name="type" value="email">

            <div class="formcon">
                <?php
                    foreach(Bootstrap::$lang->rank_list() AS $item){
                        $key        = $item["key"];
                        $data       = isset($newsletter[$key]["data"]) ? $newsletter[$key]["data"] : [];
                        ?>
                        <textarea style="display: none;" name="data[<?php echo $key; ?>]" rows="10"><?php echo implode("\n",$data); ?></textarea>
                        <?php
                    }
                ?>
            </div>

            <div class="yuzde30 guncellebtn" style="float: right;">
                <a href="javascript:void 0;" id="newsletter_form_submit" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
            </div>

            <div class="clear"></div>
        </form>

        <div class="clear"></div>
    </div>
</div>

<div id="ConfirmModal" data-izimodal-title="<?php echo __("admin/tools/submit-bulk-mail"); ?>" style="display: none;">
    <div class="padding20">

        <div align="center" id="show_result_wrap">
            <div style="margin: 30px 0px;" class="result_count"><?php echo __("admin/tools/filter-result-email",['{count}' => '<strong>0</strong>']); ?></div>

            <div class="line"></div>

            <div class="guncellebtn yuzde30">
                <a href="javascript:void(0);" id="BulkMailForm_submit" class="gonderbtn yesilbtn"><?php echo __("admin/tools/bulk-start"); ?></a>
            </div>

        </div>

        <div id="loader_start" style="display: none;">
            <div class="load-wrapp">
                <p style="margin-bottom:20px;font-size:17px;"><strong><?php echo ___("needs/processing"); ?>...</strong><br><?php echo ___("needs/please-wait"); ?></p>
                <div class="load-7">
                    <div class="square-holder">
                        <div class="square"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>


<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">
    <div style="<?php echo isset($show) && $show ? '' : 'display: none;'; ?>" class="icerik-container" id="submit_wrap">

        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo $header_title; ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="BulkMailForm">
                    <input type="hidden" name="operation" value="submit_bulk_mail">
                    <textarea style="display: none;" rows="10" name="newsletter" onchange="changed_newsletter();"></textarea>


                    <div class="formcon" id="select-template-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/tools/bulk-template"); ?></div>
                        <div class="yuzde70">

                            <div class="yuzde50">
                                <select name="template" id="load-template">
                                    <option value="0"><?php echo ___("needs/none"); ?></option>
                                    <?php
                                        if(isset($templates) && $templates)
                                        {
                                            foreach($templates AS $t)
                                            {
                                                ?>
                                                <option value="<?php echo $t["id"]; ?>"><?php echo $t["template_name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>

                                <input type="hidden" name="period" value="">
                            </div>

                            <a class="lbtn red" style="display: none;" href="javascript:void 0;" onclick="remove_template(this);" id="remove_template_btn"><?php echo __("admin/tools/bulk-template-remove"); ?></a>
                        </div>
                    </div>


                    <div class="formcon" id="template_name_wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/tools/bulk-template-name"); ?></div>
                        <div class="yuzde70">
                            <div class="yuzde50">
                                <input id="template_name" value="">
                            </div>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/bulk-type"); ?></div>
                        <div class="yuzde70">
                            <input checked type="radio" name="user_type" value="client" id="type-client" class="radio-custom">
                            <label class="radio-custom-label" for="type-client" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-type-client"); ?></label>

                            <input type="radio" name="user_type" value="staff" id="type-staff" class="radio-custom">
                            <label class="radio-custom-label" for="type-staff" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-type-staff"); ?></label>
                        </div>
                    </div>


                    <div class="formcon type-contents show-type-client">
                        <div class="yuzde30"><?php echo __("admin/tools/bulk-criteria"); ?></div>
                        <div class="yuzde70">
                            <input checked type="radio" name="criteria" value="general" id="criteria-general" class="radio-custom">
                            <label class="radio-custom-label" for="criteria-general" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-criteria-general"); ?></label>

                            <input type="radio" name="criteria" value="servers" id="criteria-servers" class="radio-custom">
                            <label class="radio-custom-label" for="criteria-servers" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-criteria-servers"); ?></label>

                            <input type="radio" name="criteria" value="domain" id="criteria-domain" class="radio-custom">
                            <label class="radio-custom-label" for="criteria-domain" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-criteria-domain"); ?></label>


                            <input type="radio" name="criteria" value="products" id="criteria-products" class="radio-custom">
                            <label class="radio-custom-label" for="criteria-products" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-criteria-products"); ?></label>

                            <input type="radio" name="criteria" value="addons" id="criteria-addons" class="radio-custom">
                            <label class="radio-custom-label" for="criteria-addons" style="margin-right: 10px;"><?php echo __("admin/tools/bulk-criteria-addons"); ?></label>
                        </div>
                    </div>

                    <div class="biggroup">
                        <div class="padding20">
                            <h4 class="biggrouptitle type-contents show-type-client"><?php echo __("admin/tools/bulk-client-criteria"); ?></h4>
                            <h4 class="biggrouptitle type-contents show-type-staff" style="display: none;"><?php echo __("admin/tools/bulk-client-criteria-staff"); ?></h4>

                            <div class="formcon type-contents show-type-client">
                                <div class="yuzde30"><?php echo __("admin/tools/user-groups"); ?></div>
                                <div class="yuzde70">

                                    <input onchange="if($(this).prop('checked')) $('input[name=\'user_groups[]\']:checked').not(this).prop('checked',false).trigger('change');" name="user_groups[]" value="0" type="checkbox" id="user_group_0" class="checkbox-custom">
                                    <label for="user_group_0" class="checkbox-custom-label" style="margin-right: 10px;"><?php echo ___("needs/allOf"); ?> (<?php echo $total_user_count; ?>)</label>

                                    <?php
                                        if(isset($user_groups) && $user_groups){
                                            foreach($user_groups AS $group){
                                                ?>
                                                <input onchange="if($(this).prop('checked')) $('#user_group_0').prop('checked',false).trigger('change');" name="user_groups[]" value="<?php echo $group["id"]; ?>" type="checkbox" id="user_group_<?php echo $group["id"]; ?>" class="checkbox-custom">
                                                <label for="user_group_<?php echo $group["id"]; ?>" class="checkbox-custom-label" style="margin-right: 10px;"><?php echo $group["name"]; ?> (<?php echo $group["user_count"]; ?>)</label>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="formcon type-contents show-type-staff" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/tools/departments"); ?></div>
                                <div class="yuzde70">
                                    <?php
                                        if(isset($departments) && $departments){
                                            foreach($departments AS $department){
                                                ?>
                                                <input name="departments[]" value="<?php echo $department["id"]; ?>" type="checkbox" id="department_<?php echo $department["id"]; ?>" class="checkbox-custom">
                                                <label for="department_<?php echo $department["id"]; ?>" class="checkbox-custom-label" style="margin-right: 10px;"><?php echo $department["name"]; ?> (<?php echo $department["user_count"]; ?>)</label>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="formcon type-contents show-type-client">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-newsletter"); ?></div>
                                <div class="yuzde70">

                                    <input checked onchange="change_newsletter(this);" name="select_newsletter" value="" type="radio" id="newsletter-none" class="radio-custom">
                                    <label style="margin-right:5px;margin-left:5px;" class="radio-custom-label" for="newsletter-none"><?php echo ___("needs/none"); ?></label>

                                    <?php
                                        foreach(Bootstrap::$lang->rank_list() AS $item){
                                            $key = $item["key"];
                                            ?>
                                            <input onchange="change_newsletter(this);" name="select_newsletter" value="<?php echo $key; ?>" type="radio" id="newsletter-<?php echo $key; ?>" class="radio-custom">
                                            <label style="margin-right:5px;margin-left:5px;" class="radio-custom-label" for="newsletter-<?php echo $key; ?>"><?php echo Utility::strtoupper($key); ?> <span id="newsletter-<?php echo $key; ?>_count">(<?php echo $newsletter[$key]["count"]; ?>)</span></label>
                                            <a href="javascript:open_newsletter_modal('<?php echo $key; ?>'); void 0;" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="formcon type-contents show-type-client">
                                <div class="yuzde30"><?php echo __("admin/tools/countries"); ?></div>
                                <div class="yuzde70">
                                    <select name="countries[]" class="select2-element" multiple data-placeholder="<?php echo __("admin/tools/bulk-select-placeholder"); ?>">
                                        <?php
                                            if($countries){
                                                foreach($countries AS $country){
                                                    ?>
                                                    <option value="<?php echo $country["id"]; ?>"><?php echo $country["name"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/languages"); ?></div>
                                <div class="yuzde70">
                                    <select name="languages[]" class="select2-element" multiple data-placeholder="<?php echo __("admin/tools/bulk-select-placeholder"); ?>">
                                        <?php
                                            foreach($lang_list AS $lang){
                                                ?>
                                                <option value="<?php echo $lang["key"]; ?>"><?php echo $lang["cname"]." (".$lang["name"].")"; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-client-status"); ?></div>
                                <div class="yuzde70">
                                    <select name="client_status[]" multiple class="select2-element" data-placeholder="<?php echo __("admin/tools/bulk-select-placeholder"); ?>">
                                        <?php
                                            foreach($user_situations AS $k => $situation)
                                            {
                                                ?>
                                                <option value="<?php echo $k; ?>"><?php echo strip_tags($situation); ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon type-contents show-type-client">
                                <div class="yuzde30"><?php echo __("admin/tools/without-products"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="without_products" value="1" class="checkbox-custom" id="without-products" onchange="reload_contact_list();">
                                    <label class="checkbox-custom-label" for="without-products">(<?php echo isset($without_products_users) ? $without_products_users : 0; ?>)</label>
                                </div>
                            </div>
                            <div class="formcon type-contents show-type-client">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-select-birthday-marketing"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="birthday_marketing" value="1" class="checkbox-custom" id="birthday-marketing" onchange="reload_contact_list();">
                                    <label class="checkbox-custom-label" for="birthday-marketing"><i class="fa fa-birthday-cake" style="margin-right: 5px;"></i> <?php echo __("admin/tools/bulk-select-birthday-marketing-d"); ?> (<?php echo  isset($birthday_marketing_users) ? $birthday_marketing_users : 0; ?>)</label>
                                </div>
                            </div>


                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="biggroup type-contents show-type-client">
                        <div class="padding20">
                            <?php
                                $pservices = [];
                            ?>
                            <h4 class="biggrouptitle"><?php echo __("admin/tools/bulk-products-criteria"); ?></h4>

                            <div class="formcon criteria-contents show-criteria-general show-criteria-servers">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-select-server-product"); ?></div>
                                <div class="yuzde70">
                                    <select name="services[]" multiple  style="height: 200px;">
                                        <option<?php echo in_array("allOf/hosting",$pservices) ? ' selected' : ''; ?> value="allOf/hosting" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-hosting"); ?></option>
                                        <?php
                                            $line   = "";
                                            $products   = $functions["get_category_products"]("hosting",0);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/hosting/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/hosting/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                            $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/hosting/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/hosting/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$row["title"],$match);
                                                    $line   = rtrim($match[0]);
                                                    $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/hosting/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/hosting/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }

                                                }
                                            }
                                        ?>

                                        <option<?php echo in_array("allOf/server",$pservices) ? ' selected' : ''; ?> value="allOf/server" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-server"); ?></option>
                                        <?php
                                            $line   = "";
                                            $products   = $functions["get_category_products"]("server","0");
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/server/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/server/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                            $get_pcategories = $functions["get_product_categories"]("products","server");
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/server/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/server/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$row["title"],$match);
                                                    $line   = rtrim($match[0]);
                                                    $products   = $functions["get_category_products"]("server",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/server/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/server/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                                if(isset($servers) && $servers)
                                {
                                    ?>
                                    <div class="formcon criteria-contents show-criteria-general show-criteria-servers">
                                        <div class="yuzde30"><?php echo __("admin/tools/shared-servers"); ?></div>
                                        <div class="yuzde70">
                                            <select name="servers[]" multiple style="height: 200px;">
                                                <?php
                                                    foreach($servers AS $server)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $server["id"]; ?>"><?php echo $server["name"]." - ".$server["ip"]." - ".$server["type"]; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>

                            <div class="formcon criteria-contents show-criteria-general show-criteria-domain">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-select-domain-product"); ?></div>
                                <div class="yuzde70">
                                    <select name="services[]" multiple  style="height: 200px;">
                                        <option<?php echo in_array("allOf/domain",$pservices) ? ' selected' : ''; ?> value="allOf/domain" style="font-weight: bold;"><?php echo ___("needs/allOf"); ?></option>
                                        <?php
                                            $tlds   = $functions["get_tlds"];
                                            $tlds   = $tlds();
                                            if($tlds){
                                                foreach($tlds AS $tld){
                                                    ?>
                                                    <option<?php echo in_array("product/domain/0/".$tld["id"],$pservices) ? ' selected' : ''; ?> value="product/domain/0/<?php echo $tld["id"]; ?>">» <?php echo $tld["name"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon criteria-contents show-criteria-general show-criteria-products">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-select-other-product"); ?></div>
                                <div class="yuzde70">
                                    <select name="services[]" multiple  style="height: 200px;">
                                        <option<?php echo in_array("allOf/softwares",$pservices) ? ' selected' : ''; ?> value="allOf/softwares" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-softwares"); ?></option>
                                        <?php
                                            $line = "";
                                            $products   = $functions["get_category_products"]("software","0");
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/software/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/software/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                            $get_pcategories = $functions["get_product_categories"]("softwares");
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/software/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/software/<?php echo $row["id"]; ?>"><?php echo " - ".$row["title"]; ?></option>
                                                    <?php
                                                    $line = "-";
                                                    $products   = $functions["get_category_products"]("software",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/software/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/software/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        ?>

                                        <?php if(Config::get("general/local")=="tr"): ?>
                                            <option<?php echo in_array("allOf/sms",$pservices) ? ' selected' : ''; ?> value="allOf/sms"  style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-sms"); ?></option>
                                            <?php
                                            $line   = "";
                                            $products   = $functions["get_category_products"]("sms",0);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/sms/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/sms/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <?php endif; ?>

                                        <?php
                                            $pspecialGroups = $functions["get_special_pgroups"]();
                                            if($pspecialGroups){
                                                foreach($pspecialGroups AS $category){
                                                    ?>
                                                    <option<?php echo in_array("allOf/special/".$category["id"],$pservices) ? ' selected' : ''; ?> value="allOf/special/<?php echo $category["id"]; ?>" style="font-weight: bold;"><?php echo $category["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$category["title"],$match);
                                                    $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                                    $products   = $functions["get_category_products"]("special",$category["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                                    if($get_pcategories){
                                                        foreach($get_pcategories AS $row){
                                                            ?>
                                                            <option<?php echo in_array("category/special/".$category["id"]."/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/special/<?php echo $category["id"]; ?>/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                            <?php
                                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                                            $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                                            $products   = $functions["get_category_products"]("special",$row["id"]);
                                                            if($products){
                                                                foreach ($products as $product) {
                                                                    ?>
                                                                    <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon criteria-contents show-criteria-general show-criteria-addons">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-select-addons-product"); ?></div>
                                <div class="yuzde70">
                                    <select name="addons[]" multiple style="height: 200px;">
                                        <?php
                                            if(isset($addon_products) && $addon_products)
                                            {
                                                foreach($addon_products AS $g_id => $g)
                                                {
                                                    ?>
                                                    <optgroup style="font-weight: bold;" label="- <?php echo $g["title"]; ?>">
                                                        <?php
                                                            foreach($g["data"] AS $a)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $a["id"]; ?>">-» <?php echo $a["name"]; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </optgroup>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/bulk-service-status"); ?></div>
                                <div class="yuzde70">
                                    <select name="services_status[]" multiple class="select2-element" data-placeholder="<?php echo __("admin/tools/bulk-select-placeholder"); ?>">
                                        <?php
                                            foreach($order_situations AS $k => $situation)
                                            {
                                                ?>
                                                <option value="<?php echo $k; ?>"><?php echo strip_tags($situation); ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>





                    <div class="formcon">
                        <div class="yuzde30">
                            <?php echo __("admin/tools/cc-emails"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/tools/cc-emails-info"); ?></span>
                        </div>
                        <div class="yuzde70">
                            <textarea name="cc" rows="5" onchange="reload_contact_list();"></textarea>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/subject"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="subject" value="">
                        </div>
                    </div>

                    <div class="formcon">
                        <textarea name="message" class="tinymce-1" id="message"><?php echo $show == "edit_campaign" && isset($templates[(int) Filter::init("GET/id","numbers")]) ? $templates[(int) Filter::init("GET/id","numbers")]["message"] : ''; ?></textarea>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/submission-type"); ?></div>
                        <div class="yuzde70">
                            <input checked onchange="if($(this).prop('checked')) $('#user_variables').css('display','block');" type="radio" name="submission-type" value="single" class="radio-custom" id="send-single">
                            <label class="radio-custom-label" for="send-single" style="margin-right:10px;margin-bottom:5px;"><?php echo __("admin/tools/send-single"); ?> <span class="kinfo"><?php echo __("admin/tools/send-single-info"); ?></span></label>
                            <div class="clear"></div>

                            <input onchange="if($(this).prop('checked')) $('#user_variables').css('display','none');" type="radio" name="submission-type" value="multiple" class="radio-custom" id="send-multiple">
                            <label class="radio-custom-label" for="send-multiple" style="margin-right:10px;"><?php echo __("admin/tools/send-multiple"); ?> <span class="kinfo"><?php echo __("admin/tools/send-multiple-info"); ?></span></label>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/bulk-number-of-people-to-send"); ?></div>
                        <div class="yuzde70">
                            <input type="hidden" name="users" id="users">
                            <strong style="font-size: 20px;" id="users_count">0</strong>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">
                            <?php echo __("admin/notifications/edit-website-variables"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/notifications/edit-website-variables-info"); ?></span>
                        </div>
                        <div class="yuzde70" id="template-variables">
                            <span>{website_header_logo}</span>
                            <span>{website_footer_logo}</span>
                            <span>{notifi_header_logo}</span>
                            <span>{notifi_footer_logo}</span>
                            <span>{notifi_body}</span>
                            <span>{website_url}</span>
                            <span>{website_title}</span>
                            <span>{website_infos}</span>
                            <span>{website_emails}</span>
                            <span>{website_phones}</span>
                            <span>{website_address}</span>
                            <span>{newsletter_unsubscribe_link}</span>
                        </div>
                    </div>

                    <div class="formcon" id="user_variables">
                        <div class="yuzde30">
                            <?php echo __("admin/notifications/edit-user-variables"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/notifications/edit-user-variables-info"); ?></span>
                        </div>
                        <div class="yuzde70" id="template-variables">
                            <span>{user_id}</span>
                            <span>{user_login_link}</span>
                            <span>{user_full_name}</span>
                            <span>{user_name}</span>
                            <span>{user_surname}</span>
                            <span>{user_company_name}</span>
                            <span>{user_email}</span>
                            <span>{user_pass}</span>
                            <span>{user_phone}</span>
                            <span>{user_country}</span>
                            <span>{user_city}</span>
                            <span>{user_counti}</span>
                            <span>{user_address}</span>
                            <span>{user_zipcode}</span>
                            <span>{user_ip}</span>
                        </div>
                    </div>


                    <div class="clear"></div>

                    <div style="margin-top:10px;display: none;" class="result_count"><?php echo __("admin/tools/filter-result-email",['{count}' => '<strong>0</strong>']); ?></div>



                    <div class="clear"></div>

                    <div id="save_template_btn_wrap" class="guncellebtn yuzde30" style="margin-top:10px;float: left;">
                        <a href="javascript:void 0;" onclick="save_template(this);" class="gonderbtn mavibtn"><?php echo __("admin/tools/bulk-template-save"); ?></a>
                    </div>
                    <div id="save_as_template_wrap" style="display: none;float: left;margin-top: 25px;font-weight: 600;">
                        <input type="checkbox" value="1" id="save_as_template" class="checkbox-custom">
                        <label class="checkbox-custom-label" for="save_as_template"><?php echo __("admin/tools/bulk-save-as-template"); ?></label>
                    </div>

                    <div id="update_template_wrap" style="display: none;float: left;margin-top: 25px;font-weight: 600;">
                        <input type="checkbox" value="1" id="update_template" class="checkbox-custom">
                        <label class="checkbox-custom-label" for="update_template"><?php echo __("admin/tools/bulk-update-template"); ?></label>
                    </div>



                    <div id="submit_btn_wrap" class="guncellebtn yuzde50" style="margin-top:10px;float: right;">

                        <a href="javascript:void 0;" id="send_btn" style="display: none;width: 250px;float: right;margin-left:10px;" onclick="open_modal('ConfirmModal');" class="gonderbtn yesilbtn"><?php echo ___("needs/button-submit"); ?></a>
                        <a class="graybtn gonderbtn" id="send_inactive_btn" style="width: 250px;float: right;margin-left:10px;"><?php echo ___("needs/button-submit"); ?></a>

                        <a class="gonderbtn mavibtn" style="float: right;width: 200px;" href="javascript:void 0;" onclick="PreviewBtn();"><?php echo __("admin/products/software-licensing-25"); ?></a>

                    </div>

                    <div class="clear"></div>

                </form>

                <script type="text/javascript">
                    $(document).ready(function(){

                        $("#ConfirmModal").on("click","#BulkMailForm_submit",function(){

                            if($("#save_as_template").prop('checked'))
                            {
                                if(!save_template())
                                {
                                    template_name   = prompt("<?php echo __("admin/tools/bulk-template-name-prompt"); ?>");
                                    template_name   = $.trim(template_name);

                                    if(template_name === '') return false;
                                }
                            }

                            $("#show_result_wrap").css("display","none");
                            $("#loader_start").css("display","block");

                            MioAjaxElement($(this),{
                                form:$("#BulkMailForm"),
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                result:"BulkMailForm_handler",
                            });

                        });
                    });

                    function BulkMailForm_handler(result){
                        if(result != ''){

                            $("#show_result_wrap").css("display","block");
                            $("#loader_start").css("display","none");

                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    template_name = '';
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#BulkMailForm "+solve.for).focus();
                                        $("#BulkMailForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#BulkMailForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){

                                    if($("#save_as_template").prop('checked') || $("#update_template").prop('checked'))
                                    {
                                        save_template();
                                        template_name = '';
                                        $("#save_as_template").prop('checked',false);
                                        $("#update_template").prop('checked',false);
                                    }

                                    alert_success(solve.message,{timer:2000});
                                    if(solve.redirect != undefined && solve.redirect != ''){
                                        setTimeout(function(){
                                            window.location.href = solve.redirect;
                                        },2000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }
                </script>

            </div>


        </div>

    </div>

    <div class="email-sms-campaigns" id="list_wrap" style="<?php echo  isset($show) && $show ? 'display:none;' : ''; ?>">

        <div class="icerikbaslik">
            <h1><strong><?php echo __("admin/tools/page-bulk-mail"); ?></strong></h1>
            <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
        </div>

        <div class="email-sms-campaigns-con">
            <div class="padding20">
                <h1><?php echo __("admin/tools/bulk-templates"); ?></h1>

                <div class="line"></div>

                <div class="green-info">
                    <div class="padding20">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("admin/tools/bulk-template-desc"); ?></p>
                    </div>
                </div>

                <a class="green lbtn" href="<?php echo $links["controller"]; ?>?show=send"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo __("admin/tools/bulk-send"); ?></a>
                <a class="blue lbtn" href="<?php echo $links["controller"]; ?>?show=create_campaign"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/tools/bulk-create-template"); ?></a>

                <table width="100%" id="table1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th data-orderable="false" align="left"><?php echo __("admin/tools/bulk-template-name"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/tools/bulk-template-updated-at"); ?></th>
                        <th data-orderable="false" width="100" align="center"><?php echo __("admin/tools/bulk-th-operations"); ?></th>
                    </tr>
                    </thead>
                    <tbody id="load-template-table1">

                    </tbody>
                </table>

            </div>
        </div>

        <div class="email-sms-campaigns-con">
            <div class="padding20">
                <h1><?php echo __("admin/tools/bulk-auto-submissions"); ?></h1>

                <div class="line"></div>

                <div class="blue-info">
                    <div class="padding20">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                       <p> <?php echo __("admin/tools/bulk-auto-submissions-desc"); ?></p>
                    </div>
                </div>

                <a class="blue lbtn" href="javascript:create_scheduled_task();void 0;"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/tools/bulk-scheduled-task-create"); ?></a>

                <table width="100%" id="table2">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th data-orderable="false" align="left"><?php echo __("admin/tools/bulk-template-name"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/tools/bulk-submission-time"); ?></th>
                        <th data-orderable="false" width="100" align="center"><?php echo __("admin/tools/bulk-th-operations"); ?></th>
                    </tr>
                    </thead>
                    <tbody id="load-template-table2">
                    </tbody>
                </table>

            </div>
        </div>



    </div>



</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>