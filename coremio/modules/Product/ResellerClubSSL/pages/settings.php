<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG   = $module->lang;
    $CONFIG = $module->config;
    Helper::Load("Money");
?>
<script type="text/javascript">
    function ResellerClubSSL_open_tab(elem, tabName){
        var owner = "ResellerClubSSL_tab";
        $("#"+owner+" .modules-tabs-content").css("display","none");
        $("#"+owner+" .modules-tabs .modules-tab-item").removeClass("active");
        $("#"+owner+"-"+tabName).css("display","block");
        $("#"+owner+" .modules-tabs .modules-tab-item[data-tab='"+tabName+"']").addClass("active");
    }
</script>

<div id="ResellerClubSSL_tab">
    <ul class="modules-tabs">
        <li><a href="javascript:ResellerClubSSL_open_tab(this,'detail');" data-tab="detail" class="modules-tab-item active"><?php echo $LANG["tab-detail"]; ?></a></li>
        <li><a href="javascript:ResellerClubSSL_open_tab(this,'import');" data-tab="import" class="modules-tab-item"><?php echo $LANG["tab-import"]; ?></a></li>
    </ul>

    <div id="ResellerClubSSL_tab-detail" class="modules-tabs-content" style="display: block">
        <form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="ResellerClubSSLSettings">
            <input type="hidden" name="operation" value="module_controller">
            <input type="hidden" name="module" value="ResellerClubSSL">
            <input type="hidden" name="controller" value="settings">

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["auth-userid"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="auth-userid" value="<?php echo $CONFIG["settings"]["auth-userid"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["auth-userid"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["api-key"]; ?></div>
                <div class="yuzde70">
                    <input type="password" name="api-key" value="<?php echo $CONFIG["settings"]["api-key"] ? "*****" : ""; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["api-key"]; ?></span>
                </div>
            </div>

            <div class="formcon" style="display: none">
                <div class="yuzde30"><?php echo $LANG["fields"]["test-mode"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["test-mode"] ? ' checked' : ''; ?> type="checkbox" name="test-mode" value="1" id="ResellerClubSSL_test-mode" class="checkbox-custom">
                    <label class="checkbox-custom-label" for="ResellerClubSSL_test-mode">
                        <span class="kinfo"><?php echo $LANG["desc"]["test-mode"]; ?></span>
                    </label>
                </div>
            </div>


            <div class="clear"></div>
            <br>

            <div style="float:left;" class="guncellebtn yuzde30"><a id="ResellerClubSSL_testConnect" href="javascript:void(0);" class="lbtn"><i class="fa fa-plug" aria-hidden="true"></i> <?php echo $LANG["test-button"]; ?></a></div>

            <div style="float:right;" class="guncellebtn yuzde30"><a id="ResellerClubSSL_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#ResellerClubSSL_testConnect").click(function(){
                    $("#ResellerClubSSLSettings input[name=controller]").val("test_connection");
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"ResellerClubSSL_handler",
                    });
                });

                $("#ResellerClubSSL_submit").click(function(){
                    $("#ResellerClubSSLSettings input[name=controller]").val("settings");
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"ResellerClubSSL_handler",
                    });
                });
            });

            function ResellerClubSSL_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#ResellerClubSSLSettings "+solve.for).focus();
                                $("#ResellerClubSSLSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#ResellerClubSSLSettings "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful")
                            alert_success(solve.message,{timer:2500});
                    }else
                        console.log(result);
                }
            }
        </script>
    </div>

    <div id="ResellerClubSSL_tab-import" class="modules-tabs-content" style="display: none;">

        <div class="blue-info">
            <div class="padding15">
                <?php echo $LANG["import-note"]; ?>
            </div>
        </div>

        <script type="text/javascript">

            function ResellerClubSSL_import_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#ResellerClubSSLImport "+solve.for).focus();
                                $("#ResellerClubSSLImport "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#ResellerClubSSLImport "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2500});
                            setTimeout(function(){
                                window.location.href = window.location.href;
                            },2500);
                        }
                    }else
                        console.log(result);
                }
            }
            $(document).ready(function(){

                $("#ResellerClubSSL_import_submit").click(function(){
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"ResellerClubSSL_import_handler",
                    });
                });

                $('#ResellerClubSSL_list_ssl').DataTable({
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
                        url: '<?php echo Controllers::$init->AdminCRLink("orders"); ?>?operation=select-users.json',
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

            });
        </script>
        <form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="ResellerClubSSLImport">
            <input type="hidden" name="operation" value="module_controller">
            <input type="hidden" name="module" value="ResellerClubSSL">
            <input type="hidden" name="controller" value="import">

            <table width="100%" id="ResellerClubSSL_list_ssl" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="center" data-orderable="false">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-domain"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-user"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-start"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/hosting-shared-servers-import-accounts-end"); ?></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;">
                <?php
                    $list   = $module->list_ssl();
                    $i = 0;
                    if($list){
                        foreach($list AS $row){
                            $i++;
                            ?>
                            <tr<?php echo isset($row["order_id"]) && $row["order_id"] ? ' style="background: #c2edc2;opacity: 0.7;    filter: alpha(opacity=70);"' : ''; ?>>
                                <td align="left"><?php echo $i; ?></td>
                                <td align="left"><?php echo $row["domain"]; ?></td>
                                <td align="center">
                                    <?php
                                        if(isset($row["user_data"]) && $row["user_data"]){
                                            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_data"]["id"]]);
                                            $user_name           = Utility::short_text($row["user_data"]["full_name"],0,21,true);
                                            $user_company_name   = Utility::short_text($row["user_data"]["company_name"],0,21,true);

                                            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_data"]["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_data"]["company_name"].'">'.$user_company_name.'</span>';
                                            echo $user_detail;
                                        }else{
                                            ?>
                                            <input type="hidden" name="data[<?php echo $row["domain"]; ?>][api_orderid]" value="<?php echo $row["api_orderid"]; ?>">
                                            <select class="width200 select-user" name="data[<?php echo $row["domain"]; ?>][user_id]"></select>
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php echo $row["creation_date"] ? DateManager::format(Config::get("options/date-format"),$row["creation_date"]) : '-'; ?>
                                </td>
                                <td align="center">
                                    <?php echo $row["end_date"] ? DateManager::format(Config::get("options/date-format"),$row["end_date"]) : '-'; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>

            <div class="clear"></div>
            <div class="guncellebtn yuzde20" style="float: right;">
                <a href="javascript:void(0);" id="ResellerClubSSL_import_submit" class="gonderbtn mavibtn"><?php echo $LANG["import-button"]; ?></a>
            </div>

        </form>

    </div>
</div>