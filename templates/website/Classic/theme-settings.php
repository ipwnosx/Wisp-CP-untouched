<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $settings       = isset($theme["config"]["settings"]) ? $theme["config"]["settings"] : [];
    
    
    if(isset($theme["config"]["header-types"]) && $theme["config"]["header-types"]){
        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/settings/theme-header-type"); ?></div>
            <div class="yuzde70">

                <script type="text/javascript">
                    function Classic_change_header_type(elem){
                        var value   =  $(elem).val();
                        var checked = $(elem).prop("checked");
                        $(".header-type-active").css("display","none");
                        if(checked) $("#Classic_header_"+value+"_active").css("display","block");
                        $(".header-type-label img").removeAttr("id");
                        $("img",$(elem).next()).attr("id","activetimage");
                    }
                </script>

                <?php
                    foreach($theme["config"]["header-types"] AS $k=>$v){
                        $active = $settings["header-type"]==$k;
                        ?>
                        <input type="radio" class="radio-custom" name="header_type" value="<?php echo $k; ?>" id="Classic_header_<?php echo $k; ?>"<?php echo $active ? ' checked' : NULL; ?>>
                        <label class="radio-custom-label" style="margin-right: 10px;" for="Classic_header_<?php echo $k; ?>">
                            <?php echo $v["name"]; ?>
                        </label>
                        <?php
                    }
                ?>
            </div>
        </div>
        <?php
    }

    if(isset($theme["config"]["clientArea-types"]) && $theme["config"]["clientArea-types"]){
        ?>
        <div class="formcon" id="Classic_clientArea_Type_wrap">
            <div class="yuzde30"><?php echo __("admin/settings/clientArea-type"); ?></div>
            <div class="yuzde70">
                <?php
                    foreach($theme["config"]["clientArea-types"] AS $k=>$v){
                        $active = $settings["clientArea-type"]==$k;
                        ?>
                        <input type="radio" class="radio-custom" name="clientArea_type" value="<?php echo $k; ?>" id="Classic_clientArea_<?php echo $k; ?>"<?php echo $active ? ' checked' : NULL; ?>>
                        <label style="margin-right: 10px;" class="radio-custom-label" for="Classic_clientArea_<?php echo $k; ?>">
                            <?php echo $v["name"]; ?>
                        </label>
                        <?php
                    }
                ?>
            </div>
        </div>
        <?php
    }
?>
<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/settings/theme-colors"); ?></div>
    <div class="yuzde70">
        <div id="colorSelector">
            <div style="background-color: #0000ff"></div></div>

        <div class="jscolorpicker">

            <div class="formcon"> <span><?php echo __("admin/settings/main-color1"); ?></span>
                <input name="color1" class="jscolor" value="<?php echo $settings["color1"]; ?>">
            </div>

            <div class="clear"></div>

            <div class="formcon"><span><?php echo __("admin/settings/main-color2"); ?></span>
                <input name="color2" class="jscolor" value="<?php echo $settings["color2"]; ?>">
            </div>

            <div class="clear"></div>

            <div class="formcon"><span><?php echo __("admin/settings/text-color"); ?></span>
                <input name="text_color" class="jscolor" value="<?php echo $settings["text-color"]; ?>">
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>