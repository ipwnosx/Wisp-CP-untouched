<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG   = $module->lang;
    $CONFIG = $module->config;
    Helper::Load("Money");
?>
<script type="text/javascript">
function InternetX_open_tab(elem, tabName){
    var owner = "InternetX_tab";
    $("#"+owner+" .modules-tabs-content").css("display","none");
    $("#"+owner+" .modules-tabs .modules-tab-item").removeClass("active");
    $("#"+owner+"-"+tabName).css("display","block");
    $("#"+owner+" .modules-tabs .modules-tab-item[data-tab='"+tabName+"']").addClass("active");
}
</script>

<div id="InternetX_tab">
    <ul class="modules-tabs">
        <li><a href="javascript:InternetX_open_tab(this,'detail');" data-tab="detail" class="modules-tab-item active"><?php echo $LANG["tab-detail"]; ?></a></li>
        <li><a href="javascript:InternetX_open_tab(this,'import');" data-tab="import" class="modules-tab-item"><?php echo $LANG["tab-import"]; ?></a></li>
    </ul>

    <div id="InternetX_tab-detail" class="modules-tabs-content" style="display: block">

        <form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="InternetXSettings">
            <input type="hidden" name="operation" value="module_controller">
            <input type="hidden" name="module" value="InternetX">
            <input type="hidden" name="controller" value="settings">

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["serverHost"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="serverHost" value="<?php echo $CONFIG["settings"]["serverHost"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["serverHost"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["serverUsername"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="serverUsername" value="<?php echo $CONFIG["settings"]["serverUsername"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["serverUsername"]; ?></span>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["serverPassword"]; ?></div>
                <div class="yuzde70">
                    <input type="password" name="serverPassword" value="<?php echo $CONFIG["settings"]["serverPassword"] ? "*****" : ""; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["serverPassword"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["serverContext"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="serverContext" value="<?php echo $CONFIG["settings"]["serverContext"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["serverContext"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["nameServers"]; ?></div>
                <div class="yuzde70">
                    <textarea name="nameServers" cols="18" rows="3"><?php echo $CONFIG["settings"]["nameServers"]; ?></textarea>
                    <span class="kinfo"><?php echo $LANG["desc"]["nameServers"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["domainMX"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="domainMX" value="<?php echo $CONFIG["settings"]["domainMX"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["domainMX"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["domainIP"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="domainIP" value="<?php echo $CONFIG["settings"]["domainIP"]; ?>">
                    <span class="kinfo"><?php echo $LANG["desc"]["domainIP"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["adminContact"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["adminContact"] ? ' checked' : ''; ?> type="checkbox" name="adminContact" value="1" id="InternetX_adminContact" class="checkbox-custom">
                    <label class="checkbox-custom-label" for="InternetX_adminContact">
                        <span class="kinfo"><?php echo $LANG["desc"]["adminContact"]; ?></span>
                    </label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["test-mode"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["test-mode"] ? ' checked' : ''; ?> type="checkbox" name="test-mode" value="1" id="InternetX_test-mode" class="checkbox-custom">
                    <label class="checkbox-custom-label" for="InternetX_test-mode">
                        <span class="kinfo"><?php echo $LANG["desc"]["test-mode"]; ?></span>
                    </label>
                </div>
            </div>
            

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["fields"]["WHiddenAmount"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="whidden-amount" value="<?php echo Money::formatter($CONFIG["settings"]["whidden-amount"],$CONFIG["settings"]["whidden-currency"]); ?>" style="width: 100px;" onkeypress='return event.charCode==46  || event.charCode>= 48 &&event.charCode<= 57'>
                    <select name="whidden-currency" style="width: 150px;">
                        <?php
                            foreach(Money::getCurrencies($CONFIG["settings"]["whidden-currency"]) AS $currency){
                                ?>
                                <option<?php echo $currency["id"] == $CONFIG["settings"]["whidden-currency"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <span class="kinfo"><?php echo $LANG["desc"]["WHiddenAmount"]; ?></span>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/profit-rate-for-registrar-module"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="profit-rate" value="<?php echo Config::get("options/domain-profit-rate"); ?>" style="width: 50px;" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>
            </div>
            

            <div class="clear"></div>
            <br>

            <div style="float:left;" class="guncellebtn yuzde30"><a id="InternetX_testConnect" href="javascript:void(0);" class="lbtn"><i class="fa fa-plug" aria-hidden="true"></i> <?php echo $LANG["test-button"]; ?></a></div>

            <div style="float:right;" class="guncellebtn yuzde30"><a id="InternetX_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#InternetX_testConnect").click(function(){
                    $("#InternetXSettings input[name=controller]").val("test_connection");
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"InternetX_handler",
                    });
                });

                $("#InternetX_submit").click(function(){
                    $("#InternetXSettings input[name=controller]").val("settings");
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"InternetX_handler",
                    });
                });
            });

            function InternetX_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#InternetXSettings "+solve.for).focus();
                                $("#InternetXSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#InternetXSettings "+solve.for).change(function(){
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

    <div id="InternetX_tab-import" class="modules-tabs-content" style="display: none;">

        <div class="blue-info">
            <div class="padding15">
                <?php echo $LANG["import-note"]; ?>
            </div>
        </div>

        <script type="text/javascript">

            function InternetX_import_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#InternetXImport "+solve.for).focus();
                                $("#InternetXImport "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#InternetXImport "+solve.for).change(function(){
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

                $("#InternetX_import_submit").click(function(){
                    MioAjaxElement($(this),{
                        waiting_text:waiting_text,
                        progress_text:progress_text,
                        result:"InternetX_import_handler",
                    });
                });

                $('#InternetX_list_domains').DataTable({
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
        <form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="InternetXImport">
            <input type="hidden" name="operation" value="module_controller">
            <input type="hidden" name="module" value="InternetX">
            <input type="hidden" name="controller" value="import">

            <table width="100%" id="InternetX_list_domains" class="table table-striped table-borderedx table-condensed nowrap">
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
                    $list   = $module->domains();
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
                <a href="javascript:void(0);" id="InternetX_import_submit" class="gonderbtn mavibtn"><?php echo $LANG["import-button"]; ?></a>
            </div>

        </form>

    </div>
</div>