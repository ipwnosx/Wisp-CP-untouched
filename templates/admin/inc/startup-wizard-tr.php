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
                .typeString('Merhaba ')
                .typeString('<STRONG>Sahip!</STRONG>')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('Ben ')
                .typeString('<STRONG>WBOT...</STRONG>')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('Size yardımcı olmak için buradayım...')
                .pauseFor(2000)
                .deleteAll(15)
                .typeString('Otomasyonunuzu en iyi şekilde yapılandırabilmeniz ve yönetebilmeniz için size daima asistanlık edeceğim.')
                .pauseFor(2000)
                .typeString('<a style="display: block;margin-top:20px;width: 200px;text-align: center;" href="javascript:open_startup_wizard();void 0;" class="green lbtn">Hadi Başlayalım!</a>')
                .pauseFor(2000)
                .typeString('<span style="margin-top: 21px;font-size:16px;float: left;width:100%;border-bottom:1px solid #eee;padding-bottom:15px;">Eğer bunun için henüz zamanınız yoksa, bana her zaman "Yardım > WBOT ile Başla" yolundan tekrar ulaşabilirsiniz.</span>')
                .pauseFor(2000)
                .typeString('<span style="margin-top: 14px;font-size:16px;float: left;width:100%;border-bottom:1px solid #eee;padding-bottom:15px;">Bu pencereyi tekrar görmek istemezseniz aşağıdaki butona tıklayabilirsiniz.</span>')
                .pauseFor(1000)
                .typeString('<a class="lbtn" href="javascript:dont_show_wizard(); void 0" style="margin-top: 21px;font-size:14px;margin-bottom: 25px;float: left;">Bunu Tekrar Gösterme</a>')
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
                            <h1>Tekrar<br><strong>Merhaba!</strong></h1>
                        </div>

                        <div class="clear"></div>
                        <div class="line"></div>
                        <h4><strong>Gereken ayarları kolaylıkla tamamlayabilmeniz için size faydalı bilgiler sağlayacak ve sizi ilgili bölümlere yönlendireceğim.</strong></h4>
                        <div class="line"></div>
                        <h5>Tüm bunlar, otomasyonunuzun sağlıklı çalışabilmesi için gereken temel ayarlamalardır. </h5>
                        <div class="line"></div>
                        <h5>Bu pencereye tekrar ulaşmak isterseniz "<strong>Yardım</strong> > <strong>WBOT ile Başla</strong>" yolu üzerinden erişim yapabilirsiniz.</h5>

                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-2" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Genel Ayarlar</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Genel Ayarlar, sisteminizin temel bilgilerini, SEO ayarlarını ve gelişmiş ayarlarını yapılandırabileceğiniz kapsamlı ayarların bulunduğu bölümdür.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ayarlar > Genel Ayarlar</strong>" yolu üzerinden erişilmektedir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Genel Ayarlar</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("settings"); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Genel Ayarlar'a Git</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-3" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Otomasyon ve Cronjob</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Otomasyon ve cronjob ayarları, sistem tarafından otomatik olarak yürütülmesi gereken görevlerin yapılandırıldığı bölümdür. Faturaların oluşturulması, hatırlatmalar, hizmetlerin askıya alınması, silinmesi vb. birçok görevin yürütülmesi için kesinlikle cronjob ayarlarının  yapılandırılması gereklidir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ayarlar > Otomasyon Ayarları</strong>" yolu üzerinden erişilmektedir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Otomasyon Ayarları</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. Otomasyon ayarları ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("automation"); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Otomasyon Ayarları'na Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kb/cronjob-ve-otomasyon"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-4" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Tahsilat Ayarları</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Tahsilat Ayarları, müşterilerinizden ödeme tahsil edebilmeniz için ödeme yöntemlerinin ayarlandığı ve etkinleştirildiği bölümdür. WISECP üzerinde standart olarak birçok ödeme yöntemi modülü mevcuttur. Bunlardan istediğinizi etkinleştirebilir ve ödeme tahsil etmek için kullanabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ayarlar > Finansal Ayarlar > Ödeme Yöntemleri</strong>" yolu üzerinden erişilmektedir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Ödeme Yöntemleri</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. Ödeme Yöntemleri ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("modules",["payment"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Ödeme Yöntemleri'ne Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kbc/odeme-yontemleri-doc"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-5" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">SMTP ve Bildirimler</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Sistemsel bildirimler, ödeme bildirimleri, hatırlatmalar, hizmet aktivasyon mesajları vb. tüm bildilerimlerin otomatik olarak gönderilebilmesi için, SMTP ayarlarının yapılandırılması gereklidir. </p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ayarlar > SMTP Ayarları</strong>" yolu üzerinden erişilmektedir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>SMTP Ayarları</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. SMTP Ayarları ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("modules",["mail"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> SMTP Ayarları'na Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kb/smtp-ayarlari"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-6" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Hosting Ayarları</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Sisteme paylaşımlı sunucularınızı tanımlamak, hosting ve sunucu hizmet satışlarını otomatikleştirmek, otomatik hizmet aktivasyonu vb. tüm işlemleri sağlamak için ayarlarınızı tamamlayın.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ürünler/Hizmetler > Hosting/Sunucu > Paylaşımlı Sunucu Ayarları</strong>" yolu üzerinden paylaşımlı sunucularınızı sisteme tanımlayabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Paylaşımlı Sunucu Ayarları</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. Paylaşımlı Sunucu Ayarları ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products-2",["hosting","shared-servers"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Paylaşımlı Sunucu Ayarları'na Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kb/paylasimli-sunucu-ayarlari"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-7" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Alan Adı Ayarları</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Alan adı tescil hizmetleri sunmak, mevcut alan adlarını sisteme aktarmak, alan adı uzantılarını yönetmek vb. tüm işlemleri sağlamak için ayarlarınızı tamamlayın.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ürünler/Hizmetler > Alan Adı Tescili > Uzantı ve Fiyatlar</strong>" yolu üzerinden uzantıları yönetebilirsiniz.</p>
                        <p>"<strong>Yönetim Paneli > Ürünler/Hizmetler > Alan Adı Tescili > Alan Adı Yazmanları</strong>" yolu üzerinden alan adı servis sağlayıcı ayarlarınızı yapabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Uzantı ve Fiyatlar</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. Alan adı tescil işlemleri ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products",["domain"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Uzantı ve Fiyatlar'a Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kb/alan-adi-hizmet-yonetimi"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <div id="wbot-startup-wizard-stage-8" class="wizard-tabcontent">
                    <div class="padding20">
                        <h1 class="wizard-tabcontent-title">Yazılım Lisanslama</h1>
                        <div class="line"></div><div class="clear"></div>
                        <p>Yazılım ürünlerinizi sisteminize birer ürün olarak ekleyebilir, lisans kontrol kodlarını temin edebilir  ve yazılım ürünlerinizin satış ve yönetimini sağlayabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>"<strong>Yönetim Paneli > Ürünler/Hizmetler > Yazılımlar</strong>" yolu üzerinden erişilmektedir.</p>
                        <div class="line"></div><div class="clear"></div>
                        <p>Aşağıdaki butona tıklayarak "<strong>Yazılımlar</strong>" bölümünü "<strong>Yeni Sekmede</strong>" görüntüleyebilir ve gerekli ayarlamaları yapabilirsiniz. Yazılım ürün paketi oluşturma ve lisanslama işlemleri ile ilgili yardımcı belgere aşağıdaki "<strong>Dokümantasyon</strong>" butonuna tıklayarak ulaşabilirsiniz.</p>
                        <div class="line"></div><div class="clear"></div>
                        <a style="margin-right:10px;" target="_blank" class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products",["software"]); ?>"><i style="margin-right:5px;" class="fa fa-external-link" aria-hidden="true"></i> Yazılımlar'a Git</a>
                        <a target="_blank" class="lbtn" href="https://docs.wisecp.com/tr/kbc/yazilim"><i style="margin-right:5px;" class="fa fa-life-ring" aria-hidden="true"></i> Dokümantasyon</a>
                    </div>
                </div>

                <ul class="wizard-tab">
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="1" onclick="wizard_tab(this, '1');"><i class="fa fa-info" aria-hidden="true"></i>Başlangıç</a></li>

                    <li><a href="javascript:void(0)" class="tablinks" data-tab="2" onclick="wizard_tab(this, '2');"><i class="fa fa-cog" aria-hidden="true"></i>Genel Ayarlar</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="3" onclick="wizard_tab(this, '3');"><i class="fa fa-cogs" aria-hidden="true"></i>Otomasyon ve Cronjob</a></li>
                    <li><a href="javascript:void(0)" class="tablinks"  data-tab="4" onclick="wizard_tab(this, '4');"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>Tahsilat Ayarları</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="5" onclick="wizard_tab(this, '5');"><i class="fa fa-envelope" aria-hidden="true"></i>SMTP ve Bildirimler</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="6" onclick="wizard_tab(this, '6');"><i class="fa fa-server" aria-hidden="true"></i>Hosting Ayarları</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="7" onclick="wizard_tab(this, '7');"><i class="fa fa-globe" aria-hidden="true"></i>Alan Adı Ayarları</a></li>
                    <li><a href="javascript:void(0)" class="tablinks" data-tab="8" onclick="wizard_tab(this, '8');"><i class="fa fa-code" aria-hidden="true"></i>Yazılım Lisanslama</a></li>
                </ul>
            </div>


            <div class="startup_wizard-stage-footer">
                <?php
                    if(!$new_established_c)
                    {
                        ?>
                        <a style="float:left;" class="lbtn" href="javascript:dont_show_wizard(); void 0;"><?php echo $ui_lang == "tr" ? 'Tekrar Gösterme' : 'Tekrar Gösterme EN'; ?></a>
                        <?php
                    }
                ?>
                <a id="continue_wizard_btn" style="float:right;" class="green lbtn" href="javascript:continue_wizard_stage(); void 0;">Anladım, Devam et</a>
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
    #wbot-startup-wizard-stage-1 {text-align:center}
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
        open_modal('wbot-startup-wizard-stages',{title:"WBOT ile Başla",width:'850px'});
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
