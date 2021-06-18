<!DOCTYPE html>
<html>
<head>
    <?php
        $accountConf = Admin::isPrivilege("ADMIN_CONFIGURE");
        $plugins    = ['isotope'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(function () {
            var $container = $('.privilegescheckbox');
            $container.isotope({
                itemSelector: '.privilegesselect'
            });
        });
        $(document).ready(function(){

            $("#selectAll").change(function(){
                var check   = $(this).prop("checked");
                $(".privilegescheckbox input[type=checkbox]").prop("checked",check);
            });

            $(".privilegescheckbox input[type=checkbox]").change(selectAllCheck);

            function selectAllCheck(){
                var remaining = $(".privilegescheckbox input[type=checkbox]:not(:checked)").length;
                if(remaining == 0)
                    $("#selectAll").prop("checked",true);
                else
                    $("#selectAll").prop("checked",false);
            }

            $(".privilegesselect input[type=checkbox]:not(.checkAll-group)").change(function(){
                var id  = $(this).attr("id");
                var exp = id.split("_");
                var gid = exp[0];

                var remaining = $("#group_content_"+gid+" input[type=checkbox]:not(:checked)").length;
                if(remaining == 0)
                    $("#group_"+gid).prop("checked",true);
                else
                    $("#group_"+gid).prop("checked",false);

                selectAllCheck();

            });


            $(".checkAll-group").change(function(){
                var id      = $(this).val();
                var check   = $(this).prop("checked");
                $("#group_content_"+id+" input[type=checkbox]").prop("checked",check);
                selectAllCheck();
            });


            $("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#submit1").click();
            });

            $("#submit1").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"submit1_handler",
                });
            });

        });

        function submit1_handler(result){
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
                        setTimeout(function(){
                            window.location.href = solve.redirect;
                        },2000);
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
                <h1><strong><?php echo __("admin/privileges/detail-page-name"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminuyedetay">
                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                    <input type="hidden" name="operation" value="edit">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/privileges/form-field-group-name"); ?></div>
                        <div class="yuzde70">
                            <input name="group_name" type="text" value="<?php echo $privilege["name"]; ?>">
                        </div>
                    </div>


                    <?php
                        $privilegesc    = Config::get("privileges");
                        $privilegescx   = NULL;
                        foreach($privilegesc AS $privlegec){
                            $privilegescx .= ",".implode(',',$privlegec);
                        }
                        $privilegescx   = ltrim($privilegescx,",");
                        $fullAll        = $privilegesx == $privilegescx;
                    ?>
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/privileges/form-field-privileges"); ?></div>



                        <br><br>
                        <div class="clear"></div>

                        <div class="privilegesselect" style="background:rgba(6,230,33,0.27)">
                            <div class="padding15">
                                <input id="selectAll" <?php echo $fullAll ? "checked " : NULL; ?>type="checkbox" class="checkbox-custom" value="" />
                                <label for="selectAll" class="checkbox-custom-label"> <strong><?php echo __("admin/privileges/form-field-selectAll"); ?></strong></label><br>
                            </div>  </div>

                        <div class="clear"></div>
                        <div class="privilegescheckbox">

                            <div class="clear"></div>


                            <?php
                                if($privilegesc){
                                    $i=0;
                                    foreach($privilegesc AS $k=>$v){
                                        $vtx = implode(",",$v);
                                        $all = false;
                                        if(strstr($privilegesx,$vtx)) $all = true;
                                        $i++;
                                        $name = __("admin/privileges/features/".$k);
                                        if(!$name) $name = $k;
                                        if(sizeof($v)<2){
                                            $name = __("admin/privileges/features/".$v[0]);
                                            if(!$name) $name = $v[0];
                                            if($name){
                                                ?>
                                                <div class="privilegesselect">
                                                    <div class="padding15">
                                                        <strong>
                                                            <input <?php echo in_array($v[0],$privilege["privileges"]) ? "checked " : NULL; ?>name="perms[]" id="single_<?php echo  $i; ?>" value="<?php echo $v[0]; ?>" type="checkbox" class="checkAll-group checkbox-custom" />
                                                            <label for="single_<?php echo $i; ?>" class="checkbox-custom-label"><?php echo $name; ?></label>
                                                        </strong>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }else{
                                            if($name){
                                                ?>
                                                <div class="privilegesselect">
                                                    <div class="padding15">
                                                        <strong  style="">
                                                            <input <?php echo $all ? 'checked ' : NULL; ?>id="group_<?php echo  $i; ?>" value="<?php echo $i; ?>" type="checkbox" class="checkAll-group checkbox-custom" />
                                                            <label for="group_<?php echo $i; ?>" class="checkbox-custom-label"><?php echo $name; ?> <i class="fa fa-caret-down"></i></label>
                                                        </strong><br>
                                                        <div id="group_content_<?php echo $i; ?>">
                                                            <?php
                                                                if(is_array($v)){
                                                                    $x = 0;
                                                                    foreach($v AS $va){
                                                                        $x++;
                                                                        $namex = __("admin/privileges/features/".$va);
                                                                        if(!$namex) $namex = $va;
                                                                        if($namex){
                                                                            ?>
                                                                            <input <?php echo in_array($va,$privilege["privileges"]) ? "checked " : NULL; ?>name="perms[]" value="<?php echo $va; ?>" id="<?php echo $i."_".$x; ?>" type="checkbox" class="checkbox-custom" />
                                                                            <label for="<?php echo $i."_".$x; ?>" class="checkbox-custom-label"><?php echo $namex; ?></label>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </div>

                                                    </div>

                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            ?>
                        </div>

                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="submit1" href="javascript:void(0);"><i class="fa fa-save"></i> <?php echo __("admin/privileges/edit-button"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>
            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>