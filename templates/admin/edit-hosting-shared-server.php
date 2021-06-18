<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var tab = _GET("settings");
            if (tab != '' && tab != undefined) {
                $("#tab-settings .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-settings .tablinks:eq(0)").addClass("active");
                $("#tab-settings .tabcontent:eq(0)").css("display", "block");
            }


            $("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#editForm_submit").click();
            });

            $("#editForm_submit").on("click",function(){
                $("input[name=operation]").val('edit_hosting_shared_server');
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $("#testConnect").on("click",function(){
                $("input[name=operation]").val('test_shared_server_connect');
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"testConnect_handler",
                });
            });


            $("select[name=type]").change(function(){
                var checker     = $("option:selected",this).data("checker");
                var have_port   = $("option:selected",this).data("have-port");
                var access_hash = $("option:selected",this).data("access-hash");
                var nport       = $("option:selected",this).data("port");
                var sport       = $("option:selected",this).data("secure-port");
                var type        = $("option:selected",this).data("type");
                var secure      = $("#secure").prop("checked");

                if(type === "virtualization"){
                    $(".virtualization-content").css("display","block");
                }else{
                    $(".virtualization-content").css("display","none");
                }

                if(checker != undefined && checker){
                    $("#checker-wrap").fadeIn(100);
                }else{
                    $("#checker-wrap").fadeOut(100);
                }

                if(have_port != undefined && have_port){
                    $("input[name=port]").val(secure ? sport : nport).attr("readonly",true);
                    $("#custom_port").prop("checked",false);
                    $("#port-wrap").fadeIn(100);
                }else{
                    $("input[name=port]").val('').attr("readonly",true);
                    $("#custom_port").prop("checked",false);
                    $("#port-wrap").fadeOut(100);
                }

                if(access_hash !== undefined && access_hash){
                    $("#access-hash-wrap").fadeIn(100);
                }else{
                    $("#access-hash-wrap").fadeOut(100);
                }

            });

        });

        function testConnect_handler(result){
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

        function change_secure(elem){
            var check   = $(elem).prop("checked");
            var type    = $("select[name=type] option:selected");
            if($("#custom_port").prop("checked")) return false;

            if(check)
                $('input[name=port]').val(type.data("secure-port"));
            else
                $('input[name=port]').val(type.data("port"));
        }

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

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-edit-hosting-shared-server"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div id="tab-settings"><!-- settings tab wrap start -->
                <ul class="tab">
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','settings')" data-tab="detail"> <?php echo __("admin/products/hosting-shared-servers-tab-detail"); ?></a></li>

                    <?php if(isset($import_support) && $import_support): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'import','settings')" data-tab="import"> <?php echo __("admin/products/hosting-shared-servers-tab-import"); ?></a></li>
                    <?php endif; ?>
                </ul>

                <div id="settings-detail" class="tabcontent"><!-- detial tab content start -->

                    <div class="adminpagecon">

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                            <input type="hidden" name="operation" value="">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-name"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="name" value="<?php echo $server["name"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-name-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-dns"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="ns1" value="<?php echo $server["ns1"]; ?>" placeholder="ns1.example.com">
                                    <input type="text" name="ns2" value="<?php echo $server["ns2"]; ?>" placeholder="ns2.example.com">
                                    <input type="text" name="ns3" value="<?php echo $server["ns3"]; ?>" placeholder="ns3.example.com">
                                    <input type="text" name="ns4" value="<?php echo $server["ns4"]; ?>" placeholder="ns4.example.com">
                                    <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-dns-desc"); ?></span>
                                </div>
                            </div>

                            <!--div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-maxaccounts"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="maxaccounts" value="<?php echo $server["maxaccounts"] ? $server["maxaccounts"] : ''; ?>" style="width: 50px;">
                                    <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-maxaccounts-desc"); ?></span>
                                </div>
                            </div-->

                            <div class="clear"></div><br>

                            <div class="blue-info">
                                <div class="padding20">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                  <p> <strong> <?php echo __("admin/products/add-hosting-shared-server-information-desc"); ?></strong></p>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-type"); ?></div>
                                <div class="yuzde70">
                                    <select name="type">
                                        <?php
                                            if(isset($server_modules) && $server_modules){
                                                $i=0;
                                                foreach($server_modules AS $k=>$v){
                                                    $i++;

                                                    $checker = isset($v["config"]["server-info-checker"]) ? $v["config"]["server-info-checker"] : false;
                                                    $havePort = isset($v["config"]["server-info-port"]) ? $v["config"]["server-info-port"] : false;
                                                    $port = isset($v["config"]["server-info-not-secure-port"]) ? $v["config"]["server-info-not-secure-port"] : 0;
                                                    $sport = isset($v["config"]["server-info-secure-port"]) ? $v["config"]["server-info-secure-port"] : 0;
                                                    $access_hash = isset($v["config"]["access-hash"]) ? $v["config"]["access-hash"] : false;
                                                    if($server["type"] == $k){
                                                        $first_module = [
                                                            'type'          => $v["config"]["type"],
                                                            'port' => $port,
                                                            'secure-port' => $sport,
                                                            'have-port' => $havePort,
                                                            'checker' => $checker,
                                                            'access-hash'   => $access_hash,
                                                        ];
                                                    }
                                                    ?>
                                                    <option<?php echo $server["type"] == $k ? ' selected' : ''; ?> data-type="<?php echo $v["config"]["type"]; ?>" data-access-hash="<?php echo $access_hash; ?>" data-secure-port="<?php echo $sport; ?>" data-port="<?php echo $port; ?>" data-have-port="<?php echo $havePort ? 'true' : 'false'; ?>" data-checker="<?php echo $checker ? 'true' : 'false'; ?>"><?php echo $k; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-type-desc"); ?></span>
                                </div>
                            </div>

                            <?php
                                if(isset($module) && $module && method_exists($module,'use_adminArea_root_SingleSignOn'))
                                {
                                    ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/shared-server-root-panel-access"); ?></div>
                                        <div class="yuzde70">
                                            <a target="_blank" href="<?php echo $links["shared-server-root-login"]."?id=".$server["id"]; ?>" class="lbtn blue"><?php echo __("admin/products/shared-server-root-panel-access-btn"); ?></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-ip"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="ip" value="<?php echo $server["ip"]; ?>" placeholder="<?php echo __("admin/products/add-hosting-shared-server-ip-desc"); ?>">

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-username"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="username" value="<?php echo $server["username"]; ?>" placeholder="<?php echo __("admin/products/add-hosting-shared-server-username-desc"); ?>">

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-password"); ?></div>
                                <div class="yuzde70">
                                    <input type="password" name="password" value="<?php echo $server["password"] ? '*****' : ''; ?>" placeholder="<?php echo __("admin/products/add-hosting-shared-server-password-desc"); ?>">

                                </div>
                            </div>

                            <div class="formcon" id="access-hash-wrap"<?php echo $first_module["access-hash"] ? '' : 'style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-access-hash"); ?></div>
                                <div class="yuzde70">
                                    <textarea rows="8" name="access-hash" placeholder="<?php echo __("admin/products/add-hosting-shared-server-access-hash-desc"); ?>"><?php echo $server["access_hash"]; ?></textarea>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-secure"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $server["secure"] ? ' checked' : ''; ?> type="checkbox" name="secure" value="1" class="checkbox-custom" id="secure" onchange="change_secure(this);">
                                    <label class="checkbox-custom-label" for="secure"><?php echo __("admin/products/add-hosting-shared-server-secure-desc"); ?></label>
                                </div>
                            </div>
                            <?php
                                $get_port       = $server["secure"] ? $first_module["secure-port"] : $first_module["port"];
                                $custom_port    = $get_port != $server["port"];
                                if($custom_port) $get_port = $server["port"];
                            ?>
                            <div class="formcon" id="port-wrap"<?php echo $first_module["have-port"] ? '' : 'style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-port"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo  $custom_port ? '' : ' readonly'; ?> type="text" name="port" value="<?php echo $get_port; ?>" style="width: 50px;">
                                    <input<?php echo $custom_port ? ' checked' : ''; ?> onchange="if($(this).prop('checked')) $('input[name=port]').removeAttr('readonly').focus(); else $('input[name=port]').attr('readonly',true);" type="checkbox" id="custom_port" class="checkbox-custom">
                                    <label class="checkbox-custom-label" for="custom_port"><?php echo __("admin/products/add-hosting-shared-port-custom"); ?></label>
                                </div>
                            </div>
                            <?php
                                $updowngrade_remove_server      = $server["updowngrade_remove_server"];
                                if(substr($updowngrade_remove_server,0,4) == "then"){
                                    $updowngrade_remove_server_day  = substr($updowngrade_remove_server,5,4);
                                    $updowngrade_remove_server      = "then";
                                }
                            ?>
                            <div class="formcon virtualization-content" style="<?php echo isset($first_module["type"]) && $first_module["type"] == "virtualization" ? '' : 'display: none;'; ?>" onkeypress="return event.charCode>= 48 &&event.charCode<= 57">
                                <div class="yuzde30">
                                    <?php echo __("admin/products/shared-server-updowngrade-settings"); ?>
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/products/shared-server-updowngrade-settings-desc"); ?></span>
                                </div>
                                <div class="yuzde70">

                                    <div style="margin-bottom: 5px;">

                                        <input<?php echo $updowngrade_remove_server == "then" ? ' checked' : ''; ?> type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_1" value="then">
                                        <label class="radio-custom-label" for="updowngrade_remove_server_1"><?php echo __("admin/products/shared-server-updowngrade-settings-1",[
                                                '{input}' => '<input type="text" name="updowngrade_remove_server_day" class="yuzde10" value="'.(isset($updowngrade_remove_server_day) ? $updowngrade_remove_server_day : '').'">',
                                            ]); ?></label>
                                    </div>
                                    <div class="clear"></div>

                                    <div style="margin-bottom: 5px;">
                                        <input<?php echo $updowngrade_remove_server == "now" ? ' checked' : ''; ?> type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_2" value="now">
                                        <label class="radio-custom-label" for="updowngrade_remove_server_2"><?php echo __("admin/products/shared-server-updowngrade-settings-2"); ?></label>
                                    </div>
                                    <div class="clear"></div>

                                    <div style="margin-bottom: 5px;">
                                        <input<?php echo $updowngrade_remove_server == "none" ? ' checked' : ''; ?> type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_3" value="none">
                                        <label class="radio-custom-label" for="updowngrade_remove_server_3"><?php echo __("admin/products/shared-server-updowngrade-settings-3"); ?></label>
                                    </div>

                                    <div class="clear"></div>

                                </div>
                            </div>



                            <div class="formcon" id="checker-wrap"<?php echo $first_module["checker"] ? '' : 'style="display:none"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-info-check"); ?></div>
                                <div class="yuzde70">
                                    <a href="javascript:void(0);" id="testConnect" class="lbtn"><i class="fa fa-plug" aria-hidden="true"></i> <?php echo __("admin/products/add-hosting-shared-server-info-check-button"); ?></a>
                                </div>
                            </div>


                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/products/edit-shared-server-button"); ?></a>
                            </div>
                            <div class="clear"></div>


                        </form>

                    </div>

                </div><!-- detail tab content end -->

                <?php if(isset($import_support) && $import_support): ?>
                    <div id="settings-import" class="tabcontent">

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#listAllAccountsButton").click(function(){

                                    $(this).html('<i class="fa fa-cog loadingicon" aria-hidden="true"></i> <?php echo __("admin/products/hosting-shared-servers-import-accounts-loading")?>');
                                    window.location.href = set_GET("list","true");
                                });
                            });
                        </script>

                        <div class="adminpagecon">

                            <div class="clear"></div>

                            <div align="center" style="    width: 60%;    margin: auto;">
                                <a href="javascript:void(0);" id="listAllAccountsButton" class="gonderbtn yesilbtn"><?php echo __("admin/products/hosting-shared-servers-import-list-all-accounts"); ?></a>
                            </div>

                        </div>

                        <?php
                            if(isset($listAccounts)){

                            if($listAccounts){
                                $first_account  = current($listAccounts);
                                $non_domain     = isset($first_account["domain"]) && $first_account["domain"] ? false : true;
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        $('#listAccounts').DataTable({
                                            "columnDefs": [
                                                {
                                                    "targets": [0],
                                                    "visible":false,
                                                },
                                            ],
                                            "lengthMenu": [
                                                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                            ],
                                            responsive: true,
                                            "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                                        });

                                        $(".select-user").select2({
                                            placeholder: "<?php echo __("admin/invoices/create-select-user"); ?>",
                                            ajax: {
                                                url: '<?php echo $links["select-users.json"]; ?>',
                                                dataType: 'json',
                                                data: function (params) {
                                                    var query = {
                                                        search: params.term,
                                                        type: 'public',
                                                    };
                                                    return query;
                                                }
                                            }
                                        });

                                        $(".select2-element").select2({
                                            placeholder: "<?php echo ___("needs/select-your"); ?>",
                                        });

                                        $("#importForm_submit").on("click",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                result:"importForm_handler",
                                            });
                                        });

                                    });

                                    function importForm_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.for != undefined && solve.for != ''){
                                                        $("#importForm "+solve.for).focus();
                                                        $("#importForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                        $("#importForm "+solve.for).change(function(){
                                                            $(this).removeAttr("style");
                                                        });
                                                    }
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    alert_success(solve.message,{timer:2000});
                                                    setTimeout(function(){
                                                        window.location.href = window.location.href;
                                                    },2000);
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }

                                    function selected_product(elem,username){
                                        var value = $(elem).val();

                                        var selecet_item = $("select[name='accounts["+username+"][period]']");
                                        selecet_item.html('<option value="0"><?php echo ___("needs/select-your"); ?></option>')

                                        if(value != 0){
                                            var periods = $("option:selected",elem).data("periods");
                                            $(periods).each(function (k, v){
                                                selecet_item.append('<option value="'+k+'">'+v+'</option>');
                                            });
                                        }

                                    }
                                </script>
                                <div class="clear"></div>
                            <br>
                                <div align="center">
                                    <h5><?php echo __("admin/products/hosting-shared-servers-import-accounts-total",['{total}' => '<strong>'.sizeof($listAccounts).'</strong>']); ?></h5>
                                </div>

                                <form action="<?php echo $links["controller"]; ?>" method="post" id="importForm">
                                    <input type="hidden" name="operation" value="hosting_shared_server_import">
                                    <input type="hidden" name="id" value="<?php echo $server["id"]; ?>">
                                    <table width="100%" id="listAccounts" class="table table-striped table-borderedx table-condensed nowrap">
                                        <thead style="background:#ebebeb;">
                                        <tr>
                                            <th align="center" data-orderable="false">#</th>
                                            <?php if(!$non_domain): ?>
                                                <th align="left" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-domain"); ?></th>
                                            <?php endif; ?>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-username"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-user"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-product"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-start"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-end"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody align="center" style="border-top:none;">
                                        <?php
                                            foreach($listAccounts AS $i=>$row){
                                                ?>
                                                <tr<?php echo isset($row["order_data"]) ? ' style="background: #c2edc2;opacity: 0.7;    filter: alpha(opacity=70);"' : ''; ?>>
                                                    <td align="left"><?php echo $i; ?></td>
                                                    <?php if(!$non_domain): ?>
                                                        <td align="left"><?php echo $row["domain"]; ?></td>
                                                    <?php endif; ?>
                                                    <td align="center"><?php echo $row["username"]; ?></td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["user_data"])){
                                                                $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_data"]["id"]]);
                                                                $user_name           = Utility::short_text($row["user_data"]["full_name"],0,21,true);
                                                                $user_company_name   = Utility::short_text($row["user_data"]["company_name"],0,21,true);

                                                                $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_data"]["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_data"]["company_name"].'">'.$user_company_name.'</span>';
                                                                echo $user_detail;
                                                            }else{
                                                                ?>
                                                                <select class="width200 select-user" name="accounts[<?php echo $row["username"]; ?>][user_id]"></select>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["order_data"]))
                                                            {
                                                                $link = Controllers::$init->AdminCRLink("orders-2",["detail",$row["order_data"]["id"]]);
                                                                $amount = ___("needs/free-amount");
                                                                $period = NULL;
                                                                if($row["order_data"]["amount"]>0){
                                                                    $amount = Money::formatter_symbol($row["order_data"]["amount"],$row["order_data"]["amount_cid"]);
                                                                    if($row["order_data"]["period_time"]>1)
                                                                        $period = $row["order_data"]["period_time"]." ";
                                                                    $period .= ___("date/periods/".$row["order_data"]["period"]);
                                                                }
                                                                $show_period    = $amount;
                                                                if($period)
                                                                    $show_period .= " (".$period.")";
                                                                ?>
                                                                <a href="<?php echo $link; ?>" target="_blank"><strong><?php echo $row["order_data"]["name"]; ?> / <?php echo $show_period; ?></strong></a>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <select name="accounts[<?php echo $row["username"]; ?>][product_id]" class="width200 select2-element" onchange="selected_product(this,'<?php echo $row["username"]; ?>');">
                                                                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                                                                    <?php
                                                                        if($products){
                                                                            foreach($products AS $cat){
                                                                                $items  = $cat["items"];
                                                                                if($items){
                                                                                    ?>
                                                                                    <optgroup label="<?php echo $cat["title"]; ?>">
                                                                                        <?php
                                                                                            foreach ($items AS $item){
                                                                                                $periods = [];
                                                                                                foreach($item["price"] AS $price){
                                                                                                    $amount = ___("needs/free-amount");
                                                                                                    $period = NULL;
                                                                                                    if($price["amount"]>0){
                                                                                                        $amount = Money::formatter_symbol($price["amount"],$price["cid"]);
                                                                                                        if($price["time"]>1)
                                                                                                            $period .= $price["time"]." ";
                                                                                                        $period .= ___("date/periods/".$price["period"]);
                                                                                                        $name = $amount;
                                                                                                        if($period) $name .= " (".$period.")";
                                                                                                        $periods[] = $name;
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                                <option value="<?php echo $item["id"]; ?>" data-periods='<?php echo Utility::jencode($periods); ?>'><?php echo $item["title"]; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                        ?>
                                                                                    </optgroup>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <select name="accounts[<?php echo $row["username"]; ?>][period]" style="width:140px">
                                                                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                                                                </select>
                                                                <input type="hidden" name="accounts[<?php echo $row["username"]; ?>][domain]" value="<?php echo $row["domain"]; ?>">
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["order_data"])){
                                                                echo DateManager::format(Config::get("options/date-format"),$row["order_data"]["cdate"]);
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <input type="date" name="accounts[<?php echo $row["username"]; ?>][cdate]" value="<?php echo $row["cdate"] ? DateManager::format("Y-m-d",$row["cdate"]) : ''; ?>">
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["order_data"])){
                                                                echo DateManager::format(Config::get("options/date-format"),$row["order_data"]["duedate"]);
                                                            }
                                                            else{
                                                                ?>
                                                                <input type="date" name="accounts[<?php echo $row["username"]; ?>][duedate]" value="">
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>

                                    <div class="clear"></div>
                                    <div class="guncellebtn yuzde20" style="float: right;">
                                        <a href="javascript:void(0);" id="importForm_submit" class="gonderbtn mavibtn"><?php echo ___("needs/button-save"); ?></a>
                                    </div>
                                </form>

                            <?php


                                }else{
                            ?>
                                <div class="red-info">
                                    <div class="padding15">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <p><?php echo __("admin/products/hosting-shared-servers-import-no-account"); ?></p>
                                        <?php if(isset($module_error)): ?>
                                            <p><?php echo $module_error; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                                }
                                }
                                elseif(isset($list_vps)){

                                if($list_vps){
                            ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        $('#listAccounts').DataTable({
                                            "columnDefs": [
                                                {
                                                    "targets": [0],
                                                    "visible":false,
                                                },
                                            ],
                                            "lengthMenu": [
                                                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                            ],
                                            responsive: true,
                                            "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                                        });

                                        $(".select-user").select2({
                                            placeholder: "<?php echo __("admin/invoices/create-select-user"); ?>",
                                            ajax: {
                                                url: '<?php echo $links["select-users.json"]; ?>',
                                                dataType: 'json',
                                                data: function (params) {
                                                    var query = {
                                                        search: params.term,
                                                        type: 'public',
                                                    };
                                                    return query;
                                                }
                                            }
                                        });

                                        $(".select2-element").select2({
                                            placeholder: "<?php echo ___("needs/select-your"); ?>",
                                        });

                                        $("#importForm_submit").on("click",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                result:"importForm_handler",
                                            });
                                        });

                                    });

                                    function importForm_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.for != undefined && solve.for != ''){
                                                        $("#importForm "+solve.for).focus();
                                                        $("#importForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                        $("#importForm "+solve.for).change(function(){
                                                            $(this).removeAttr("style");
                                                        });
                                                    }
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    alert_success(solve.message,{timer:2000});
                                                    setTimeout(function(){
                                                        window.location.href = window.location.href;
                                                    },2000);
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }

                                    function selected_product(elem,name){
                                        var value = $(elem).val();

                                        var selecet_item = $("select[name='list["+name+"][period]']");
                                        selecet_item.html('<option value="0"><?php echo ___("needs/select-your"); ?></option>')

                                        if(value != 0){
                                            var periods = $("option:selected",elem).data("periods");
                                            $(periods).each(function (k, v){
                                                selecet_item.append('<option value="'+k+'">'+v+'</option>');
                                            });
                                        }

                                    }
                                </script>
                                <div class="clear"></div>
                            <br>
                                <div align="center">
                                    <h5><?php echo __("admin/products/hosting-shared-servers-import-accounts-total",['{total}' => '<strong>'.sizeof($list_vps).'</strong>']); ?></h5>
                                </div>

                                <form action="<?php echo $links["controller"]; ?>" method="post" id="importForm">
                                    <input type="hidden" name="type" value="server">
                                    <input type="hidden" name="operation" value="hosting_shared_server_import">
                                    <input type="hidden" name="id" value="<?php echo $server["id"]; ?>">
                                    <table width="100%" id="listAccounts" class="table table-striped table-borderedx table-condensed nowrap">
                                        <thead style="background:#ebebeb;">
                                        <tr>
                                            <th align="center" data-orderable="false">#</th>
                                            <th align="left" data-orderable="false">IP</th>
                                            <th align="center" data-orderable="false">Hostname</th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-user"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-product"); ?></th>
                                            <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-start"); ?> / <?php echo __("admin/products/hosting-shared-servers-import-accounts-end"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody align="center" style="border-top:none;">
                                        <?php
                                            $i = 0;
                                            foreach($list_vps AS $key=>$row){
                                                $i++;
                                                ?>
                                                <tr<?php echo isset($row["order_data"]) ? ' style="background: #c2edc2;opacity: 0.7;    filter: alpha(opacity=70);"' : ''; ?>>
                                                    <td align="left"><?php echo $i; ?></td>
                                                    <td align="left"><?php echo $row["ip"]; ?></td>
                                                    <td align="center"><?php echo $row["hostname"]; ?></td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["user_data"])){
                                                                $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_data"]["id"]]);
                                                                $user_name           = Utility::short_text($row["user_data"]["full_name"],0,21,true);
                                                                $user_company_name   = Utility::short_text($row["user_data"]["company_name"],0,21,true);

                                                                $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_data"]["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_data"]["company_name"].'">'.$user_company_name.'</span>';
                                                                echo $user_detail;
                                                            }else{
                                                                ?>
                                                                <select class="width200 select-user" name="list[<?php echo $key; ?>][user_id]"></select>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["order_data"])){
                                                                $link = Controllers::$init->AdminCRLink("orders-2",["detail",$row["order_data"]["id"]]);
                                                                $amount = ___("needs/free-amount");
                                                                $period = NULL;
                                                                if($row["order_data"]["amount"]>0){
                                                                    $amount = Money::formatter_symbol($row["order_data"]["amount"],$row["order_data"]["amount_cid"]);
                                                                    if($row["order_data"]["period_time"]>1)
                                                                        $period = $row["order_data"]["period_time"]." ";
                                                                    $period .= ___("date/periods/".$row["order_data"]["period"]);
                                                                }
                                                                $show_period    = $amount;
                                                                if($period)
                                                                    $show_period .= " (".$period.")";
                                                                ?>
                                                                <a href="<?php echo $link; ?>" target="_blank"><strong><?php echo $row["order_data"]["name"]; ?> / <?php echo $show_period; ?></strong></a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <select name="list[<?php echo $key; ?>][product_id]" class="width200 select2-element" onchange="selected_product(this,'<?php echo $key; ?>');">
                                                                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                                                                    <?php
                                                                        if($products){
                                                                            foreach($products AS $cat){
                                                                                $items  = $cat["items"];
                                                                                if($items){
                                                                                    ?>
                                                                                    <optgroup label="<?php echo $cat["title"]; ?>">
                                                                                        <?php
                                                                                            foreach ($items AS $item){
                                                                                                $periods = [];
                                                                                                foreach($item["price"] AS $price){
                                                                                                    $amount = ___("needs/free-amount");
                                                                                                    $period = NULL;
                                                                                                    if($price["amount"]>0){
                                                                                                        $amount = Money::formatter_symbol($price["amount"],$price["cid"]);
                                                                                                        if($price["time"]>1)
                                                                                                            $period .= $price["time"]." ";
                                                                                                        $period .= ___("date/periods/".$price["period"]);
                                                                                                        $name = $amount;
                                                                                                        if($period) $name .= " (".$period.")";
                                                                                                        $periods[] = $name;
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                                <option value="<?php echo $item["id"]; ?>" data-periods='<?php echo Utility::jencode($periods); ?>'><?php echo $item["title"]; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                        ?>
                                                                                    </optgroup>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <div class="clear"></div>
                                                                <select name="list[<?php echo $key; ?>][period]" style="width:140px">
                                                                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                                                                </select>
                                                                <input type="hidden" name="list[<?php echo $key; ?>][cdate]" value="<?php echo isset($row["cdate"]) ? $row["cdate"] : ''; ?>">
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                            if(isset($row["order_data"])){
                                                                echo DateManager::format(Config::get("options/date-format"),$row["order_data"]["cdate"]);
                                                            }else{
                                                                ?>
                                                                <input type="date" name="list[<?php echo $key; ?>][cdate]" value="<?php echo isset($row["cdate"]) ? $row["cdate"] : ''; ?>" style="width: 150px;">
                                                                <?php
                                                            }
                                                        ?>
                                                        <div class="clear"></div>
                                                        <?php
                                                            if(isset($row["order_data"])){
                                                                echo DateManager::format(Config::get("options/date-format"),$row["order_data"]["duedate"]);
                                                            }else{
                                                                ?>
                                                                <input type="date" name="list[<?php echo $key; ?>][duedate]" value="" style="width: 150px;">
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>

                                    <div class="clear"></div>
                                    <div class="guncellebtn yuzde20" style="float: right;">
                                        <a href="javascript:void(0);" id="importForm_submit" class="gonderbtn mavibtn"><?php echo ___("needs/button-save"); ?></a>
                                    </div>
                                </form>

                            <?php


                                }else{
                            ?>
                                <div class="red-info">
                                    <div class="padding15">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <p><?php echo __("admin/products/hosting-shared-servers-import-no-account"); ?></p>
                                        <?php if(isset($module_error)): ?>
                                            <p><?php echo $module_error; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            }
                        ?>

                    </div>
                <?php endif; ?>

            </div><!-- settings tab wrap content end -->


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>