<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!isset($ac_header_info_inc)){
        $ac_header_info_inc = true;
        ?>
        <div class="mpanelinfo">
            <div id="wrapper">

                <script type="text/javascript">
                    var dashboard_styleToggle=false;
                    function dashboard_style_toggle(){
                        if(dashboard_styleToggle){
                            $(".leftbar").css({'margin-left':'-80%'});
                            $("#button_close").css("display","none");
                            $(".mobmenuclose").css("display","none");
                            $("body").css("overflow","auto");
                            $("#dashboard_button_open").fadeIn(0);
                            dashboard_styleToggle = false;
                        }else{
                            $(".leftbar").css({'margin-left':'0px'});
                            $(".mobmenuclose").css("display","block");
                            $("body").css("overflow","hidden");

                            $("#dashboard_button_close").fadeIn(100);
                            dashboard_styleToggle = true;
                        }
                    }

                </script>

                <a onclick="dashboard_style_toggle();" href="javascript:void 0;" id="dashboard_button_open" class="mclientmobbtn" style=""><i class="fa fa-bars" aria-hidden="true"></i></a>




                <span><?php echo __("website/account/welcome-board",[
                        '{name}' => $acheader_info["name"],
                        '{surname}' => $acheader_info["surname"],
                        '{full_name}' => $acheader_info["full_name"],
                    ]); ?></span>


                <?php
                    if(isset($acheader_info["dealership"]["status"]) && $acheader_info["dealership"]["status"] == "active"){
                        ?>
                        <a id="resellertooltip" class="tooltip-right" data-tooltip="<?php echo __("website/account/active-reseller"); ?>" href="<?php echo Controllers::$init->CRLink("reseller"); ?>"><img class="resellericon" height="25" src="<?php echo $tadress; ?>images/dealership.svg"></a>
                        <?php
                    }
                ?>


                <div class="headbutonlar">

                    <?php if($visibility_basket): ?>
                        <a title="Sepetim" id="sepeticon" href="<?php echo $basket_link; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="basket-count"><?php echo $basket_count; ?></span></a>
                    <?php endif; ?>


                    <div class="wclientnotifi">
                        <a class="wnotifitibtn" href="#"><i class="fa fa-bell-o" aria-hidden="true"></i><span class="notifi-count">3</span></a>


                        <div class="wclientnotification">

                            <div class="wnotifititle">
                                <div class="padding30">
                                    <h3>9 Yeni Bildirim</h3>
                                    <h5>İşlem Bildirimleri</h5>
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="padding30">

                                <div class="wnotificontent">

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Foto galeri yapı değişikliği</strong></a> başlıklı destek talebiniz yanıtlanmıştır.</h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Foto galeri yapı değişikliği</strong></a> başlıklı destek talebiniz yanıtlanmıştır.</h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>#45784</strong></a> nolu faturanızın son ödeme tarihi yaklaşıyor.</h5></div>
                                    </div>

                                    <div class="read wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>#45784</strong></a> nolu faturanızın son ödeme tarihi geçmiştir.</h5></div>
                                    </div>

                                    <div class="read wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>SSD PRO - exampledomain.com (#4574)</strong></a> hizmetinizin sonlanma tarihi yaklaşıyor.</h5></div>
                                    </div>

                                    <div class="read wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>SSD PRO - exampledomain.com (#4574)</strong></a> hizmetiniz askıya alınmıştır.</h5></div>
                                    </div>

                                    <div class="read wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>SSD PRO - exampledomain.com (#4574)</strong></a> hizmetiniz iptal edilmiştir.</h5></div>
                                    </div>


                                </div>



                                <div class="allread"><a href="#">Tümünü Okundu İşaretle</a></div>


                            </div>
                        </div>

                    </div>



                    <div class="wclientnotifi">
                        <a class="wnotifitibtn" href="#"><i class="fa fa-user" aria-hidden="true"></i></a>


                        <div class="wclientnotification">

                            <div class="wnotifititle">
                                <div class="padding30">
                                    <h3>Sn. Mahmut Tuncer</h3>
                                    <h5>Hesabınızı Yönetin</h5>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="padding30">

                                <div class="wnotificontent" style="height:auto;">

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-info" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Genel Bilgiler</strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Adres ve Fatura Bilgileri</strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-star-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Tercihler</strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="#"><strong>Şifre Değiştir</strong></a></h5></div>
                                    </div>


                                </div>


                                <div class="allread"><a href="#">Güvenli Çıkış Yap</a></div>


                            </div>
                        </div>

                    </div>




                </div>

            </div>
        </div>
        <?php
    }
?>