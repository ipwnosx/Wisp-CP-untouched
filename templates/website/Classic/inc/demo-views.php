<?php
    if(DEMO_MODE){
        $theme_style_options    = Cookie::get("theme_style_options");
        $onlyPanel              = Cookie::get("onlyPanel");
        $thoptstat              = !$theme_style_options || $theme_style_options == "enable";
        $redirect_link           = $canonical_link;
        if(stristr($redirect_link,"?")) $redirect_link .= "&";
        else $redirect_link .= "?";
        ?>
        <script type="text/javascript">
            function change_theme_option_style(el){
                var stat = $(el).attr("data-status");

                if(stat === 'enable'){
                    $("#sselectorclosex").animate({"margin-right":"-285px"},500);
                    $(el).attr("data-status","disable");
                    setCookie("theme_style_options","disable",30);
                    $(".thopt-status-icon").removeClass("fa-chevron-up");
                    $(".thopt-status-icon").addClass("fa-chevron-down");
                }else{
                    $("#sselectorclosex").animate({"margin-right":"0px"},500);
                    $(el).attr("data-status","enable");
                    setCookie("theme_style_options","enable",30);

                    $(".thopt-status-icon").removeClass("fa-chevron-down");
                    $(".thopt-status-icon").addClass("fa-chevron-up");
                }

            }
        </script>
        <div class="style-selector" id="sselectorclosex" style="<?php echo $thoptstat ? '' : 'margin-right:-285px;';?>">
            <h1>Style Selector</h1>

            <label><span><?php echo __("website/index/theme-style"); ?></span>
                <select onchange="window.location = this.options[this.selectedIndex].value;">
                    <option value="<?php echo $redirect_link."cheader=1"; ?>"<?php echo $header_type == 1 ? ' selected' : ''; ?>>Agency Style</option>
                    <option value="<?php echo $redirect_link."cheader=2"; ?>"<?php echo $header_type == 2 ? ' selected' : ''; ?>>Corporate Style</option>
                </select>
            </label>

            <label><span><?php echo __("website/index/clientArea-style"); ?></span>
                <select onchange="window.location = this.options[this.selectedIndex].value;">
                    <option value="<?php echo $redirect_link."c_clientArea=1"; ?>"<?php echo $clientArea_type == 1 ? ' selected' : ''; ?>>WClient</option>
                    <option value="<?php echo $redirect_link."c_clientArea=2"; ?>"<?php echo $clientArea_type == 2 ? ' selected' : ''; ?>>Basic Style</option>
                </select>
            </label>

            <div class="clear"></div>
            <div id="selectorOnlyPanel">
                <strong><?php echo __("theme/tools-onlyPanel"); ?></strong>
                <input <?php echo $onlyPanel ? 'checked' : ''; ?> type="checkbox" id="only-panel" value="1" class="sitemio-checkbox" onchange="if($(this).prop('checked')) window.location.href = '<?php echo $redirect_link.'set_onlyPanel=1'; ?>'; else window.location.href = '<?php echo $redirect_link.'set_onlyPanel=0'; ?>';">
                <label class="sitemio-checkbox-label" for="only-panel"></label>
            </div>


            <a href="javascript:void 0;" onclick="change_theme_option_style(this);" data-status="<?php echo $thoptstat ? 'enable' : 'disable'; ?>" class="arrowbtn">
                <i class="thopt-status-icon fa fa-chevron-<?php echo $thoptstat ? 'up' : 'down'; ?>" aria-hidden="true"></i>
            </a>
        </div>
        <?php
    }