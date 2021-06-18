 <div class="red-info" style="text-align:center;">
    <div class="padding20">
        <h5><?php echo Utility::text_replace($_LANG["note"]["content"],['{code}' => $module->get_rce()]); ?></h5>
    </div>
 </div>

 <div class="bank-notification">
     <span class="bank-notification-info"><?php echo $_LANG["text6"]; ?></span>

     <div class="yuzde50">
         <form action="<?php echo $module->links["notification"]; ?>" method="post" id="NotificationForm20">
            <!-- <H4><strong><?php echo Utility::text_replace($_LANG["amount-to-be-paid"]["content"],['{fee}' => Money::formatter_symbol($checkout["data"]["total"],$checkout["data"]["currency"])]); ?></strong></H4>-->
             <!--H4><strong><?php echo Utility::text_replace($_LANG["reference-code"]["content"],['{code}' => $module->get_rce()]); ?></strong></H4-->

             <select name="bank">
                 <option value=""><?php echo $_LANG["text1"]; ?></option>
                 <?php
                     $list = $module->accounts();
                     foreach($list AS $item){
                         ?><option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option><?php
                     }
                 ?>
             </select>
             <input name="sender_name" type="text" placeholder="<?php echo $_LANG["text2"]; ?>">
             <div class="clear"></div><br>
             <a class="yesilbtn gonderbtn" href="javascript:void(0);" id="NotificationForm20_submit"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $_LANG["text5"]; ?></a>
             <div class="clear"></div>
             <div id="result" class="error" style="text-align: center; display: none; margin-top: 5px;"></div>
         </form>
     </div>
     <script type="text/javascript">
         $(document).ready(function(){
             $(".sepetrightcon hr").remove();
             $(".sepetrightcon #NotificationForm").remove();
             $("#NotificationForm20_submit").on("click",function(){
                 MioAjaxElement($(this),{
                     waiting_text: '<?php echo addslashes(__("website/others/button1-pending")); ?>',
                     result:"NotificationForm20_handler",
                 });
             });

         });
         function NotificationForm20_handler(result) {
             if(result != ''){
                 var solve = getJson(result);
                 if(solve !== false){
                     if(solve.status == "error"){
                         if(solve.for != undefined && solve.for != ''){
                             $("#NotificationForm20 "+solve.for).focus();
                             $("#NotificationForm20 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                             $("#NotificationForm20 "+solve.for).change(function(){
                                 $(this).removeAttr("style");
                             });
                         }
                         if(solve.message != undefined && solve.message != '')
                             $("#NotificationForm20 #result").fadeIn(300).html(solve.message);
                         else
                             $("#NotificationForm20 #result").fadeOut(300).html('');
                     }else if(solve.status == "successful"){
                         if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                     }
                 }else
                     console.log(result);
             }
         }
     </script>
 </div>

 <div class="clear"></div>

<?php
    if(!isset($list)) $list = $module->accounts();
    foreach ($list AS $item){
        ?>
        <div class="bankablok">
            <div class="padding15">
                <?php
                    $wide = true;
                    if($item["image"] != ''){
                        $wide = false;
                        ?>
                        <div class="bankalogo"><img src="<?php echo $item["image"]; ?>" width="auto" height="auto"> <h4><?php echo $item["name"]; ?></h4></div>
                        <?php
                    }
                ?>
                <div class="bankainfo"<?php echo $wide ? ' style="width:100%;"' : NULL; ?>>

                    <div class="line"></div>
                    <?php
                        if($item["buyer_name"] != ''){
                            ?>
                            <h5><span><?php echo $_LANG["text7"]; ?></span>: <?php echo $item["buyer_name"]; ?></h5>
                            <?php
                        }

                        if($item["iban"] != ''){
                            ?>
                            <h5><span><?php echo $_LANG["text8"]; ?></span>: <?php echo $item["iban"]; ?></h5>
                            <?php
                        }

                        if($item["account_number"] != ''){
                            ?>
                            <h5><span><?php echo $_LANG["text9"]; ?></span>: <?php echo $item["account_number"]; ?></h5>
                            <?php
                        }

                        if($item["branch_nc"] != ''){
                            ?>
                            <h5><span><?php echo $_LANG["text10"]; ?></span>: <?php echo $item["branch_nc"]; ?></h5>
                            <?php
                        }
                        if($item["swiftc"] != ''){
                            ?>
                            <h5><span><?php echo $_LANG["text11"]; ?></span>: <?php echo $item["swiftc"]; ?></h5>
                            <?php
                        }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
    }
?>

 <div class="clear"></div>