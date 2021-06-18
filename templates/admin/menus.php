<?php
    function menu_listing($list=[],$children=false,$opt=[]){
        ?><ol class="dd-list"><?php
        echo EOL;

        foreach($list AS $row){
            echo EOL;
            ?>
            <li class="dd-item" data-id="<?php echo $row["id"]; ?>">
                <div class="dd-handle"><?php echo $row["title"]; ?></div>
                <div class="nestablebtns">
                    <a data-tooltip="<?php echo ___("needs/button-edit"); ?>" href="javascript:editMenu(<?php echo $row["id"]; ?>);"><i class="fa fa-pencil"></i></a>
                    <a data-tooltip="<?php echo ___("needs/button-delete"); ?>" href="javascript:deleteMenu(<?php echo $row["id"]; ?>);"><i class="fa fa-trash"></i></a>
                </div>
                <?php isset($row["children"]) ? menu_listing($row["children"],true,$opt) : false; ?>
            </li>
            <?php
            echo EOL;
        }

        ?></ol><?php
        echo EOL;
    }

    $bring  = Filter::GET("bring");

    if($bring){

        if($bring == "list"){
            $type       = Filter::init("GET/type","route");
            $status     = Filter::init("GET/status","letters");
            if(!($type == "header" || $type == "footer" || $type == "pages-sidebar" || $type == "cleintArea" || $type == "mobile"))
                return false;
            if(!($status == "active" || $status == "inactive")) return false;

            if($type == "header"){
                if($header_menus[$status]) menu_listing($header_menus[$status]);
            }

            if($type == "footer"){
                if($footer_menus[$status]) menu_listing($footer_menus[$status]);
            }

            if($type == "mobile"){
                if($mobile_menus[$status]) menu_listing($mobile_menus[$status]);
            }

            if($type == "clientArea"){
                if($clientArea_menus[$status]) menu_listing($clientArea_menus[$status]);
            }

            if($type == "pages-sidebar"){
                if($pages_sidebar[$status]) menu_listing($pages_sidebar[$status]);
            }

        }

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>

    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','jquery-nestable','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){

            var tab = _GET("type");
            if (tab != '' && tab != undefined) {
                $("#tab-type .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-type .tablinks:eq(0)").addClass("active");
                $("#tab-type .tabcontent:eq(0)").css("display", "block");
            }
            /*
            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } */
            //else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            //}

            $('#header-active-items,#header-inactive-items').nestable({
                group: "header",
                maxDepth:5,
            });

            $('#footer-active-items,#footer-inactive-items').nestable({
                group: "footer",
                maxDepth:2,
            });

            $('#pages-sidebar-active-items,#pages-sidebar-inactive-items').nestable({
                group: "pages-sidebar",
                maxDepth:1,
            });

            $('#clientArea-active-items,#clientArea-inactive-items').nestable({
                group: "clientArea",
                maxDepth:2,
            });

            $('#mobile-active-items,#mobile-inactive-items').nestable({
                group: "mobile",
                maxDepth:5,
            });

        });

        function addMenu(type){
            $("#manageMenu").attr("data-izimodal-title",'<?php echo htmlspecialchars(__("admin/manage-website/add-menu-title"),ENT_QUOTES); ?>');
            open_modal('manageMenu',{width:'1024px'});
            $("#manageMenu input[name=operation]").val('add_menu');
            $("#manageMenu input[name=type]").val(type);
            $("#manageMenu select[name=page] option").removeAttr("selected").trigger("change");
            $("#manageMenu .manage-menu-title").val('');
            $("#manageMenu .manage-menu-link").val('');
            $("#manageMenu .manage-menu-link-wrap").css("display","block");
            $("#manageMenuForm_submit").html('<?php echo ___("needs/button-create"); ?>');

            $(".onlyCa-formcon").css("display","none");
            $(".mega-formcon").css("display","none");
            $(".tag-formcon").css("display","none");
            $(".icon-formcon").css("display","none");

            if(type === "header" || type === "mobile"){
                $(".mega-formcon").css("display","block");
                $(".tag-formcon").css("display","block");
                $(".icon-formcon").css("display","block");
            }
            else if(type == "clientArea"){
                $(".onlyCa-formcon").css("display","block");
                $(".icon-formcon").css("display","block");
            }

        }

        function editMenu(id){

            $("#manageMenu").attr("data-izimodal-title",'<?php echo htmlspecialchars(__("admin/manage-website/edit-menu-title"),ENT_QUOTES); ?>');

            $("#manageMenu input[name=operation]").val('edit_menu');
            $("#manageMenu input[name=id]").val(id);
            $("#manageMenu input[name=type]").val('');
            $("#manageMenu .manage-menu-title").val('');
            $("#manageMenu .manage-menu-link").val('');
            $("#manageMenu .manage-menu-link-wrap").css("display","block");
            $("#manageMenuForm_submit").html('<?php echo ___("needs/button-update"); ?>');

            open_modal('manageMenu',{width:'1024px'});

            $.get('<?php echo $links["controller"]; ?>?operation=get_menu&id='+id,function(result) {
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        $("#manageMenu input[name=target]").prop("checked",(solve.target == 1));
                        $("#manageMenu select[name=page] option[value='"+solve.page+"']").attr("selected",true).trigger("change");

                        var values      = solve.values,key;
                        var keys        = Object.keys(values);
                        var size        = keys.length-1;
                        for(var i = 0; i<= size; i++) {
                            key = keys[i];
                            $("#manageMenu input[name='title["+key+"]']").val(values[key].title);
                            $("#manageMenu input[name='link["+key+"]']").val(values[key].link);
                            if(solve.page != 0) $("#manageMenu .manage-menu-link-wrap").css("display","none");
                            if(solve.parent == 0 && (solve.type === 'header' || solve.type === 'mobile') ){
                                $("#mega_"+key+"_content").css("display","block");
                                $("#tag_"+key+"_content").css("display","block");
                            }
                            else{
                                $("#mega_"+key+"_content").css("display","none");
                                $("#tag_"+key+"_content").css("display","none");
                            }

                            $("#mega_menu_active_"+key).prop('checked',false).trigger("change");
                            $("#mega_content_"+key+" textarea").val('');

                            $("#tag_active_"+key).prop('checked',false).trigger("change");
                            $("#tag_content_"+key+" input").val('');

                            if(values[key].mega !== undefined && values[key].mega !== ''){
                                $("#mega_menu_active_"+key).prop('checked',true).trigger("change");
                                $("#mega_content_"+key+" textarea").val(values[key].mega);
                            }

                            if(values[key].tag !== undefined){
                                $("#tag_active_"+key).prop('checked',true).trigger("change");
                                $("#tag_content_"+key+" input[name='tag["+key+"][name]']").val(values[key].tag.name);
                                $("#tag_content_"+key+" input[name='tag["+key+"][color]']").val(values[key].tag.color);
                            }

                            if(solve.type === 'mobile')
                            {
                                $("#onlyCa_"+key+"_content").css("display","none");
                                $("#icon_"+key+"_content").css("display","block");
                                $("#icon_"+key+"_content input[name=icon]").val(solve.icon);
                            }
                            else if(solve.type === 'clientArea')
                            {
                                $("#onlyCa_"+key+"_content").css("display","block");
                                $("#onlyCa_"+key+"_content input[name=onlyCa]").prop('checked',solve.onlyCa == 1);
                                $("#icon_"+key+"_content").css("display","block");
                                $("#icon_"+key+"_content input[name=icon]").val(solve.icon);
                            }
                            else{
                                $("#onlyCa_"+key+"_content").css("display","none");
                                $("#icon_"+key+"_content").css("display","none");
                            }

                        }

                    }else
                        console.log(result);
                }
            });

        }

        function deleteMenu(id,name){

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"delete_menu",id:id}
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
                                //alert_success(solve.message,{timer:3000});
                                //reload_menu_listing(solve.type,solve.stat);
                                window.location.href = window.location.href;
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });

        }

        function set_menu_ranking(type){
            var active_output   = $('#'+type+'-active-items').nestable('serialize');
            var inactive_output = $('#'+type+'-inactive-items').nestable('serialize');

            var request = MioAjax({
                button_element:$("#ButtonSave_"+type),
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"set_menu_ranking",
                    type:type,
                    active:active_output,
                    inactive:inactive_output,
                },
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
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
    </script>
</head>
<body>

<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p id="confirmModal_text"></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo ___("needs/yes"); ?></a>
    </div>
</div>

<div id="manageMenu" style="display:none;" data-izimodal-title="<?php echo __("admin/manage-website/add-menu-title"); ?>">
    <script type="text/javascript">
        $(document).ready(function(){
            $("#select-page").select2({'width':'100%'});
            $('#select-page-wrap .select2-container').slice(1).remove();

            $("#select-page").change(function(){

                if(this.options[this.selectedIndex].value == ''){
                    $('#manageMenu .manage-menu-link-wrap').css('display','block');
                } else{
                    var text    = this.options[this.selectedIndex].text;
                    text        = text.replace(/^-*|>/g, '');
                    text        = $.trim(text);

                    if($("#manageMenu input[name=operation]").val() == "add_menu")
                        $("#manageMenu .manage-menu-title").val(text);
                    else
                        $("#manageMenu .manage-menu-title").filter(function(){return !this.value;}).val(text);
                    $('#manageMenu .manage-menu-link-wrap').css('display','none');
                }

            });

        });
    </script>
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="manageMenuForm">
            <input type="hidden" name="operation" value="add_menu">
            <input type="hidden" name="type" value="header">
            <input type="hidden" name="id" value="0">

            <div id="tab-lang"><!-- tab wrap content start -->
                <ul class="tab">
                    <?php
                        foreach($lang_list AS $lang){
                            ?>
                            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','lang')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lang["key"]); ?></a></li>
                            <?php
                        }
                    ?>
                </ul>

                <?php
                    foreach($lang_list AS $lang) {
                        $lkey = $lang["key"];

                        ?>
                        <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                            <?php if($lang["local"]): ?>
                                <div class="formcon onlyCa-formcon" id="onlyCa_<?php echo $lkey; ?>_content">
                                    <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-onlyCa"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" name="onlyCa" value="1" class="sitemio-checkbox" id="onlyCa">
                                        <label class="sitemio-checkbox-label" for="onlyCa"></label>
                                        <span class="kinfo"><?php echo __("admin/manage-website/create-menus-onlyCa-info"); ?></span>
                                    </div>
                                </div>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-page"); ?></div>
                                    <div class="yuzde70" id="select-page-wrap">
                                        <select id="select-page" name="page">
                                        <option value=""><?php echo __("admin/manage-website/create-menus-select-page"); ?></option>
                                        <?php
                                            if(isset($select_pages) && $select_pages){
                                                foreach($select_pages AS $key=>$value){
                                                    ?>
                                                    <option<?php echo stristr($key,"disabled") ? ' disabled' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/manage-website/create-menus-page-info"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon icon-formcon" id="icon_<?php echo $lkey; ?>_content">
                                    <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-icon"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="icon" placeholder="fa fa-icon">
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo ___("needs/select-icon-help"); ?></span>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-title"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" class="manage-menu-title" name="title[<?php echo $lkey; ?>]">
                                </div>
                            </div>

                            <div class="formcon manage-menu-link-wrap">
                                <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-link"); ?></div>
                                <div class="yuzde70">
                                    <input class="manage-menu-link" name="link[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/manage-website/create-menus-link-info"); ?>">
                                    <span class="kinfo"><?php echo __("admin/manage-website/create-menus-link-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon mega-formcon" id="mega_<?php echo $lkey; ?>_content">
                                <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-mega"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" class="checkbox-custom" id="mega_menu_active_<?php echo $lkey; ?>" onchange="if($(this).prop('checked')) $('#mega_content_<?php echo $lkey; ?>').css('display','block'); else{ $('#mega_content_<?php echo $lkey; ?>').css('display','none'); $('#mega_content_<?php echo $lkey; ?> textarea').val('');}">
                                    <label class="checkbox-custom-label" for="mega_menu_active_<?php echo $lkey; ?>"></label>

                                    <div id="mega_content_<?php echo $lkey;?>" style="display: none;">
                                        <textarea name="mega[<?php echo $lkey; ?>]" rows="5"></textarea>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/manage-website/create-menus-mega-desc"); ?></span>
                                    </div>

                                </div>
                            </div>

                            <div class="formcon tag-formcon" id="tag_<?php echo $lkey; ?>_content">
                                <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-tag"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" class="checkbox-custom" id="tag_active_<?php echo $lkey; ?>" onchange="if($(this).prop('checked')) $('#tag_content_<?php echo $lkey; ?>').css('display','block'); else{ $('#tag_content_<?php echo $lkey; ?>').css('display','none'); $('#tag_content_<?php echo $lkey; ?> input').val('');}">
                                    <label class="checkbox-custom-label" for="tag_active_<?php echo $lkey; ?>">
                                        <span class="kinfo"><?php echo __("admin/manage-website/create-menus-tag-desc"); ?></span>
                                    </label>

                                    <div id="tag_content_<?php echo $lkey;?>" style="display: none;">

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-tag-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="tag[<?php echo $lkey; ?>][name]" value="">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-tag-color"); ?></div>
                                            <div class="yuzde70">
                                                <input placeholder="<?php echo __("admin/manage-website/create-menus-tag-color-ex"); ?>" type="text" name="tag[<?php echo $lkey; ?>][color]" value="">
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>

                            <?php if($lang["local"]): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-target"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="target" name="target" value="1">
                                        <label class="sitemio-checkbox-label" for="target"></label>
                                        <span class="kinfo"><?php echo __("admin/manage-website/create-menus-target-info"); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <div class="clear"></div>
                        </div>
                        <?php
                    }
                ?>
            </div><!-- tab wrap content end -->

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="manageMenuForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
            </div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#manageMenuForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        result:"manageMenuForm_handler",
                    });
                });
            });

            function manageMenuForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#manageMenuForm "+solve.for).focus();
                                $("#manageMenuForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#manageMenuForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){

                            //alert_success(solve.message,{timer:2000});

                            //reload_menu_listing(solve.type,"inactive");

                            window.location.href = window.location.href;
                        }
                    }else
                        console.log(result);
                }
            }

            function reload_menu_listing(type,status){
                var active_content      = $("#"+type+"-active-items");
                var inactive_content    = $("#"+type+"-inactive-items");

                if(status == "active") active_content.html('<div class="spinner"></div>');
                if(status == "inactive") inactive_content.html('<div class="spinner"></div>');

                if(status == "active")
                    $.get("<?php echo $links["controller"]; ?>?bring=list&type="+type+"&status=active",function(data){
                        active_content.html(data);
                        active_content.nestable('destroy');
                        active_content.nestable('init');

                        inactive_content.nestable('destroy');
                        inactive_content.nestable('init');

                    });

                if(status == "inactive")
                    $.get("<?php echo $links["controller"]; ?>?bring=list&type="+type+"&status=inactive",function(data){
                        inactive_content.html(data);
                        inactive_content.nestable('destroy');
                        inactive_content.nestable('init');

                        active_content.nestable('destroy');
                        active_content.nestable('init');
                    });
            }
        </script>

        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/manage-website/page-menus"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="menumanage">


                <div id="tab-type"><!-- tab wrap content start -->

                    <ul class="tab">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'header','type')" data-tab="header"><?php echo __("admin/manage-website/menus-header"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'footer','type')" data-tab="footer"><?php echo __("admin/manage-website/menus-footer"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'mobile','type')" data-tab="mobile"><?php echo __("admin/manage-website/menus-mobile"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'pages-sidebar','type')" data-tab="pages-sidebar"><?php echo __("admin/manage-website/menus-pages-sidebar"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'clientArea','type')" data-tab="clientArea"><?php echo __("admin/manage-website/menus-clientArea"); ?></a></li>

                    </ul>

                    <div id="type-header" class="tabcontent">

                        <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/manage-website/menus-header-info"); ?></p>
                                </div>
                            </div>

                            <div class="leftmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-active-headings"); ?></h5>
                                <div id="header-list-active">

                                    <div class="dd" id="header-active-items">
                                        <?php
                                            if($header_menus["active"]) menu_listing($header_menus["active"]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup">

                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-inactive-headings"); ?></h5>

                                <div id="header-list-inactive">
                                    <div class="dd" id="header-inactive-items">
                                        <?php
                                            if($header_menus["inactive"]) menu_listing($header_menus["inactive"]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup" id="rightmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-add-new-menu"); ?></h5>

                                <div class="menuedit" id="menuedit5">
                                    <a href="javascript:addMenu('header');" class="lbtn"><?php echo __("admin/manage-website/button-add-item"); ?></a>
                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div style="float: right;" class="guncellebtn yuzde30">
                                <a href="javascript:set_menu_ranking('header');" id="ButtonSave_header" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div><!-- tab content end -->

                    <div id="type-footer" class="tabcontent">

                        <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/manage-website/menus-footer-info"); ?></p>
                                </div>
                            </div>

                            <div class="leftmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-active-headings"); ?></h5>
                                <div id="footer-list-active">

                                    <div class="dd" id="footer-active-items">
                                        <?php
                                            if($footer_menus["active"]) menu_listing($footer_menus["active"]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup">

                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-inactive-headings"); ?></h5>

                                <div id="footer-list-inactive">
                                    <div class="dd" id="footer-inactive-items">
                                        <?php
                                            if($footer_menus["inactive"]) menu_listing($footer_menus["inactive"]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup" id="rightmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-add-new-menu"); ?></h5>

                                <div class="menuedit" id="menuedit5">
                                    <a href="javascript:addMenu('footer');" class="lbtn"><?php echo __("admin/manage-website/button-add-item"); ?></a>
                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div style="float: right;" class="guncellebtn yuzde30">
                                <a href="javascript:set_menu_ranking('footer');" id="ButtonSave_footer" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div><!-- tab content end -->

                    <div id="type-mobile" class="tabcontent">

                        <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/manage-website/menus-mobile-info"); ?></p>
                                </div>
                            </div>

                            <div class="leftmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-active-headings"); ?></h5>
                                <div id="mobile-list-active">

                                    <div class="dd" id="mobile-active-items">
                                        <?php
                                            if($mobile_menus["active"]) menu_listing($mobile_menus["active"]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup">

                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-inactive-headings"); ?></h5>

                                <div id="mobile-list-inactive">
                                    <div class="dd" id="mobile-inactive-items">
                                        <?php
                                            if($mobile_menus["inactive"]) menu_listing($mobile_menus["inactive"]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup" id="rightmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-add-new-menu"); ?></h5>

                                <div class="menuedit" id="menuedit5">
                                    <a href="javascript:addMenu('mobile');" class="lbtn"><?php echo __("admin/manage-website/button-add-item"); ?></a>
                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div style="float: right;" class="guncellebtn yuzde30">
                                <a href="javascript:set_menu_ranking('mobile');" id="ButtonSave_mobile" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div><!-- tab content end -->

                    <div id="type-pages-sidebar" class="tabcontent">

                        <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/manage-website/menus-pages-sidebar-info"); ?></p>
                                </div>
                            </div>

                            <div class="leftmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-active-headings"); ?></h5>
                                <div id="pages-sidebar-list-active">

                                    <div class="dd" id="pages-sidebar-active-items">
                                        <?php
                                            if($pages_sidebar["active"]) menu_listing($pages_sidebar["active"]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup">

                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-inactive-headings"); ?></h5>

                                <div id="pages-sidebar-list-inactive">
                                    <div class="dd" id="pages-sidebar-inactive-items">
                                        <?php
                                            if($pages_sidebar["inactive"]) menu_listing($pages_sidebar["inactive"]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup" id="rightmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-add-new-menu"); ?></h5>

                                <div class="menuedit" id="menuedit5">
                                    <a href="javascript:addMenu('pages-sidebar');" class="lbtn"><?php echo __("admin/manage-website/button-add-item"); ?></a>
                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div style="float: right;" class="guncellebtn yuzde30">
                                <a href="javascript:set_menu_ranking('pages-sidebar');" id="ButtonSave_pages-sidebar" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
                            </div>

                            <div class="clear"></div>

                        </div>

                        <div class="clear"></div>

                    </div><!-- tab content end -->

                    <div id="type-clientArea" class="tabcontent">

                        <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/manage-website/menus-clientArea-info"); ?></p>
                                </div>
                            </div>

                            <div class="leftmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-active-headings"); ?></h5>
                                <div id="clientArea-list-active">

                                    <div class="dd" id="clientArea-active-items">
                                        <?php
                                            if($clientArea_menus["active"]) menu_listing($clientArea_menus["active"]);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup">

                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-inactive-headings"); ?></h5>

                                <div id="clientArea-list-inactive">
                                    <div class="dd" id="clientArea-inactive-items">
                                        <?php
                                            if($clientArea_menus["inactive"]) menu_listing($clientArea_menus["inactive"]);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="leftmenucon stickmenugroup" id="rightmenucon">
                                <h5 class="menublocktitle"><?php echo __("admin/manage-website/menus-add-new-menu"); ?></h5>

                                <div class="menuedit" id="menuedit5">
                                    <a href="javascript:addMenu('clientArea');" class="lbtn"><?php echo __("admin/manage-website/button-add-item"); ?></a>
                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="clear"></div>

                            <div style="float: right;" class="guncellebtn yuzde30">
                                <a href="javascript:set_menu_ranking('clientArea');" id="ButtonSave_clientArea" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div><!-- tab content end -->

                </div><!-- tab wrap content end -->

            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>