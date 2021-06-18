<div class="stage2">
    <div class="logo"><img src="https://www.wisecp.com/images/logo.svg"></div>
    <div class="title">v<?php echo file_get_contents(CORE_DIR."VERSION"); ?> <?php echo $lang["name"]; ?></div>
    <div style="padding:25px;">

        <div class="agreement">

            <h1><?php echo $lang["agreement"]; ?></h1>
            <div class="agreementinfo">
                <iframe src="https://www.wisecp.com/agreement/<?php echo $clang; ?>.html" style="width: 100%; height: 100%;" frameborder="0"></iframe>
            </div>


        </div>

        <div style="text-align:center;margin-top:25px;">

            <input type="checkbox" class="checkbox-custom" id="agreement" value="1">
            <label style="margin-right: 15px; font-size:15px;" class="checkbox-custom-label" for="agreement"><?php echo $lang["accept-agreement"]; ?></label>
            <div class="clear"></div>
            <div style="margin-top:20px;" class="stagebtn"><a class="disablebtn button" id="continue_button"><?php echo $lang["stage-text3"]; ?></a></div></div>

        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#agreement").change(function(){
            var checked = $(this).prop("checked");
            var button  = $("#continue_button");

            if(checked){
                button.removeClass("disablebtn");
                button.attr("href","?act=stage1");
            }else{
                button.addClass("disablebtn");
                button.removeAttr("href");
            }

        });
    });
</script>