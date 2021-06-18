<div class="stage2">
    <div class="logo"><img src="<?php echo $taddress; ?>images/logo2.svg" /></div>
    <div class="title"><?php echo $lang["stage5"]; ?></div>
    <div style="padding:25px;">


        <div class="installcomplete">

            <i class="fa fa-check-circle-o" aria-hidden="true"></i>


            <h2><strong><?php echo $lang["stage5-text8"]; ?></strong></h2>

            <h3><?php echo $lang["stage5-text7"]; ?></h3>

            <div class="siteinformation">
                    <div style="padding:15px;">

                        <div class="smalltitle"><?php echo $lang["stage3-text20"]; ?></div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo $lang["stage3-text23"]; ?></div>
                            <div class="yuzde50"><strong><?php echo isset($admin_email) && $admin_email ? $admin_email : 'info@example.com'; ?></strong></div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo $lang["stage3-text25"]; ?></div>
                            <div class="yuzde50"><strong><?php echo isset($admin_pass) && $admin_pass ? $admin_pass : 'admin123'; ?></strong></div>
                        </div>

                        <div class="formcon" style="border:none">
                             <a href="<?php echo $address."admin"; ?>" target="_blank" class="button"><strong><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $lang["stage5-text5"]; ?></strong></a>
                        </div>

  					<div class="clear"></div>
                    </div>
                </div>
           
           


            <div class="clear"></div>
            <span><?php echo $lang["stage5-text6"]; ?></span> </div>


        <div class="clear"></div>
    </div>
</div> 