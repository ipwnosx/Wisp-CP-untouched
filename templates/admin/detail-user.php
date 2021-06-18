<?php
    $privOperation  = Admin::isPrivilege(["USERS_OPERATION"]);
    $privDelete     = Admin::isPrivilege(["USERS_DELETE"]);
    $getCurrency = Money::getSymbol($user["balance_currency"]);
    $bring  = Filter::init("GET/bring","route");

    if($bring == "address-list"){

        if(isset($acAddresses) && $acAddresses){
            foreach($acAddresses AS $addr){
                ?>
                <div class="adresbilgisi" id="address_<?php echo $addr["id"];?>">
                    <input type="hidden" name="country_id" value="<?php echo $addr["country_id"]; ?>">
                    <input type="hidden" name="detouse" value="<?php echo $addr["detouse"] ? 1 : 0; ?>">
                    <input type="hidden" name="zipcode" value="<?php echo $addr["zipcode"]; ?>">
                    <input type="hidden" name="city" value="<?php echo $addr["city"]; ?>">
                    <input type="hidden" name="counti" value="<?php echo $addr["counti"]; ?>">
                    <input type="hidden" name="address" value="<?php echo htmlentities($addr["address"],ENT_QUOTES); ?>">
                    <div class="yuzde90">
                        - <?php echo $addr["name"]; ?>
                        <?php if($addr["detouse"]): ?>
                            <strong>(<?php echo __("admin/users/detail-info-default-address"); ?>)</strong>
                        <?php endif; ?>
                    </div>
                    <?php if($privOperation): ?>
                        <div class="yuzde10" style="float:right;">
                            <a href="javascript:void(0);editAddress(<?php echo $addr["id"]; ?>);" style="margin-left:5px;" title="<?php echo __("admin/users/button-edit") ?>" class="sbtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="javascript:void(0);deleteAddress(<?php echo $addr["id"]; ?>);" style="margin-left:5px;" title="<?php echo __("admin/users/button-delete") ?>" class="red sbtn"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            }
        }

        die();
    }
    if($bring == "credit-logs" && Admin::isPrivilege("USERS_MANAGE_CREDIT")){

        if(isset($creditLogs) && $creditLogs){
            foreach($creditLogs AS $row){
                $creditCurr = $user["balance_currency"] == $row["cid"] ? $getCurrency : Money::getSymbol($row["currency"]);
                $desc = $row["description"];

                if(substr($desc,0,1) == "#")
                {
                    $number = substr($desc,1);
                    $desc = '<a target="_blank" href="'.Controllers::$init->AdminCRLink("invoices-2",["detail",$number]).'">#'.$number.'</a>';
                }

                ?>
                <tr id="credit_<?php echo $row["id"]; ?>">
                    <td align="left">
                        <div class="credit-desc" style="display:none;"><?php echo $row["description"]; ?></div>
                        <div class="credit-type" style="display:none;"><?php echo $row["type"]; ?></div>
                        <div class="credit-amount" style="display:none;"><?php echo Money::formatter($row["amount"],$row["cid"]); ?></div>
                        <div class="credit-amount-prefix" style="display:none;"><?php echo $creditCurr["prefix"]; ?></div>
                        <div class="credit-amount-suffix" style="display:none;"><?php echo $creditCurr["suffix"]; ?></div>
                        <?php echo $desc; ?>
                    </td>
                    <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]); ?></td>
                    <td align="center"><?php echo $row["type"] == "up" ? '<span style="color:green">+'.Money::formatter_symbol($row["amount"],$row["cid"]).'</span>' : '<span style="color:red">-'.Money::formatter_symbol($row["amount"],$row["cid"]).'</span>'; ?></td>
                    <td align="center">
                        <a href="javascript:editCredit(<?php echo $row["id"]; ?>);void 0;" class="sbtn"><i class="fa fa-pencil-square-o"></i></a>
                        <a class="red sbtn" href="javascript:deleteCredit(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
                <?php
            }
        }else{
            ?>
            <tr>
                <td colspan="3" align="center">
                    <span class="error"><?php echo __("admin/users/manage-balance-logs-none"); ?></span>
                </td>
            </tr>
            <?php
        }

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','intlTelInput','dataTables','mio-icons','select2','voucher_codes'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        var default_country,city_request = false,counti_request=false;
        $(document).ready(function(){

            var tab = _GET("tab");
            if (tab != '' && tab != undefined) {
                $("#tab-tab .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-tab .tablinks:eq(0)").addClass("active");
                $("#tab-tab .tabcontent:eq(0)").css("display", "block");
            }

            $(".remind_unpaid_bill_button").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"remind_unpaid_bill"}
                },true,true);

                request.done(function(result){
                    button_handler("remind_unpaid_bill",result);
                });
            });

            $("#block_user_button").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"block_user"}
                },true,true);

                request.done(function(result){
                    button_handler("block_user",result);
                });
            });

            $("#unblock_user_button").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"unblock_user"}
                },true,true);

                request.done(function(result){
                    button_handler("unblock_user",result);
                });
            });

            $("#reset_and_send_password_button").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"reset_and_send_password"}
                },true,true);

                request.done(function(result){
                    button_handler("reset_and_send_password",result);
                });
            });

            $("#suspend_all_of_services").on("click","#suspend_all_of_services_ok",function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"suspend_all_of_services"}
                },true,true);

                request.done(function(result){
                    button_handler("suspend_all_of_services",result);
                });
            });

            $("#unsuspend_all_of_services").on("click","#unsuspend_all_of_services_ok",function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"unsuspend_all_of_services"}
                },true,true);

                request.done(function(result){
                    button_handler("unsuspend_all_of_services",result);
                });
            });

            $("#delete_everything_about_user").on("click","#delete_everything_about_user_ok",function(){
                var passwordInput = $("#password1");

                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"delete_everything_about_user",password:passwordInput.val()}
                },true,true);

                passwordInput.val('');

                request.done(function(result){
                    button_handler("delete_everything_about_user",result);
                });
            });

            $("#send_sms").on("click","#sendSMSForm_submit",function(){

                var request = MioAjax({
                    form:$("#sendSMSForm"),
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                },true,true);

                request.done(function(result){
                    button_handler("send_sms",result);
                });
            });

            $("#send_mail").on("click","#sendMailForm_submit",function(){

                var request = MioAjax({
                    form:$("#sendMailForm"),
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                },true,true);

                request.done(function(result){
                    button_handler("send_mail",result);
                });
            });


            $("#suspend_all_of_services_button").click(function(){
                open_modal("suspend_all_of_services");
            });

            $("#unsuspend_all_of_services_button").click(function(){
                open_modal("unsuspend_all_of_services");
            });

            $("#delete_everything_about_user_button").click(function(){
                open_modal("delete_everything_about_user");
            });

            $("#send_sms_button").click(function(){
                open_modal('send_sms');
            });

            $("#send_mail_button").click(function(){
                open_modal('send_mail');
            });

            $("#manage_balance_button").click(function(){
                open_modal('manage-balance');
            });

            var select2_element = $('.select2');
            select2_element.select2();

        });

        function button_handler(type,result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
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

        function change_notes(elem){
            var value = $(elem).val();

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"edit_notes",notes:value},
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
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
            });
        }

        function addAddress(){
            $("#manageAddress").attr("data-izimodal-title",'<?php echo htmlspecialchars(__("admin/users/detail-info-add-address"),ENT_QUOTES); ?>');
            open_modal('manageAddress');

            $("#manageAddressForm input[name=operation]").val('add_address');
            $("#manageAddressForm input[name=id]").val('0');

            $("#manageAddressForm select[name=country]").val('');

            $("#manageAddressForm select[name=city]").html('').css("display","none").attr("disabled",true);
            $("#manageAddressForm input[name=city]").val('').css("display","block").attr("disabled",false);

            $("#manageAddressForm select[name=counti]").html('').css("display","none").attr("disabled",true);
            $("#manageAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);


            $("#manageAddressForm_submit").html('+ <?php echo htmlspecialchars(__("admin/users/button-add-address"),ENT_QUOTES); ?>');

        }
        function editAddress(id){
            $("#manageAddress").attr("data-izimodal-title",'<?php echo htmlspecialchars(__("admin/users/detail-info-edit-address"),ENT_QUOTES); ?>');
            open_modal('manageAddress');

            $("#manageAddressForm input[name=operation]").val('edit_address');
            $("#manageAddressForm input[name=id]").val(id);

            $("#manageAddressForm_submit").html('<?php echo htmlspecialchars(__("admin/users/button-edit-address"),ENT_QUOTES); ?>');

            var city            = $("#address_"+id+" input[name=city]").val();
            var counti          = $("#address_"+id+" input[name=counti]").val();
            var zipcode         = $("#address_"+id+" input[name=zipcode]").val();
            var address         = $("#address_"+id+" input[name=address]").val();
            var detouse         = $("#address_"+id+" input[name=detouse]").val();
            var country_id      = $("#address_"+id+" input[name=country_id]").val();

            $("#manageAddressForm input[name=zipcode]").val(zipcode);
            $("#manageAddressForm input[name=address]").val(address);
            $("#manageAddressForm input[name=detouse]").prop("checked",detouse == 1);

            $("#manageAddressForm select[name=country]").val(country_id);

            getCities(country_id,true);

            var cityInterval = setInterval(function(){
                if(city_request === "done"){
                    $("#manageAddressForm *[name=city]").val(city);
                    clearInterval(cityInterval);
                    city_request = false;

                    getCounties(city,true);

                    var countiInterval = setInterval(function(){
                        if(counti_request === "done"){
                            $("#manageAddressForm *[name=counti]").val(counti);
                            clearInterval(countiInterval);
                            counti_request = false;
                        }
                    },100);

                }
            },100);
        }
        function getCities(country,call_request){

            $("#manageAddressForm select[name=city]").html('').css("display","none").attr("disabled",true);
            $("#manageAddressForm input[name=city]").val('').css("display","block").attr("disabled",false);

            $("#manageAddressForm select[name=counti]").html('').css("display","none").attr("disabled",true);
            $("#manageAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);

            if(call_request) city_request = false;

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"getCities",country:country},
            },true,true);

            request.done(function(result){
                if(call_request) city_request = "done";

                if(result || result !== undefined){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "successful"){
                                $("#manageAddressForm select[name=city]").html('');
                                $("#manageAddressForm select[name='city']").append($('<option>', {
                                    value: '',
                                    text: "<?php echo ___("needs/select-your"); ?>",
                                }));
                                $(solve.data).each(function (index,elem) {
                                    $("#manageAddressForm select[name='city']").append($('<option>', {
                                        value: elem.id,
                                        text: elem.name
                                    }));
                                });
                                $("#manageAddressForm select[name='city']").css("display","block").attr("disabled",false);
                                $("#manageAddressForm input[name='city']").css("display","none").attr("disabled",true);
                            }else{
                                $("#manageAddressForm select[name='city']").css("display","none").attr("disabled",true);
                                $("#manageAddressForm input[name='city']").css("display","block").attr("disabled",false);
                                $("#manageAddressForm input[name='city']").focus();
                            }
                        }else
                            console.log(result);
                    }
                }
            });
        }
        function getCounties(city,call_request){

            if(call_request) counti_request = false;

            if(city !== ''){
                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"getCounties",city:city},
                },true,true);

                request.done(function(result){
                    if(call_request) counti_request = "done";
                    if(result || result != undefined){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "successful"){
                                    $("#manageAddressForm select[name=counti]").html('');
                                    $("#manageAddressForm select[name='counti']").append($('<option>', {
                                        value: '',
                                        text: "<?php echo ___("needs/select-your"); ?>",
                                    }));
                                    $(solve.data).each(function (index,elem) {
                                        $("#manageAddressForm select[name='counti']").append($('<option>', {
                                            value: elem.id,
                                            text: elem.name
                                        }));
                                    });
                                    $("#manageAddressForm select[name=counti]").css("display","block").attr("disabled",false);
                                    $("#manageAddressForm input[name=counti]").val('').css("display","none").attr("disabled",true);
                                }else{
                                    $("#manageAddressForm select[name=counti]").css("display","none").attr("disabled",true);
                                    $("#manageAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);
                                    $("#manageAddressForm input[name='counti']").focus();
                                }
                            }else
                                console.log(result);
                        }
                    }
                });
            }
            else{
                $("#manageAddressForm select[name=counti]").html('').css("display","none").attr("disabled",true);
                $("#manageAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);
                if(call_request) counti_request = "done";
            }
        }
        function manageAddressForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#manageAddressForm "+solve.for).focus();
                            $("#manageAddressForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#manageAddressForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});

                        $.get( "<?php echo $links["controller"]."?bring=address-list"; ?>", function( data ) {
                            $( "#AddressList" ).html( data );
                            $("#empty_content").css("display","none");

                        });
                    }
                }else
                    console.log(result);
            }
        }

        function add_blacklist(btn){
            if(btn){
                var reason  = $("#blacklist_reason").val();

                var request = MioAjax({
                    button_element:btn,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"add_blacklist",id:<?php echo $user["id"]; ?>,reason:reason}
                },true,true);
                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:3000});
                                    setTimeout(function(){
                                        window.location.href = '<?php echo $links["controller"]; ?>';
                                    },3000);
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });
            }else open_modal('add_blacklist_modal');
        }
        function remove_blacklist(btn){
            var request = MioAjax({
                button_element:btn,
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"delete_blacklist",id:<?php echo $user["id"]; ?>}
            },true,true);
            request.done(function(result){
                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:3000});
                                setTimeout(function(){
                                    window.location.href = '<?php echo $links["controller"]; ?>';
                                },3000);
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });
        }

        var g_accordion = parseInt(_GET("accordion"));

        $( function() {
            $( "#accordion" ).accordion({
                heightStyle: "content",
                active: isNaN(g_accordion) ? 0 : g_accordion,
                collapsible: true,
            });
        } );
    </script>

</head>
<body>

<div id="add_blacklist_modal" style="display: none;" data-izimodal-title="<?php echo __("admin/users/blacklist-add-btn"); ?>">
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add_blacklist_submit").on('click',function(){
                add_blacklist(this);
            });
        });
    </script>
    <div class="padding20">
        <div align="center">

            <textarea id="blacklist_reason" placeholder="<?php echo __("admin/users/blacklist-reason-placeholder"); ?>" rows="5"></textarea>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="add_blacklist_submit" href="javascript:void(0);"><?php echo __("admin/users/blacklist-save-btn"); ?></a>
            </div>
        </div>

        <div class="clear"></div>

    </div>
</div>

<div id="suspend_all_of_services" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-summary-suspend-all-of-services"); ?>">
    <div class="padding20">

        <div align="center">
            <p><?php echo __("admin/users/suspend-all-of-services-message"); ?></p>

            <div class="clear"></div>

            <div class="yuzde50">
                <a href="javascript:void(0);" id="suspend_all_of_services_ok" class="turuncbtn gonderbtn"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div id="unsuspend_all_of_services" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-summary-unsuspend-all-of-services"); ?>">
    <div class="padding20">

        <div align="center">
            <p><?php echo __("admin/users/unsuspend-all-of-services-message"); ?></p>

            <div class="clear"></div>

            <div class="yuzde50">
                <a href="javascript:void(0);" id="unsuspend_all_of_services_ok" class="turuncbtn gonderbtn"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div id="delete_everything_about_user" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-summary-delete-everything-about-user"); ?>">
    <div class="padding20">

        <div align="center">
            <p><?php echo __("admin/users/delete-everything-about-user-message"); ?></p>

            <div class="clear"></div>
            <div id="password_wrapper">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>
            <div class="clear"></div>

            <div class="yuzde50">
                <a href="javascript:void(0);" id="delete_everything_about_user_ok" class="redbtn gonderbtn"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<?php
    if(Admin::isPrivilege("USERS_MANAGE_CREDIT")){
        ?>
        <div id="manage-balance" data-izimodal-title="<?php echo __("admin/users/detail-summary-manage-balance"); ?>" style="display: none;">
            <div class="padding20">

                <script type="text/javascript">
                    $(document).ready(function(){

                        $("#addCreditForm_submit").on("click",function(){
                            MioAjaxElement($(this),{
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                result:"addCreditForm_handler",
                            });
                        });

                        $("#editCreditForm_submit").on("click",function(){
                            MioAjaxElement($(this),{
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                result:"editCreditForm_handler",
                            });
                        });

                    });

                    function addCreditForm_handler(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#addCreditForm "+solve.for).focus();
                                        $("#addCreditForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#addCreditForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){

                                    $.get("<?php echo $links["controller"]."?bring=credit-logs"; ?>", function( data ) {
                                        $( "#creditLogs" ).html( data );

                                        $("#addCreditForm input[type=text]").val('');

                                    });

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

                    function editCreditForm_handler(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#editCreditForm "+solve.for).focus();
                                        $("#editCreditForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#editCreditForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){

                                    $.get("<?php echo $links["controller"]."?bring=credit-logs"; ?>", function( data ) {
                                        $( "#creditLogs" ).html( data );
                                        $("#editCreditForm").css("display","none");
                                        $("#addCreditForm").css("display","block");
                                    });

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

                    function deleteCredit(id){
                        var request = MioAjax({
                            action:"<?php echo $links["controller"]; ?>",
                            method:"POST",
                            data:{operation:"delete_credit",id:id}
                        },true,true);

                        request.done(function (result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:5000});
                                    }else if(solve.status == "successful"){
                                        $.get("<?php echo $links["controller"]."?bring=credit-logs"; ?>", function( data ) {
                                            $( "#creditLogs" ).html( data );
                                            $("#addCreditForm").css("display","block");
                                            $("#editCreditForm").css("display","none");
                                        });

                                        if(solve.redirect != undefined && solve.redirect != ''){
                                            setTimeout(function(){
                                                window.location.href = solve.redirect;
                                            },2000);
                                        }
                                    }
                                }else
                                    console.log(result);
                            }
                        });
                    }

                    function editCredit(id){
                        var desc   = $("#credit_"+id+" .credit-desc").html();
                        var type   = $("#credit_"+id+" .credit-type").html();
                        var amount = $("#credit_"+id+" .credit-amount").html();
                        var prefix = $("#credit_"+id+" .credit-amount-prefix").html();
                        var suffix = $("#credit_"+id+" .credit-amount-suffix").html();

                        $("#editCreditForm input[name=id]").val(id);
                        $("#editCreditForm input[name=description]").val(desc);
                        $("#editCreditForm input[name=type]").prop("checked",false);
                        $("#editCreditForm #edit_credit_type_"+type).prop("checked",true);
                        $("#editCreditForm input[name=amount]").val(amount);
                        $("#amount_prefix").html(prefix);
                        $("#amount_suffix").html(suffix);

                        $("#addCreditForm").css("display","none");
                        $("#editCreditForm").css("display","block");

                    }
                </script>

                <?php if($privOperation): ?>
                    <form action="<?php echo $links["controller"]; ?>" method="post" id="addCreditForm">
                        <input type="hidden" name="operation" value="add_credit">

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-amount"); ?></div>
                            <div class="yuzde70">
                                <span style="font-size:24px;"><?php echo $getCurrency["prefix"];?></span>
                                <input type="text" name="amount" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="width200">
                                <span style="font-size:24px;"><?php echo $getCurrency["suffix"];?></span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-type"); ?></div>
                            <div class="yuzde70">
                                <input checked type="radio" class="radio-custom" id="add_credit_type_up" value="up" name="type">
                                <label for="add_credit_type_up" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/users/manage-balance-type-up"); ?></label>
                                <input type="radio" class="radio-custom" id="add_credit_type_down" value="down" name="type">
                                <label for="add_credit_type_down" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/users/manage-balance-type-down"); ?></label>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-description"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="description" value="" placeholder="<?php echo __("admin/users/manage-balance-description-i"); ?>">
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                            <a class="yesilbtn gonderbtn" id="addCreditForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-apply"); ?></a>
                        </div>
                        <div class="clear"></div>
                        <br>
                    </form>

                    <form action="<?php echo $links["controller"]; ?>" method="post" id="editCreditForm" style="display: none;">
                        <input type="hidden" name="operation" value="edit_credit">
                        <input type="hidden" name="id" value="0">

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-amount"); ?></div>
                            <div class="yuzde70">
                                <span style="font-size:24px;" id="amount_prefix"></span>
                                <input type="text" name="amount" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="width200">
                                <span style="font-size:24px;" id="amount_suffix"></span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-type"); ?></div>
                            <div class="yuzde70">
                                <input checked type="radio" class="radio-custom" id="edit_credit_type_up" value="up" name="type">
                                <label for="edit_credit_type_up" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/users/manage-balance-type-up"); ?></label>
                                <input type="radio" class="radio-custom" id="edit_credit_type_down" value="down" name="type">
                                <label for="edit_credit_type_down" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/users/manage-balance-type-down"); ?></label>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/manage-balance-description"); ?></div>
                            <div class="yuzde70">

                                <input type="text" name="description" value="" placeholder="<?php echo __("admin/users/manage-balance-description-i"); ?>">
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div style="float:left;margin-top:10px;" class="guncellebtn yuzde30">
                            <a class="redbtn gonderbtn" id="editCreditForm_cancel" href="javascript:$('#editCreditForm').css('display','none'),$('#addCreditForm').css('display','block');void 0;"><?php echo __("admin/users/button-cancel"); ?></a>
                        </div>

                        <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                            <a class="yesilbtn gonderbtn" id="editCreditForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-update"); ?></a>
                        </div>
                        <div class="clear"></div>
                        <br>
                    </form>
                <?php endif; ?>
                <div class="clear"></div>

                <table width="100%" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left"><?php echo __("admin/users/manage-balance-description"); ?></th>
                        <th align="center"><?php echo __("admin/users/manage-balance-date"); ?></th>
                        <th align="center"><?php echo __("admin/users/manage-balance-amount"); ?></th>
                        <?php if($privOperation): ?>
                            <th align="center"> </th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody align="center" style="border-top:none;" id="creditLogs">
                    <?php
                        if(isset($creditLogs) && $creditLogs){
                            foreach($creditLogs AS $row){
                                $creditCurr = $user["balance_currency"] == $row["cid"] ? $getCurrency : Money::getSymbol($row["cid"]);
                                $desc = $row["description"];

                                if(substr($desc,0,1) == "#")
                                {
                                    $number = substr($desc,1);
                                    $desc = '<a target="_blank" href="'.Controllers::$init->AdminCRLink("invoices-2",["detail",$number]).'">#'.$number.'</a>';
                                }
                                ?>
                                <tr id="credit_<?php echo $row["id"]; ?>">
                                    <td align="left">
                                        <div class="credit-desc" style="display:none;"><?php echo $row["description"]; ?></div>
                                        <div class="credit-type" style="display:none;"><?php echo $row["type"]; ?></div>
                                        <div class="credit-amount" style="display:none;"><?php echo Money::formatter($row["amount"],$row["cid"]); ?></div>
                                        <div class="credit-amount-prefix" style="display:none;"><?php echo $creditCurr["prefix"]; ?></div>
                                        <div class="credit-amount-suffix" style="display:none;"><?php echo $creditCurr["suffix"]; ?></div>
                                        <?php echo $desc; ?>
                                    </td>
                                    <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]); ?></td>
                                    <td align="center"><?php echo $row["type"] == "up" ? '<span style="color:green">+'.Money::formatter_symbol($row["amount"],$row["cid"]).'</span>' : '<span style="color:red">-'.Money::formatter_symbol($row["amount"],$row["cid"]).'</span>'; ?></td>
                                    <?php if($privOperation): ?>
                                        <td align="center">
                                            <a href="javascript:editCredit(<?php echo $row["id"]; ?>);void 0;" class="sbtn"><i class="fa fa-pencil-square-o"></i></a>
                                            <a class="red sbtn" href="javascript:deleteCredit(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="3" align="center">
                                    <span class="error"><?php echo __("admin/users/manage-balance-logs-none"); ?></span>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>


            </div>
        </div>
        <?php
    }
?>

<div id="login-logs" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-info-login-log"); ?>">
    <div class="padding20">

        <table width="100%" class="table table-striped table-borderedx table-condensed nowrap">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left"><?php echo __("admin/users/detail-info-login-logs-date"); ?></th>
                <th align="left"><?php echo __("admin/users/detail-info-login-logs-platform"); ?></th>
                <th align="left"><?php echo __("admin/users/detail-info-login-logs-browser"); ?></th>
                <th align="left"><?php echo __("admin/users/detail-info-login-logs-ip"); ?></th>
                <th align="center"><?php echo __("admin/users/detail-info-login-logs-country"); ?></th>
                <th align="center"><?php echo __("admin/users/detail-info-login-logs-city"); ?></th>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;">
            <?php
                Helper::Load("Browser");
                if(isset($loginLogs) && $loginLogs){
                    foreach($loginLogs AS $row){
                        $browser = new Browser($row["user_agent"]);
                        ?>
                        <tr>
                            <td align="left"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]); ?></td>
                            <td align="left"><?php echo $browser->getPlatform(); ?></td>
                            <td align="left"><?php echo $browser->getBrowser()." ".$browser->getVersion(); ?></td>
                            <td align="left"><u><a referrerpolicy="no-referrer" href="https://check-host.net/ip-info?host=<?php echo $row["ip"]; ?>" target="_blank"><?php echo $row["ip"]; ?></a></u></td>
                            <td align="center">
                                <?php
                                    if($row["country_code"]){
                                        $cc = $row["country_code"];
                                        ?>
                                        <img src="<?php echo $sadress; ?>assets/images/flags/<?php echo $cc; ?>.svg" height="15"> <?php echo AddressManager::get_country_name($cc); ?>
                                        <?php
                                    }else
                                        echo ___("needs/unknown");

                                ?>
                            </td>
                            <td align="center">
                                <?php
                                    if($row["city"])
                                        echo $row["city"];
                                    else
                                        echo ___("needs/unknown");
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <tr>
                        <td colspan="2" align="center">
                            <span class="error"><?php echo __("admin/users/detail-info-login-logs-none"); ?></span>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div id="send_sms" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-summary-send-sms"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="sendSMSForm">
            <input type="hidden" name="operation" value="send_sms">

            <div class="formcon">
                <textarea id="sms_message" onchange="change_message(this);" onkeyup="change_message(this);" name="message" rows="8"></textarea>
                <span class="kinfo"><strong id="message_character">0</strong> <?php echo __("admin/users/send-sms-character"); ?></span>
                <script type="text/javascript">
                    change_message(document.getElementById("sms_message"));
                    function change_message(elem) {
                        var value = $(elem).val();
                        var size      = value.length;

                        $("#message_character").html(size);

                    }
                </script>
            </div>

            <div class="clear"></div>

            <div style="float: right;" class="guncellebtn yuzde50">
                <a href="javascript:void(0);" id="sendSMSForm_submit" class="yesilbtn gonderbtn"><i class="fa fa-paper-plane"></i> <?php echo __("admin/users/button-submit"); ?></a>
            </div>

        </form>

        <div class="clear"></div>
    </div>
</div>

<div id="send_mail" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-summary-send-mail"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="sendMailForm">
            <input type="hidden" name="operation" value="send_mail">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/send-mail-subject"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="subject" placeholder="">
                </div>
            </div>

            <div class="formcon">
                <textarea name="message" rows="8"></textarea>
                <span class="kinfo"><?php echo __("admin/users/send-mail-message-info"); ?></span>
            </div>

            <div class="clear"></div>

            <div style="float: right;" class="guncellebtn yuzde50">
                <a href="javascript:void(0);" id="sendMailForm_submit" class="yesilbtn gonderbtn"><i class="fa fa-paper-plane"></i> <?php echo __("admin/users/button-submit"); ?></a>
            </div>

        </form>

        <div class="clear"></div>
    </div>
</div>

<div id="manageAddress" style="display: none;" data-izimodal-title="<?php echo __("admin/users/detail-info-add-address"); ?>">
    <div class="padding20">

        <script type="text/javascript">
            $(document).ready(function(){

                $("#manageAddressForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"manageAddressForm_handler",
                    });

                });
            });
        </script>

        <form action="<?php echo $links["controller"]; ?>" method="post" id="manageAddressForm">
            <input type="hidden" name="operation" value="add_address">
            <input type="hidden" name="id" value="0">

            <?php
                if(isset($countryList) && $countryList){
                    ?>
                    <div class="yuzde25">
                        <strong><?php echo __("website/account_info/country"); ?></strong>
                        <select name="country" onchange="getCities(this.options[this.selectedIndex].value);">
                            <option value=""><?php echo __("website/account_info/select-your"); ?></option>
                            <?php
                                foreach($countryList as $country){
                                    ?><option value="<?php echo $country["id"];?>" data-code="<?php echo $country["code"]; ?>"><?php echo $country["name"];?></option><?php
                                }
                            ?>
                        </select>
                    </div>
                    <?php
                }
            ?>
            <div id="cities" class="yuzde25">
                <strong><?php echo __("admin/users/create-city"); ?></strong>
                <select name="city" disabled id="selectCity" onchange="getCounties($(this).val());" style="display:none;"></select>
                <input type="text" name="city" placeholder="<?php echo __("admin/users/create-city-placeholder"); ?>">
            </div>
            <div id="counti" class="yuzde25" >
                <strong><?php echo __("admin/users/create-counti"); ?></strong>
                <select name="counti" disabled id="selectCounti" style="display:none;"></select>
                <input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>">
            </div>
            <div id="zipcode" class="yuzde25" style="margin-left:5px;">
                <strong><?php echo __("admin/users/create-zipcode"); ?></strong>
                <input name="zipcode" type="text" placeholder="<?php echo __("admin/users/create-zipcode-placeholder"); ?>">
            </div>
            <div id="address" class="yuzde100" style="margin-top:20px;">
                <strong><?php echo __("admin/users/create-address"); ?></strong>
                <input name="address" type="text" placeholder="<?php echo __("admin/users/create-address-placeholder"); ?>">
            </div>
            <div class="yuzde100" style="margin-top:10px;">
                <input type="checkbox" name="detouse" value="1" class="checkbox-custom" id="detouse">
                <label class="checkbox-custom-label" for="detouse"><?php echo __("admin/users/detail-info-default-address"); ?></label>
            </div>

            <a style="float:right;" href="javascript:void(0);" id="manageAddressForm_submit" class="lbtn"><?php echo __("admin/users/button-add-address"); ?></a>

        </form>
        <div class="clear"></div>


    </div>
</div>


<table style="display: none">
    <tbody id="template-rate-item">
    <tr>
        <td align="center">
            <input type="text" name="dp_discounts[x][from][]" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        </td>
        <td align="center">
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </td>
        <td align="center">
            <input type="text" name="dp_discounts[x][to][]" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        </td>
        <td align="center">
            <?php echo __("admin/users/dealership-discount-between"); ?>
        </td>
        <td align="center">
            <input type="text" name="dp_discounts[x][rate][]" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
        </td>
        <td align="center">
            <a class="sbtn red" onclick="$(this).parent().parent().remove();">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
    </tbody>
</table>


<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo __("admin/users/page-detail",["{name}" => $user["full_name"]]); ?></h1>

                <div style="float: left;">
                    <?php
                        if(Config::get("options/blacklist/status") && $user["blacklist"] != 2){

                            if($user["blacklist"]){
                                ?>
                                <a class="lbtn red" href="javascript:void 0;" onclick="remove_blacklist(this);"><?php echo __("admin/users/blacklist-remove-btn"); ?></a>
                                <?php
                            }else{
                                ?>
                                <a class="lbtn" href="javascript:void 0;" onclick="add_blacklist();"><i class="fa fa-ban"></i> <?php echo __("admin/users/blacklist-add-btn"); ?></a>
                                <?php
                            }

                        }
                    ?>
                </div>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>
            <div class="clear"></div>

            <?php
                if(isset($blacklist_blocking) && $blacklist_blocking){
                    ?>
                    <div class="red-info" id="blacklisteduser">
                        <div class="padding20">
                            <i class="fa fa-exclamation-triangle"></i>
                            <p><?php echo __("admin/users/blacklist-warning-info-".$blacklist_blocking); ?></p>
                            <?php
                                if($user["blacklist_reason"]){
                                    ?>
                                    <p class="blacklistreasonp"><strong><?php echo __("admin/users/blacklist-reason"); ?></strong>: <?php echo nl2br($user["blacklist_reason"]); ?></p>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            ?>

            <div id="tab-tab"><!-- tab wrap content start -->

                <ul class="tab">
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'summary','tab')" data-tab="summary"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-summary"); ?></a></li>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'informations','tab')" data-tab="informations"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-informations"); ?></a></li>
                    <?php if(Admin::isPrivilege(Config::get("privileges/INVOICES"))): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'invoices','tab')" data-tab="invoices"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-invoices"); ?></a></li>
                    <?php endif; ?>
                    <?php if(Admin::isPrivilege(Config::get("privileges/ORDERS"))): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'services','tab')" data-tab="services"><i class="fa fa-rocket" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-services"); ?></a></li>
                    <?php endif; ?>
                    <?php if(Admin::isPrivilege(["USERS_DEALERSHIP"]) && Config::get("options/dealership/status")): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'dealership','tab')" data-tab="dealership"><i class="fa fa-certificate" aria-hidden="true"></i> <?php echo __("admin/users/detail-info-dealership"); ?></a></li>
                    <?php endif; ?>
                    <?php if(Admin::isPrivilege(["USERS_AFFILIATE"]) && Config::get("options/affiliate/status")): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'affiliate','tab')" data-tab="affiliate"><i class="fa fa-handshake-o" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-affiliate"); ?></a></li>
                    <?php endif; ?>
                    <?php if(Admin::isPrivilege(Config::get("privileges/TICKETS"))): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'tickets','tab')" data-tab="tickets"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-tickets"); ?></a></li>
                    <?php endif; ?>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'messages','tab')" data-tab="messages"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-messages"); ?></a></li>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'actions','tab')" data-tab="actions"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php echo __("admin/users/detail-tab-actions"); ?></a></li>
                </ul>

                <div id="tab-summary" class="tabcontent">

                    <div class="adminpagecon">

                        <div class="uyeozetbilgiler">

                            <div class="yuzde33">

                                <h5><strong><?php echo __("admin/users/detail-summary-user"); ?></strong></h5>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-name"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo $user["full_name"]; ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-ac-type"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo __("admin/users/create-ac-type-".$user["kind"]); ?>
                                        <?php if(isset($group)): ?>
                                            <strong>(<?php echo $group["name"]; ?>)</strong>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if($user["kind"] == "corporate" && $user["company_name"]): ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-company-name"); ?></div>
                                        <div class="yuzde70">
                                            <?php echo $user["company_name"]; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-email"); ?>
                                        <?php if($user["verified-email"] == $user["email"]): ?>
                                            <a data-tooltip="<?php echo ___("needs/verified"); ?>"><i style="color:#8bc34a" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="yuzde70">
                                        <?php echo $user["email"]; ?>
                                        <?php if($user["verified-email"] != $user["email"]): ?>
                                            <a href="<?php echo $links["controller"]; ?>?operation=verified_email&id=<?php echo $user["id"]; ?>">(<span style="color:#8bc34a"><?php echo __("admin/users/button-verify"); ?></span>)</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-phone"); ?>
                                        <?php if($user["phone"] && $user["verified-gsm"] == $user["phone"]): ?>
                                            <a data-tooltip="<?php echo ___("needs/verified"); ?>"><i style="color:#8bc34a" class="fa fa-check-circle-o" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="yuzde70">
                                        <?php echo $user["phone"] ? "+".$user["phone"] : ___("needs/none"); ?>

                                        <?php if($user["phone"] && $user["verified-gsm"] != $user["phone"]): ?>
                                            <a href="<?php echo $links["controller"]; ?>?operation=verified_gsm&id=<?php echo $user["id"]; ?>">(<span style="color:#8bc34a"><?php echo __("admin/users/button-verify"); ?></span>)</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php
                                    if($user["landline_phone"])
                                    {
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/users/create-landline-phone"); ?></div>
                                            <div class="yuzde70">
                                                <?php echo $user["landline_phone"] ? $user["landline_phone"] : ___("needs/none"); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-country"); ?> / <?php echo __("admin/users/create-city"); ?> / <?php echo __("admin/users/create-counti"); ?></div>
                                    <div class="yuzde70">
                                        <?php
                                            $addressBar = NULL;
                                            if(isset($acAddresses) && $acAddresses){
                                                $findAddress = $acAddresses;
                                                Utility::sksort($findAddress,"detouse");
                                                $findAddress = $findAddress[0];

                                                $addressBar .= $findAddress["country_name"];

                                                if(isset($findAddress["city_name"]))
                                                    $addressBar .= " / ".$findAddress["city_name"];
                                                else
                                                    $addressBar .= " / ".$findAddress["city"];

                                                if(isset($findAddress["counti_name"]))
                                                    $addressBar .= " / ".$findAddress["counti_name"];
                                                else
                                                    $addressBar .= " / ".$findAddress["counti"];

                                            }

                                            echo $addressBar ? $addressBar : ___("needs/none");
                                        ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-ac-status"); ?></div>
                                    <div class="yuzde70">
                                        <?php
                                            if($user["status"] == "active"){
                                                ?>
                                                <div class="listingstatus"><span class="active"><?php echo __("admin/users/situations/active"); ?></span></div>
                                                <?php
                                            }elseif($user["status"] == "inactive"){
                                                ?>
                                                <div class="listingstatus"><span class="wait"><?php echo __("admin/users/situations/inactive"); ?></span></div>
                                                <?php
                                            }elseif($user["status"] == "blocked"){
                                                ?>
                                                <div class="listingstatus"><span class="wait"><?php echo __("admin/users/situations/blocked"); ?></span></div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-info-cdate"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$user["creation_time"]); ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-info-ldate"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$user["last_login_time"]); ?>
                                    </div>
                                </div>


                                <div class="formcon" style="border: none;">
                                    <a href="<?php echo $links["controller"]; ?>?bring=login" target="_blank" class="blue gonderbtn"><i class="fa fa-sign-in"></i> <strong><?php echo __("admin/users/login-to-customer-panel"); ?></strong></a>
                                </div>

                            </div>

                            <div class="yuzde33">

                                <h5><strong><?php echo __("admin/users/detail-summary-accounting"); ?></strong></h5>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-summary-bill-paid"); ?></div>
                                    <div class="yuzde70" style="color:#4caf50;">
                                        <?php echo $statistics["invoices"]["paid"]["quantity"]; ?> (<strong><?php echo Money::formatter_symbol($statistics["invoices"]["paid"]["amount"],Config::get("general/currency")); ?></strong>)
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-summary-bill-unpaid"); ?></div>
                                    <div class="yuzde70" style="color:#f44336;">
                                        <?php echo $statistics["invoices"]["unpaid"]["quantity"]; ?> (<strong><?php echo Money::formatter_symbol($statistics["invoices"]["unpaid"]["amount"],Config::get("general/currency")); ?></strong>)
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-summary-bill-refund"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo $statistics["invoices"]["refund"]["quantity"]; ?> (<strong><?php echo Money::formatter_symbol($statistics["invoices"]["refund"]["amount"],Config::get("general/currency")); ?></strong>)
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-summary-balance"); ?></div>
                                    <div class="yuzde70">
                                        <strong ><?php echo Money::formatter_symbol($user["balance"],$user["balance_currency"]); ?></strong>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/create-ticket-tax-exemption"); ?></div>
                                    <div class="yuzde70">
                                        <?php echo $user["taxation"] != NULL && $user["taxation"]==0 ? ___("needs/yes") : ___("needs/no"); ?>
                                    </div>
                                </div>

                                <?php if(Admin::isPrivilege(Config::get("privileges/INVOICES"))): ?>
                                    <div class="formcon" style="text-align:center;border: none;">
                                        <strong><a class="gonderbtn" href="<?php echo $links["add-bill"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-bill"); ?></a></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($privOperation): ?>
                                    <div class="formcon" style="text-align:center;border: none;"><strong><a class="gonderbtn remind_unpaid_bill_button" href="javascript:void(0);"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-remind-unpaid-bill"); ?></a></strong>
                                    </div>
                                <?php endif; ?>
                                <?php
                                    if(Admin::isPrivilege("USERS_MANAGE_CREDIT")){
                                        ?>
                                        <div class="formcon" style="text-align:center;border: none;"><strong><a class="gonderbtn" href="javascript:void(0);" id="manage_balance_button"><i class="fa fa-money" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-manage-balance"); ?></a></strong>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>



                            <div class="yuzde33">

                                <h5><strong><?php echo __("admin/users/detail-summary-orders"); ?></strong></h5>

                                <?php
                                    if(isset($statistics["orders"])){
                                        foreach($statistics["orders"] AS $row){
                                            ?>
                                            <div class="formcon">
                                                <div class="yuzde50"><strong><?php echo $row["name"]; ?></strong></div>
                                                <div class="yuzde50">
                                                    <?php echo $row["quantity"]; ?> (<strong><?php echo Money::formatter_symbol($row["amount"],Config::get("general/currency")); ?></strong>)
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>

                                <div class="formcon" style="text-align:center;color:#17b41d;font-size:14px;padding:10px 0px;">
                                    <?php echo __("admin/users/detail-summary-total-trade-volume"); ?>:  <strong><?php echo Money::formatter_symbol($statistics["total_trade_volume"],Config::get("general/currency")); ?></strong>
                                </div>

                                <?php if(Admin::isPrivilege(["ORDERS_OPERATION"])): ?>
                                    <div class="formcon" style="text-align:center;border: none;">
                                        <strong><a class="gonderbtn" href="<?php echo $links["add-order"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-order"); ?></a></strong>
                                    </div>
                                <?php endif; ?>

                            </div>


                            <?php if($privOperation): ?>
                                <div class="yuzde33">
                                    <h5><strong><?php echo __("admin/users/detail-summary-notes"); ?></strong></h5>
                                    <textarea style="font-size:13px;" name="notes" onchange="change_notes(this);" rows="10" placeholder="<?php echo __("admin/users/detail-summary-notes-info"); ?>"><?php echo $user["notes"]; ?></textarea>
                                </div>
                            <?php endif; ?>


                            <?php if($privOperation || Admin::isPrivilege(["TICKETS_OPERATION"])): ?>
                                <div class="yuzde33">
                                    <h5><strong><?php echo __("admin/users/detail-summary-other-operation"); ?></strong></h5>

                                    <?php if(Admin::isPrivilege(["TICKETS_OPERATION"])): ?>
                                        <div class="formcon" style="text-align:center;border: none;">
                                            <strong><a class="gonderbtn" href="<?php echo $links["add-ticket"]; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-ticket"); ?></a></strong>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($privOperation): ?>
                                        <?php if($user["status"] != "active"): ?>
                                            <div class="formcon" style="text-align:center;border: none;">
                                                <strong><a id="unblock_user_button" class="gonderbtn" href="javascript:void(0);"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-unblock-user"); ?></a></strong>
                                            </div>
                                        <?php else: ?>
                                            <div class="formcon" style="text-align:center;border: none;">
                                                <strong><a id="block_user_button" class="gonderbtn" href="javascript:void(0);"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-block-user"); ?></a></strong>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($user["suspend_all_of_services"]): ?>
                                            <div class="formcon" style="text-align:center;border: none;">
                                                <strong><a class="gonderbtn" href="javascript:void(0);" id="unsuspend_all_of_services_button"><i class="fa fa-power-off" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-unsuspend-all-of-services"); ?></a></strong>
                                            </div>
                                        <?php else: ?>
                                            <div class="formcon" style="text-align:center;border: none;">
                                                <strong><a class="gonderbtn" href="javascript:void(0);" id="suspend_all_of_services_button"><i class="fa fa-power-off" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-suspend-all-of-services"); ?></a></strong>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($privDelete): ?>
                                            <div class="formcon" style="text-align:center;border: none;">
                                                <strong><a class="red gonderbtn" href="javascript:void(0);" id="delete_everything_about_user_button"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-delete-everything-about-user"); ?></a></strong>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>



                                </div>
                            <?php endif; ?>

                            <?php if($privOperation): ?>
                                <div class="yuzde33">
                                    <h5><strong><?php echo __("admin/users/detail-summary-send-notification"); ?></strong></h5>

                                    <div class="formcon" style="text-align:center;border: none;">
                                        <strong><a class="gonderbtn" href="javascript:void(0);" id="reset_and_send_password_button"><i class="fa fa-shield" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-reset-and-send-password"); ?></a></strong>
                                    </div>
                                    <div class="formcon" style="text-align:center;border: none;">
                                        <strong><a  class="gonderbtn" href="javascript:void(0);" id="send_sms_button"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-send-sms"); ?></a></strong>
                                    </div>
                                    <div class="formcon" style="text-align:center;border: none;">
                                        <strong><a class="gonderbtn" href="javascript:void(0);" id="send_mail_button"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-send-mail"); ?></a></strong>
                                    </div>

                                </div>
                            <?php endif; ?>

                        </div>




                    </div>
                    <div class="clear"></div>
                </div>

                <div id="tab-informations" class="tabcontent">

                    <div class="adminpagecon">

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("input[name=kind][value='<?php echo $user["kind"]; ?>']").prop("checked",true).trigger("click");
                            });
                        </script>
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                            <input type="hidden" name="operation" value="edit_user">

                            <div class="clear"></div>

                            <div id="accordion" style="margin-top:15px;">

                                <!-- Profile Info -->
                                <h3><?php echo __("admin/users/detail-info-profile"); ?></h3>
                                <div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-ac-type"); ?></div>
                                        <div class="yuzde70">
                                            <input onclick="$('.ac-type-wrap').not('.individual-wrap').css('display','none'),$('.individual-wrap').css('display','block');" id="kind-individual" class="radio-custom" name="kind" value="individual" type="radio">
                                            <label for="kind-individual" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-individual"); ?></span></label>
                                            <input id="kind-corporate" onclick="$('.ac-type-wrap').not('.corporate-wrap').css('display','none'),$('.corporate-wrap').css('display','block');" class="radio-custom" name="kind" value="corporate" type="radio">
                                            <label for="kind-corporate" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-corporate"); ?></span></label>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-name"); ?></div>
                                        <div class="yuzde70">
                                            <input name="full_name" type="text" value="<?php echo $user["full_name"]; ?>">
                                        </div>
                                    </div>

                                    <?php if($user["country"] == 227 && Config::get("general/country") == "tr"): ?>
                                        <div class="formcon">
                                            <div class="yuzde30">T.C Kimlik No</div>
                                            <div class="yuzde70">
                                                <input name="identity" type="text" value="<?php echo $user["identity"]; ?>" maxlength="11" class="width200" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-birthday"); ?></div>
                                        <div class="yuzde70">
                                            <input type="date" name="birthday" value="<?php echo $user["birthday"];?>" class="width200">
                                        </div>
                                    </div>


                                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                        <div class="yuzde30"><?php echo __("admin/users/create-company-name"); ?></div>
                                        <div class="yuzde70">
                                            <input name="company_name" type="text" value="<?php echo $user["company_name"]; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                        <div class="yuzde30"><?php echo __("admin/users/create-company-tax-number"); ?></div>
                                        <div class="yuzde70">
                                            <input name="company_tax_number" type="text" value="<?php echo $user["company_tax_number"]; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                        <div class="yuzde30"><?php echo __("admin/users/create-company-tax-office"); ?></div>
                                        <div class="yuzde70">
                                            <input name="company_tax_office" type="text" value="<?php echo $user["company_tax_office"]; ?>">
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-email"); ?></div>
                                        <div class="yuzde70">
                                            <input name="email" type="email" value="<?php echo $user["email"]; ?>" required="required">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-phone"); ?></div>
                                        <div class="yuzde70">
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    var telInput = $("#gsm");
                                                    telInput.intlTelInput({
                                                        geoIpLookup: function(callback) {
                                                            callback('<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>');
                                                        },
                                                        autoPlaceholder: "on",
                                                        formatOnDisplay: true,
                                                        initialCountry: "auto",
                                                        hiddenInput: "gsm",
                                                        nationalMode: false,
                                                        placeholderNumberType: "MOBILE",
                                                        preferredCountries: ['us', 'gb', 'ch', 'ca', 'de', 'it'],
                                                        separateDialCode: true,
                                                        utilsScript: "<?php echo $sadress;?>assets/plugins/phone-cc/js/utils.js"
                                                    });
                                                });
                                            </script>
                                            <input  id="gsm" type="text" value="<?php echo $user["phone"] ? '+'.$user["phone"] : ''; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-landline-phone"); ?></div>
                                        <div class="yuzde70">
                                            <input name="landline_phone" type="text" value="<?php echo $user["landline_phone"]; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-notification-permissions"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["email_notifications"] ? ' checked' : ''; ?> id="email_notifications" class="checkbox-custom" name="email_notifications" value="1" type="checkbox">
                                            <label for="email_notifications" class="checkbox-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-notification-email"); ?></span></label>
                                            <input<?php echo $user["sms_notifications"] ? ' checked' : ''; ?> id="sms_notifications" class="checkbox-custom" name="sms_notifications" value="1" type="checkbox">
                                            <label for="sms_notifications" class="checkbox-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-notification-sms"); ?></span></label>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-ac-status"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["status"]=="active" ? ' checked' : ''; ?> id="status_active" class="radio-custom" name="status" value="active" type="radio">
                                            <label for="status_active" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/active"); ?></span></label>
                                            <input<?php echo $user["status"]=="inactive" ? ' checked' : ''; ?> id="status_inactive" class="radio-custom" name="status" value="inactive" type="radio">
                                            <label for="status_inactive" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/inactive"); ?></span></label>

                                            <input<?php echo $user["status"]=="blocked" ? ' checked' : ''; ?> id="status_blocked" class="radio-custom" name="status" value="blocked" type="radio">
                                            <label for="status_blocked" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/blocked"); ?></span></label>
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-group"); ?></div>
                                        <div class="yuzde70">
                                            <select name="group_id" style="width:101%;">
                                                <option value=""><?php echo ___("needs/select-your"); ?></option>
                                                <?php
                                                    if(isset($groups) && $groups){
                                                        foreach($groups AS $group){
                                                            ?>
                                                            <option<?php echo $user["group_id"] == $group["id"] ? ' selected' : ''; ?> value="<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-language"); ?></div>
                                        <div class="yuzde70">
                                            <select name="lang" style="width:101%;">

                                                <?php
                                                    foreach($lang_list AS $row){
                                                        ?>
                                                        <option<?php echo $user["lang"] == $row["key"] ? ' selected' : '';?> value="<?php echo $row["key"];?>"><?php echo $row["cname"]." (".$row["name"].")"; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-currency"); ?></div>
                                        <div class="yuzde70">
                                            <select name="currency" style="width:101%;">
                                                <?php
                                                    foreach(Money::getCurrencies() AS $row){
                                                        ?>
                                                        <option<?php echo $user["currency"] == $row["id"] ? ' selected' : '';?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-tax-exemption"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["taxation"] != NULL && $user["taxation"]==0 ? ' checked' : '';?> id="taxation" name="taxation" value="1" type="checkbox" class="sitemio-checkbox">
                                            <label for="taxation" class="sitemio-checkbox-label"></label>
                                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-tax-examption-info"); ?>)</span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-never-suspend"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["never_suspend"] ? ' checked' : ''; ?> id="never_suspend" name="never_suspend" value="1" type="checkbox" class="checkbox-custom">
                                            <label for="never_suspend" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/users/create-never-suspend-info"); ?></span></label>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-never-cancel"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["never_cancel"] ? ' checked' : ''; ?> id="never_cancel" name="never_cancel" value="1" type="checkbox" class="checkbox-custom">
                                            <label for="never_cancel" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/users/create-never-cancel-info"); ?></span></label>
                                        </div>
                                    </div>



                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-cdate"); ?></div>
                                        <div class="yuzde70">
                                            <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$user["creation_time"]); ?>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-ldate"); ?></div>
                                        <div class="yuzde70">
                                            <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$user["last_login_time"]); ?>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-lip"); ?></div>
                                        <div class="yuzde70">
                                            <u><a referrerpolicy="no-referrer" href="https://geoiptool.com/en/?IP=<?php echo $user["ip"]; ?>" target="_blank"><?php echo $user["ip"]; ?></a></u> <a style="margin-left:15px;" class="lbtn" href="javascript:void(0);open_modal('login-logs',{width:'1024px'});"><?php echo __("admin/users/detail-info-login-log"); ?></a>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-password"); ?></div>
                                        <div class="yuzde70">
                                            <input name="password" type="text" value="" placeholder="" style="width:170px;">
                                            <a class="lbtn " href="javascript:void 0;" onclick="$('#password_primary').attr('type','text'); $('input[name=password]').val(voucher_codes.generate({length:16,charset: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*()-_=+[]\|;:,./?'})).trigger('change');"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/new-random-password"); ?></a>

                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    $("input[name=password]").bind('paste keypress keyup keydown change',function(){
                                                        var pw1 = $("input[name=password]").val();

                                                        var level = checkStrength(pw1);

                                                        $('.level-block').css("display","none");
                                                        $("#"+level).css("display","block");
                                                    });
                                                });
                                            </script>
                                            <div id="password_strength">
                                                <div id="weak" style="display:none;" class="level-block"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level1"); ?></strong></div>
                                                <div id="good" class="level-block" style="display:none"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level2"); ?></strong></div>
                                                <div id="strong" class="level-block" style="display: none;"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level3"); ?></strong></div>
                                            </div>
                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/users/detail-info-password-info"); ?></span>
                                        </div>
                                    </div>


                                </div>
                                <!-- Profile Info -->

                                <!-- Security -->
                                <h3><?php echo __("admin/users/detail-info-security"); ?></h3>
                                <div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-force-document-verification"); ?></div>
                                        <div class="yuzde70">
                                            <select name="force-document-verification-filters[]" multiple class="select2" style="width:100%;">
                                                <?php
                                                    $f_d_v_fs = $user["force-document-verification-filters"];
                                                    if($f_d_v_fs) $f_d_v_fs = explode(",",$f_d_v_fs);
                                                    else $f_d_v_fs = [];

                                                    if(isset($document_verification_filters) && $document_verification_filters){
                                                        foreach($document_verification_filters AS $row){
                                                            ?>
                                                            <option<?php echo in_array($row["id"],$f_d_v_fs) ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                        if(Config::get("options/blacklist/status") && $user["blacklist"] != 2){
                                            ?>
                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/users/detail-info-add-blacklist"); ?></div>
                                                <div class="yuzde70">
                                                    <?php
                                                        if($user["blacklist"]){
                                                            ?>
                                                            <a class="lbtn red" href="javascript:void 0;" onclick="remove_blacklist(this);"><?php echo __("admin/users/blacklist-remove-btn"); ?></a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <a class="lbtn" href="javascript:void 0;" onclick="add_blacklist();"><i class="fa fa-ban"></i> <?php echo __("admin/users/blacklist-add-btn"); ?></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-block-proxy-usage"); ?></div>
                                        <div class="yuzde70">
                                            <?php
                                                $b_p_u = $user["block-proxy-usage"];
                                            ?>
                                            <input<?php echo $b_p_u ? ' checked' : ''; ?> type="checkbox" name="block-proxy-usage" value="1" class="sitemio-checkbox" id="block-proxy-usage">
                                            <label class="sitemio-checkbox-label" for="block-proxy-usage"></label>
                                        </div>
                                    </div>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/exempt-proxy-check"); ?></div>
                                        <div class="yuzde70">
                                            <?php
                                                $e_p_c = $user["exempt-proxy-check"];
                                            ?>
                                            <input<?php echo $e_p_c ? ' checked' : ''; ?> type="checkbox" name="exempt-proxy-check" value="1" class="sitemio-checkbox" id="exempt-proxy-check">
                                            <label class="sitemio-checkbox-label" for="exempt-proxy-check"></label>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/detail-info-block-payment-gateways"); ?></div>
                                        <div class="yuzde70">
                                            <select name="block-payment-gateways[]" multiple class="select2" style="width: 100%;">
                                                <?php
                                                    $b_p_g = $user["block-payment-gateways"];
                                                    if($b_p_g) $b_p_g = explode(",",$b_p_g);
                                                    else $b_p_g = [];

                                                    if(isset($payment_gateways)){
                                                        foreach($payment_gateways AS $k=>$row){
                                                            ?>
                                                            <option<?php echo in_array($k,$b_p_g) ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $row; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="formcon"<?php echo Config::get("general/country") != "tr" ? ' style="display:none;"' : NULL; ?>>
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-identity-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_identity_required" name="sign_up_identity_required" value="1"<?php echo $user["identity_required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_identity_required"><?php echo __("admin/settings/sign-up-identity-required"); ?></label>

                                            <br>


                                            <input onclick="if($(this).prop('checked')) $('#sign_birthday_required').prop('checked',true);" type="checkbox" class="checkbox-custom" id="sign_up_identity_checker" name="sign_up_identity_checker" value="1"<?php echo $user["identity_checker"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_identity_checker"><?php echo __("admin/settings/sign-up-identity-checker"); ?></label>

                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-birthday-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_birthday_required" name="sign_birthday_required" value="1"<?php echo $user["birthday_required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_birthday_required"><?php echo __("admin/settings/sign-birthday-required"); ?></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_birthday_adult_verify" name="sign_birthday_adult_verify" value="1"<?php echo $user["birthday_adult_verify"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_birthday_adult_verify"><?php echo __("admin/settings/sign-birthday-adult-verify"); ?></label>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-restricted"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["ticket_restricted"] ? ' checked' : '';?> id="ticket_restricted" name="ticket_restricted" value="1" type="checkbox" class="sitemio-checkbox">
                                            <label for="ticket_restricted" class="sitemio-checkbox-label"></label>
                                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-restricted-info"); ?>)</span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-blocked"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $user["ticket_blocked"] ? ' checked' : '';?> id="ticket_blocked" name="ticket_blocked" value="1" type="checkbox" class="sitemio-checkbox">
                                            <label for="ticket_blocked" class="sitemio-checkbox-label"></label>
                                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-blocked-info"); ?>)</span>
                                        </div>
                                    </div>

                                    <?php
                                        if(Config::get("options/sign/security-question/status")){
                                            ?>
                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("website/account/field-security_question"); ?></div>
                                                <div class="yuzde70">
                                                    <input type="text" name="security_question" value="<?php echo $user["security_question"]; ?>">
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("website/account/field-security_question_answer"); ?></div>
                                                <div class="yuzde70">
                                                    <input type="text" name="security_question_answer" value="<?php echo $user["security_question_answer"]; ?>">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <!-- Security -->

                                <!-- Custom Fields -->
                                <h3><?php echo __("admin/users/detail-info-custom-fields"); ?></h3>
                                <div>

                                    <?php
                                        if(isset($cfields) && $cfields){
                                            foreach($cfields AS $field){
                                                ?>
                                                <div class="formcon" id="cfield_<?php echo $field["id"]; ?>_wrap">
                                                    <div class="yuzde30"><?php echo $field["name"]; ?></div>
                                                    <div class="yuzde70">
                                                        <?php
                                                            $value = $user["field_".$field["id"]];
                                                            if($field["type"] == "text"){
                                                                ?>
                                                                <input id="cfield_<?php echo $field["id"]; ?>" type="text" name="cfields[<?php echo $field["id"]; ?>]" value="<?php echo $value; ?>">
                                                                <?php
                                                            }elseif($field["type"] == "textarea"){
                                                                ?>
                                                                <textarea rows="3" id="cfield_<?php echo $field["id"]; ?>" name="cfields[<?php echo $field["id"]; ?>]"><?php echo $value; ?></textarea>
                                                                <?php
                                                            }elseif($field["type"] == "select"){
                                                                ?>
                                                                <select id="cfield_<?php echo $field["id"]; ?>" class="accountinputs" name="cfields[<?php echo $field["id"]; ?>]">
                                                                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                                                                    <?php
                                                                        $parse = explode(",",$field["options"]);
                                                                        foreach($parse AS $p){
                                                                            $selected = $value == $p ? " selected" : NULL;
                                                                            ?>
                                                                            <option<?php echo $selected; ?>><?php echo  $p; ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <?php
                                                            }elseif($field["type"] == "radio"){
                                                                $parse = explode(",",$field["options"]);
                                                                foreach($parse AS $k=>$p){
                                                                    $checked = $value == $p ? " checked" : NULL;
                                                                    ?>
                                                                    <input<?php echo $checked; ?>
                                                                            name="cfields[<?php echo $field["id"]; ?>]"
                                                                            value="<?php echo $p; ?>"
                                                                            class="radio-custom"
                                                                            id="cfield_<?php echo $field["id"] . "_" . $k; ?>"
                                                                            type="radio">
                                                                    <label style="margin-right:15px;"
                                                                           for="cfield_<?php echo $field["id"] . "_" . $k; ?>"
                                                                           class="radio-custom-label"><?php echo $p; ?></label>
                                                                    <?php
                                                                }
                                                            }elseif($field["type"] == "checkbox"){
                                                                $parsev = explode(",",$value);
                                                                $parse  = explode(",",$field["options"]);
                                                                foreach($parse AS $k=>$p){
                                                                    $checked = array_search($p,$parsev) ? " checked" : NULL;
                                                                    ?>
                                                                    <input<?php echo $disabled.$checked;?> name="cfields[<?php echo $field["id"]; ?>][]" value="<?php echo $p;?>" class="checkbox-custom" id="cfield_<?php echo $field["id"]."_".$k; ?>" type="checkbox">
                                                                    <label style="margin-right:15px;" for="cfield_<?php echo $field["id"]."_".$k; ?>" class="checkbox-custom-label"><?php echo $p; ?></label>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>

                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>

                                </div>
                                <!-- Custom Fields -->

                                <?php
                                    if(isset($c_s_m) && $c_s_m && $c_s_m != "none")
                                    {
                                        ?>
                                        <h3><?php echo __("website/account_info/stored-cards-1"); ?></h3>
                                        <div>
                                            <?php
                                                if(isset($stored_cards) && $stored_cards)
                                                {
                                                    ?>
                                                    <script type="text/javascript">
                                                        let waiting_text = '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;" aria-hidden="true"></i>'
                                                        $(document).ready(function(){
                                                            $(".card_as_default_btn").click(function(){
                                                                let
                                                                    btn = $(this),
                                                                    request = MioAjax({
                                                                        button_element  : btn,
                                                                        waiting_text    : waiting_text,
                                                                        action          : "<?php echo $links["controller"]; ?>",
                                                                        method          : "POST",
                                                                        data            : {
                                                                            operation:"stored_card_as_default",
                                                                            id:btn.data("id")
                                                                        }
                                                                    },true,true);
                                                                request.done(function(result){
                                                                    if(result != ''){
                                                                        let solve = getJson(result);
                                                                        if(solve !== false){
                                                                            if(solve.status == "error")
                                                                                alert_error(solve.message,{timer:5000});
                                                                            else if(solve.status === "successful")
                                                                            {
                                                                                $(".creditcardbox").removeAttr("id");
                                                                                $(".card_as_default_btn").css("display","block");
                                                                                $(".creditcardbox .defaultcardtitle").css("display","none");
                                                                                $(".creditcardbox[data-id="+btn.data("id")+"]").attr("id","default");
                                                                                $(".creditcardbox[data-id="+btn.data("id")+"] .defaultcardtitle").css("display","block");
                                                                                $(".creditcardbox[data-id="+btn.data("id")+"] .card_as_default_btn").css("display","none");
                                                                            }
                                                                        }else
                                                                            console.log(result);
                                                                    }
                                                                });
                                                            });

                                                            $(".card_remove_btn").click(function(){

                                                                if(!confirm("<?php echo ___("needs/delete-are-you-sure"); ?>"))
                                                                    return false;

                                                                let
                                                                    btn = $(this),
                                                                    request = MioAjax({
                                                                        button_element  : btn,
                                                                        waiting_text    : waiting_text,
                                                                        action          : "<?php echo $links["controller"]; ?>",
                                                                        method          : "POST",
                                                                        data            : {
                                                                            operation:"stored_card_remove",
                                                                            id:btn.data("id")
                                                                        }
                                                                    },true,true);
                                                                request.done(function(result){
                                                                    if(result != ''){
                                                                        let solve = getJson(result);
                                                                        if(solve !== false){
                                                                            if(solve.status == "error")
                                                                                alert_error(solve.message,{timer:5000});
                                                                            else if(solve.status === "successful")
                                                                                window.location.href = '<?php echo $links["controller"]; ?>?tab=informations';
                                                                        }else
                                                                            console.log(result);
                                                                    }
                                                                });
                                                            });

                                                        });
                                                    </script>
                                                    <div class="creditcardbox-list">

                                                        <?php
                                                            foreach($stored_cards AS $sc)
                                                            {
                                                                $as_default     = $sc["as_default"] == 1;
                                                                $bank_logo      = PaymentGatewayModule::find_bank_logo($sc["bank_name"],$sc["card_brand"],$sc["card_type"]);

                                                                ?>
                                                                <div data-id="<?php echo $sc["id"]; ?>" class="creditcardbox"<?php if($as_default){ ?> id="default" title="<?php echo __("website/account_info/stored-cards-4"); ?>"<?php } ?>>
                                                                    <div style="<?php echo !$as_default ? 'display:none;' : ''; ?>" class="defaultcardtitle"><?php echo __("website/account_info/stored-cards-5"); ?></div>
                                                                    <a class="deletecard tooltip-right card_remove_btn" href="javascript:void 0;" data-id="<?php echo $sc["id"]; ?>" title="<?php echo __("website/account_info/stored-cards-7"); ?>" alt="<?php echo __("website/account_info/stored-cards-7"); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                                    <div class="creditcardbox-con">
                                                                        <?php
                                                                            if($bank_logo)
                                                                            {
                                                                                ?>
                                                                                <img class="banklogo" src="<?php echo $bank_logo; ?>" alt="">
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <div class="banknologo"><?php echo $sc["bank_name"]; ?></div>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        <img class="visamaster" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/<?php echo strtolower($sc["card_schema"]); ?>.png" alt="<?php echo $sc["card_schema"]; ?>">
                                                                        <img class="cardchip" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/chipicon.png" alt="">
                                                                        <div class="creditcardbox-numbers"><h5>****</h5><h5>****</h5><h5>****</h5><h5><?php echo $sc["ln4"]; ?></h5></div>
                                                                        <div class="creditcardbox-validdate"><?php echo $sc["expiry_month"]; ?>/<?php echo $sc["expiry_year"]; ?></div>
                                                                        <div class="creditcardbox-fullname"><?php echo $sc["name"]; ?></div>
                                                                        <div class="clear"></div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>
                                                        <div class="line"></div>

                                                        <div class="clear"></div>
                                                    </div>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                    <div class="creditcardbox-list">
                                                        <h4><?php echo __("website/account_info/stored-cards-3"); ?></h4>
                                                    </div>
                                                    <?php
                                                }
                                            ?>


                                        </div>

                                        <?php
                                    }
                                ?>


                                <h3><?php echo __("admin/users/detail-info-addresses"); ?></h3>
                                <div>

                                    <?php if($privOperation): ?>
                                        <a href="javascript:void(0);addAddress();" class="green lbtn">+ <?php echo __("admin/users/detail-info-add-address"); ?></a>
                                        <div class="clear"></div>
                                        <br>
                                    <?php endif; ?>

                                    <div id="AddressList">
                                        <?php
                                            if(isset($acAddresses) && $acAddresses){
                                                foreach($acAddresses AS $addr){
                                                    ?>
                                                    <div class="adresbilgisi" id="address_<?php echo $addr["id"];?>">
                                                        <input type="hidden" name="country_id" value="<?php echo $addr["country_id"]; ?>">
                                                        <input type="hidden" name="detouse" value="<?php echo $addr["detouse"] ? 1 : 0; ?>">
                                                        <input type="hidden" name="zipcode" value="<?php echo $addr["zipcode"]; ?>">
                                                        <input type="hidden" name="city" value="<?php echo $addr["city"]; ?>">
                                                        <input type="hidden" name="counti" value="<?php echo $addr["counti"]; ?>">
                                                        <input type="hidden" name="address" value="<?php echo htmlentities($addr["address"],ENT_QUOTES); ?>">
                                                        <div class="yuzde90">
                                                            - <?php echo $addr["name"]; ?>
                                                            <?php if($addr["detouse"]): ?>
                                                                <strong>(<?php echo __("admin/users/detail-info-default-address"); ?>)</strong>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if($privOperation): ?>
                                                            <div class="yuzde10" style="float:right;">
                                                                <a href="javascript:void(0);editAddress(<?php echo $addr["id"]; ?>);" style="margin-left:5px;" title="<?php echo __("admin/users/button-edit") ?>" class="sbtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                <a href="javascript:void(0);deleteAddress(<?php echo $addr["id"]; ?>);" style="margin-left:5px;" title="<?php echo __("admin/users/button-delete") ?>" class="red sbtn"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="error" id="empty_content" style="<?php echo isset($acAddresses) && $acAddresses ? 'display: none;' : ''; ?>"><?php echo __("admin/users/detail-info-address-none"); ?></div>
                                    <script type="text/javascript">
                                        function deleteAddress(id){
                                            if(confirm('<?php echo htmlspecialchars(__("admin/users/delete-are-you-sure"),ENT_QUOTES); ?>')){
                                                $("#address_"+id).animate({opacity: 4}, 300);

                                                var request = MioAjax({
                                                    action:"<?php echo $links["controller"]; ?>",
                                                    method:"POST",
                                                    data:{
                                                        operation:"delete_address",
                                                        id:id,
                                                    }
                                                },true,true);

                                                request.done(function(result){
                                                    if(result != ''){
                                                        var solve = getJson(result);
                                                        if(solve !== false){
                                                            if(solve.status == "error"){
                                                                alert_error(solve.message,{timer:3000});
                                                            }else if(solve.status == "successful"){
                                                                $("#address_"+id).animate({backgroundColor:'#4E1402',opacity:0}, 500,function () {
                                                                    $("#address_"+id).remove();
                                                                    if(solve.total<1){
                                                                        $("#empty_content").slideDown(300);
                                                                    }
                                                                });
                                                            }
                                                        }else
                                                            console.log(result);
                                                    }
                                                });
                                            }
                                        }
                                    </script>
                                </div>

                            </div>


                            <div class="clear"></div>

                            <?php if($privOperation): ?>
                                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-update"); ?></a>
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>


                        </form>
                        <script type="text/javascript">
                            $(document).ready(function(){

                                $("#editForm_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        result:"editForm_handler",
                                    });
                                });

                            });

                            function editForm_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#editForm "+solve.for).focus();
                                                $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#editForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
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

                    <div class="clear"></div>
                </div>

                <?php if(Admin::isPrivilege(["USERS_DEALERSHIP"]) && Config::get("options/dealership/status")): ?>
                    <div id="tab-dealership" class="tabcontent">

                        <div class="adminpagecon">
                            <form action="<?php echo $links["controller"]; ?>" method="post" id="dp_editForm">
                                <input type="hidden" name="operation" value="edit_user_dp">

                                <div class="formcon">
                                    <?php
                                        $dp        = $user["dealership"];
                                        $dp_status = isset($dp["status"]) ? $dp["status"] : false;
                                    ?>
                                    <div class="yuzde30"><?php echo __("admin/users/detail-info-dealership-status"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo $dp_status == "active" ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="dp_status" name="dp_status" value="1">
                                        <label for="dp_status" class="sitemio-checkbox-label"></label>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div id="bigmobil" class="yuzde30"><?php echo __("admin/users/detail-info-dealership-credit-obligation"); ?><br>
                                        <span class="kinfo" style="font-weight:normal;"><?php echo __("admin/users/detail-info-dealership-credit-obligation-info"); ?></span></div>

                                    <div id="bigmobil" class="yuzde70">

                                        <div class="formcon">
                                            <?php
                                                $require_min_credit_amount  = isset($dp["require_min_credit_amount"]) && $dp["require_min_credit_amount"] ? Money::formatter($dp["require_min_credit_amount"],$dp["require_min_credit_cid"]) : '';
                                                $require_min_credit_cid  = isset($dp["require_min_credit_cid"]) ? $dp["require_min_credit_cid"] : 0;
                                                $input  = '<input style="width:80px;" name="dp_require_min_credit_amount" type="text" placeholder="'.___("needs/example1").':750" value="'.$require_min_credit_amount.'">';
                                                $input .= '<select name="dp_require_min_credit_cid" style="width:200px;">';
                                                foreach(Money::getCurrencies() AS $row){
                                                    $checked = $require_min_credit_cid == $row["id"] ? ' selected' : '';
                                                    $input .= '<option'.$checked.' value="'.$row["id"].'">'.$row["name"].' ('.$row["code"].')</option>';
                                                }
                                                $input .= '</select>';

                                                echo __("admin/users/detail-info-dp-cdt-oblign-min-credit",['{input}' => $input]);
                                            ?>
                                        </div>
                                        <div class="formcon">

                                            <?php
                                                $require_min_discount_amount  = isset($dp["require_min_discount_amount"]) && $dp["require_min_discount_amount"] ? Money::formatter($dp["require_min_discount_amount"],$dp["require_min_discount_cid"]) : '';
                                                $require_min_discount_cid  = isset($dp["require_min_discount_cid"]) ? $dp["require_min_discount_cid"] : 0;
                                                $input  = '<input style="width:80px;" name="dp_require_min_discount_amount" type="text" placeholder="'.___("needs/example1").':100" value="'.$require_min_discount_amount.'">';
                                                $input .= '<select name="dp_require_min_discount_cid" style="width:200px;">';
                                                foreach(Money::getCurrencies() AS $row){
                                                    $checked = $require_min_discount_cid == $row["id"] ? ' selected' : '';
                                                    $input .= '<option'.$checked.' value="'.$row["id"].'">'.$row["name"].' ('.$row["code"].')</option>';
                                                }
                                                $input .= '</select>';

                                                echo __("admin/users/detail-info-dp-cdt-oblign-min-discount",['{input}' => $input]);
                                            ?>
                                        </div>
                                        <div class="formcon">
                                            <input<?php echo !isset($dp["only_credit_paid"]) ? ' checked' : ''; ?> name="only_credit_paid" type="radio" class="radio-custom" id="only_credit_paid_default">
                                            <label class="radio-custom-label" for="only_credit_paid_default" style="margin-right: 10px;"><?php echo ___("needs/default"); ?></label>

                                            <input<?php echo isset($dp["only_credit_paid"]) && $dp["only_credit_paid"] ? ' checked' : ''; ?> name="only_credit_paid" type="radio" class="radio-custom" id="only_credit_paid_yes" value="1">
                                            <label class="radio-custom-label" for="only_credit_paid_yes" style="margin-right: 10px;"><?php echo ___("needs/yes"); ?></label>

                                            <input<?php echo isset($dp["only_credit_paid"]) && !$dp["only_credit_paid"] ? ' checked' : ''; ?> name="only_credit_paid" type="radio" class="radio-custom" id="only_credit_paid_no" value="0">
                                            <label class="radio-custom-label" for="only_credit_paid_no" style="margin-right: 10px;"><?php echo ___("needs/no"); ?></label>

                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/users/detail-info-dp-only-credit-paid"); ?></span>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/users/detail-info-dp-discounts"); ?><br><span class="kinfo" style="font-weight:normal;"><?php echo __("admin/users/detail-info-dp-discounts-info"); ?></span></div>
                                    <div class="clearmob"></div>
                                    <div id="resellerproductlist" class="yuzde70">

                                        <script type="text/javascript">
                                            $(document).ready(function(){

                                                $("#selectProductItem").change(function(){
                                                    var selected = $(this).val();

                                                    if(selected === '')
                                                    {
                                                        $(".resellerdiscounts").css("display","none");
                                                        return false;
                                                    }
                                                    else
                                                    {
                                                        $(".resellerdiscounts").css("display","table");
                                                    }

                                                    $(".tbody-rates").css("display","none");
                                                    $("tbody[data-key='"+selected+"']").css("display","table-row-group");

                                                    if($("tbody[data-key='"+selected+"'] tr").length < 1) add_new_rate();
                                                });
                                            });
                                            function add_new_rate(){
                                                var selected    = $("#selectProductItem").val();
                                                var template    = $("#template-rate-item").html();
                                                template = template.replace(/\[x\]/g,"["+selected+"]");
                                                $("tbody[data-key='"+selected+"']").append(template);
                                            }
                                        </script>
                                        <?php
                                            $items  = [
                                                'default' => isset($dp['discounts']["default"]) ? $dp['discounts']["default"] : [],
                                            ];
                                        ?>
                                        <select id="selectProductItem">
                                            <option value=""><?php echo __("admin/users/dealership-default"); ?></option>
                                            <option value="default"><?php echo __("admin/users/dealership-allOf"); ?></option>
                                            <?php
                                                if(isset($products) && $products)
                                                {
                                                    foreach($products AS $g_k => $g)
                                                    {
                                                        $gk             = '';
                                                        $gk_split       = explode("-",$g_k);
                                                        $gk_0           = isset($gk_split[0]) ? $gk_split[0] : '';
                                                        $gk_1           = isset($gk_split[1]) ? $gk_split[1] : '';

                                                        if(Validation::isInt($gk_0) && $gk_1 == 0)
                                                            $gk = "special/".$gk_0;
                                                        elseif(Validation::isInt($gk_0))
                                                            $gk = "special/".$gk_1;
                                                        elseif($gk_1 == 0)
                                                            $gk = $gk_0;
                                                        else
                                                            $gk = $gk_0."/".$gk_1;
                                                        if(!isset($items[$gk])) $items[$gk] = isset($dp['discounts'][$gk]) ? $dp['discounts'][$gk] : [];
                                                        ?>
                                                        <option style="font-weight: bold;" value="<?php echo $gk; ?>"><?php echo $g['name']; ?></option>
                                                        <?php

                                                        $_products      = $g["products"];

                                                        if($_products)
                                                        {
                                                            foreach($_products AS $_p)
                                                            {
                                                                $pk         = $_p['type']."-".$_p["id"];
                                                                if(!isset($items[$pk])) $items[$pk] = isset($dp['discounts'][$pk]) ? $dp['discounts'][$pk] : [];
                                                                ?>
                                                                <option value="<?php echo $pk; ?>">&nbsp;&nbsp;<?php echo $_p["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <table class="resellerdiscounts" width="100%" border="0" cellpadding="0" cellspacing="0" style="display: none;">
                                            <thead>
                                            <tr>
                                                <th colspan="3" bgcolor="#eee"><?php echo __("admin/users/dealership-order-quantity"); ?></th>
                                                <th bgcolor="#eee"> </th>
                                                <th bgcolor="#eee"><?php echo __("admin/users/dealership-discount-rate"); ?></th>
                                                <th bgcolor="#eee"></th>
                                            </tr>
                                            </thead>
                                            <?php
                                                $i=0;
                                                foreach($items AS $k=>$rates)
                                                {
                                                    $i++;
                                                    ?>
                                                    <tbody class="tbody-rates" data-key="<?php echo $k; ?>" style="display:none">
                                                    <?php
                                                        if($rates && is_array($rates))
                                                        {
                                                            foreach($rates AS $row)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td align="center">
                                                                        <input type="text" name="dp_discounts[<?php echo $k; ?>][from][]" value="<?php echo $row["from"]; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                                                    </td>
                                                                    <td align="center">
                                                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                                    </td>
                                                                    <td align="center">
                                                                        <input type="text" name="dp_discounts[<?php echo $k; ?>][to][]" value="<?php echo $row["to"]; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                                                    </td>
                                                                    <td align="center">
                                                                        <?php echo __("admin/users/dealership-discount-between"); ?>
                                                                    </td>
                                                                    <td align="center">
                                                                        <input type="text" name="dp_discounts[<?php echo $k; ?>][rate][]" value="<?php echo $row["rate"]; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                                                                    </td>
                                                                    <td align="center">
                                                                        <a class="sbtn red" onclick="$(this).parent().parent().remove();">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    </tbody>
                                                    <?php
                                                }
                                            ?>
                                            <tbody>
                                            <tr>
                                                <td colspan="6"><a class="sbtn" onclick="add_new_rate();"><i class="fa fa-plus"></i></a></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                                <?php if($privOperation): ?>
                                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                        <a class="yesilbtn gonderbtn" id="dp_editForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-update"); ?></a>
                                    </div>
                                    <div class="clear"></div>
                                <?php endif; ?>

                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){

                                    $("#dp_editForm_submit").on("click",function(){
                                        MioAjaxElement($(this),{
                                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                            result:"dp_editForm_handler",
                                        });
                                    });
                                });

                                function dp_editForm_handler(result){
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#dp_editForm "+solve.for).focus();
                                                    $("#dp_editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#dp_editForm "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    alert_error(solve.message,{timer:5000});
                                            }else if(solve.status == "successful"){
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
                <?php endif; ?>

                <?php if(Admin::isPrivilege(["USERS_AFFILIATE"]) && Config::get("options/affiliate/status")): ?>
                    <div id="tab-affiliate" class="tabcontent">
                        <?php
                            if($aff)
                            {
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        var xtab = _GET("affiliate");
                                        if (xtab !== '' && xtab !== undefined && xtab !== null){
                                            $("#tab-affiliate .tablinks[data-tab='" + xtab + "']").click();
                                        } else {
                                            $("#tab-affiliate .tablinks:eq(0)").addClass("active");
                                            $("#tab-affiliate .tabcontent:eq(0)").css("display", "block");
                                        }

                                        $('#table_transactions,#table_hits').DataTable({
                                            "columnDefs": [
                                                {
                                                    "targets": [0],
                                                    "visible":false,
                                                    "searchable": false
                                                }
                                            ],
                                            "lengthMenu": [
                                                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                            ],
                                            responsive: true,
                                            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                                        });

                                        table2 = $('#withdrawals').DataTable({
                                            "columnDefs": [
                                                {
                                                    "targets": [0],
                                                    "visible":false,
                                                    "searchable": false
                                                }
                                            ],
                                            "lengthMenu": [
                                                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                            ],
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": "<?php echo $links["ajax-withdrawals"]; ?>",
                                            responsive: true,
                                            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                                        });

                                        $("#updateAffiliateForm_submit").on("click",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                result:"updateAffiliateForm_handler",
                                            });
                                        });

                                        $("#detail_withdrawal_modal").on("click","#updateWithdrawalForm_submit",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                result:"updateWithdrawalForm_handler",
                                            });
                                        });

                                    });

                                    function updateWithdrawalForm_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.for != undefined && solve.for != ''){
                                                        $("#updateWithdrawalForm "+solve.for).focus();
                                                        $("#updateWithdrawalForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                        $("#updateWithdrawalForm "+solve.for).change(function(){
                                                            $(this).removeAttr("style");
                                                        });
                                                    }
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    alert_success(solve.message,{timer:2000});
                                                    if(solve.redirect != undefined && solve.redirect != ''){
                                                        setTimeout(function(){
                                                            window.location.href = solve.redirect;
                                                        },2000);
                                                    }
                                                    table2.ajax.reload();
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }

                                    function detail_withdrawal(id){
                                        var affiliate           = $("#withdrawal_"+id+" .wl-affiliate").html();
                                        var ctime               = $("#withdrawal_"+id+" .wl-ctime").html();
                                        var gateway             = $("#withdrawal_"+id+" .wl-gateway").html();
                                        var gateway_info        = $("#withdrawal_"+id+" .wl-gateway-info").html();
                                        var amount              = $("#withdrawal_"+id+" .wl-amount").html();
                                        var status              = $("#withdrawal_"+id+" .wl-status").html();
                                        var status_msg          = $("#withdrawal_"+id+" .wl-status_msg").html();

                                        open_modal('detail_withdrawal_modal');

                                        $("#wl-id").val(id);
                                        $("#wl-affiliate").html(affiliate);
                                        $("#wl-ctime").html(ctime);
                                        $("#wl-gateway").html(gateway);
                                        $("#wl-gateway-info").html(gateway_info);
                                        $("#wl-amount").html(amount);
                                        $("#wl-status").val(status);
                                        $("#wl-status_msg").val(status_msg);

                                    }

                                    function delete_withdrawal(id){
                                        open_modal("delete_withdrawal_modal",{
                                            title:"<?php echo ___("needs/button-delete"); ?>"
                                        });

                                        $("#delete_withdrawal_modal .delete_ok").click(function(){
                                            var password = $('#password1').val();
                                            var request = MioAjax({
                                                button_element:$(this),
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data: {operation:"delete_withdrawal",id:id}
                                            },true,true);

                                            request.done(function(result){
                                                if(result){
                                                    if(result !== ''){
                                                        var solve = getJson(result);
                                                        if(solve !== false){
                                                            if(solve.status == "error"){
                                                                if(solve.message != undefined && solve.message != '')
                                                                    alert_error(solve.message,{timer:5000});
                                                            }else if(solve.status == "successful"){
                                                                alert_success(solve.message,{timer:3000});
                                                                table2.ajax.reload();
                                                            }
                                                        }else
                                                            console.log(result);
                                                    }
                                                }else console.log(result);
                                            });
                                        });

                                        $("#delete_withdrawal_modal .delete_no").on("click",function(){
                                            close_modal("delete_withdrawal_modal");
                                        });
                                    }

                                    function updateAffiliateForm_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.for != undefined && solve.for != ''){
                                                        $("#updateAffiliateForm "+solve.for).focus();
                                                        $("#updateAffiliateForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                        $("#updateAffiliateForm "+solve.for).change(function(){
                                                            $(this).removeAttr("style");
                                                        });
                                                    }
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
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
                                <div id="delete_withdrawal_modal" style="display: none;">
                                    <div class="padding20">
                                        <div align="center">

                                            <p><?php echo ___("needs/delete-are-you-sure"); ?></p>
                                            <div class="clear"></div><br>
                                            <div class="yuzde50">
                                                <a href="javascript:void(0);" class="delete_ok gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo ___("needs/ok"); ?></a>
                                            </div>
                                            <div class="yuzde50">
                                                <a href="javascript:void(0);" class="delete_no gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo ___("needs/no"); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="detail_withdrawal_modal" style="display: none;" data-izimodal-title="<?php echo ___("needs/button-detail"); ?>">
                                    <div class="padding20">

                                        <form action="<?php echo $links["controller"]; ?>" method="post" id="updateWithdrawalForm">
                                            <input type="hidden" name="operation" value="update_withdrawal">
                                            <input type="hidden" name="id" value="0" id="wl-id">

                                            <div class="formcon" style="display: none;">
                                                <div class="yuzde30"><?php echo __("admin/users/list-th-affiliate"); ?></div>
                                                <div class="yuzde70" id="wl-affiliate">?</div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-ctime"); ?></div>
                                                <div class="yuzde70" id="wl-ctime">00/00/0000 00:00</div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-gateway"); ?></div>
                                                <div class="yuzde70">
                                                    <strong id="wl-gateway"></strong>
                                                    <div class="clear"></div>
                                                    <span id="wl-gateway-info"></span>
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-amount"); ?></div>
                                                <div class="yuzde70">
                                                    <strong id="wl-amount"></strong>
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-status"); ?></div>
                                                <div class="yuzde70">
                                                    <select name="status" id="wl-status">
                                                        <?php
                                                            foreach(__("admin/users/affiliate-withdrawal-situations") AS $k=>$v)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <div class="clear"></div>
                                                    <textarea name="status_msg" id="wl-status_msg" placeholder="<?php echo __("admin/users/affiliate-withdrawal-status-msg"); ?>"></textarea>
                                                </div>
                                            </div>

                                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                                <a class="yesilbtn gonderbtn" id="updateWithdrawalForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                                            </div>
                                            <div class="clear"></div>

                                        </form>

                                        <div class="clear"></div>
                                    </div>
                                </div>



                                <div id="tab-affiliate">
                                    <ul class="tab">
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'settings','affiliate')" data-tab="settings"><?php echo __("admin/users/affiliate-settings"); ?></a></li>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'transactions','affiliate')" data-tab="transactions"><?php echo __("admin/users/affiliate-transactions"); ?></a></li>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'withdrawals','affiliate')" data-tab="withdrawals"><?php echo __("admin/users/affiliate-withdrawals"); ?></a></li>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'hits','affiliate')" data-tab="hits"><?php echo __("admin/users/affiliate-hits"); ?></a></li>
                                    </ul>
                                    <div id="affiliate-settings" class="tabcontent">
                                        <div class="adminpagecon">
                                            <div class="dashboardboxs">

                                                <div class="dashboardbox" id="turuncublok">
                                                    <div class="padding10">
                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                        <h2><?php echo $pending_balance_today; ?>

                                                        </h2>
                                                        <h4><?php echo __("website/account/affiliate-tx22"); ?></h4>
                                                        <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx23"); ?> <strong><?php echo $pending_balance_total; ?></strong></span></div>
                                                    </div>
                                                </div>

                                                <div class="dashboardbox" id="yesilblok">
                                                    <?php
                                                        $available_balance = $aff['balance'] >= Money::exChange(Config::get("options/affiliate/min-payment-amount"),Config::get("general/currency"),$aff['currency']);
                                                    ?>

                                                    <div class="padding10">
                                                        <?php
                                                            if($available_balance)
                                                            {
                                                                ?>
                                                                <i class="ion-happy-outline" style="line-height: 105px;" aria-hidden="true"></i>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <i class="fa fa-meh-o" style="line-height: 100px;" aria-hidden="true"></i>
                                                                <?php
                                                            }
                                                        ?>
                                                        <h2><?php echo $total_balance; ?>

                                                        </h2>
                                                        <h4><?php echo __("website/account/affiliate-tx26"); ?></h4>
                                                        <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx27"); ?> <strong><?php echo  $total_withdrawals; ?></strong></span></div>
                                                    </div>
                                                </div>

                                                <div class="dashboardbox" id="redblok">
                                                    <div class="padding10">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                        <h2><?php echo $references_today; ?>

                                                        </h2>
                                                        <h4><?php echo __("website/account/affiliate-tx29"); ?></h4>
                                                        <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx30"); ?> <strong><?php echo $references_total; ?></strong></span></div>
                                                    </div>
                                                </div>

                                                <div class="dashboardbox" id="maviblok">
                                                    <div class="padding10">
                                                        <i class="ion-earth" style="line-height: 20px;" aria-hidden="true"></i>
                                                        <h2><?php echo $hits_today; ?>

                                                        </h2>
                                                        <h4><?php echo __("website/account/affiliate-tx32"); ?></h4>
                                                        <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx30"); ?> <strong><?php echo $hits_total; ?></strong></span></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateAffiliateForm">
                                                <input type="hidden" name="operation" value="update_affiliate">
                                                <input type="hidden" name="id" value="<?php echo $aff['id']; ?>">
                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/users/affiliate-user-activate-date"); ?></div>
                                                    <div class="yuzde70">
                                                        <?php echo DateManager::format(Config::get("options/date-format")." H:i",$aff['date']); ?>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("website/account/affiliate-tx33"); ?></div>
                                                    <div class="yuzde70">
                                                        <a><?php echo $links["tracking"]; ?></a>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/users/affiliate-user-disable"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $aff["disabled"] ? ' checked' : ''; ?> type="checkbox" name="disabled" value="1" id="aff_disable" class="checkbox-custom">
                                                        <label class="checkbox-custom-label" for="aff_disable"><span class="kinfo"><?php echo __("admin/users/affiliate-user-disable-desc"); ?></span></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/users/affiliate-commission-period"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $aff["commission_period"] == '' ? ' checked' : ''; ?> type="radio" name="commission-period" value="" class="radio-custom" id="commission-period-default">
                                                        <label  style="margin-right: 10px;" class="radio-custom-label" for="commission-period-default"><?php echo __("admin/users/affiliate-commission-period-default"); ?></label>

                                                        <input<?php echo $aff["commission_period"] == 'lifetime' ? ' checked' : ''; ?> type="radio" name="commission-period" value="lifetime" class="radio-custom" id="commission-period-lifetime">
                                                        <label  style="margin-right: 10px;" class="radio-custom-label" for="commission-period-lifetime"><?php echo __("admin/users/affiliate-commission-period-lifetime"); ?></label>

                                                        <input<?php echo $aff["commission_period"] == 'onetime' ? ' checked' : ''; ?> type="radio" name="commission-period" value="onetime" class="radio-custom" id="commission-period-onetime">
                                                        <label class="radio-custom-label" for="commission-period-onetime"><?php echo __("admin/users/affiliate-commission-period-onetime"); ?></label>

                                                        <div class="clear"></div>
                                                        <span class="kinfo"><?php echo __("admin/users/affiliate-user-commission-period-desc"); ?></span>

                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/users/affiliate-user-rate"); ?></div>
                                                    <div class="yuzde70">
                    <span class="infochar">
                        %
                    </span>
                                                        <?php
                                                            $c_rate         = $aff['commission_value'];
                                                            $c_split        = explode(".",$c_rate);
                                                            if(isset($c_split[1]) && $c_split[1] < 01)
                                                                $c_rate = $c_split[0];
                                                        ?>
                                                        <input type="text" name="rate" value="<?php echo $c_rate > 0.00 ? $c_rate : ''; ?>" placeholder="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                                                        <span class="kinfo"><?php echo __("admin/users/affiliate-user-rate-desc"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/users/affiliate-user-balance"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="text" name="balance" value="<?php echo Money::formatter($aff['balance'],$aff['currency']); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                                                        <select name="currency" class="yuzde30">
                                                            <?php
                                                                foreach(Money::getCurrencies() AS $row){
                                                                    ?>
                                                                    <option<?php echo $aff["currency"] == $row["id"] ? ' selected' : '';?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="clear"></div>

                                                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                                    <a class="yesilbtn gonderbtn" id="updateAffiliateForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-update"); ?></a>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div id="affiliate-transactions" class="tabcontent">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_transactions">
                                            <thead style="background:#ebebeb;">
                                            <tr>
                                                <th align="center">#</th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx39"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx40"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx41"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx42"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx43"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx44"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                if($transaction_list)
                                                {
                                                    foreach($transaction_list AS $k => $row)
                                                    {
                                                        $rate = $row["rate"];
                                                        $rate_split = explode(".",$rate);
                                                        if(isset($rate_split[1]) && $rate_split[1] < 01)
                                                            $rate = $rate_split[0];
                                                        ?>
                                                        <tr>
                                                            <td align="center"><?php echo $k; ?></td>
                                                            <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." H:i",$row['clicked_ctime']); ?></td>
                                                            <td align="center"><a href="<?php echo Controllers::$init->AdminCRLink("users-2",["detail",$row["user_id"]]); ?>"><strong><?php echo $row["full_name"]; ?></strong></a><br>(<?php echo in_array($row['status'],['invalid','invalid-another']) ? __("website/account/affiliate-tx46") : __("website/account/affiliate-tx45"); ?>)</td>
                                                            <td align="center"><a href="<?php echo Controllers::$init->AdminCRLink("orders-2",["detail",$row["order_id"]]); ?>"><?php echo $row['order_name'] ? $row["order_name"] : __("website/account/affiliate-tx59"); ?></a></td>
                                                            <td align="center"><?php echo Money::formatter_symbol($row["amount"],$row["currency"]); ?></td>
                                                            <td align="center">
                                                                <strong><?php echo Money::formatter_symbol($row["commission"],$aff["currency"]); ?></strong> (%<?php echo $rate; ?>)
                                                                <?php
                                                                    if($row["exchange"] > 0.00)
                                                                    {
                                                                        ?>
                                                                        <br>(<?php echo __("website/account/affiliate-tx51")." ".Money::formatter($row["exchange"],$aff["currency"]); ?>)
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="center">

                                                                <div class="listingstatus">
                                                                    <?php echo $transaction_situations[$row["status"]]; ?>
                                                                    <?php
                                                                        if(in_array($row["status"],['approved','completed']))
                                                                        {
                                                                            ?>
                                                                            <br>(<?php echo DateManager::format(Config::get("options/date-format"),$row["ctime"]); ?>)
                                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx48",['{date}' => DateManager::format(Config::get("options/date-format"),$row["clearing_date"])]); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                                            <?php
                                                                        }
                                                                        elseif($row["status"] == "invalid")
                                                                        {
                                                                            ?>
                                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx47"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                                            <?php
                                                                        }
                                                                        elseif($row["status"] == "invalid-another")
                                                                        {
                                                                            ?>
                                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx60"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div id="affiliate-withdrawals" class="tabcontent">
                                        <table width="100%" id="withdrawals" class="table table-striped table-borderedx table-condensed nowrap">
                                            <thead style="background:#ebebeb;">
                                            <tr>
                                                <th align="left" data-orderable="false">#</th>
                                                <!--<th align="left" data-orderable="false"><?php echo __("admin/users/list-th-affiliate"); ?></th>-->
                                                <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-ctime"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-gateway"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-amount"); ?></th>
                                                <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-status"); ?></th>
                                                <th align="center" data-orderable="false"></th>
                                            </tr>
                                            </thead>
                                            <tbody align="center" style="border-top:none;"></tbody>
                                        </table>
                                    </div>
                                    <div id="affiliate-hits" class="tabcontent">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_hits">
                                            <thead style="background:#ebebeb;">
                                            <tr>
                                                <th align="center">#</th>
                                                <th data-orderable="false" align="left"><?php echo __("website/account/affiliate-tx56"); ?></th>
                                                <th align="center"><?php echo __("website/account/affiliate-tx57"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                if($referrer_list)
                                                {
                                                    foreach($referrer_list AS $k => $row)
                                                    {
                                                        ?>
                                                        <tr>
                                                            <td align="center"><?php echo $k; ?></td>
                                                            <td align="left">
                                                                <?php
                                                                    if($row["referrer"]){
                                                                        ?>
                                                                        <a target="_blank" referrerpolicy="no-referrer" href="<?php echo $row["referrer"]; ?>"><?php echo $row["referrer"]; ?></a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        echo ___("needs/none");
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="center"><?php echo $row["hits"]; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php
                                }
                                else
                                {
                            ?>
                            <br>
                                <div align="center">
                                    <div class="guncellebtn yuzde50">
                                        <a class="gonderbtn yesilbtn" href="<?php echo $links["controller"]; ?>?operation=activate_affiliate"><?php echo __("admin/users/affiliate-user-activate"); ?></a>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>

                    </div>
                <?php endif; ?>

                <style>
                    .listheadbtn {margin:12px 0px;}
                </style>

                <?php if(Admin::isPrivilege(Config::get("privileges/INVOICES"))): ?>
                    <div id="tab-invoices" class="tabcontent">
                        <script type="text/javascript">
                            var invoices;
                            $(document).ready(function(){

                                invoices = $('#invoicesTable').DataTable({
                                    "columnDefs": [
                                        {
                                            "targets": [0],
                                            "visible":false,
                                        },
                                    ],
                                    "lengthMenu": [
                                        [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                    ],
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": "<?php echo $links["ajax-invoices"]; ?>",
                                    responsive: true,
                                    "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                                });

                            });

                            function deleteInvoice(id){

                                if(typeof id == "object" && id.length>1){
                                    $("#password_wrapper2").css("display","block");
                                }else
                                    $("#password_wrapper2").css("display","none");

                                $("#invoice_password1").val('');

                                open_modal("invoice_deleteModal",{
                                    title:"<?php echo __("admin/invoices/delete-modal-title-bills"); ?>"
                                });

                                $("#delete_ok").click(function(){
                                    var password = $('#invoice_password1').val();
                                    var request = MioAjax({
                                        button_element:this,
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        action: "<?php echo $links["invoices"]; ?>",
                                        method: "POST",
                                        data: {operation:"apply_operation",from:"list",type:"delete",id:id,password:password}
                                    },true,true);

                                    request.done(function(result){
                                        if(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "error"){
                                                        $("#invoice_password1").val('');
                                                        if(solve.message != undefined && solve.message != '')
                                                            alert_error(solve.message,{timer:5000});
                                                    }else if(solve.status == "successful"){
                                                        $("#invoice_password1").val('');
                                                        alert_success(solve.message,{timer:3000});
                                                        close_modal("invoice_deleteModal");
                                                        invoices.ajax.reload();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }else console.log(result);
                                    });

                                });

                                $("#delete_no").click(function(){
                                    close_modal("invoice_deleteModal");
                                    $("#invoice_password1").val('');
                                });

                            }

                            function InvoiceApplyOperation(type,id){
                                $("#Bills").addClass("tab-blur-content");
                                $("#operation-loading").fadeIn(500,function(){
                                });

                                var request = MioAjax({
                                    action: "<?php echo $links["invoices"]; ?>",
                                    method: "POST",
                                    data: {operation:"apply_operation",from:"list",type:type,id:id}
                                },true,true);

                                request.done(function(result){

                                    $("#operation-loading").fadeOut(500,function(){
                                        $("#Bills").removeClass("tab-blur-content");
                                    });

                                    if(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                    invoices.ajax.reload();
                                                }else if(solve.status == "successful"){

                                                    invoices.ajax.reload();

                                                    alert_success(solve.message,{timer:3000});
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }else console.log(result);
                                });

                            }

                            function InvoiceApplySelection(element){
                                var selection = $(element).val();
                                if(selection == ''){

                                }else{
                                    $(element).val('');
                                    var values = [],value;
                                    $('.selected-item:checked').each(function(){
                                        value       = $(this).val();
                                        if(value) values.push(value);
                                    });
                                    if(values.length==0) return false;

                                    if(selection === "delete")
                                        deleteInvoice(values);
                                    else
                                        InvoiceApplyOperation(selection,values);
                                }
                            }

                        </script>


                        <div id="invoice_deleteModal" style="display: none;">
                            <div class="padding20">
                                <div align="center">

                                    <p><?php echo __("admin/invoices/delete-are-youu-sure-bills"); ?></p>

                                    <div id="password_wrapper2" style="display: none;">
                                        <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="invoice_password1" value="" placeholder="********"></label>
                                        <div class="clear"></div>
                                        <br>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-foot-btn">
                                <a href="javascript:void(0);" id="delete_ok" class="red lbtn"><?php echo __("admin/orders/delete-ok"); ?></a>
                            </div>
                        </div>

                        <div id="operation-loading" class="blur-text" style="display: none">
                            <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <strong><?php echo __("admin/invoices/bills-row-operation-processing"); ?></strong>
                        </div>


                        <div id="Bills">

                            <div class="listheadbtn">

                                <?php if($privOperation): ?>
                                    <select class="applyselect" id="InvoiceSelectApply" onchange="InvoiceApplySelection(this);">
                                        <option value=""><?php echo __("admin/invoices/bills-apply-to-selected"); ?></option>
                                        <option value="paid"><?php echo __("admin/invoices/bills-apply-to-selected-paid"); ?></option>
                                        <option value="unpaid"><?php echo __("admin/invoices/bills-apply-to-selected-unpaid"); ?></option>
                                        <option value="merge"><?php echo __("admin/invoices/bills-apply-to-selected-merge"); ?></option>
                                        <option value="remind"><?php echo __("admin/invoices/bills-apply-to-selected-remind"); ?></option>
                                        <?php if($privDelete): ?>
                                            <option value="delete"><?php echo __("admin/invoices/bills-apply-to-selected-delete"); ?></option>
                                        <?php endif; ?>
                                        <?php if($privOperation): ?>
                                            <option value="cancelled"><?php echo __("admin/invoices/bills-apply-to-selected-cancelled"); ?></option>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>

                                <?php if(Admin::isPrivilege(Config::get("privileges/INVOICES"))): ?>
                                    <a class="lbtn" href="<?php echo $links["add-bill"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-bill"); ?></a>
                                <?php endif; ?>

                                <?php /*if($privOperation): ?>
                                    <a class="lbtn remind_unpaid_bill_button" href="javascript:void(0);"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-remind-unpaid-bill"); ?></a>
                                <?php endif; */ ?>

                            </div>

                            <div class="clear"></div>

                            <table width="100%" id="invoicesTable">
                                <thead style="background:#ebebeb;">
                                <tr>
                                    <th align="left">#</th>
                                    <th align="left" data-orderable="false" style="width:5px;">
                                        <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                                    </th>
                                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-id"); ?></th>
                                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-amount"); ?></th>
                                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-date"); ?></th>

                                    <?php if(Config::get("options/send-bill-to-address/status")): ?>
                                        <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-sendbta"); ?></th>
                                    <?php endif; ?>
                                    <?php if(Config::get("options/taxation")): ?>
                                        <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-taxed"); ?></th>
                                    <?php endif; ?>
                                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-status"); ?></th>
                                    <th align="center" data-orderable="false"></th>
                                </tr>
                                </thead>
                                <tbody align="center" style="border-top:none;"></tbody>
                            </table>
                            <div class="clear"></div>
                        </div>



                        <div class="clear"></div>

                    </div>
                <?php endif; ?>

                <?php if(Admin::isPrivilege(Config::get("privileges/ORDERS"))): ?>
                    <div id="tab-services" class="tabcontent">
                        <script type="text/javascript">
                            var orders;
                            $(document).ready(function() {

                                $("#ordersTable").on("click",".status-msg",function(){
                                    var message = $(this).data("message");
                                    open_modal('statusMessage');
                                    $("#statusMessage .status-message-text").html(message);
                                });

                                orders = $('#ordersTable').DataTable({
                                    "columnDefs": [
                                        {
                                            "targets": [0],
                                            "visible":false,
                                            "searchable": false
                                        },
                                    ],
                                    "lengthMenu": [
                                        [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                    ],
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": "<?php echo $links["ajax-orders"]; ?>",
                                    responsive: true,
                                    "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                                });
                            });

                            function deleteOrder(id){

                                var automation = $("#delete-"+id).data("automation");

                                var content1 = "<?php echo __("admin/orders/delete-are-youu-sure-list"); ?>";
                                var content2 = "<?php echo __("admin/orders/delete-are-youu-sure-list-note"); ?>";
                                $("#orders_deleteModal_text1").html(content1);
                                if(automation)
                                    $("#deleteModal_text2").css("display","block");
                                else
                                    $("#deleteModal_text2").css("display","none");

                                open_modal("orders_deleteModal",{
                                    title:"<?php echo __("admin/orders/delete-modal-title-list"); ?>"
                                });

                                $("#orders_delete_ok").click(function(){
                                    var request = MioAjax({
                                        action: "<?php echo $links["orders"]; ?>",
                                        method: "POST",
                                        data: {
                                            operation:"apply_operation",
                                            from:"list",
                                            type:"delete",
                                            id:id,
                                            apply_on_module: $("#delete-apply-on-module").prop('checked') ? 1 : 0
                                        }
                                    },true,true);

                                    request.done(function(result){
                                        if(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "error"){
                                                        if(solve.message != undefined && solve.message != '')
                                                            alert_error(solve.message,{timer:5000});
                                                    }else if(solve.status == "successful"){
                                                        alert_success(solve.message,{timer:3000});
                                                        close_modal("orders_deleteModal");
                                                        orders.ajax.reload();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }else console.log(result);
                                    });

                                });

                                $("#orders_delete_no").click(function(){
                                    close_modal("orders_deleteModal");
                                });

                            }
                        </script>

                        <div id="statusMessage" style="display: none;" data-izimodal-title="<?php echo __("admin/orders/modal-status-message"); ?>">
                            <div class="padding20">
                                <div class="status-message-text"></div>
                            </div>
                        </div>

                        <div id="orders_deleteModal" style="display: none;">
                            <div class="padding20">
                                <div align="center">

                                    <p id="orders_deleteModal_text1"></p>
                                    <div style="width: 30%; display:inline-block; margin-bottom: 10px;" id="deleteModal_text2">
                                        <input checked type="checkbox" class="checkbox-custom" id="delete-apply-on-module" value="1">
                                        <label class="checkbox-custom-label" for="delete-apply-on-module"><span class="kinfo"><?php echo __("admin/orders/apply-on-module"); ?></span></label>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="yuzde50">
                                        <a href="javascript:void(0);" id="orders_delete_ok" class="gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/orders/delete-ok"); ?></a>
                                    </div>
                                    <div class="yuzde50">
                                        <a href="javascript:void(0);" id="orders_delete_no" class="gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/orders/delete-no"); ?></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <style type="text/css">
                            #ordersTable tbody tr td:nth-child(1),#ordersTable tbody tr td:nth-child(2) {text-align: left}
                        </style>

                        <div class="listheadbtn">
                            <?php if(Admin::isPrivilege(["ORDERS_OPERATION"])): ?>
                                <a class="lbtn" href="<?php echo $links["add-order"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-order"); ?></a>
                            <?php endif; ?>

                            <select class="applyselect" style="float: right;" onchange="location = this.options[this.selectedIndex].value;">
                                <option value="<?php echo $links["controller"]; ?>?tab=services"><?php echo ___("needs/allOf"); ?></option>
                                <?php
                                    foreach($product_groups AS $k => $g)
                                    {
                                        ?>
                                        <option<?php echo $service_group == $k ? ' selected' : '' ; ?> value="<?php echo $links["controller"]; ?>?tab=services&service_group=<?php echo $k; ?>"><?php echo $g; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>




                        <table width="100%" id="ordersTable" class="">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left">#</th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-name"); ?></th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-group"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-create-date"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-amount-period"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-status"); ?></th>
                                <th align="center" data-orderable="false"></th>
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;"></tbody>
                        </table>


                        <div class="clear"></div>
                    </div>
                <?php endif; ?>

                <?php if(Admin::isPrivilege(Config::get("privileges/TICKETS"))): ?>
                    <div id="tab-tickets" class="tabcontent">

                        <script>
                            var tickets;
                            $(document).ready(function() {

                                tickets = $('#ticketsTable').DataTable({
                                    "columnDefs": [
                                        {
                                            "targets": [0],
                                            "visible":false,
                                            "searchable": false
                                        }
                                    ],
                                    "lengthMenu": [
                                        [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                    ],
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": "<?php echo $links["ajax-tickets"]; ?>",
                                    responsive: true,
                                    "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                                });
                            });

                            function deleteRequest(id){
                                open_modal("tickets_ConfirmModal");

                                $("#tickets_delete_ok").click(function(){
                                    var request = MioAjax({
                                        button_element:$("#tickets_delete_ok"),
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        action: "<?php echo $links["tickets"]; ?>",
                                        method: "POST",
                                        data: {operation:"delete_request",id:id}
                                    },true,true);

                                    request.done(function(result){
                                        if(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "error"){
                                                        if(solve.message != undefined && solve.message != '')
                                                            alert_error(solve.message,{timer:5000});
                                                    }else if(solve.status == "successful"){
                                                        alert_success(solve.message,{timer:3000});
                                                        close_modal("tickets_ConfirmModal");
                                                        tickets.ajax.reload();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }else console.log(result);
                                    });

                                });

                                $("#tickets_delete_no").click(function(){
                                    close_modal("tickets_ConfirmModal");
                                });

                            }
                        </script>

                        <style type="text/css">
                            #ticketsTable tbody tr td:nth-child(1) {text-align: left;}
                        </style>




                        <div id="tickets_ConfirmModal" style="display: none;" data-izimodal-title="<?php echo __("admin/tickets/requests-td-delete-title"); ?>">
                            <div class="padding20">
                                <p><?php echo __("admin/tickets/delete-are-youu-sure"); ?></p>

                                <div align="center">
                                    <div class="yuzde50">
                                        <a id="tickets_delete_ok" href="javascript:void(0);" class="gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/orders/delete-ok"); ?></a>
                                    </div>
                                    <div class="yuzde50">
                                        <a id="tickets_delete_no" href="javascript:void(0);" class="gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/orders/delete-no"); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="listheadbtn">
                            <?php if(Admin::isPrivilege(["TICKETS_OPERATION"])): ?>
                                <a class="lbtn" href="<?php echo $links["add-ticket"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/users/detail-summary-add-ticket"); ?></a>
                            <?php endif; ?>
                        </div>

                        <table width="100%" id="ticketsTable" class="">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left">#</th>
                                <th align="left" data-orderable="false"><?php echo __("admin/tickets/requests-th-subject"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-department"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-assigned"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-cdate"); ?></th>
                                <th align="center" data-orderable="false"><i class="ion-android-done-all"></i></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-status"); ?></th>
                                <th align="center" data-orderable="false"></th>
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;"></tbody>
                        </table>


                        <div class="clear"></div>
                    </div>
                <?php endif; ?>

                <div id="tab-messages" class="tabcontent">
                    <style>
                        #messagesTable tbody tr td:nth-child(1){text-align: left;}
                    </style>
                    <script>
                        var messages;
                        $(document).ready(function() {

                            messages = $('#messagesTable').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "visible":false,
                                        "searchable": false
                                    }
                                ],
                                "lengthMenu": [
                                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                ],
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo $links["ajax-messages"]; ?>",
                                responsive: true,
                                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                            });
                        });

                        function showMessage(id,subject){
                            $("#showMessage").attr("data-izimodal-title",subject);
                            $("#showMessage_text").html('');
                            open_modal("showMessage",{width:'800px'});
                            var content = $("#message_"+id).html();

                            document.getElementById('showMessage_content').src = "data:text/html;charset=utf-8," + encodeURIComponent(content);
                        }
                    </script>

                    <div id="showMessage" style="display: none;" data-izimodal-title="">
                        <iframe id="showMessage_content" style="width:100%; height:700px;border:none;"></iframe>
                    </div>

                    <table width="100%" id="messagesTable" class="">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left" data-orderable="false"><?php echo __("admin/users/detail-messages-th-subject"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/detail-messages-th-date"); ?></th>
                            <th align="center" data-orderable="false"></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>


                    <div class="clear"></div>
                </div>

                <div id="tab-actions" class="tabcontent">

                    <style>
                        #actionsTable tbody tr td:nth-child(1){text-align: left;}
                    </style>
                    <script>
                        var actions;
                        $(document).ready(function() {

                            actions = $('#actionsTable').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "visible":false,
                                        "searchable": false
                                    }
                                ],
                                "lengthMenu": [
                                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                ],
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo $links["ajax-actions"]; ?>",
                                responsive: true,
                                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                            });
                        });
                    </script>

                    <table width="100%" id="actionsTable" class="">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left" data-orderable="false"><?php echo __("admin/users/detail-actions-th-description"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/detail-actions-th-date"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/detail-actions-th-ip"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>

                    <div class="clear"></div>
                </div>

                <div class="clear"></div>

            </div><!-- tab wrap content end -->



            <div class="clear"></div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>




</body>
</html>