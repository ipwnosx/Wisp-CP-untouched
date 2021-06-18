<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(isset($visibility_invoice) && $visibility_invoice && $statistic3>0){
        if(!isset($get_unpaid_invoice_total)){
            Helper::Load(["Invoices","Money"]);
            $u_data = UserManager::LoginData("member");
            $get_unpaid_invoice_total  = Invoices::get_total_unpaid_invoices_amount($u_data["id"]);
        }
        ?>

        <div class="invoiceremind">
            <div class="red-info">
                <div class="padding20">
                    <div class="billreminicon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                    <div class="billremininfo">
                    <h4><?php echo __("website/account/remind-invoice-text1"); ?></h4><br>
                    <span><?php echo __("website/account/remind-invoice-text2",[
                            '{count}' => $statistic3,
                            '{total}' => Money::formatter_symbol($get_unpaid_invoice_total,Money::getUCID()),
                        ]); ?></span>
                    <div class="clear"></div>
                    <a class="lbtn" href="<?php echo Controllers::$init->CRLink("ac-ps-invoices-p",["bulk-payment"]); ?>"><?php echo $statistic3>1 ? __("website/account/remind-invoice-text3") : __("website/account/remind-invoice-text4"); ?></a>
                    </div>
               <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php
    }