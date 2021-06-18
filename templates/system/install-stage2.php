<div class="stage2">
    <div class="logo"><img src="<?php echo $taddress; ?>images/logo2.svg" /></div>
    <div class="title"><?php echo $lang["stage2"]; ?></div>
    <div style="padding:25px;">

        <div class="notice">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="noticeinfo">
                <?php echo $lang["stage2-text1"]; ?>
            </div>
        </div>



        <div class="progress" id="loading" style="display:none">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                <defs>
                    <filter id="gooey">
                        <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                        <feBlend in="SourceGraphic" in2="goo"></feBlend>
                    </filter>
                </defs>
            </svg>
            <div class="blob blob-0"></div>
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
            <div class="blob blob-4"></div>
            <div class="blob blob-5"></div>
            <h2><?php echo $lang["loading-text1"]; ?></h2>
            <h3><?php echo $lang["loading-text2"]; ?></h3>
        </div>
        <div class="dbinformation" style="">

            <script type="text/javascript">
                var button_pending=false;
                $(document).ready(function(){
                    $("#continue_button").click(function(){
                        if(button_pending) return false;
                        button_pending = true;

                        $("#loading").css("display","block");
                        $(".dbinformation").attr("style",'filter: blur(3px);');

                        $.post('?act=stage3', $('#StageForm').serialize(),function(result){
                            setTimeout(function(){
                                button_pending = false;
                                $("#loading").css("display","none");
                                $(".dbinformation").removeAttr("style");

                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#StageForm "+solve.for).focus();
                                                $("#StageForm "+solve.for+":focus").attr("style","border-color:red;color:red;");
                                                $("#StageForm "+solve.for+":focus").change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }

                                            alert_error(solve.message,{timer:5000});

                                        }else if(solve.status == "successful" && solve.redirect != undefined && solve.redirect != '')
                                            window.location.href = solve.redirect;

                                    }else
                                        console.log(result);
                                }

                            },500);
                        });

                    });

                });
            </script>
            <form action="" method="post" id="StageForm" onsubmit="return false;">

                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage2-text3"]; ?></div>
                    <div class="yuzde70">
                        <input name="db_host" type="text" placeholder="" value="localhost">
                        <span class="kinfo"><?php echo $lang["stage2-text4"]; ?></span>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage2-text5"]; ?></div>
                    <div class="yuzde70">
                        <input name="db_name" type="text" placeholder="" value="">
                        <span class="kinfo"><?php echo $lang["stage2-text6"]; ?></span>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage2-text7"]; ?></div>
                    <div class="yuzde70">
                        <input name="db_username" type="text" placeholder="" value="">
                        <span class="kinfo"><?php echo $lang["stage2-text8"]; ?></span>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo $lang["stage2-text9"]; ?></div>
                    <div class="yuzde70">
                        <input name="db_password" type="text" placeholder="" value="">
                        <span class="kinfo"><?php echo $lang["stage2-text10"]; ?></span>
                    </div>
                </div>
            </form>

            <div class="clear"></div>
        </div>

        <div class="clear"></div>
        <br>
        <div align="center">
            <a id="continue_button" style="cursor:pointer;" class="button"><?php echo $lang["start-setup"]; ?></a>
        </div>
    </div>
</div>