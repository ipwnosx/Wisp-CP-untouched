<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">

        $(document).ready(function(){

            var tab = _GET("lang");
            if (tab != '' && tab != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }


            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
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
        function change_status(el){
            if($(el).val() === 'unverified') $(el).next('.status-msg').css("display","inline-block");
            else $(el).next('.status-msg').css("display","none");

        }
    </script>
</head>
<body>
<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/users/page-detail-document-record",['{user_name}' => $user["full_name"]]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminpagecon">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                    <input type="hidden" name="operation" value="edit_document_record">

                    <div class="formcon">
                        <div class="yuzde30">Açıklama</div>
                        <div class="yuzde30">Değer</div>
                        <div class="yuzde40">Durum</div>
                    </div>

                    <?php
                        if(isset($records) && $records){
                            foreach($records AS $record){
                                $f_type = $record["field_type"];

                                ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo $record["field_name"]; ?></div>
                                    <div class="yuzde30">
                                        <?php
                                            $value      = $record["field_value"];
                                            $value_data = Utility::jdecode($value,true);

                                            if($f_type == "textarea"){
                                                echo Filter::link_convert(nl2br($value),true);
                                            }
                                            elseif($f_type == "checkbox"){
                                                echo implode(",",$value_data);
                                            }
                                            elseif($f_type == "file"){
                                                $download_link = Utility::link_determiner($value_data["file_path"],RESOURCE_DIR."uploads".DS."attachments".DS,false);
                                                ?>
                                                <a data-balloon-pos="up" data-balloon="<?php echo $value_data["file_name"]; ?>" class="lbtn blue" href="<?php echo $download_link; ?>" target="_blank"><i class="fa fa-download"></i> <?php echo __("admin/users/document-button-download"); ?></a>
                                                <?php
                                            }
                                            else
                                                echo $value;
                                        ?>
                                    </div>
                                    <div class="yuzde40">
                                       <select name="records[<?php echo $record["id"]; ?>][status]" onchange="change_status(this);" style="width: 30%;">
                                           <?php
                                               foreach(['awaiting','verified','unverified'] AS $row){
                                                   ?>
                                                   <option<?php echo $record['status'] == $row ? ' selected' : ''; ?> value="<?php echo $row; ?>"><?php echo __("admin/users/document-record-status-".$row); ?></option>
                                                   <?php
                                               }
                                           ?>
                                       </select>
                                        <input type="text" name="records[<?php echo $record["id"]; ?>][status_msg]" class="status-msg" style="width:60%;<?php echo $record["status"] == 'unverified' ? '' : 'display: none;'; ?>" value="<?php echo $record["status_msg"]; ?>" placeholder="<?php echo __("admin/users/document-record-status-msg-ex"); ?>">
                                    </div>
                                </div>
                                <?php

                            }
                        }
                    ?>



                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

            </div>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>