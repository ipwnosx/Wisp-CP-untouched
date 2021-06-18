<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation = Admin::isPrivilege(['LANGUAGES_OPERATION']);
        $plugins    = ['dataTables','mio-icons'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var
            activate_api_code   = '',
            activate_api_id     = 0,
            table,
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';

        $(document).ready(function(){

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }, /*
                    {
                        "targets": [1,2,3,4,6,8],
                        "orderable": false
                    }*/
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function ChangeStatus(element){
            var status  = $(element).prop("checked");
            var key     = $(element).data("key");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"change_lang_status",status:status,key:key}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            if(status){
                                $("#row_"+key).removeClass("currency-inactive");
                            }else{
                                $("#row_"+key).addClass("currency-inactive");
                            }
                            alert_success(solve.message,{timer:2000});
                        }else if(solve.status == "error"){
                            if(solve.for != undefined && solve.for == "local"){
                                $(element).prop("checked",true);
                                alert_error(solve.message,{timer:5000});
                            }
                        }
                    }else
                        console.log(result);
                }
            });
        }

        function deleteLang(key,name){
            var content = "<?php echo __("admin/languages/list-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/languages/list-delete-modal-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete",key:key}
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
                                    close_modal("ConfirmModal");
                                    var elem  = $("#row_"+key);
                                    table.row(elem).remove().draw();
                                    setTimeout(function(){
                                        window.location.href = '<?php echo $links["controller"]; ?>';
                                    },2500);
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#delete_no").click(function(){
                close_modal("ConfirmModal");
            });
        }

        function Activate_Language(code,api_id,name)
        {
            if(code !== "apply")
            {
                var title       = "<?php echo __("admin/languages/api-text4"); ?>";
                title           = title.replace("{language}",name);
                open_modal('ActivateModal',{
                    title: title,
                });
                var translator_link = $("#"+code+"_translator_link").attr("href");

                $("#translator_link").attr("href",translator_link);
                activate_api_code   = code;
                activate_api_id     = api_id;
            }
            else
            {
                var request = MioAjax({
                    button_element:$("#ActivateBtn"),
                    waiting_text:waiting_text,
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {
                        operation   : "add_new_language",
                        api         : 1,
                        api_id      : activate_api_id,
                        api_code    : activate_api_code
                    },
                },true,true);
                request.done(function(result){
                    if(result !== '')
                    {
                        var solve = getJson(result);
                        if(solve !== false)
                        {
                            if(solve.status === "error")
                                swal(solve.message,'','error');
                            else if(solve.status === "successful")
                            {
                                swal(solve.message,'','success');
                                setTimeout(function(){
                                    window.location.href = '<?php echo $links["controller"]; ?>';
                                },2000);
                            }
                        }
                    }
                });
            }
        }
    </script>
</head>
<body>

<div id="ActivateModal" style="display: none;">
    <div class="padding20">
        <?php echo __("admin/languages/api-text3"); ?>
    </div>
    <div class="modal-foot-btn">
        <a href="javascript:void 0;" class="green lbtn" id="ActivateBtn" onclick="Activate_Language('apply');"><?php echo __("admin/languages/api-text2"); ?></a>
    </div>
</div>


<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p id="confirmModal_text"></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo __("admin/languages/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/languages/page-list"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding20">
                   <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p><?php echo __("admin/languages/list-description"); ?></p>
                </div>
            </div>

            <div class="blue-info">
                <div class="padding20">
                    <i class="fa fa-lightbulb-o" aria-hidden="true"></i>

                    <p><?php echo __("admin/languages/list-description2"); ?></p>

                </div>
            </div>

            <?php
                if(!is_array($list_api))
                {
                    ?>
                    <div class="red-info">
                        <div class="padding20">
                            <i class="fa fa-exclamation-triangle"></i>
                            <p><?php echo $list_api; ?></p>
                        </div>
                    </div>
                    <?php
                }
                else $list = array_merge($list,$list_api);
            ?>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/languages/list-table-country"); ?></th>
                    <th align="left"><?php echo __("admin/languages/list-table-name"); ?></th>
                    <th align="center"><?php echo __("admin/languages/list-table-country-code"); ?></th>
                    <th align="center"><?php echo __("admin/languages/list-table-phone-code"); ?></th>
                    <th align="center"><?php echo __("admin/languages/list-table-local"); ?></th>
                    <?php if($privOperation): ?>
                        <th align="center"><?php echo __("admin/languages/list-table-status"); ?></th>
                    <?php endif; ?>
                    <th align="center"></th>
                </tr>
                </thead>

                <tbody>
                <?php
                    $i=0;
                    $gcname = $functions["get_country_name"];
                    foreach(array_merge($list) AS $lang){
                        $i++;
                        $key        = $lang["key"];
                        $code       = $lang["code"];
                        $cc         = $lang["country-code"] ? $lang["country-code"] : '-';
                        $pc         = $lang["phone-code"] ? "+".$lang["phone-code"] : '-';
                        $flagc      = strtolower($cc);
                        $cname      = $gcname($lang["country-id"]);
                        $name       = $lang["name"];
                        $status     = $lang["status"];
                        $islocal    = $lang["local"];

                        if($cc == "-"){
                            $cname  = "Worldwide";
                            $flagc  = "en";
                        }
                        $api        = isset($lang["api"]) ? $lang["api"] : false;
                        $api_id     = isset($lang["api_id"]) ? $lang["api_id"] : false;


                        ?>
                        <tr id="row_<?php echo $key; ?>">
                            <td align="left" class="<?php echo $status ? '' : 'currency-inactive'; ?>"><?php echo $i; ?></td>
                            <td align="left" class="<?php echo $status ? '' : 'currency-inactive'; ?>">
                                <img src="<?php echo $sadress."assets/images/flags/".$flagc.".svg"; ?>" height="15" style="float: left;margin-top:5px;margin-right: 5px;height:15px;width: 18px;"> <?php echo $cname; ?>
                            </td>
                            <td align="left" class="<?php echo $status ? '' : 'currency-inactive'; ?>"><?php echo $name; ?></td>
                            <td align="center" class="<?php echo $status ? '' : 'currency-inactive'; ?>"><?php echo $cc; ?></td>
                            <td align="center" class="<?php echo $status ? '' : 'currency-inactive'; ?>"><?php echo $pc; ?></td>
                            <td align="center" class="<?php echo $status ? '' : 'currency-inactive'; ?>">
                                <?php if($islocal): ?>
                                <span style="font-size: 24px;color: #81c04e;"><i class="ion-android-checkmark-circle"></i></span>
                                <?php endif; ?>
                            </td>
                            <?php if($privOperation): ?>
                                <td align="center" class="<?php echo $api || $status ? '' : 'currency-inactive'; ?>">
                                    <?php
                                        if($api)
                                        {
                                            ?>
                                            <a id="<?php echo $key; ?>_translator_link" href="<?php echo $lang["detail"]; ?>" target="_blank" class="lbtn"><?php echo __("admin/languages/api-text1"); ?></a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <input<?php echo $status ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="lang_<?php echo $key; ?>_status" data-key="<?php echo $key; ?>" onchange="ChangeStatus(this);">
                                            <label style="float:none;display:inline-block;" for="lang_<?php echo $key; ?>_status" class="sitemio-checkbox-label"></label>
                                            <?php
                                        }
                                    ?>
                                </td>
                            <?php endif; ?>
                            <td align="center" class="<?php echo $api || $status ? '' : 'currency-inactive'; ?>">
                                <?php
                                    if($api)
                                    {
                                        ?>
                                        <a href="javascript:Activate_Language('<?php echo $key; ?>',<?php echo $api_id; ?>,'<?php echo $name; ?>');void 0;" class="lbtn green"><i class="fa fa-download"></i> <?php echo __("admin/languages/api-text2"); ?></a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <a href="<?php echo $links["edit"]; ?>?key=<?php echo $key; ?>" class="sbtn"><i class="fa fa-edit"></i></a>
                                        <?php if($privOperation && !$islocal) : ?>
                                        <a href="javascript:deleteLang('<?php echo $key; ?>','<?php echo $cname." (".$lang['name'].")"; ?>');void 0;" data-key="<?php echo $key; ?>" class="red sbtn"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
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


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>