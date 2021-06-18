<?php
    $__ip = $account_info["last_login_ip"];

    if(Admin::isPrivilege("TOOLS_ACTIONS"))
        $__ip = '<a href="'.Controllers::$init->AdminCRLink("tools-2",["actions","login-log"]).'?type=admin">'.$__ip.'</a>';

?>
<div id="wrapper">
    <span class="guvenliknotu"><?php echo __("admin/index/footer-security-note",['{date}' => $account_info["last_login_date"],'{ip}' => $__ip]); ?></span>
</div>

<div class="clear"></div>

<div class="footer">
    <div id="wrapper">
    	<span class="copyrightinfo">Copyright © <?php echo date("Y"); ?> All Rights Reserved.</span>
    	<div class="producer"><span>Powered by</span><div class="clearmob"></div>
    	<a target="_blank" href="https://www.wisecp.com"><img src="<?php echo $tadress; ?>images/footer-logo.svg?v=1.6"/></a></div>
    </div>
</div>

<?php if($h_contents = Hook::run("AdminAreaEndBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>