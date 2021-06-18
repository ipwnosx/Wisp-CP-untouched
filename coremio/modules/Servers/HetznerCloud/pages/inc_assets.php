<style type="text/css">
 .hetznerneedaction{width:100%;height:560px;background-image:url(<?php echo Utility::image_link_determiner("images/hetznerblurbg.jpg",$module_dir);?>);background-repeat:repeat;background-position:top;background-size:100%;text-align:center}
.hetznerneedaction-con{margin-top:120px;display:inline-block;background:rgb(255 255 255 / 72%);padding:50px;border-radius:5px}
.hetznerneedaction h3{font-weight:900;font-size:32px}
.hetznerneedaction h5{margin:20px 0px;font-weight:600}
.hetznerbulkupdate{float:right}
.hetznerbulkupdate input{width:70px;text-align:center;padding:5px 0px}
.hetznertabbtns{text-align:center;margin:35px 0px}
.hetznertabbtn{display:inline-block;position:relative;border:1px solid #eee;width:48%;cursor:pointer;text-align:left;vertical-align:top;border-radius:5px;min-height:280px;margin:5px;overflow:hidden;-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out}
.hetznertabbtn:hover{box-shadow:0px 0px 10px #eee}
.hetznertabbtn.active{background:#d50c2d;color:white;border-color:#d50c2d}
.hetznertabbtn h3{font-weight:600;font-size:20px;margin-left:22px}
.hetznertabbtn ul li{list-style-type:disc;font-size:14px}
.hetznertable table thead{background:#ebebeb;vertical-align:top;font-weight:600}
.hetznertable table tr td{}
.hetznertable table tr{}
.hetznertable select{text-align-last:center;width:130px}
.hetznerprice{width:60px;text-align:center;font-weight:600;}
.hetznertypename{text-align:center;width:130px}
.bottombtns{background:white;color:#095174;border-top:1px solid #eee;bottom:0px;padding-left:40px;position:absolute;width:100%}

@media only screen and (min-width:320px) and (max-width:1024px) {
.hetznertabbtn{width:100%;font-size:13px;margin:0;margin-bottom:15px}
.padding20{padding:10px 5px}
.hetznertabbtn ul li{font-size:13px}
.padding20.bottombtns{padding-left:25px;padding-bottom:20px}
.hetznertable{overflow-y:hidden;width:100%;margin-top:0px;overflow-x:scroll}
}


</style>

<script type="text/javascript">
    function hetzner_rs(result){
        if(result !== '')
        {
            let solve = getJson(result);
            if(solve !== false)
            {
                if(solve.status === "successful" && solve.message !== undefined) alert_success(solve.message,{timer:3000});
                if(solve.status === "error" && solve.message !== undefined) alert_error(solve.message,{timer:3000});
                if(solve.redirect !== undefined)
                {
                    if(solve.redirect === "refresh")
                        window.location.href = "<?php echo $links["controller"]; ?>";
                    else
                        window.location.href = solve.redirect;
                }
                if(solve.server_type !== undefined && solve.server_type.length > 1)
                {
                    $("input[name='products["+solve.server_type+"][name]']").removeAttr("disabled");
                    $("input[name='products["+solve.server_type+"][traffic]']").removeAttr("disabled");
                    $("input[name='products["+solve.server_type+"][sale]']").removeAttr("disabled");
                    $("select[name='products["+solve.server_type+"][network]']").removeAttr("disabled");
                    $("select[name='products["+solve.server_type+"][location]']").removeAttr("disabled");
                    $("select[name='products["+solve.server_type+"][category]']").removeAttr("disabled");
                    $("#wrap-"+solve.server_type+"-status").html(
                        '<input checked type="checkbox" id="p-'+solve.server_type+'-status" name="products['+solve.server_type+'][status]" value="1" class="sitemio-checkbox">'+
                        '<label style="margin-right: 0px;" class="sitemio-checkbox-label" for="p-'+solve.server_type+'-status"></label>'
                    );

                    if(solve.network !== undefined)
                    {
                        $("select[name='products["+solve.server_type+"][network]'] option").removeAttr("selected");
                        $("select[name='products["+solve.server_type+"][network]'] option[value="+solve.network+"]").attr("selected",true);
                    }

                    if(solve.location !== undefined)
                    {
                        $("select[name='products["+solve.server_type+"][location]'] option").removeAttr("selected");
                        $("select[name='products["+solve.server_type+"][location]'] option[value="+solve.location+"]").attr("selected",true);
                    }

                    if(solve.category !== undefined)
                    {
                        $("select[name='products["+solve.server_type+"][category]'] option").removeAttr("selected");
                        $("select[name='products["+solve.server_type+"][category]'] option[value="+solve.category+"]").attr("selected",true);
                    }

                }

            }
            else
                console.log(result);
        }
    }
</script>