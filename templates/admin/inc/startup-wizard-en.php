<?php
    if(isset($is_dashboard) && $is_dashboard && $new_established && !$new_established_c):
        ?>
        <!-- WBOT START -->
        <div id="wbot-startup-wizard-welcome" style="display: none;">
            <div class="padding20">
                <div class="wbot-startup-wizard">

                    <div class="wbot-startup-wizard-con">
                        <img src="<?php echo Utility::image_link_determiner("templates/admin/images/wbot-startup-wizard.svg"); ?>?v=1.6" width="250" height="auto">
                        <div class="wbot-comment-triangle"></div>
                        <div class="wbot-comment" id="typewriter"></div>
                    </div>

                </div>
            </div>
        </div>
        <!-- WBOT END -->

        <script type="text/javascript">
            open_modal('wbot-startup-wizard-welcome',{width:'500px'});

            const instance = new Typewriter('#typewriter', {
                loop: false,
                delay: 10
            });
            instance
                .typeString('Hello ')
                .typeString('<STRONG>Owner!</STRONG>')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('I am ')
                .typeString('<STRONG>WBOT...</STRONG>')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('I am here to assist you...')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('I will always assist you in configuring and managing your automation in the best way possible.')
                .pauseFor(2000)
                .typeString('<a style="display: block;margin-top:20px;width: 200px;text-align: center;" href="javascript:open_startup_wizard();void 0;" class="green lbtn">Let\'s Start!</a>')
                .pauseFor(2000)
                .typeString('<span style="margin-top: 21px;font-size:16px;float: left;width:100%;border-bottom:1px solid #eee;padding-bottom:15px;">If you don\'t have time for this yet, you can always reach me again at "Help > Start with WBOT"</span>')
                .pauseFor(2000)
                .typeString('<span style="margin-top: 14px;font-size:16px;float: left;width:100%;border-bottom:1px solid #eee;padding-bottom:15px;">If you don\'t want to see this window again, you can click the button below.</span>')
                .pauseFor(1000)
                .typeString('<a class="lbtn" href="javascript:dont_show_wizard(); void 0" style="margin-top: 21px;font-size:14px;margin-bottom: 25px;float: left;">Don\'t Show This Again</a>')
                .start();
        </script>

    <?php
    endif;
?>
<div id="wbot-startup-wizard-stages" style="display: none;">
    <div class="wbot-startup-wizard">

        <div class="startup_wizard-stages">


            <div id="tab-wbot-startup-wizard-stage">
                <input type="hidden" id="wizard_stage" value="1">

                <div id="wbot-startup-wizard-stage-1" class="wizard-tabcontent">
                    <div class="padding20">

                        <div class="wbot-wizard-welcome">
                            <img src="<?php echo Utility::image_link_determiner("templates/admin/images/wbot-startup-wizard2.svg"); ?>" width="" height="auto">
                            <h1 style="float: left;margin-top: 25px;"><strong>Hello</strong> Again!</h1>
                        </div>

                        <div class="clear"></div>
                        <div class="line"></div>
                        <h4><strong>I will provide you with useful information and direct you to the relevant sections so that you can easily complete the required settings.</strong></h4>
                        <div class="line"></div>
                        <h5>All these are the basic adjustments required for your automation to work smoothly.</h5>
                        <div class="line"></div>
                        <h5>If you don't have time for this yet, you can always reach me again at "Help > Start with WBOT"</h5>

                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-2" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">General Settings</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>"General Settings" is the section where you can configure basic information, SEO settings and advanced settings of your system.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>It is accessed via "<strong>Admin Area > Settings > General</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>General Settings</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("settings"); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to General Settings</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-3" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Automation Settings</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Automation settings are the section where the tasks that should be executed automatically by the system are configured. It is absolutely necessary to configure the cronjob settings for the execution of many tasks such as creating invoices, reminders, suspending, deleting services, etc.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>It is accessed via "<strong>Admin Area > Settings > Automation</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Automation Settings</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about automation settings by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("automation"); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Automation Settings</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kb/cronjob-automation"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-4" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Payment Settings</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Payment Settings is the section where payment methods are set up and activated so that you can collect payments from your customers. There are many payment gateway modules on WISECP as standard. You can activate any of these and use them to collect payments.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>It is accessed via "<strong>Admin Area > Settings > Billing > Payment Gateways</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Payment Settings</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about Payment Settings by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("modules",["payment"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Payment Settings</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kbc/payment-gateways-docs"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-5" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">SMTP & Notifications</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>It is necessary to configure the SMTP settings in order to automatically send systematic notifications, payment notifications, reminders, service activation messages, etc.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>It is accessed via "<strong>Admin Area > Settings > Mail</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Mail Settings</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about Mail Settings by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("modules",["mail"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Mail Settings</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kb/smtp-configuration"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-6" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Hosting Settings</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Complete your settings to define your shared servers in the system, automate hosting and server service sales, automatic service activation, etc.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>You can define your shared servers to the system via "<strong>Admin Area > Services > Hosting Management > Server Settings</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Shared Server Settings</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about Shared Server Settings by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products-2",["hosting","shared-servers"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Shared Server Settings</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kb/shared-server-settings"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-7" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Domain Settings</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Complete your settings to provide domain name registration services, transfer existing domain names to the system, manage domain extensions, etc.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>You can manage extensions via "<strong>Admin Area > Services > Domain Name Registration > Extensions and Prices</strong>"</p>
                        <p>You can make your domain name registrar settings via "<strong>Admin Area > Services > Domain Name Registration > Domain Name Registrars</strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Extensions and Prices</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about Domain Name Management by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products",["domain"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Extensions and Prices</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kb/domain-name-service-management"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-8" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Software Licensing</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>You can add your software products to your system as a product, obtain license control codes, and provide sales and management of your software products.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>You can define your shared servers to the system via "<strong>Admin Area > Services > Software Services </strong>"</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>By clicking the button below, you can view the "<strong>Software Services</strong>" section in the "<strong>New Tab</strong>" and make the necessary adjustments.</p>  <p>You can access the help documents about Software Services by clicking the "<strong>Documentation</strong>" button below.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products",["software"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Go to Software Services</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/en/kbc/software"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Documentation</a>
                    </div>
                </div>

                <ul class="wizard-tab">
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="1" onclick="wizard_tab(this, '1');"><i class="fa fa-info" aria-hidden="true"></i>Getting Started</a></li>

                    <li><a href="javascript:void(0)" class="tablinks" data-tab="2" onclick="wizard_tab(this, '2');"><i class="fa fa-cog" aria-hidden="true"></i>General Settings</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="3" onclick="wizard_tab(this, '3');"><i class="fa fa-cogs" aria-hidden="true"></i>Automation Settings</a></li>
                    <li><a href="javascript:void(0)" class="tablinks"  data-tab="4" onclick="wizard_tab(this, '4');"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>Payment Settings</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="5" onclick="wizard_tab(this, '5');"><i class="fa fa-envelope" aria-hidden="true"></i>SMTP & Notifications</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="6" onclick="wizard_tab(this, '6');"><i class="fa fa-server" aria-hidden="true"></i>Hosting Settings</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="7" onclick="wizard_tab(this, '7');"><i class="fa fa-globe" aria-hidden="true"></i>Domain Settings</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="8" onclick="wizard_tab(this, '8');"><i class="fa fa-code" aria-hidden="true"></i>Software Licensing</a></li>
                </ul>
            </div>


            <div class="startup_wizard-stage-footer">
                <?php
                    if(!$new_established_c)
                    {
                        ?>
                        <a style="float:left;" class="lbtn" href="javascript:dont_show_wizard(); void 0;">Don't show this again</a>
                        <?php
                    }
                ?>
                <a id="continue_wizard_btn" style="float:right;" class="green lbtn" href="javascript:continue_wizard_stage(); void 0;">I get it, go ahead</a>
            </div>
        </div>

    </div>
</div>

<style type="text/css">
    .wbot-startup-wizard-con img{position:absolute;margin-left:-166px;margin-top:-150px;height:210px}
    .wbot-comment{font-size:20px}
    .wbot-comment-triangle{width:0;position:absolute;height:0;border-style:solid;border-width:0 18.5px 73px 18.5px;border-color:transparent transparent #fff transparent;transform:rotate(321deg);top:-47px;left:10px}
    ul.wizard-tab{float:left;list-style-type:none;border-radius:0;margin:0;padding:0;overflow:hidden;width:30%}
    ul.wizard-tab li{float:left;width:100%;background:#e7e7e7}
    ul.wizard-tab li a{width:100%;border-radius:3px;border-bottom:1px solid #eee;display:inline-block;padding:17px 26px;text-decoration:none;transition:0.3s;font-size:16px;background:rgb(244,244,244);background:-moz-linear-gradient(left,rgba(244,244,244,1) 0%,rgba(255,255,255,1) 100%);background:-webkit-linear-gradient(left,rgba(244,244,244,1) 0%,rgba(255,255,255,1) 100%);background:linear-gradient(to right,rgba(244,244,244,1) 0%,rgba(255,255,255,1) 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#f4f4f4',endColorstr='#ffffff',GradientType=1 );-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out}
    ul.wizard-tab li a.active{background:#e7e7e7}
    ul.wizard-tab li a i{margin-right:15px;width:20px;text-align:center}
    .wizard-tabcontent{display:none;padding:6px 12px;border:1px solid #ccc;border-top:none}
    .wizard-tabcontent h4{margin-top:10px}
    .wizard-tabcontent{-webkit-animation:fadeEffect 1s;animation:fadeEffect 1s}
    @-webkit-keyframes fadeEffect{from{opacity:0}
        to{opacity:1}
    }
    @keyframes fadeEffect{from{opacity:0}
        to{opacity:1}
    }
    .wizard-tabcontent{width:70%;float:right;border:none}
    .wbot-startup-wizard-stages img{position:absolute;margin-left:-136px;margin-top:-120px;height:250px;width:auto}
    .startup_wizard-stages{position:relative;z-index:5}
    #wbot-startup-wizard-stage-1{text-align:center}
    #wbot-startup-wizard-stage-1 .line{margin:25px 0}
    #wbot-startup-wizard-stage-1 h4{font-size:18px}
    #wbot-startup-wizard-stage-1 h5{font-size:16px}
    .wbot-wizard-welcome{}
    .wbot-wizard-welcome img{width:152px;float:left;margin-right:25px}
    .wbot-wizard-welcome h1{font-size:36px;text-align:left}
    .wbot-wizard-welcome h1 strong{font-size:40px}
    .startup_wizard-stage-footer{float:left;width:100%;background:#f1f1f1;padding:19px}
    .green{background:#6ca56e;color:white}
    .green:hover{background:#578459;color:white}
    .wizard-tabcontent-title{font-weight:600;font-size:25px}
    .wizard-tabcontent .line{margin:10px 0px}

    @media only screen and (min-width: 320px) and (max-width: 1024px) {
        .wbot-startup-wizard-con img{position:relative;margin-left:-68px;margin-top:-159px;z-index:-1}
        .wbot-comment-triangle {            left: 120px;        }
        .wizard-tabcontent {
            width: 100%;
        }
        ul.wizard-tab {
            width: 100%;
        }
        .wbot-wizard-welcome h1 {
            font-size: 31px;
        }
        .wbot-wizard-welcome h1 strong {
            font-size: 31px;
        }
        .wbot-wizard-welcome img {
            width: 126px;

        }
    }



</style>

<script type="text/javascript">
    function open_startup_wizard()
    {
        $('a.tablinks[data-tab="1"]').click();
        close_modal('wbot-startup-wizard-welcome');
        open_modal('wbot-startup-wizard-stages',{title:"Start with WBOT",width:'850px'});
    }

    function dont_show_wizard()
    {
        close_modal('wbot-startup-wizard-welcome');
        close_modal('wbot-startup-wizard-stages');
        setCookie('wbot_welcome_dont_show',"true",2);
    }

    function wizard_tab(evt, tabName){
        var owner = 'wbot-startup-wizard-stage';
        var wrap_owner = "#tab-"+owner;
        $(wrap_owner+" > .wizard-tabcontent").css("display","none");
        $(wrap_owner+"> ul .tablinks").removeClass("active");
        $("#"+owner+"-"+tabName).css("display","block");
        $(evt).addClass("active");
        $("#wizard_stage").val(tabName);
        if(parseInt(tabName) > 7)
            $("#continue_wizard_btn").css("display","none");
        else
            $("#continue_wizard_btn").css("display","block");
    }

    function continue_wizard_stage()
    {
        var s = parseInt($("#wizard_stage").val());
        s++;

        if(s === 9) s = 1;

        $('a.tablinks[data-tab="'+s+'"]').click();
    }
</script>
