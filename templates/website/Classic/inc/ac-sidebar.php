<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!isset($gtype)) $gtype = false;
?>
<div class="mpanelleft">
    <div class="clean-theme-client-left-block">
        <div class="clean-theme-client-left-block-title">
            <h4><?php echo __("website/account/text24"); ?></h4>
            <span title="<?php echo __("website/account_invoices/user-id"); ?>">#<?php echo $udata["id"]; ?></span>
        </div>
        <div class="padding20">
            <span class="clean-theme-left-block-title">
                <strong><?php echo __("website/account/welcome-board2"); ?> <?php echo $udata["full_name"]; ?></strong>
                <?php
                    if($udata["company_name"])
                    {
                        ?>
                        <br>
                        <?php echo $udata["company_name"]; ?>
                        <?php
                    }
                ?>
            </span>
            <?php

                if($udata["address"])
                {
                    echo $udata["address"]["address"]." , ".$udata["address"]["counti"]." , ".$udata["address"]["city"]." , ".$udata["address"]["zipcode"]." , ".$udata["address"]["country_code"];
                }
                else
                    echo __("website/account/address-1");
            ?>
            <a class="yesilbtn gonderbtn" href="<?php echo $menu_links['menu-5']; ?>?tab=2">
                <i class="fa fa-pencil" aria-hidden="true"></i> <?php echo ___("needs/button-update"); ?>
            </a>
        </div>
    </div>

<?php if($visibility_balance): ?>
    <div class="clean-theme-client-left-block">
        <div class="clean-theme-client-left-block-title">
            <h4><?php echo __("website/account/statistic-5-name"); ?></h4>
        </div>
        <div class="padding20">

            <?php
                if(Filter::numbers($statistic5) > 0)
                    echo __("website/account/balance-2",['{amount}' => $statistic5]);
                else
                    echo __("website/account/balance-1");
            ?>

            <a class="yesilbtn gonderbtn" href="<?php echo $acsidebar_links["balance-link"]; ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("website/account/statistic-5-link"); ?></a>
        </div>
    </div>
<?php endif; ?>

    <?php
        if(isset($visibility_invoice) && $visibility_invoice && $statistic3>0 && $pname != "account_dashboard" && !isset($unpaid_invoices)){
            if(!isset($get_unpaid_invoice_total)){
                Helper::Load(["Invoices","Money"]);
                $u_data = UserManager::LoginData("member");
                $get_unpaid_invoice_total  = Invoices::get_total_unpaid_invoices_amount($u_data["id"]);
            }
            ?>
            <style>
                .invoicereminleft{color:#F44336;margin-bottom:15px;position:relative;overflow:hidden;}
                .invoicereminleft h4{font-size:16px;font-weight:700;margin-bottom:5px}
                .invoicereminleft span{font-weight:300}
                .invoicereminleft .lbtn{margin-top:15px;color:#F44336;border:1px solid #F44336;font-weight:400;font-size:14px}
                .invoicereminleft .lbtn:hover {background:#F44336;color:white;}
                .invoicereminleft img {height: 170px;position:absolute;right: -45px;bottom: -30px;opacity: 0.2;filter: alpha(opacity=20);}
            </style>

            <div class="invoicereminleft">
                <img src="https://image.flaticon.com/icons/svg/179/179386.svg">
                <div class="padding20">
                    <h4><?php echo __("website/account/remind-invoice-text5"); ?></h4>
                    <span><?php echo __("website/account/remind-invoice-text6",[
                            '{count}' => $statistic3,
                            '{total}' => Money::formatter_symbol($get_unpaid_invoice_total,Money::getUCID()),
                        ]); ?></span><div class="clear"></div>
                    <a href="<?php echo Controllers::$init->CRLink("ac-ps-invoices-p",["bulk-payment"]); ?>" class="lbtn"><?php echo $statistic3>1 ? __("website/account/remind-invoice-text3") : __("website/account/remind-invoice-text4"); ?></a>
                </div>
            </div>
            <?php
        }
    ?>
</div>