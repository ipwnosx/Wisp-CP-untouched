<div align="center">
    <?php
        $data       = $module->get_form_data($links["successful-page"],$links["failed-page"]);
        $url        = $data["url"];
        $params     = $data["params"];
    ?>

    <div align="center">
        <div class="progresspayment">
        
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
       
        <br><h3 id="progressh3"><?php echo $module->lang["redirect-message"]; ?></h3>
        <h4>
            <div class='angrytext'>
                <strong><?php echo __("website/others/loader-text2"); ?></strong>
            </div>
        </h4>

    </div>
    </div>

    <script type="text/javascript">
        setTimeout(function(){
            $("#ShopierRedirectForm").submit();
        },2000);
    </script>
    <form action="<?php echo $url; ?>" method="post" id="ShopierRedirectForm">
        <?php
            if($params){
                foreach($params AS $k=>$v){
                    ?>
                    <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>">
                    <?php
                }
            }
        ?>
    </form>

    <?php if(isset($links["back"])){ ?>
        <div class="clear"></div>
        <a class="lbtn" href="<?php echo $links["back"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo $_LANG["turn-back"]; ?></a>
        <div class="clear"></div>
    <?php } ?>
</div>
<br>