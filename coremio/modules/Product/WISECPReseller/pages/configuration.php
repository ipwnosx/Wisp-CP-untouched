<?php if(!defined("CORE_FOLDER")) return false; ?>
<form action="<?php echo $area_link; ?>" method="post" id="configurationForm">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="<?php echo $m_name; ?>">
    <input type="hidden" name="controller" value="save">

    <div class="green-info">
        <div class="padding20">
            <i class="fa fa-info-circle"></i>
            <?php echo $lang["desc"]; ?>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $lang["status"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $config["status"] ? ' checked' : ''; ?> type="checkbox" name="status" value="1" id="status-active" class="sitemio-checkbox">
            <label class="sitemio-checkbox-label" for="status-active"></label>
            <span class="kinfo"><?php echo $lang["status-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $lang["key"]; ?></div>
        <div class="yuzde70">
            <input type="password" name="key" value="<?php echo $config["settings"]["key"] ? '*****' : ''; ?>">
            <div class="clear"></div>
            <span class="kinfo"><?php echo $lang["key-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $lang["support-addon"]; ?></div>
        <div class="yuzde70">
            <select name="support_addon_id">
                <option value="0"><?php echo ___("needs/select-your"); ?></option>
                <?php
                    if(isset($addons) && $addons)
                    {
                        foreach($addons AS $addon)
                        {
                            ?>
                            <option<?php echo isset($config["settings"]["support_addon_id"]) && $config["settings"]["support_addon_id"] == $addon["id"] ? ' selected' : ''; ?> value="<?php echo $addon["id"]; ?>"><?php echo $addon["category_name"]." / ".$addon["name"]; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
            <div class="clear"></div>
            <span class="kinfo"><?php echo $lang["support-addon-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $lang["balance"]; ?></div>
        <div class="yuzde70">
            <?php echo $config["settings"]["key"] ? $balance : $lang["error2"]; ?>
        </div>
    </div>


    <div class="clear"></div>
    <br>

    <div style="float:right;" class="guncellebtn yuzde30"><a id="configurationForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo ___("needs/button-save"); ?></a></div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#configurationForm_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"configurationForm_handler",
            });
        });
    });
    function configurationForm_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful")
                    alert_success(solve.message,{timer:2500});
            }else
                console.log(result);
        }
    }
</script>