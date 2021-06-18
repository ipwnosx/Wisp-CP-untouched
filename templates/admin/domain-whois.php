<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','jscolor','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){


            $("#queryForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"queryForm_handler",
                });
            });
        });

        function queryForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#queryForm "+solve.for).focus();
                            $("#queryForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#queryForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){

                        $("#whois_result").html(solve.data);
                        $(".domain-status").css("display","none");
                        $("#domain_status_"+solve.domain_status).css("display","block");
                    }
                }else
                    console.log(result);
            }
        }
        

        $( function() {
            $( ".accordion" ).accordion({
                heightStyle: "content",
                active: false,
                collapsible: true,
            });
        } );
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-domain-whois"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

           

                <div class="wholis-lookup-head">
            <h4><?php echo __("admin/products/domain-whois-text1"); ?></h4>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="queryForm" onsubmit="$('#queryForm_submit').click(); return false;">
                <input type="hidden" name="operation" value="whois_query">

                <input type="text" name="domain" value="" placeholder="example.com">

                <a class="yesilbtn gonderbtn" id="queryForm_submit" href="javascript:void(0);"><?php echo __("admin/products/whois-query-button"); ?></a>

            </form>
            <strong class="domain-status" id="domain_status_available" style="display: none;"><?php echo __("admin/orders/create-domain-status-available"); ?></strong>
            <strong class="domain-status" id="domain_status_unavailable" style="display: none"><?php echo __("admin/orders/create-domain-status-unavailable"); ?></strong>
            <strong class="domain-status" id="domain_status_unknown" style="display: none"><?php echo ___("needs/needs/unknown"); ?></strong>
            

            <pre id="whois_result"></pre>

            <div class="clear"></div>
            </div>
            


            <div class="clear"></div>
    
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>