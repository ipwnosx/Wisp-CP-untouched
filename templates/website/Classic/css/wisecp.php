@charset "utf-8";
body{font-family:'Titillium Web',sans-serif;font-size:15px;line-height:normal;color:#<?php echo $text_color; ?>;margin:0;padding:0;overflow-x:hidden;background-repeat:repeat-x}
#muspanel{background-image:url(../images/cloudbg.jpg);background-repeat:no-repeat;background-position:center top;background-attachment:fixed}
#wrapper{width:85%;margin-left:auto;margin-right:auto}
a,img,input,select,textarea{-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
a{color:#<?php echo $text_color; ?>;text-decoration:none}
input,select,textarea{font-family:'Titillium Web',sans-serif;outline:none;padding:5px;font-size:15px;color:#<?php echo $text_color; ?>;border:1px solid #ccc}
input,textarea{-webkit-transition:all .3s ease-in-out;-moz-transition:all .3s ease-in-out;-ms-transition:all .3s ease-in-out;-o-transition:all .3s ease-in-out;outline:none;border:1px solid #444}
::-webkit-input-placeholder{color:rgba(0,0,0,0.35);}
:-moz-placeholder{color:rgba(0,0,0,0.35);}
::-moz-placeholder{color:rgba(0,0,0,0.35);}
:-ms-input-placeholder{color:rgba(0,0,0,0.35);}
textarea{resize:vertical}
p {line-height:23px;}
.zorunlu{font-weight:bolder;color:red}
.notice{color:orange;font-weight:700;display:inline-block}
.error{color:#f44336;font-weight:700}
.complete{color:green;font-weight:700;display:inline-block}
.selectalltext{-webkit-user-select:all;-moz-user-select:all;-ms-user-select:all;user-select:all}
.clear{clear:both}
.is-fixed{position:fixed;top:20px;width:258px}
h1,h2,h3,h4,h5{padding:0;margin:0;font-weight:400} 
h1{font-size:32px}
h2{font-size:28px}
h3{font-size:26px}
h4{font-size:20px}
h5{font-size:18px}
input:disabled{background:#eee;padding-left:10px;width:97%}
select:disabled{background:#eee;padding-left:10px}
textarea:disabled{background:#eee;padding-left:10px;width:97%}
input:-webkit-autofill,input:-webkit-autofill:hover,input:-webkit-autofill:focus,input:-webkit-autofill:active{-webkit-animation:autofill 0s forwards;animation:autofill 0s forwards}
@keyframes autofill{100%{background:transparent;color:inherit}
}
@-webkit-keyframes autofill{100%{background:transparent;color:inherit}
}
.padding5{padding:5px}
.padding10{padding:10px}
.padding15{padding:15px}
.padding20{padding:20px}
.padding25{padding:25px}
.padding30{padding:30px}
.jssorl-009-spin img{animation-name:jssorl-009-spin;animation-duration:1.6s;animation-iteration-count:infinite;animation-timing-function:linear}
@keyframes jssorl-009-spin {
from{transform:rotate(0deg)}
to{transform:rotate(360deg)}
}
.formcon{float:left;width:100%;border-bottom:1px solid #ddd;padding:7px 0;word-wrap:break-word}
.kinfo{font-size:13px;font-weight:400}
.middle .yuzde30{vertical-align:middle}
.middle{vertical-align:middle}
.formcon .yuzde30{vertical-align:middle;font-weight:600;font-size:15px;padding:7px 0}
.formcon .yuzde70{vertical-align:middle;font-size:15px}
.formcon .yuzde40{vertical-align:middle;font-weight:600;font-size:15px}
.formcon .yuzde60{vertical-align:middle;font-size:15px}
.formcon .yuzde50{vertical-align:middle;font-size:15px}
.jssorb064{position:absolute}
.jssorb064 .i{position:absolute;cursor:pointer}
.jssorb064 .i .b{fill:#000;fill-opacity:.5;stroke:#fff;stroke-width:400;stroke-miterlimit:10;stroke-opacity:.5}
.jssorb064 .iav .b{fill:#fff;fill-opacity:1;stroke:#fff;stroke-opacity:.7;stroke-width:2000}
.jssorb064 .i.idn{opacity:.3}
.jssora051{display:block;position:absolute;cursor:pointer}
.jssora051 .a{fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10}
.jssora051:hover{opacity:.8}
.jssora051.jssora051dn{opacity:.5}
.jssora051.jssora051ds{opacity:.3;pointer-events:none}
.mioslidertext{color:#fff;position:absolute;top:270px;left:140px;width:350px;height:250px}
.mioslidertext h1{font-weight:700;font-size:24px}
.mioslidertext p{font-weight:200;font-size:14px}
.mioslidertext #largeredbtn{font-size:11px;color:#FFF;margin-top:10px;padding:7px 50px}
div.required-field-info h5{-webkit-animation:blink 3s ease-in 0 infinite normal;animation:blink 3s ease-in 0 infinite normal}
@-webkit-keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
@keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
.menu{float:right;position:relative;z-index:75}
.menu ul{padding:0;margin:0}
.menu li{float:left;position:relative;list-style-type:none}
.menu li a{float:right;font-family: 'Raleway',sans-serif;color:#fff;padding-left:25px;padding-right:25px;text-decoration:none;line-height: 68px;font-weight:700;font-size: 16px;border-bottom: 2px solid transparent;}
.menu li a:hover {border-bottom:2px solid white;}
#megamenuli {position:inherit;}
#megamenuli a:hover {border:none}
.menu ul li ul li:hover a{background:rgba(0,0,0,0.08)}
.menu ul li ul{width:200px;float:left;position:absolute;top:68px;left:0;z-index:1;display:none;margin:0;padding:0;background:#fff;-webkit-animation-name:fadeIn;animation-name:fadeIn;-webkit-animation-duration:.5s;animation-duration:.5s;-webkit-animation-fill-mode:both;animation-fill-mode:both;-moz-border-radius-topleft:5px;-moz-border-radius-topright:5px;-moz-border-radius-bottomleft:5px;-moz-border-radius-bottomright:5px;-webkit-border-top-left-radius:5px;-webkit-border-top-right-radius:5px;-webkit-border-bottom-left-radius:5px;-webkit-border-bottom-right-radius:5px;border-top-right-radius:5px;border-top-left-radius:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px}
.menu ul li ul li{float:none;margin:0;padding:0}
.menu ul li ul li a{background:none;font-weight:400;font-size:14px;color: #<?php echo $color2; ?>;float:none;text-align:left;display:block;line-height:40px;margin:0;padding: 0 0 0 15px;}
.menu ul li ul li a:hover {border:none}
#noborder a {border:none}
.menu li:hover>ul{display:block;-webkit-transition: all .4s ease-out;-moz-transition: all .4s ease-out;-ms-transition: all .4s ease-out;-o-transition: all .4s ease-out;transition: all .4s ease-out;position: absolute;}
.sabithead .menu li:hover>ul{-webkit-border-bottom-right-radius:5px;-webkit-border-bottom-left-radius:5px;-moz-border-radius-bottomright:5px;-moz-border-radius-bottomleft:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;border-top-right-radius:0px;border-top-left-radius:0px}
.menu ul li ul li ul{width:200px;height:auto;float:left;position:absolute;top:0;left:195px;z-index:1;display:none}
.menu ul li ul li ul li a:hover{background:rgba(0,0,0,0.13)}
.ulup{position:absolute;color:white;width:100%;text-align:center;bottom:-9px;display:none;font-size:16px}
.menu li:hover .ulup{display:block}
.menu li a i{font-size:14px;margin-left:10px}
#megamenu{width:100%;left:0px;border-radius:5px;position:absolute;overflow:hidden;margin:0;padding:0;background-color:#fff;background-size:100% auto;background-repeat:repeat;background-position:top center}
#megamenu:hover a{border:none}
.menu li #megamenuservice:hover a{border:none}
.ulup.mega{width:auto;margin-left:7%;bottom:-7px}
#fullwidth .ulup.mega{margin-left:6%}
#megamenuservice a{float:none;padding:0;line-height:normal;font-weight:400;font-size:15px;color:#<?php echo $color2;?>}
#megamenuservice{width:30%;margin:0px 8px;margin-top:10px;display:inline-block;text-align:center;vertical-align:top;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out;position:relative;background:rgba(255,255,255,0.7)}
#megamenuservice:hover{box-shadow:0px 0px 20px #ccc,inset 0px 0px 10px 5px #eee}
#megamenuservice i{font-size:50px;margin-left:0}
.menuAc{padding:5px;color:#fff;font-weight:700;cursor:pointer;display:none;font-size:24px;width:100%;float:left}
.sayfalama{width:100%;text-align:center;margin:17px auto}
input,select,textarea{width:100%;background:transparent;border-bottom-width:2px;border-bottom-color:#ccc;padding:10px 0;border-style:none none solid}
input:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;border-style:none none solid}
select:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;border-style:none none solid}
textarea:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;border-style:none none solid}
[data-tooltip],.tooltip{position:relative;cursor:pointer}
[data-tooltip]:before,[data-tooltip]:after,.tooltip:before,.tooltip:after{position:absolute;visibility:hidden;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);opacity:0;-webkit-transition:opacity .2s ease-in-out,visibility .2s ease-in-out,-webkit-transform .2s cubic-bezier(0.71,1.7,0.77,1.24);-moz-transition:opacity .2s ease-in-out,visibility .2s ease-in-out,-moz-transform .2s cubic-bezier(0.71,1.7,0.77,1.24);transition:opacity .2s ease-in-out,visibility .2s ease-in-out,transform .2s cubic-bezier(0.71,1.7,0.77,1.24);-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);transform:translate3d(0,0,0);pointer-events:none}
[data-tooltip]:hover:before,[data-tooltip]:hover:after,[data-tooltip]:focus:before,[data-tooltip]:focus:after,.tooltip:hover:before,.tooltip:hover:after,.tooltip:focus:before,.tooltip:focus:after{visibility:visible;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);opacity:1}
.tooltip:before,[data-tooltip]:before{z-index:1001;border:6px solid transparent;background:transparent;content:""}
.tooltip:after,[data-tooltip]:after{z-index:1000;padding:8px;width:150px;background-color:#ccc;color:#555;content:attr(data-tooltip);font-size:13px;line-height:1.2;text-align:center;display:inline-block;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#raporlar [data-tooltip]:after{width:230px;background:#ccc;color:#2d2d2d;box-shadow:0 0 5px #c5c5c5}
#raporlar .tooltip-bottom:before{border-bottom-color:hsl(0,0%,80%)}
.mpanelinfo [data-tooltip]:after{width:100px;background-color:hsl(32,86%,64%);color:#fff;font-weight:700}
.mpanelinfo .tooltip-right:before{border-top-color:transparent;border-right-color:#000;border-right-color:hsl(32,86%,64%);margin-top:5px}
[data-tooltip]:before,[data-tooltip]:after,.tooltip:before,.tooltip:after,.tooltip-top:before,.tooltip-top:after{bottom:100%;left:50%}
[data-tooltip]:before,.tooltip:before,.tooltip-top:before{margin-left:-6px;margin-bottom:-12px;border-top-color:#ccc}
[data-tooltip]:after,.tooltip:after,.tooltip-top:after{margin-left:-80px}
[data-tooltip]:hover:before,[data-tooltip]:hover:after,[data-tooltip]:focus:before,[data-tooltip]:focus:after,.tooltip:hover:before,.tooltip:hover:after,.tooltip:focus:before,.tooltip:focus:after,.tooltip-top:hover:before,.tooltip-top:hover:after,.tooltip-top:focus:before,.tooltip-top:focus:after{-webkit-transform:translateY(-12px);-moz-transform:translateY(-12px);transform:translateY(-12px)}
.tooltip-left:before,.tooltip-left:after{right:100%;bottom:50%;left:auto}
.tooltip-left:before{margin-left:0;margin-right:-12px;margin-bottom:0;border-top-color:transparent;border-left-color:#000;border-left-color:hsla(0,0%,20%,0.9)}
.tooltip-left:hover:before,.tooltip-left:hover:after,.tooltip-left:focus:before,.tooltip-left:focus:after{-webkit-transform:translateX(-12px);-moz-transform:translateX(-12px);transform:translateX(-12px)}
.tooltip-bottom:before,.tooltip-bottom:after{top:100%;bottom:auto;left:50%}
.tooltip-bottom:before{margin-top:-12px;margin-bottom:0;border-top-color:transparent;border-bottom-color:hsl(0, 0%, 80%)}
.tooltip-bottom:hover:before,.tooltip-bottom:hover:after,.tooltip-bottom:focus:before,.tooltip-bottom:focus:after{-webkit-transform:translateY(12px);-moz-transform:translateY(12px);transform:translateY(12px)}
.tooltip-right:before,.tooltip-right:after{bottom:50%;left:100%}
.tooltip-right:before{margin-bottom:0;margin-left:-12px;border-top-color:transparent;border-right-color:#000;border-right-color:hsla(0,0%,20%,0.9)}
.tooltip-right:hover:before,.tooltip-right:hover:after,.tooltip-right:focus:before,.tooltip-right:focus:after{-webkit-transform:translateX(12px);-moz-transform:translateX(12px);transform:translateX(12px)}
.tooltip-left:before,.tooltip-right:before{top:3px}
.tooltip-left:after,.tooltip-right:after{margin-left:0;margin-bottom:-16px}
.sayfalama span a{text-decoration:none;border-radius: 5px;font-size:15px;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;border:1px solid #CCC;padding:5px 10px}
.sayfalama span a:hover{background-color:#E5E5E5}
.sayfalama .sayfalama-active a{background-color:#E5E5E5}
.iletisimtable{float:left;width:49%}
.iletisiminfo{text-align:center;margin-top:15px;margin-bottom:15px}
.iletisimtable h4{color:#a93030}
.gonderbtn{color:#<?php echo $color2;?>;border:2px solid #<?php echo $color2;?>;display:inline-block;padding:10px 25px;border-radius:50px}
.gonderbtn:hover{color:#FFF;text-decoration:none;background-color:#<?php echo $color2; ?>}
.btn{font-family:'Titillium Web',sans-serif;font-size:15px;cursor:pointer;display:inline-block;padding:10px 5px;width:58%;border-radius:50px;color:#<?php echo $text_color; ?>;border:1px solid #333;margin-top:5px;text-align:center}
.btn:hover{color:#fff;background:#333;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.iletisimbilgileri iframe{box-shadow:0 0 15px #ccc}
.clearmob{display:none}
#slider{position:relative}
#largeredbtn{font-size:16px;color:#FFF;margin-top:30px;padding:10px 60px;border:1px solid #FFF}
#largeredbtn:hover{color:#000;background:#fff}
.slidetext-container h1{font-weight:700;font-size:38px}
.slidetext-container p{font-weight:200;font-size:20px;width:50%}
.slides-container img{opacity:.7;filter:alpha(opacity=70)}
.header{background-position:center center;margin-bottom:10px;background-image:url(../images/image4.jpg);float:left;height:300px;width:100%;position:relative;z-index:55;-webkit-box-shadow:inset 0 198px 110px -45px rgba(0,0,0,0.68);-moz-box-shadow:inset 0 198px 110px -45px rgba(0,0,0,0.68);box-shadow:inset 0 198px 110px -45px rgba(0,0,0,0.68);background-size:100% auto}
#fullwidth #wrapper{width:85%}
#muspanel .header{height:auto;margin-bottom:0;}
#home .header{position:absolute;background:none}
.head{width:85%;margin-right:auto;margin-left:auto;margin-top:25px}
.sosyalbtns a{float:left;color:#ffffff87;font-size:18px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;width:40px;height:40px;text-align:center;line-height:40px;border:1px solid transparent}
.sosyalbtns a:hover{color:#fff;border:1px solid #fff}
.sosyalbtns{float:left}
.langbtn{float:left;margin-left:10px}
.langbtn a{color:#fff;line-height:40px;margin:0 5px}
.headbutonlar{float:right;    font-family: 'Raleway',sans-serif;}
.headbutonlar a{float:right;color:#ffffff87;margin-left:30px;font-size:15px}
.headbutonlar a:hover{color:#ccc}
.headbutonlar i{margin-right:7px}
#sepeticon{font-size:26px;float:right;color:#fff;margin-top:-7px;margin-right:15px}
.sabithead #sepeticon{font-size:26px;margin-top:15px;float:right;color:#fff}
#sepeticon span{font-size:13px;width:20px;height:20px;background:linear-gradient(#9BC90D 0%,#79A70A 100%);color:#fff;position:absolute;text-align:center;line-height:19px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;margin-left:-10px}
.logo{float:left;margin-top:15px;position:absolute}
#muspanel .logo{position:relative;margin-bottom:20px}
#muspanel #fullwidth .logo{margin-bottom:0}
.logo img{width:180px}
.domainhome{background-color:#<?php echo $color1; ?>;float:left;height:112px;width:100%}
#v2domainhome{background-color:#2c3037}
.hdomainslogan{color:#fff;margin-top:20px;float:left}
.hdomainslogan h3{font-size:27px;font-weight:700}
.hdomainslogan h4{font-size:22px;font-weight:200}
.hdomainsorgu{float:right;width:47%;margin-top:10px}
.hdomainsorgu input{width:100%;padding:20px 0;color:#fff;font-size:26px;background:transparent;outline:none;border-color:transparent transparent #fff;border-style:solid;border-width:2px;position:relative;z-index:2}
.hdomainsorgu ::-webkit-input-placeholder{color:#fff}
.hdomainsorgu :-moz-placeholder{color:#fff}
.hdomainsorgu ::-moz-placeholder{color:#fff}
.hdomainsorgu :-ms-input-placeholder{color:#fff}
.hsorgulabtn{color:#fff;font-size:30px;padding:13px 15px;margin-top:-73px;float:right;position:relative;z-index:2;margin-right:-3px}
.hsorgulabtn:hover{color:#<?php echo $color1; ?>;background:#fff}
.domainfiyatlar{background-color:#696f7a;float:left;white-space:nowrap;overflow:hidden;height:50px;width:100%;box-shadow:0 0 10px #696f7a}
.domainfiyatlar h4{float:left;color:#fff;font-weight:600;font-size:24px;margin:5px 20px;text-shadow:0 0 2px #4a4e55;text-transform:lowercase}
.domainfiyatlar h4 span{color:#393d45;font-weight:700;font-size:22px}
.tablopaketler{background-repeat:no-repeat;background-position:center top;float:left;width:100%;background-size:100% 100%;text-align:center; padding: 25px 0px; margin: 35px 0px;}
#wrapper .tablopaketler { padding-top: 0px; margin-top: 35px; padding-bottom: 0px; margin-bottom: 0px;}
.tablopaketler{margin-bottom:25px;padding-bottom:50px;padding-top:35px}
.pakettitle{float:left;width:100%;padding-top:15px;text-align:center;    color: #<?php echo $color1; ?>;}
 .pakettitle{margin-top:50px;padding-bottom:15px}
.line{background-color:#ddd;float:left;height:0.5px;width:100%;margin-top:15px;margin-bottom:15px}
.pakettitle .line {display:none;}
.pakettitle h2{font-size:22px;margin:15px 0;display:inline-block;font-weight:300;color:#<?php echo $color2;?>}
.pakettitle h1{font-size:34px}
.tablopaketler .gonderbtn{border:none;font-size:17px;padding:17px 30px;color:#<?php echo $color2;?>;float:none;margin:5px;border-radius:50px;-webkit-box-shadow:0px 20px 45px 0px rgba(0,0,0,0.08);box-shadow:0px 20px 45px 0px rgba(0,0,0,0.08)}
.tablopaketler .gonderbtn:hover{background:#<?php echo $color1; ?>;color:#fff}
#paketaktifbtn{background:#<?php echo $color2; ?>;color:#fff}
.miotab-content{text-align:center}
.tablepaket{background-color:#FFF;display:inline-block;vertical-align:top;width:31%;text-align:center;margin:8px;padding-bottom:15px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;position:relative;-webkit-transition: all 0.3s ease-out;
-moz-transition: all 0.3s ease-out;
-ms-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;}
.tablepaket strong{margin-bottom:10px;display:inline-block}
.tablepaket b{margin-bottom:10px;display:inline-block}
.tablepaket.active{border:2px solid #<?php echo $color1;?>;padding:25px 0px;margin-top:-10px;overflow:hidden}
.tablepaket.active .gonderbtn {   background: #<?php echo $color1; ?>;    color: #fff;}
.tablepaket.active .gonderbtn i{display:none;font-size:20px;-webkit-animation-name:fadeInUp;animation-name:fadeInUp;-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;position:absolute}
 @-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}
100%{opacity:1;-webkit-transform:none;transform:none}
}
@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}
100%{opacity:1;-webkit-transform:none;transform:none}
}
.tablepaket .gonderbtn i{display:none}
.tablepaket:first-child:nth-last-child(4),.tablepaket:first-child:nth-last-child(4) ~ .tablepaket{width:23%}
.tablepaket:first-child:nth-last-child(8),.tablepaket:first-child:nth-last-child(8) ~ .tablepaket{width:23%}
.tablepaket:first-child:nth-last-child(12),.tablepaket:first-child:nth-last-child(12) ~ .tablepaket{width:23%}
.tablepaket:hover{-webkit-box-shadow:0px 20px 45px 0px rgba(0,0,0,0.17);box-shadow:0px 20px 45px 0px rgba(0,0,0,0.17)}
.tpakettitle{width:100%;color:#<?php echo $color2;?>;text-align:center;font-size:28px;font-weight:900;margin-bottom:15px;margin-top:25px}
.paketline{height:1px;background:#cecece;width:50%;display:inline-block;margin:10px auto}
#upgrade .paketline {    display: block;}
#tableactive {border:2px solid #<?php echo $color1; ?>}
.tpakettitle i{color:#<?php echo $color2; ?>;margin-top:-12px;float:left;text-align:center;width:100%;font-size:28px}
.ribbonx{width:200px;height:300px;position:relative;border:1px solid #BBB;background:#EEE}
.ribbon{position:absolute;left:-5px;top:-5px;z-index:1;overflow:hidden;width:75px;height:75px;text-align:right}
.ribbon div{font-size:12px;font-weight:700;color:#FFF;text-transform:uppercase;text-align:center;line-height:20px;transform:rotate(-45deg);-webkit-transform:rotate(-45deg);width:100px;display:block;background:#79A70A;background:linear-gradient(#9BC90D 0%,#79A70A 100%);box-shadow:0 3px 10px -5px rgba(0,0,0,1);position:absolute;top:19px;left:-21px}
.ribbon div::before{content:"";position:absolute;left:0;top:100%;z-index:-1;border-left:3px solid #79A70A;border-right:3px solid transparent;border-bottom:3px solid transparent;border-top:3px solid #79A70A}
.ribbon div::after{content:"";position:absolute;right:0;top:100%;z-index:-1;border-left:3px solid transparent;border-right:3px solid #79A70A;border-bottom:3px solid transparent;border-top:3px solid #79A70A}
div.mostpopularx{-webkit-animation:blink 3s linear 0 infinite normal;animation:blink 3s linear 0 infinite normal}
@-webkit-keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
@keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
.tablepaket span{float:left;width:100%;padding:5px 0}
.tablepaket h3{color:#<?php echo $color1;?>;float:left;width:100%;font-size:36px;font-weight:900}
.tablepaket h3 div{position:relative;display:inline}
.tablepopular{position:absolute;background:#<?php echo $color1;?>;color:white;width:150px;height:60px;font-size:14px;-ms-transform:rotate(20deg);-webkit-transform:rotate(20deg);transform:rotate(-40deg);left:-52px;line-height:80px;top:-12px}
.tablepaket h4{font-weight:300;font-size:22px;color:#<?php echo $color2;?>;line-height:25px;display:inline-block;width:100%}
.tablepaket .gonderbtn{margin-top:10px;display:inline-block;width:41%;text-transform:uppercase;margin-bottom: 15px;background:#fff;color:white;border:none;font-weight:600;background:#4CAF50}
.tablepaket .gonderbtn:hover {background:#<?php echo $color1; ?>}
.tablepaket .gonderbtn i{margin-right:5px}
.anascript{background-image:url(../images/anascript-bg.jpg);background-repeat:no-repeat;background-position:center center;float:left;text-align:center;width:100%;background-size:100% 100%;padding:25px 0;}
.scriptkategoriler{float:left;width:23%;margin-top:15px}
.scriptkategoriler a{float:left;width:100%;color:#fff;padding:6px;padding-left:20px;margin-bottom:8px;font-size:16px;border-left-width:1px;border-left-style:solid;border-left-color:#FFF}
.scriptkategoriler a span{font-weight:600}
.scriptkategoriler a:hover{background:#fff;color:#000}
#scataktif{background:#fff;color:#000}
.anascriptlist{position:relative;display:inline-block;vertical-align:top;background-color:#FFF;margin:1%;width:255px;text-align:center;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;border-radius: 7px;overflow: hidden;}
.anascriptlist:hover{box-shadow:0 0 10px #ccc}
.anascriptlist h4{font-size:15px;margin-top:10px;font-family:'Raleway',sans-serif}
.anascripler{float:right;width:72%;margin-top:15px}
.anascriptlist div h5{color: #<?php echo $color1; ?>;font-size: 26px;    margin-bottom: 10px;    font-weight: 900;}
.tumscriptbtn{font-size:16px;margin:15px 0;margin-top:20px}
.scriptozellk{float:left;padding: 3px 10px;font-size: 14px;color:#fff;background:#54d719;opacity:.8;filter:alpha(opacity=80);margin-bottom:-45px;margin-top:15px;}
#mobiluyum{margin-bottom:-75px;margin-top:50px;background:#<?php echo $color2; ?>}
.ribbon{position:absolute;left:-5px;top:-5px;z-index:1;overflow:hidden;width:75px;height:75px;text-align:right}
.ribbon span{font-size:10px;font-weight:700;color:#FFF;text-transform:uppercase;text-align:center;line-height:20px;transform:rotate(-45deg);-webkit-transform:rotate(-45deg);width:100px;display:block;background:#79A70A;background:linear-gradient(#2989d8 0%,#1e5799 100%);box-shadow:0 3px 10px -5px rgba(0,0,0,1);position:absolute;top:19px;left:-21px}
.ribbon span::before{content:"";position:absolute;left:0;top:100%;z-index:-1;border-left:3px solid #1e5799;border-right:3px solid transparent;border-bottom:3px solid transparent;border-top:3px solid #1e5799}
.ribbon span::after{content:"";position:absolute;right:0;top:100%;z-index:-1;border-left:3px solid transparent;border-right:3px solid #1e5799;border-bottom:3px solid transparent;border-top:3px solid #1e5799}
.ribbon2{position:absolute;right:-5px;top:-5px;z-index:1;overflow:hidden;width:75px;height:75px;text-align:right}
.ribbon2 span{font-size:10px;font-weight:700;color:#FFF;text-transform:uppercase;text-align:center;line-height:20px;transform:rotate(45deg);-webkit-transform:rotate(45deg);width:100px;display:block;background:#79A70A;background:linear-gradient(#9BC90D 0%,#79A70A 100%);box-shadow:0 3px 10px -5px rgba(0,0,0,1);position:absolute;top:19px;right:-21px}
.ribbon2 span::before{content:"";position:absolute;left:0;top:100%;z-index:-1;border-left:3px solid #79A70A;border-right:3px solid transparent;border-bottom:3px solid transparent;border-top:3px solid #79A70A}
.ribbon2 span::after{content:"";position:absolute;right:0;top:100%;z-index:-1;border-left:3px solid transparent;border-right:3px solid #79A70A;border-bottom:3px solid transparent;border-top:3px solid #79A70A}
.anascriptlist img{height:190px;width:100%;    border-radius: 5px;}
.scripthoverinfo{-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;opacity:0;filter:alpha(opacity=00);position:absolute;width:255px;height:195px;background:rgba(0,0,0,0.6)}
.scripthoverinfo a{color:#fff;background: none;border:2px solid #fff;margin:80px 5px;       padding: 8px 13px;border-radius: 5px;}
.scripthoverinfo a:hover{-webkit-transform:scale(1.10);-moz-transform:scale(1.10);-ms-transform:scale(1.10);-o-transform:scale(1.10);transform:scale(1.10);background:#fff;color:#000}
.urunozellikleri{width:100%;display:inline-block;margin-top:25px;text-align:center}
.urunozellik{display:inline-block;border:1px solid #333;padding:15px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:26%;padding:15px;margin:9px;text-align:center;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.urunozellik h4{font-weight:600;font-size: 16px;}
.urunozellik i{font-size:35px;margin-bottom:10px}
.katslogan{float:left;width:100%;text-align:center;margin-top:10px}
.urunozellikleri .fa-caret-right{display:inline-block;font-size:24px;margin-left:-13px;margin-top:50px;position:absolute}
.urunozellikleri .fa-check-circle{display:inline-block;font-size:20px;margin-left:-18px;margin-top:50px;background:#fff;position:absolute}
.anascriptlist:hover .scripthoverinfo{opacity:1;filter:alpha(opacity=100)}
.nedenbiz{background-image:url(../images/nedenbizbg.jpg);background-repeat:repeat;background-position:center center;float:left;height:auto;width:100%;margin:35px 0;box-shadow: inset 0 0 70px 30px #fff;;text-align: center;}
.ozellik{height:auto;width: 28%;text-align: center;margin: 30px;/* float:left; */display: inline-block;vertical-align: top;}
.servisikon{height:120px;width:120px;/* float:left; */background:#f0f0f0;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;line-height:150px;display:inline-block;text-align:center;font-size:54px;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;/* margin-right:20px; */}
.ozellik h4{color:#<?php echo $color2; ?>;font-weight:700;font-size: 24px;    margin-bottom: 15px;}
.ozellik p{font-size:15px;line-height:20px;margin:0}
.servisikonalt{height:104px;width:104px;color:#<?php echo $color1; ?>;border:3px solid #fff;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;float:left;margin-left:5px;margin-top:5px;line-height:104px;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;overflow:hidden}
.ozellik .servisikonalt:hover{background:#<?php echo $color1; ?>}
.ozellik .servisikonalt:hover i{color:#fff}
.ozellik:hover .servisikon{background:#<?php echo $color1; ?>}
.ozellik:hover .servisikonalt i{color:#fff}
.servisinfos{/* float:right; */width: 100%;margin-top: 10px;}
#genelpaketler .pakettitle{color:#FFF}
#genelpaketler .gonderbtn{color:#FFF;border:2px solid #FFF}
#genelpaketler .gonderbtn:hover{background:#<?php echo $color1; ?>;border:2px solid #<?php echo $color1; ?>}
#genelpaketler #paketaktifbtn{background:#<?php echo $color1; ?>;border:2px solid #<?php echo $color1; ?>}
#genelpaketler .tpakettitle{background:#<?php echo $color1; ?>}
#genelpaketler .fa.fa-caret-down{color:#<?php echo $color1; ?>}
#genelpaketler .tablepaket .gonderbtn{color:#<?php echo $color1; ?>;border:2px solid #<?php echo $color1; ?>}
#genelpaketler .tablepaket .gonderbtn:hover{color:#fff}
#genelpaketler .tablepaket h3{color:#<?php echo $color1; ?>}
#genelpaketler .tablepaket h4{color:#<?php echo $color1; ?>}
.musterigorusleri{width:100%;float:left;margin:25px 0}
.list_carousel{width:100%;margin:auto;height:auto}
.list_carousel ul{margin:0;padding:0;list-style:none;display:block}
.list_carousel li{width:250px;height:auto;display:block;float:left}
.list_carousel.responsive{width:auto;margin-left:0}
.clearfix{float:none;clear:both}
.prev{float:left;margin-left:10px}
.next{float:right;margin-right:10px}
.pager{float:right;text-align:right;margin-top:-95px;position:relative;z-index:22}
.pager a.selected{text-decoration:underline}
.pager a{margin:3px;border:2px solid #<?php echo $color2; ?>;background:#fff;color:transparent;width:22px;height:22px;float:left;-webkit-border-radius:100;-moz-border-radius:100;border-radius:100%}
.pager a:hover{background:#<?php echo $color2; ?>}
.pager a.selected{background:#<?php echo $color2; ?>}
.musterigorusleri .list_carousel{width:900px;margin:auto}
#foo2 li{width:900px;height:250px}
.musyorum{width:100%;height:auto;color:#<?php echo $color2; ?>;background:#eeeeee57;text-align:center;float:left;font-size:16px;font-weight:500;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px}
#mgorusarrow{margin-left:25px;font-size:65px;position:absolute;margin-top:-66px;color:#eeeeee57}
.yorumyapan{float:left;margin-top:25px;margin-left:25px;width:45%}
.yorumyapan img{-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;float:left;margin-right:20px}
.yorumyapan h3{float:left;font-size:18px;font-weight:700;width:75%;    margin-top: 10px;}
.yorumyapan h4{float:left;font-size:16px;width:75%;font-weight:300}
.gorusgonderbtn{float:right;margin-top:-45px;font-weight:700;position:relative;z-index:22;color:#999}
.gorusgonderbtn:hover{color:#000}
.modalDialog{position:fixed;top:0;right:0;bottom:0;left:0;background:rgba(0,0,0,0.7);z-index:99999;opacity:0;-webkit-transition:opacity 400ms ease-in;-moz-transition:opacity 400ms ease-in;transition:opacity 400ms ease-in;pointer-events:none}
.modalDialog:target{opacity:1;pointer-events:auto}
.modalDialog>div{width:700px;position:relative;margin:5% auto;padding:5px 20px 13px;border-radius:4px;background:#fff}
.close{background:#606061;color:#FFF;line-height:25px;position:absolute;right:-10px;text-align:center;top:-10px;width:24px;text-decoration:none;font-weight:700;-webkit-border-radius:12px;-moz-border-radius:12px;border-radius:12px;-moz-box-shadow:1px 1px 3px #000;-webkit-box-shadow:1px 1px 3px #000;box-shadow:1px 1px 3px #000}
.close:hover{background:#00d9ff}
#gorusgonder input{margin-bottom:5px}
#gorusgonder hr{border:1px solid #ccc}
.modalDialog h2{font-size:20px;padding:15px 0;margin-bottom:15px;border-bottom:1px solid #eee}
.blogvehaber{background-image:url(../images/bloghaberbg.jpg);background-repeat:repeat;background-position:center top;float:left;width:100%;margin:35px 0;text-align:center;padding:30px 0;box-shadow:inset 0 0 70px 40px #fff}
.haberblog{background:#fff;width:485px;float:none;margin:20px 25px;display:inline-block;text-align:left;vertical-align:top;    border-radius: 7px;}
.haberbloktitle{width:100%;float:left;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee}
.haberbloktitle h4{font-weight:700}
.haberbloktitle i {color:#<?php echo $color2; ?>}
.haberblog li{width:455px}
.haberblog .list_carousel li img{float:left;margin-right:15px;    border-radius: 7px;}
.haberblog li h4 a{color:#<?php echo $color1; ?>;font-size:20px;font-weight:600;font-family:'Raleway',sans-serif;}
.haberblog li h4 span{font-size:16px;color:#77777787}
.haberblog .pager{margin:0}
.haberblog p{font-size:14px}
.pager a{width:18px;height:18px;border:2px solid #ccc}
.pager a:hover{background:#ccc}
.pager a.selected{background:#ccc}
.haberbloktitle h4{font-size:18px}
#bloghome{float:right}
.rakamlarlabiz{margin-bottom:35px;float:left;width:100%}
.istatistik{float:left;width:22%;margin:15px;text-align:center}
.istatistik h1{font-size:46px;font-weight:700;color:#<?php echo $color2; ?>}
.istatistik h2{font-size:24px;font-weight:200;color:#<?php echo $color2; ?>;margin-top:15px}
.istatistik span{width:70%;height:1px;background:#<?php echo $color2; ?>;display:inline-block}
.istatistik i{font-size:120px;color:#eee;float:right;position:absolute;margin-top:-130px;z-index:-1}
.footlogos{text-align:center;margin-top:20px;float:left;width:100%}
.footlogos img{width:120px;vertical-align:middle;margin:17px;-webkit-filter:grayscale(100%);filter:grayscale(100%)}
.footlogos img:hover{-webkit-filter:none;filter:none}
.ebulten{background-image:url(../images/ebultenbg.jpg);background-repeat:no-repeat;background-position:center center;float:left;height:200px;width:100%;background-size:100% auto}
.ebultencont{background-color:#FFF;width:700px;margin:auto;height:55px;margin-top:70px;box-shadow:0 0 45px #a9a9a9a8;border-radius:50px}
.ebultencont i{float:left;font-size:24px;color:#ccc;margin:14px;margin-left:20px}
.ebultencont input{float:left;border:none;line-height:45px;width:450px;padding:5px;font-family: 'Raleway',sans-serif;}
.aboneolbtn{background:#<?php echo $color2; ?>;color:#fff;border:none;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;float:right;margin:6px;width:95px;text-align:center;    border-radius: 50px;}
.aboneolbtn:hover{background:#<?php echo $color1; ?>;}
.footslogan{float:left;text-align:center;width:100%;color:#ffffff80}
.footslogan:hover h2 a{color:white}
.footslogan h4{font-size:22px;font-weight:200}
.footslogan h2{margin-bottom:10px;font-size:30px;font-weight:600}
.footer{background-image:url(../images/footerbg.png);background-color:#2e3d44;background-size:100% auto;background-repeat:repeat;background-position:center top;float:left;height:auto;width:100%;padding:70px 0;color:#fff}
.footslogan a{color:#fff}
.footer a{color:#ffffff80}
.footlogo{width:180px;margin-bottom:30px}
.footinfos{float:left;width:25%;margin-right:20px;color:#ffffff80;font-family:'Raleway',sans-serif}
.footinfos h5{font-size:15px;font-weight:600;margin:20px 0px}
.footinfos h4{font-weight:600;margin:15px 0px}
.footinfos h5 span{margin-top:10px;float:left;width:100%;font-weight:900}
.footblok{float:left;width:14%;margin:21px;font-size:14px;font-family:'Raleway',sans-serif}
.footblok h3{font-weight:900;font-size:15px;margin-bottom:10px}
.footblok a{color:#ffffff9e;float:left;width:100%;font-weight:400;padding:5px 0px}
.footblok a:hover{padding-left:3px;color:#fff}
.footend{width:100%;background:#1c1c1c;height:74px;float:left}
.footend a{color:#ccc}
.footend span{line-height:74px;color:#ccc;font-weight:200;float:left}
.footer .line{background-color:#4c606b;margin-top:25px;margin-bottom:25px}
.footsosyal{display:inline-block;margin:auto;width:100%;text-align:center}
.footsosyal a{display:inline-block;color:#ffffff87;font-size:18px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;width:50px;height:50px;text-align:center;line-height:50px;border:1px solid transparent;margin:0px 10px}
.footsosyal a:hover{background:#00000030}
.cd-top{display:inline-block;height:60px;border-radius: 5px;width:60px;position:fixed;bottom:50px;right:20px;box-shadow:0 0 10px rgba(0,0,0,0.05);overflow:hidden;text-indent:100%;white-space:nowrap;background:rgba(232,98,86,0.8) url(../images/cd-top-arrow.svg) no-repeat center 50%;visibility:hidden;opacity:0;-webkit-transition:opacity .3s 0s,visibility 0 .3s;-moz-transition:opacity .3s 0s,visibility 0 .3s;transition:opacity .3s 0s,visibility 0 .3s}
.cd-top.cd-is-visible,.cd-top.cd-fade-out,.no-touch .cd-top:hover{-webkit-transition:opacity .3s 0s,visibility 0 0;-moz-transition:opacity .3s 0s,visibility 0 0;transition:opacity .3s 0s,visibility 0 0}
.cd-top.cd-is-visible{visibility:visible;opacity:1}
.cd-top.cd-fade-out{opacity:.5}
.cd-top.cd-fade-out:hover{opacity:1.5}
.no-touch .cd-top:hover{background-color:#e86256;opacity:1}
.sabithead{display:none;background-color:#<?php echo $color2;?>}
.sabithead .menu li a{line-height:60px;font-weight:600;font-size:15px;text-shadow:0 0 2px #767676}
.sabithead .menu li ul li a{line-height:40px}
.sabithead .menu ul li ul li a{border:none;color:white;font-weight:300}
.sabithead .menu ul li ul {    background: #<?php echo $color2; ?>;top:60px;}
.sabithead .menu li:hover a{border: none}
.sabithead .ulup {bottom: -5px;}
#fullwidth{position:relative;height:auto;background:none;margin:0;padding-bottom:0}
#muspanel #fullwidth{height:auto;}
#fullwidth .head{width:100%;background:#e5e5e5;margin:0;height:50px;line-height:50px}
#fullwidth .head a{color:#3d3d3d;padding:0 15px;margin-left:0}
#fullwidth .head a:hover{background:#d8d8d8}
#fullwidth #sepeticon{margin-top:12px;position:relative;z-index:22;color:#fff;font-size:28px}
#fullwidth #sepeticon span{font-size:13px;width:20px;height:20px;background:linear-gradient(#9BC90D 0%,#79A70A 100%);color:#fff;position:absolute;text-align:center;line-height:20px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;margin-left:-10px}
#fullwidth .headustlinks a{line-height:50px;padding:0 10px;float:left;border-right:1px solid #dedede}
#fullwidth .sosyalbtns a{padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;border:none;line-height:50px;height:auto}
#fullwidth .sosyalbtns a:hover{background:#d8d8d8}
.fullwidthhead{width:100%;height:auto;padding:12px 0;float:left;background-image:url(../images/menubg2018.jpg);position:relative;margin-top:0;background-size:100%;background-color:white}
#fullwidth .logo{padding:5px 0;display:inline-block;float:left;height:40px;position:relative;margin:0px;width:auto}
#fullwidth .headbutonlar a{float:right;color:#<?php echo $color2;?>;margin-left:10px;font-size:14px;border:2px solid transparent;padding:10px 15px;border-radius:50px;font-weight:500}
#fullwidth .headbutonlar a:hover{color:white;background:#<?php echo $color2;?>}
#fullwidth .headbutonlar{margin-top:5px}
#fullwidth .langbtn{float:left;margin-left:20px;margin-top:15px;font-size:16px}
#fullwidth .langbtn a{color:#333}
.headmail{float:right;margin-top:5px;font-size:16px;margin-left:40px;color:#333}
.headmail a{color:#333}
.headmail i{float:left;font-size:40px;margin-right:10px;margin-top:5px}
.headinfospan{float:left;font-size:16px;line-height:23px}
#fullwidth .menu{float:left;width:100%;margin:0;background-image:url(../images/menubg.jpg);background-position:top center}
.menucolor{background-color:#<?php echo $color2; ?>;float:left;    z-index: -1;height:68px;width:100%;position:absolute;opacity:.3;filter:alpha(opacity=30)}
#fullwidth .menu ul li ul li:hover a{background:rgba(0,0,0,0.3)}
#fullwidth .menu li:hover a{background:rgba(0,0,0,0.2);color:#ffffffd6}
#fullwidth .menu ul li ul li ul{top:0px}
#fullwidth .menu ul li ul{background:#<?php echo $color2;?>;-webkit-border-bottom-right-radius:5px;-webkit-border-bottom-left-radius:5px;top:68px;-moz-border-radius-bottomright:5px;-moz-border-radius-bottomleft:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;border-top-left-radius:0px;border-top-right-radius:0px}
#fullwidth .headbutonlar #headicon{font-size:20px;padding:0px;width:30px;height:30px;line-height:30px;text-align:center;margin:0px;margin-right:20px;margin-top:3px}
#fullwidth .headbutonlar #headicon .basket-count{font-size:13px;width:20px;height:20px;background:linear-gradient(#9BC90D 0%,#79A70A 100%);color:#fff;position:absolute;text-align:center;line-height:20px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;margin-left:-5px;margin-top:-5px}
#fullwidth .headbutonlar #headicon .fa-shopping-cart{font-size:22px}
#fullwidth #megamenuservice{width:20%;box-shadow:none;background:rgba(0,0,0,0.28)}
#fullwidth #megamenuservice:hover {    background:#<?php echo $color1; ?>69;}
#fullwidth #megamenuservice:hover a{background:none}
#fullwidth #megamenuservice a{padding:0px}
.digerhmzinfo{float:right;width:200px;color:white;position:absolute;right:0px;top:0px;padding:0px 45px;height:100%;background:#<?php echo $color1;?>;font-weight:200}
.digerhmzinfo h5{margin-top:25px;font-family:'Raleway',sans-serif}
.digerhzmucgen{width:0;height:0;top:30px;position:absolute;border-style:solid;border-width:15px 15px 15px 0;border-color:transparent #<?php echo $color1;?>transparent transparent;margin-left:-53px;margin-top:65px}
#fullwidth .menu li .digerhmzinfo a{padding:10px 25px;line-height:normal;float:left;border-radius:50px;margin-top:10px;font-size:15px}
#fullwidth .menu li .digerhmzinfo a:hover{background:rgba(0,0,0,0.34)}
#megamenu:hover #megamenuservice a {background:none;}
#fullwidth .menu li:hover #megamenuservice a {background:none;}
#fullwidth #megamenu {    color: #ffffffd6;}
#fullwidth .headbutonlar .borderedbtn {border:2px solid #<?php echo $color2; ?>}
#fullwidth .headbutonlar #headicon i{margin:0px;}
#slider2,#slider3{box-shadow:none;-moz-box-shadow:none;-webkit-box-shadow:none;margin:0 auto}
.rslides_tabs{list-style:none;padding:0;background:rgba(0,0,0,.25);box-shadow:0 0 1px rgba(255,255,255,.3),inset 0 0 5px rgba(0,0,0,1.0);-moz-box-shadow:0 0 1px rgba(255,255,255,.3),inset 0 0 5px rgba(0,0,0,1.0);-webkit-box-shadow:0 0 1px rgba(255,255,255,.3),inset 0 0 5px rgba(0,0,0,1.0);font-size:18px;list-style:none;margin:0 auto 50px;max-width:540px;padding:10px 0;text-align:center;width:100%}
.rslides_tabs li{display:inline;float:none;margin-right:1px}
.rslides_tabs a{width:auto;line-height:20px;padding:9px 20px;height:auto;background:transparent;display:inline}
.rslides_tabs li:first-child{margin-left:0}
.rslides_tabs .rslides_here a{background:rgba(255,255,255,.1);color:#fff;font-weight:700}
.callbacks_container .slidetext-container{width:80%;margin:12%;margin-top:8%;position:absolute;z-index:22}
.callbacks{position:relative;list-style:none;overflow:hidden;width:100%;padding:0;margin:0}
.callbacks li{position:absolute;width:100%;left:0;top:0}
.callbacks img{display:block;position:relative;z-index:1;height:auto;width:100%;border:0}
.callbacks .caption{display:block;position:absolute;z-index:2;font-size:20px;text-shadow:none;color:#fff;background:#000;background:rgba(0,0,0,.8);left:0;right:0;bottom:0;padding:10px 20px;margin:0;max-width:none}
.callbacks_nav{position:relative;-webkit-tap-highlight-color:rgba(0,0,0,0);left:0;display:none;opacity:.7;z-index:3;text-indent:-9999px;overflow:hidden;text-decoration:none;height:61px;width:38px;background:transparent url(../images/themes.png) no-repeat left top;margin-top:-120px}
.callbacks_nav:active{opacity:1}
.callbacks_nav.next{left:auto;background-position:right top;right:0}
.head2logo{float:left;margin-right:25px}
.slidetext-container{width:80%;margin:auto;margin-top:20%;color:#fff;text-align:left}
.sayfaustheader{background-image:url(../images/image4.jpg);background-repeat:no-repeat;background-position:center top;float:left;height:260px;width:100%;background-size:100% auto}
.headerwhite{background-image:url(../images/headerwhite.png);background-repeat:repeat;background-position:center bottom;width:100%;height:149px;display:inline-block;position:absolute;bottom:-2px}
#home .headerwhite {display:none;}
#muspanel .sayfabaslik{margin-top:20px;display:none}
.sayfabaslik{float:right;color:#fff;text-align:right;margin-top:35px;position:relative;z-index:1;text-shadow:0 0 2px #666}
.sayfabaslik i{font-size:12px;margin:10px}
.sayfabaslik a{color:#fff;font-weight:200;font-size:16px}
.sayfabaslik a:hover{color:#ccc}
.sayfabaslik h1{font-weight:bolder;font-size:24px}
.sayfacontent{float:right;width:74%;margin-bottom:35px;}
.sidebar{float:left;width:24%;border-right-width:3px;border-bottom-width:3px;border-right-style:solid;border-bottom-style:solid;border-right-color:#ececec;border-bottom-color:#ddd;margin-top:20px;margin-bottom:35px}
.sidelinks a{float:left;width:100%;padding:10px 0;-webkit-border-radius:7px;-webkit-border-top-right-radius:1px;-webkit-border-bottom-right-radius:1px;-moz-border-radius:7px;-moz-border-radius-topright:1px;-moz-border-radius-bottomright:1px;border-radius:7px;border-top-right-radius:1px;border-bottom-right-radius:1px;border-bottom:1px solid #eee}
.sidelinks span{padding:2px 7px;display:inline-block}
.sidelinks a:hover{color:#<?php echo $color1; ?>;background:#eee}
.paypasbutonlar{float:right;margin-top:20px;text-align:center;color:#666;-webkit-border-top-left-radius:3px;-webkit-border-top-right-radius:3px;-moz-border-radius-topleft:3px;-moz-border-radius-topright:3px;border-top-left-radius:3px;border-top-right-radius:3px;position:relative}
.scriptpaylas{margin-top:15px}
.fullwidtscriptdetay{margin-top:-65px}
#header2 .paypasbutonlar{margin-top:45px}
.paypasbutonlar a{color:#666;float:left;height:40px;width:40px;font-size:16px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;text-align:center;line-height:250%;background:#fff;border-top:1px solid #eee}
.paypasbutonlar a:hover{color:#fff;background:#666}
#facepaylas:hover{background:#365899}
#twitpaylas:hover{background:#1da1f2}
#googlepaylas:hover{background:#d73d32}
#linkedpaylas:hover{background:#008cc9}
#uyeolgirisbody{background:#000}
#uyeolgirisbody .footend{bottom:0;position:fixed}
.uyeolgirishead{float:left;width:100%;margin-top:15px;color:#fff;margin-bottom:5%}
.uyeolgirishead h1{float:right;font-weight:200;margin-top:30px}
.uyeolgirisyap{float:left;width:100%;margin-bottom:80px}
#girisyapright h4{border-bottom:1px solid #ccc;padding-bottom:10px}
#girisyapright h4 i{margin-right:5px}
.uyeol h4{border-bottom:1px solid #ccc;padding-bottom:10px}
.uyeol h4 i{margin-right:5px}
.sifreunuttulink{float:right}
.uyeolgirisyap .btn{font-size:16px;    padding: 15px 0px;background:#fff;margin-bottom:15px;border:1.5px solid #<?php echo $color1; ?>;color:#<?php echo $color1; ?>;font-weight:700;outline:none}
.uyeolgirisyap .btn:hover{background:#<?php echo $color1; ?>;color:#fff;border:1.5px solid transparent}
.uyeol{float:right;width:40%;margin-bottom:20px;background:#fff;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px}
.girisyap h3{text-align:center;font-size:20px;margin-top:30px;font-weight:700}
.uyeolgirisslogan{float:left;color:#fff;width:40%;text-align:center;margin-top:6%}
.uyeolgirisyap .gonderbtn{float:none;color:#fff;border:1px solid #fff;padding:15px 45px;font-weight:700;font-size:16px}
.uyeolgirisyap .gonderbtn:hover{background:#fff;color:#000}
.checkbox-custom,.radio-custom{opacity:0;position:absolute}
.checkbox-custom,.checkbox-custom-label,.radio-custom,.radio-custom-label{display:inline-block;vertical-align:middle;cursor:pointer;width:auto}
.checkbox-custom-label,.radio-custom-label{position:relative;margin-bottom: 5px;}
.checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before{content:'';border:1.5px solid #<?php echo $color1; ?>;    border-radius: 5px;display:inline-block;line-height:20px;vertical-align:middle;width:20px;height:20px;padding:2px;margin-right:10px;text-align:center}
.checkbox-custom:checked+.checkbox-custom-label:before{content:"\f00c";font-family:'FontAwesome';background:#<?php echo $color1; ?>;color:#fff;font-size:15px}
.radio-custom+.radio-custom-label:before{border-radius:50%}
.radio-custom:checked+.radio-custom-label:before{content:"\f00c";font-family:'FontAwesome';color:#fff;background:#<?php echo $color1; ?>}
#uyelik table tbody tr td h4{padding-bottom:10px;border-bottom:1px solid #eee;margin-top:-8px}
#uyelik input{border-bottom-width:2px;border-bottom-color:#ccc;padding:10px 0;border-style:none none solid}
#uyelik input:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;border-style:none none solid}
.uyeolgirisslogan h4{font-weight:200}
#uyelik::-webkit-input-placeholder{color:#444}
#uyelik:-moz-placeholder{color:#444}
#uyelik::-moz-placeholder{color:#444}
#uyelik:-ms-input-placeholder{color:#444}
#girisyapright{float:right}
#uyegirisloganleft{float:left}
.iletisimpage{float:left;width:100%}
.iletisimblok{display:inline-block;width:22%;    line-height: 23px;text-align:center;border-right:1px solid #eee;vertical-align:top;min-height:175px}
#compnayinfo{width:30%;text-align:left;    line-height: 27px;}
.iletisimblok h3{font-weight:700;font-size:18px;margin-bottom:10px;color:#<?php echo $color1; ?>}
.iletisimblok i{font-size:70px;margin-bottom:15px}
.iletisimblok span{float:left;width:100%;font-size:15px}
.googlemap{width:48%;float:left;margin-bottom:25px}
.iletisimtitle{padding-bottom:10px;margin-bottom:10px;width:100%;float:left;border-bottom:1px solid #eee;font-weight:700;font-size:20px}
.iletisimformu{float:right;width:48%}
.iletisimslogan{text-align:center;width:80%;font-weight:400;font-size:24px;margin:50px auto;margin-top:19px}
.iletisimformu input,textarea{width:100%;border-bottom-width:2px;border-bottom-color:#ccc;padding:16px 0;border-style:none none solid}
.iletisimformu input:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;color:#<?php echo $color1; ?>;border-style:none none solid}
.iletisimformu textarea:focus{border-bottom-width:2px;border-bottom-color:#<?php echo $color1; ?>;padding-left:5px;color:#<?php echo $color1; ?>;border-style:none none solid}
.bigmaplink{font-size:13px;float:right;color:#777;font-weight:400;margin-top:10px}
.bigmaplink:hover{color:#000;text-decoration:underline}
.sayfabaslik{margin-top:35px;background:rgba(0,0,0,0.4);padding:10px 30px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}
#header2 .sayfabaslik{margin-top:55px}
#rightsidebar{float:right}
.listeleme{float:left;width:73%;margin-top:17px}
.list{display:inline-block;width:46%;margin:10px;    border-radius: 7px;
    overflow: hidden;box-shadow:0 0 15px #eee;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.list:hover{box-shadow:0 0 15px #ccc}
.list h4 a{color:#<?php echo $color1; ?>}
.list p{margin:0;padding:7px 0;padding-right:5px}
.list img{margin-bottom:10px;float:left;width:100%;height:225px}
.listbaslik{font-size:22px;font-weight:700;float:left;width:100%;padding-bottom:10px;border-bottom:1px solid #eee;margin-bottom:15px}
.sidebar h4{font-size:17px;font-weight:700;float:left;width:100%;padding-bottom:15px;border-bottom:1px solid #eee}
.bloginfos{font-size:14px;float:left;width:100%;background:rgba(0,0,0,0.6);margin-top:-35px;color:#fff}
.bloginfos a{color:#fff;float:right}
.alanadisorgu{width:100%;float:left;text-align:center;margin-bottom:20px}
.alanadisorgu .gonderbtn{background:#8BC34A;margin-left: -156px;}
.alanadisorgu .gonderbtn:hover{background:#72a833}
#transferbtn{background:#009595;margin-left:0px;}
#transferbtn:hover{background:#<?php echo $color2; ?>}
.transfercode{width:70%;text-align:center;display:none;transition-property:all;transition-duration:0;transition-timing-function:ease;opacity:1;margin:auto;margin-bottom:50px}
.transfercode input{border-radius:2.20588rem;width:45%;border:0px;padding:20px 32px;padding-top:17px;padding-bottom:21px;-webkit-box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);border:1px solid #f5f3f3;margin:25px 0px;font-size:22px;font-weight:300;color:#607D8B}
.alanadisorgu h1{font-weight:200;font-size:36px;margin-bottom:20px}
.alanadisorgu input{border-radius: 2.20588rem;width: 45%;height: 100%;border: 0px;padding: 20px 32px;padding-top: 19px;-webkit-box-shadow: 0px 10px 45px 0px rgba(0, 0, 0, 0.06);box-shadow: 0px 10px 45px 0px rgba(0, 0, 0, 0.06);border: 1px solid #f5f3f3;margin: 25px 0px;font-size: 22px;font-weight: 300;color: #607D8B;}
#transfercode .lbtn{border:0px;background-color:#<?php echo $color2;?>;border-radius:2.20588rem;color:#FFFFFF;margin-left:-158px;padding:20px 0px;display:inline-block;cursor:pointer;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;transition:all 0.4s ease;width:150px;font-weight:normal;font-size:16px}
.alanadisorgu .gonderbtn{color:#fff;border:none;font-size:16px;-moz-border-radius:0;padding:18px 40px;z-index:5;position:relative}
#checkButton{border:0px;background-color:#8BC34A;border-radius:2.20588rem;color:#FFFFFF;margin-left:-158px;padding:20px 0px;position:absolute;margin-top:30px;display:inline-block;cursor:pointer;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;transition:all 0.4s ease;width:150px;font-size:16px}
#checkButton:hover{background:#709d3d}
.uzantibox{width:10%;padding:5px 0;border:2px solid #eee;vertical-align:top;border-radius:7px;text-align:center;display:inline-block;margin:7px;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;text-transform:lowercase}
.uzantibox img{width:auto;max-height:30px}
.uzantibox:hover{border:2px solid #<?php echo $color1; ?>}
.uzantibox H4{font-weight:700}
.popuzantilar{text-align:center;margin-top:15px}
.uzantibox .checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before{-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%}
.domainozellikler{background-image:url(../images/domainbg.jpg);background-size: 100% auto;margin-bottom:0;margin-top: 80px;background-repeat:no-repeat;background-position:center center;float:left;height:auto;width:100%;padding-top:35px;padding-bottom:35px;font-size:16px;box-shadow: inset 0 0 70px 40px #fff;}
.domainozellikler h3{padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #aac28f;font-weight:600;font-size:24px;display: none;}
.domainozellikler h4{font-weight: 700;font-size:18px;margin-bottom: 10px;}
.domainozellikler i{font-size: 70px;display: inline-block;/* margin-right:25px; */line-height:50px;text-align:center;width:75px;}
.dozelliklist{margin: 20px;display: inline-block;width: 29%;text-align: center;vertical-align: top;}
.domainiconleft{/* float:left; *//* width:100px; */margin-bottom: 20px;}
.domainfeatright{display:inline-block;width: 100%;font-size: 15px;}
.tescilucretleri{width:90%;padding-top:25px;text-align:center;margin:35px auto 50px}
.tescilucretleri span{float:left;width:125px;padding:5px;border-right-width:1px;border-right-style:solid;border-right-color:#CCC;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#CCC}
.tescilucretleri table {    border-radius: 10px;
    overflow: hidden;}
.tescilucretleri h4{margin-bottom:30px;font-size:26px}
.tescilsonuc{float:left;width:100%;margin-bottom:35px}
.tescilucretleri table tr td{padding:10px;border-bottom:1px dotted #eee;text-transform:lowercase}
.tescilucretleri table tr{-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.tescilucretleri table tr:hover{background:#eee}
.tescilsonuc{float:left;width:100%;margin-bottom:25px;padding-bottom:40px;border-bottom:1px solid #eee}
.tescilsonuc table{width:70%;margin:auto}
#tesclsure{text-align-last:center;border:none;cursor:pointer;padding:0}
.tescilsonuc table thead tr td .checkbox-custom-label{margin-right:0}
.tescilsonuc tr td{padding:5px 10px;border-bottom:1px dotted #EBEBEB;line-height:40px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before#tesclsure{width:190px;text-align:center;text-align-last:center}
.hostingozellikler{float:left;width:100%;padding-top:20px;margin-top: 35px;}
.hostozellk{display:inline-block;width:22%;font-size:16px;font-weight:300;vertical-align:top;text-align:center;padding:12px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.hostozellk h4{font-size:20px;font-weight:400}
.hostozellk:hover{background:#f6f6f6;box-shadow:0 0 12px #eee}
.sss{float:left;width:100%;padding-top:20px;border-top:1px solid #ebebeb}
.sss h4{margin-bottom:15px}
.sss #accordion h3{font-size:17px;    border-radius: 10px;-webkit-transition: all 0.3s ease-out;
-moz-transition: all 0.3s ease-out;
-ms-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;}
#scriptlistesi{background:none;padding:0;text-align:left}
#scriptlistesi .anascripler{text-align:center}
#scriptlistesi .scriptkategoriler a{color:#<?php echo $text_color;?>;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#eee;border-right-width:2px;border-right-style:solid;border-right-color:#eee;margin-bottom:0;padding:12px 7px;font-size:15px}
#scriptlistesi .scriptkategoriler a:hover{background:#eee}
#scriptlistesi #scataktif{background:#eee}
.scriptlisttitle{padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #ebebeb;color:#<?php echo $color1; ?>;font-size:22px;width:100%;text-align:left}
#scriptlistesi .anascriptlist{box-shadow:0 0 5px #eee;margin:1.4%}
#scriptlistesi .anascriptlist:hover{box-shadow:0 0 10px #ddd}
.scriptdetayinfo{float:left;width:71.5%;padding-right:28px;margin-right:15px;border-right:2px solid #ebebeb}
.scriptrightside{float:right;width:24%;position:-webkit-sticky;position:sticky;top:15px}
.scriptdetayinfo img{width:100%;height:auto;margin-bottom:15px;box-shadow:0 0 10px #9d9d9d}
.scriptrightside h4{font-size:18px;margin-bottom:7px;font-weight:300}
.scriptrightside h4 i {margin-right:10px;}
.scriptrightside .btn{font-size:15px;padding:12px 0;width:100%;font-size:16px;border-radius:50px;background:#eee;border:#eee}
.scriptrightside .btn:hover{background:#ccc;color:#333}
.sunucugereksinim{margin-top:20px;line-height:25px;font-size:15px}
.scriptfiyat{float:left;width:100%;padding:10px 0;text-align:center;border-top:2px solid #ebebeb;border-bottom:2px solid #ebebeb;margin:20px 0}
.scriptfiyat span{font-size:24px;font-weight:200}
.scriptdetaybenzer{float:left;width:100%;margin-top:50px;text-align:center}
.scriptdetaybenzer .anascriptlist{box-shadow:0 0 5px #b1b1b1}
.scriptozellks{margin:5px;border:2px solid #eee;width:47.8%;line-height:20px;    border-radius: 5px;display:inline-block;height:120px;vertical-align:top;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;text-shadow:0 0 2px #ccc}
.scriptozellks:hover{border:2px solid #<?php echo $text_color; ?>}
.scriptozellks h3{font-size:16px;font-weight:700;margin-bottom:7px}
.scriptozellkinfo{float:right;width:82%}
.ozellkiconxx{font-size:45px;text-align:center;width:50px;float:left}
.scriptozellks p{font-size:14px;font-weight:300;padding:0;margin:0;padding-bottom:10px}
.scriptfiyat h1{font-weight:700;color:#8bc34a;line-height:38px}
#urunsatinlink{border:1px solid #4CAF50;color:#4CAF50;font-weight:700;background:#4CAF50;color:#fff}
#urunsatinlink:hover{color:#fff;background:#368639}
.kutubanner{width:100%;text-align:center;margin-top:25px}
.scriptrightside .paypasbutonlar{margin-top:5px;float:left;margin-bottom:0}
.surumgecmisi{margin-top:25px;font-size:14px}
.sunucular{float:left;width:100%;margin-top:10px;margin-bottom:25px}
#datatable tr td:last-child{border-right:none}
.datatable tr td:last-child{border-right:none}
.sunucular table tr td{font-size:16px;border-bottom:1px solid #ebebeb;padding:12px}
.sunucular table tr:hover{background:#eee;}
.sunucular table tr{-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.sunucustok{background:#4caf50;color:#fff;padding:2px 0;font-size:12px;margin-left:-73px;position:absolute;margin-top:-50px;width:62px}
.sunucustok:after{content:'';position:absolute;border-color:transparent transparent transparent #4caf50;border-style:solid;border-width:5px;width:0;height:0;margin-top:5px;margin-left:4px}
.indirim{background:#4caf50;color:#fff;border-radius:3px;padding:2px 0;font-size:13px;display:inline-block;margin-left:15px;width:100px;text-align:center;line-height:21px;position:relative}
.indirim:after{content:'';position:absolute;border-color:transparent #4caf50 transparent transparent;border-style:solid;border-width:6px;width:0;height:0;margin-top:4px;left:-12px}
#tukendi{background:#f44336}
#tukendi:after{border-color:transparent transparent transparent #f44336;border-style:solid;margin-left:11px;border-width:5px}
.sunucular .gonderbtn i{margin-right:7px}
.sunucular select{padding:5px 0;font-weight:700;text-align-last:center}
.sunucular .gonderbtn{border:none;background:#4caf50;color:#fff}
.sunucular .gonderbtn:hover{background:#3a993e}
#sunucutukenbtn{opacity:.4;filter:alpha(opacity=40);background:none;color:#81c04e}
#digerpaketler .tpakettitle{background:#FF9800}
#digerpaketler .tpakettitle i{color:#FF9800}
#digerpaketler .tablepaket h3{color:#FF9800}
#digerpaketler .tablepaket h4{color:#FF9800}
#digerpaketler .tablepaket .gonderbtn{border:2px solid #FF9800;color:#FF9800}
#digerpaketler .tablepaket .gonderbtn:hover{color:#fff;background:#FF9800}
#smspaketleri .tpakettitle{background:#E91E63}
#smspaketleri .tpakettitle i{color:#E91E63}
#smspaketleri .tablepaket h3{color:#E91E63}
#smspaketleri .tablepaket h4{color:#E91E63}
#smspaketleri .tablepaket .gonderbtn{border:2px solid #E91E63;color:#E91E63}
#smspaketleri .tablepaket .gonderbtn:hover{color:#fff;background:#E91E63}
#sslpaketleri .tpakettitle{background:#8bc34a}
#sslpaketleri .tpakettitle i{color:#8bc34a}
#sslpaketleri .tablepaket h3{color:#8bc34a}
#sslpaketleri .tablepaket h4{color:#8bc34a}
#sslpaketleri .tablepaket .gonderbtn{border:2px solid #8bc34a;color:#8bc34a}
#sslpaketleri .tablepaket .gonderbtn:hover{color:#fff;background:#8bc34a}
.siparisbilgileri{margin-bottom:40px}
.siparisbilgileri .radio-custom-label{margin-bottom:5px}
.siparisbilgileri .btn{font-size:16px;float:right;color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:200px;background:#8bc34a;text-align:center;font-size:16px;margin-top:10px;font-weight:700;}
.siparisbilgileri .btn i {display:none}
.siparisbilgileri .btn i{margin-left:5px}
.siparisbilgileri .btn:hover{background:#<?php echo $color2; ?>;color:#fff}
.siparisbilgileri table{width:70%}
.siparisbilgileri table tr td{padding: 12px 10px;border-bottom:1px solid #ebebeb}
.ilanasamalar{float:left;width:100%;padding-bottom:20px;text-align:center;margin-bottom:40px;margin-top: 25px;}
.ilanasamax{text-align:center;vertical-align:top;width:32.7%;font-size:18px;display:inline-block}
.ilanasamax h3{width:80px;background:#eee;text-align:center;height:80px;margin-bottom:7px;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;line-height:80px;font-size:34px;font-weight:700;text-shadow:.03em .03em #fff}
.ilanasamalar .ilanasamax:first-child:nth-last-child(4),.ilanasamalar .ilanasamax:first-child:nth-last-child(4) ~ .ilanasamax{width:24%}
.ilanasamalar .ilanasamax:first-child:nth-last-child(5),.ilanasamalar .ilanasamax:first-child:nth-last-child(5) ~ .ilanasamax{width:19%}
.asamaline{width:100%;background:#eee;height:5px;margin-top:60px;float:left;margin-bottom:-70px}
#asamaaktif h3{background:#<?php echo $color1; ?>;color:#fff;text-shadow:none}
#asamaaktif{color:#<?php echo $color1; ?>;font-weight:bolder}
.domainsec{width:800px;margin:auto}
.domainsec input{width:76%;font-size:20px}
.domainsec select{border-radius:2.20588rem;width:80%;height:100%;border:0px;padding:20px 32px;padding-top:19px;-webkit-box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);border:1px solid #f5f3f3;margin:25px 0px;font-size:18px;font-weight:300}
.domainsec table{width:100%}
.domainsec .btn{margin-top:25px}
.domainsec h5{margin-top:7px;color:#<?php echo $text_color; ?>;font-size:17px;}
.domainsec .alanadisorgu .gonderbtn{text-align:center;border:0px;background-color:#8BC34A;border-radius:2.20588rem;color:#FFFFFF;margin-left:-160px;padding:18px 0px;display:inline-block;cursor:pointer;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;transition:all 0.4s ease;width:150px;font-size:16px}
.domainsec .tescilsonuc table{width:100%;font-size:15px}
.domainsec .tescilsonuc{margin:0;padding:0;border:none}
.domainsec .alanadisorgu{margin-top:0;margin-bottom:15px;}
.sadeckyinfo{font-size:16px;color:#<?php echo $text_color; ?>;margin:0 7px;font-size:18px;margin-bottom:10px;float:left;width:100%}
.domainsec .tescilsonuc .gonderbtn{background:#ff9800;color:#fff;border:transparent;padding:5px 40px;margin-bottom:20px}
.domainsec .tescilsonuc .gonderbtn:hover{background:#d57f00}
.sipdvmtmmbtn .gonderbtn{width:40%;border:none;background:#ebebeb;margin-bottom:15px;padding:18px 0;font-size:18px}
.sipdvmtmmbtn .gonderbtn i{margin-right:5px}
#alisverisdevam:hover{background:orange;color:#fff}
#alisveristamam:hover{background:green;color:#fff}
.sungenbil{float:left;width:63%}
.skonfiginfo{border:1px solid #ebebeb;float:left;width:100%;border-radius:10px}
.sunucukonfigurasyonu{float:left;width:100%;margin-bottom:50px}
.skonfiginfo h4{float:left;width:100%;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #ebebeb;font-weight:700;font-size:18px}
.sunucusipside{float:right;width:35%;position:-webkit-sticky;position:sticky;top:15px}
.skonfigside{float:left;background:#<?php echo $color2; ?>;color:#fff;padding-bottom:10px;border-radius:10px}
.skonfigside .line{background: rgb(0 0 0 / 25%);}
.skonfigside h4{float:left;width:100%;padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid rgb(0 0 0 / 25%);font-weight:700}
.skonfigside span{float:left;width:100%;padding:6px 0;font-size:14px}
.skonfigside span strong{float:right;   }
.sunucretler span{font-size:16px}
.sunucretler #total_amount {    font-size: 26px;}
.skonfigside h3 span{font-size:20px}
.sunucusipside .gonderbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#8bc34a;text-align:center;font-size:18px;margin-top:10px;font-weight:700}
.sunucusipside .gonderbtn:hover{background:#333;color:#fff}
.sepet{float:left;width:100%;margin-bottom:60px}
.sepetleft{float:left;width:73%}
.sepetright{float:right;width:25%;position:-webkit-sticky;position:sticky;top:15px}
.sepetrightshadow{ background: white;   -webkit-box-shadow: 0px 10px 45px 0px rgba(0, 0, 0, 0.06);
    box-shadow: 0px 10px 45px 0px rgba(0, 0, 0, 0.06);    border-radius: 10px;}
.sepetbaslik{float:left;line-height:50px;width:100%;background:#<?php echo $color2; ?>;color:#fff;-webkit-border-radius:10px;-moz-border-radius:2px;border-radius:10px;font-size:16px;font-weight:700;z-index: 15;position: relative;}
.uhinfo{width:40%;float:left}
.sepetlistcon .uhinfo{line-height:25px}
.uhperiyod{width:25%;text-align:center;float:left}
.uhperiyod h5{font-size:18px;font-weight:600}
.uhperiyod option{font-size:15px;font-size:14px}
.uhtutar h4{font-size:20px}
.uhtutar h4 strong{position:relative}
.uhtutar{width:25%;text-align:center;float:left}
.sepetlist{float:left;background:white;width:100%;margin-top:-8px;-webkit-box-shadow:0px 10px 45px 0px rgb(0 0 0 / 6%);box-shadow:0px 10px 45px 0px rgb(0 0 0 / 6%);border-radius:10px;z-index:8;position:relative;margin-bottom: 15px;padding-top: 10px;}
#item_list .sepetlist {margin:0px;}
.sepetlistcon{padding:40px 20px;}
.uhinfo h5{margin:0;font-size:18px}
.uhinfo h4 a{font-size:15px;color:#c20000;margin:0;float:left}
.uhinfo p{font-size:14px}
.uhinfo p span{font-weight:600}
.uhperiyod select{text-align-last:center;border:none;padding:5px 0px;width:auto;display:block;margin:auto;font-weight:600;font-size:18px}
.uhsil{float:right;width:10%;text-align:center;}
.uhsil a{font-size:20px;}
.uhsil a:hover{color:#333}
.green-label{background-color:#81bc00;color:#fff}
.row-label{display:inline-block;padding-right:8px;padding-left:8px;font-size:11px;position:absolute;margin-left:-8px;height:19px;line-height:19px;border-radius:2px 0 0 0;letter-spacing:1px}
.green-label::before{position:absolute;content:" ";width:0;height:0;border-style:solid;border-width:0 8px 8px 0;border-color:transparent #679404 transparent transparent;left:0;bottom:-7px}
.sepetsipinfo{font-size:14px}
.sepetrightcon{padding:15px;}
.sepetsipinfo h5{font-weight:700;font-size:19px;color:#FF5722;width:120px}
.sepetsipinfo tr td{border-bottom:1px dotted #ebebeb;padding:10px 0}
.sepetsipinfo input{text-align-last:center}
.sepetright .gonderbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#8bc34a;text-align:center;font-size:18px;margin-top:10px;font-weight:700;border-radius:10px;}
.sepetright .gonderbtn:hover{background:#<?php echo $color2; ?>;color:#fff}
.smspreviewinfo .yuzde30{vertical-align:top;}
.yuzde5{width:5%;display:inline-block}
.yuzde10{width:9%;display:inline-block}
.yuzde15{width:15%;display:inline-block}
.yuzde20{width:19%;display:inline-block}
.yuzde30{width:29%;display:inline-block}
.yuzde33{width:33%;display:inline-block}
.yuzde40{width:39%;display:inline-block}
.yuzde50inpt{width:49%;display:inline-block}
.yuzde50{width:49%;display:inline-block}
.yuzde60{width:59%;display:inline-block}
.yuzde70{width:69%;display:inline-block}
.yuzde80{width:79%;display:inline-block}
.yuzde90{width:89%;display:inline-block}
.yuzde25{width:24.5%;display:inline-block}
.yuzde75{width:74%;display:inline-block}
.sepetlistcon .checkbox-custom-label{margin-right:25px;margin-top:5px}
.sepetlistcon .radio-custom-label{margin-right:25px;margin-top:10px}
.mpanelinfo{float:left;width:100%;height:65px;background:#<?php echo $color2; ?>;color:#fff;line-height:65px;font-size:16px}
.header .mpanelinfo{background:rgba(0,0,0,0.5)}
#fullwidth .mpanelinfo{background:#343434}
.mpanelright{float:right;box-shadow:0 0 3px #ccc;border-radius: 7px;width:75%;margin-bottom:20px;background:#fff;margin-top:20px;min-height:430px}
.mpanelrightcon{padding:20px;word-wrap:break-word}
.mpaneltitle{float:left;width:100%;border-bottom:1px solid #ebebeb;padding-bottom:10px;margin-bottom:15px}
.mpanelrightcon .ui-widget-content{border:none}
.mpaneltitle i{margin-right:7px}
.mpaneltitle h4{font-size:18px}
.mpanelright tr td{border-bottom:1px solid #eee}
.mpanelhaber h5 span{font-size:14px;color:#777}
.mpanelhaber{float:left;width:100%;border-bottom:1px dotted #ccc;padding:12px 0}
.mpanelhaber img{float:left;width:135px;margin-right:20px;    border-radius: 5px;margin-left:5px;opacity:.6;filter:alpha(opacity=60)}
.mpanelhaber:hover img{opacity:1;filter:alpha(opacity=100);-webkit-backface-visibility:visible!important;backface-visibility:visible!important;-webkit-animation-name:flipInY;animation-name:flipInY;-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}
@-webkit-keyframes flipInY {
0%{-webkit-transform:perspective(400px) rotate3d(0,1,0,90deg);transform:perspective(400px) rotate3d(0,1,0,90deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in;opacity:0}
40%{-webkit-transform:perspective(400px) rotate3d(0,1,0,-20deg);transform:perspective(400px) rotate3d(0,1,0,-20deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in}
60%{-webkit-transform:perspective(400px) rotate3d(0,1,0,10deg);transform:perspective(400px) rotate3d(0,1,0,10deg);opacity:1}
80%{-webkit-transform:perspective(400px) rotate3d(0,1,0,-5deg);transform:perspective(400px) rotate3d(0,1,0,-5deg)}
100%{-webkit-transform:perspective(400px);transform:perspective(400px)}
}
@keyframes flipInY {
0%{-webkit-transform:perspective(400px) rotate3d(0,1,0,90deg);transform:perspective(400px) rotate3d(0,1,0,90deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in;opacity:0}
40%{-webkit-transform:perspective(400px) rotate3d(0,1,0,-20deg);transform:perspective(400px) rotate3d(0,1,0,-20deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in}
60%{-webkit-transform:perspective(400px) rotate3d(0,1,0,10deg);transform:perspective(400px) rotate3d(0,1,0,10deg);opacity:1}
80%{-webkit-transform:perspective(400px) rotate3d(0,1,0,-5deg);transform:perspective(400px) rotate3d(0,1,0,-5deg)}
100%{-webkit-transform:perspective(400px);transform:perspective(400px)}
}
.mpanelhaber p{margin:0;color:#666}
.songiris{float:right;font-size:14px}
.muspanelbloks{float:left;width:100%;margin-top:20px;text-align:center}
.mpanelblok{display:inline-block;width:18.8%;margin-right: 10px;background:#eee;border-radius: 5px;text-align:center;box-shadow:0 0 5px #ccc;overflow:hidden;min-height:147px;position:relative}
.mpanelblok:first-child:nth-last-child(4),.mpanelblok:first-child:nth-last-child(4) ~ .mpanelblok{width:24%}
.mpanelblok:first-child:nth-last-child(3),.mpanelblok:first-child:nth-last-child(3) ~ .mpanelblok{width:32%}
.mpanelblok:first-child:nth-last-child(2),.mpanelblok:first-child:nth-last-child(2) ~ .mpanelblok{width:49%}
.mpanelblok h1{font-size:30px;margin-top:25px;font-weight:bolder;color:#fff;position:relative;z-index:6}
.mpanelblok h2{font-size:17px;color:#fff;position:relative;z-index:6}
.mblokbtn{width:100%;color:rgba(255,255,255,0.5);background:rgba(0,0,0,0.3);text-align:left;font-size:14px;-webkit-transition:all .3s ease-out;position:absolute;bottom:0;z-index:6;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
.mpanelblokicon{z-index:5;color:rgba(0,0,0,0.13);font-size:150px;position:absolute;top:-43px;margin:0;right:-100%;left:-100%}
.mblokbtn span{float:right;margin-right:5px}
a .mblokbtn:hover{color:rgba(255,255,255,1.5);background:rgba(0,0,0,0.43)}
.mblokbtn .padding10{padding:6px}
#green{background:#8BC34A}
#blue{background:#2196f3}
#red{background:#f44336}
#gray{background:#607D8B}
#turquise{background:#00bcd4}
#turquise h2{line-height:15px}
.mpanelleft{float:left;box-shadow:0 0 3px #ccc;border-radius: 7px;width:24%;margin-bottom:40px;background:#fff;margin-top:20px}
.mpanelbtns a{float:left;width:100%;padding:7px 0;border-bottom:1px solid #eee;font-size:16px;font-weight:600}
.mpanelbtns i{width:20px;text-align:center;float:left;margin-right:12px;line-height:25px}
.mpanelbtns a:hover{background:#eee}
#mpanelbtnsaktif{background:#eee;font-weight:600}
.mpanelbtns a span{padding:7px 15px;display:block}
.sayfayolu{float:right}
.sayfayolu a{margin:0 5px}
.sayfayolu a:hover{color:#000}
.sayfayolu a:first-child{font-weight:700}
#bigcontent{width:100%}
.datatbspan{float:left;margin-right:7px;line-height:50px}
.dttblegoster{float:left;width:100px;margin-right:7px}
#datatable tr{-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
#datatable tr td{border-bottom:1px solid #eee;padding:10px}
.incelebtn{display:inline-block;padding:7px 15px;background:#eee;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;font-size:13px;font-weight:700}
.incelebtn:hover{background:#ccc}
.ticketdetail{float:left;width:100%}
.ticketinfos{float:left;width:100%}
.ticketstatusbtn .gonderbtn{width:48%;margin-top:25px;margin-bottom:25px}
.ticketstatusbtn .graybtn{float:left;opacity:1;filter:alpha(opacity=100);box-shadow:0 0 5px #ccc;background:#e1e1e1}
.ticketstatusbtn .graybtn:hover{background:#ccc}
.ticketstatusbtn .mavibtn{float:right}
.ticketinfos input{width:49%;padding:20px 0}
.ticketinfos select{width:49%;padding:20px 0}
#ticketfixed{width:100%;margin-bottom:20px}
#ticketfixed .destekinfo{width:23%}
.destekdetayleft{float:left;width:100%}
.destekdetayright{float:left;width:100%;margin-bottom:35px}
.destekdetaymsj{border:1px solid #46BE8A;margin-bottom:10px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.msjyazan{float:left;width:100%;border-bottom:1px solid #ddd;padding-bottom:10px}
.reply-message{padding:15px;padding-bottom:0}
.ticket-attachment-file{margin-top:15px;font-size:14px}
.ticket-attachment-file a{color:#777}
.ticket-attachment-file a:hover{color:#333}
.ticket-attachment-file i{margin-right:5px}
.destekdetaymsjcon{padding:15px}
.msjyazan h4{font-size:16px;float:left;font-weight:700;color:#46BE8A}
.msjyazan h5{font-size:13px;float:right;background:#46BE8A;color:#fff;font-weight:400;padding:0 8px;margin-left:10px}
.msjyazan h4 span{font-size:13px;background:#46BE8A;color:#fff;font-weight:400;padding:0 8px;margin-left:10px}
#yetkilimsj{border:1px solid #62A8EA}
#yetkilimsj .msjyazan h4{color:#62A8EA}
#yetkilimsj .msjyazan h5{background:#62A8EA}
#yetkilimsj .msjyazan h4 span{background:#62A8EA}
.destekdetayright .gonderbtn{color:#fff;border:none;float:right;box-shadow:0 0 10px #ccc;padding:15px 0;width:50%;background:#8bc34a;text-align:center;font-size:18px;margin-top:10px;font-weight:700}
.destekdetayright .gonderbtn:hover{background:#333;color:#fff}
.destekdosyaeki{float:left;width:45%}
.mavibtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#62A8EA;text-align:center;font-size:16px;margin-top:10px;font-weight:700}
.mavibtn:hover{background:#333;color:#fff}
.metalbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#<?php echo $color2; ?>;text-align:center;font-size:16px;margin-top:10px;font-weight:700}
.metalbtn:hover{background:#333;color:#fff}
.graybtn{-webkit-filter:grayscale(100%);filter:grayscale(100%);color:#777;opacity:.5;filter:alpha(opacity=50);border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#ccc;text-align:center;font-size:15px;margin-top:10px;font-weight:700}
.graybtn:hover{background:#CCC;color:#777}
.yesilbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#8bc34a;text-align:center;font-size:16px;margin-top:10px;font-weight:600}
.yesilbtn:hover{background:#333;color:#fff}
.redbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#E21D1D;text-align:center;font-size:16px;margin-top:10px;font-weight:600}
.redbtn:hover{background:#333;color:#fff}
.turuncbtn{color:#fff;border:none;box-shadow:0 0 10px #ccc;padding:15px 0;width:100%;background:#f26c31;text-align:center;font-size:16px;margin-top:10px;font-weight:600}
.turuncbtn:hover{background:#333;color:#fff}
#destekcvpyaz .lbtn{float:right;margin:20px;margin-right:30px}
.lbtn{padding:5px 15px;border:2px solid #<?php echo $color1; ?>;color:#<?php echo $color1; ?>;font-weight:600;border-radius:50px;display:inline-block;outline:none}
.lbtn:hover{color:#fff;background:#<?php echo $color1; ?>}
.sbtn{display:inline-block;padding:7px 15px;background:#eee;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;font-size:13px;width:auto;font-weight:600}
.sbtn:hover{background:#ccc}
.green{border-color:#81c04e;color:#81c04e}
.green:hover{color:#fff;background:#81c04e}
.red{border-color:#F44336;color:#F44336}
.red:hover{color:#fff;background:#F44336}
.orange{border-color:orange;color:orange}
.orange:hover{color:#fff;background:orange}
.blue{border-color:#62A8EA;color:#62A8EA}
.blue:hover{color:#fff;background:#62A8EA}
.ucte1{width:33%}
.destekinfo{display:inline-block;width:23%;vertical-align:top;margin:5px;background: #f6f6f6; text-align:center;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.destekinfocon{padding:25px 10px}
.destekinfo h4{font-size:14px}
.destekinfo h5{font-size:15px}
.destektalebiolustur{float:left;width:100%}
.destektalebiolustur .yesilbtn{width:50%;float:right}
.bilgibankasi{float:left;width:100%;text-align:center;margin:20px 0}
.bilgibankasi .btn{width:44%;font-size:15px;font-weight:600;border:none;margin-top:15px;padding:9px 20px;display:inline-block;vertical-align:top;border-right:1px solid #ccc;border-left:1px solid #ccc}
.hizmetblok{display:inline-block;width:48%;margin:9px;vertical-align:top;font-size:14px;border-right:1px solid #eee;border-bottom:1px solid #eee;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.hizmetblok tr:nth-child(1) td{font-size:15px;padding:12px;background:none;border-bottom:1px solid #eee;color:#<?php echo $color2; ?>;background:#efefef;background:-moz-linear-gradient(top,#efefef 0%,#fff 100%);background:-webkit-linear-gradient(top,#efefef 0%,#fff 100%);background:linear-gradient(to bottom,#efefef 0%,#fff 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#efefef',endColorstr='#ffffff',GradientType=0)}
.hizmetblok #otherLimits tr:nth-child(1) td{background:none;padding:8px}
.hizmetblok tr td{padding:8px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;border-bottom: 1px solid #eee;}
.hizmetblok:first-child{border-right:none}
.hizmetblok:first-child:nth-last-child(6),.hizmetblok:first-child:nth-last-child(6) ~ .hizmetblok{width:31.5%}
ul.tab{list-style-type:none;margin:0;padding:0;overflow:hidden;border:none;display:inline-block;width:100%;background:#f2f2f2;background:-moz-linear-gradient(top,#f2f2f2 0%,#fff 100%);background:-webkit-linear-gradient(top,#f2f2f2 0%,#fff 100%);background:linear-gradient(to bottom,#f2f2f2 0%,#fff 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f2f2f2',endColorstr='#ffffff',GradientType=0)}
ul.tab li{float:left}
ul.tab li a{display:inline-block;text-align:center;padding:14px 30px;text-decoration:none;transition:.3s;font-size:15px;border-bottom:2px solid #e7e7e7;border-right:1px solid #dbdbdb}
ul.tab li a i{margin-right:7px}
ul.tab li a.active{border-bottom:2px solid #fff}
.tabcontent{display:none;padding:30px 0;border-top:none}
.tabcontent{-webkit-animation:fadeEffect 1s;animation:fadeEffect 1s}
@-webkit-keyframes fadeEffect {
from{opacity:0}
to{opacity:1}
}
@keyframes fadeEffect {
from{opacity:0}
to{opacity:1}
}
.hizmetblok:nth-child(-n+1){border-bottom:none}
.cpanelebmail{float:left;width:100%;text-align:center;word-wrap:break-word;min-height:323px}
.cpanelebmail img{margin:auto;width:140px;padding:7px 15px;display:block}
.cpanelebmail h5{font-size:17px;margin:15px 0;font-weight:600}
.cpanelebmail .gonderbtn{width:90%;padding:12px 0;font-weight:600;font-size:15px}
.cpanelebmail .gonderbtn i{font-size:20px;line-height:0}
.cpanelebmail .yesilbtn{color:#8bc34a;box-shadow:none;background:#eeeeee;width:47%;}
.cpanelebmail .yesilbtn{color:#8bc34a;box-shadow:none;background:#eeeeee;width:47%;}
.cpanelebmail .yesilbtn:hover{color:#fff;background:#8bc34a}
.cpanelebmail .turuncbtn{color:#f26c31;box-shadow:none;background:#eee;width:47%}
.cpanelebmail .turuncbtn:hover{color:#fff;background:#f26c31}
.cpanelebmail .mavibtn{color:#62A8EA;box-shadow:none;background:#eee;width:47%}
.cpanelebmail .mavibtn:hover{color:#fff;background:#62A8EA}
#updownbtn{width:95%;color:#<?php echo $color2;?>;opacity:1.5;filter:alpha(opacity=100);font-weight:600;background:#eee;box-shadow:none;margin-top:5px}
#updownbtn:hover{background:#<?php echo $color2; ?>;color:#fff}
#updownbtn i{font-size:20px;line-height:0;margin-right:5px}
.espotaolustur{width:80%;margin:auto;margin-bottom:25px}
.tabcontentcon{width:80%;margin:auto;margin-bottom:25px}
.tabcontentcon h5{font-size:16px}
#sentSMS {font-size:16px;}
.destekolsbtn{font-size:16px;float:right;padding:10px 20px;margin-top:-8px}
.destekolsbtn:hover{background:#8bc34a}
.domaindetayinfo{text-align:center;float:left;width:100%;word-wrap:break-word}
.domaindetayinfo h4{font-size:16px;margin:15px 0}
.domaindetayinfo h5{font-size:16px;margin:15px 0;font-weight:600}
.domaindetayinfo .gonderbtn{padding:12px 0;font-weight:600;font-size:15px}
.domaindetayinfo .yesilbtn{color:#8bc34a;box-shadow:none;background:#fff;width:47%;border:1px solid #8bc34a}
.domaindetayinfo .yesilbtn:hover{color:#fff;background:#8bc34a}
.domaindetayinfo .mavibtn{color:#62A8EA;box-shadow:none;background:#fff;width:47%;border:1px solid #62A8EA}
.domaindetayinfo .mavibtn:hover{color:#fff;background:#62A8EA}
.domaindetayinfo i{font-size:80px}
#whoisbilgileri .ucte1{width:32.5%}
.whoisgizlenmis{background:orange;color:#fff;padding:3px 0;font-size:13px;font-weight:600;position:relative;margin:auto;margin-top:-20px;width:120px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#epostayonet h5{font-size:16px}
.mailyonsec{float:left;width:100%;margin:10px 0}
.mailyonsec span{float:left;width:25%}
.mailyonbtn .gonderbtn{width:33%;font-size:16px;padding:12px 0}
.yuzde45{width:45%}
#smsgonder .yuzde50{float:left;margin-left:5px}
#rehber .checkbox-custom-label{margin-right:25px}
#rehber div{font-size:15px}
#rehber .checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before{-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%}
.faturalarim table tr td,th{padding:20px;border-bottom:1px solid #eee}
.fatcusinfo{display:inline-block;width:50%;vertical-align:top}
.fatodenmedi{display:inline-block;padding:10px 25px;text-align:center;width:50%;border:2px solid red;color:red;margin-bottom:20px;font-weight:600}
.fatodendi{border:2px solid #8BC34A;color:#8BC34A;font-weight:600}
.fattutarlar span{text-align:left}
.odemeyontem{float:left;margin-bottom:20px;width:100%}
.odemeyontem h5{padding-bottom:10px;margin-bottom:10px;border-bottom:1px solid #ccc}
.odemeyontem .checkbox-custom-label{margin-right:25px;margin-top:10px}
.odemeyontem .radio-custom-label{margin-right:25px;margin-top:10px}
.odemeyontem .checkbox-custom+.checkbox-custom-label:before{-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%}
.odemeyontem .checkbox-custom+.radio-custom+.radio-custom-label:before{-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%}
.faturaodenmis{float:left;width:100%;text-align:center}
.tutartd td{background:#fff;background:-moz-linear-gradient(top,#fff 0%,#efefef 100%);background:-webkit-linear-gradient(top,#fff 0%,#efefef 100%);background:linear-gradient(to bottom,#fff 0%,#efefef 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#efefef',GradientType=0);font-size:16px}
.durumraportable{height:250px;overflow-y:scroll}
.hesapbilgilerim table tr td{padding:7px;border-bottom:1px solid #eee;font-size:15px}
.adresbilgisi{float:left;width:100%;padding:10px 0;border-bottom:1px solid #eee;font-size:14px}
.adresbilgisi .yuzde80{padding:10px 0}
.menuurunlink a span{padding:1px 22px}
.menuurunlink a{font-weight:400;font-size:15px}
.ui-accordion .ui-accordion-content{padding:25px;border-top:0}
#header2{height:220px;margin-bottom:20px;background-position:center center}
#muspanel #header2{display:none}
#header2 .headerwhite{margin-top:74px;bottom:auto}
#muspanel .headerwhite{display:none}
.mobilgenislet{display:none}
.bilgibanka{margin-bottom:35px}
.bbankadetay{float:left;margin-bottom:45px}
.bbankaara{float:left;width:100%;text-align:center;margin:50px 0px;}
.bbankaara h3{color:#<?php echo $color1; ?>}
.bbankaara input{font-size:18px}
.bbankaara h4{margin-bottom:15px}
.bbankaara .lbtn{padding:10px 20px;font-size:20px;border:2px solid #c6c6c6;margin-left:5px;color:#c6c6c6}
.bbankaara .lbtn:hover{background:#c6c6c6;color:#fff}
.bbankakonu{box-shadow:0 0 5px #ccc;display:inline-block;margin:10px;margin-bottom:15px;width:30%;color:#777;vertical-align:top;font-size:13px}
.bbankakonu h4{font-size:16px;color:#333}
.bbankakonu i{float:left;margin-right:15px;font-size:32px;margin-bottom:12px;color:#<?php echo $color1; ?>}
.bbankabasliklar{float:left;width:100%;margin-bottom:25px}
.bbbaslik{font-size:20px}
.encokokunanbasliklar h5{float:left;width:100%;padding:13px 0;border-bottom:1px solid #eee;font-size:15px}
.encokokunanbasliklar{display:inline-block;width:100%}
.encokokunanbasliklar .error{font-size:17px;color:#777;font-weight:400}
.encokokunanbasliklar h5 a{font-weight:600}
.encokokunanbasliklar h5 i{margin-right:7px}
.encokokunanbasliklar h5 a:hover{color:#000;padding-left:5px}
.encokokunanbasliklar h5 span{font-size:16px}
.faydalimi{float:left;width:100%;margin-bottom:20px}
.faydalimi h5{float:left;margin-right:10px;margin-top:5px;font-size:16px}
#faydaliContent{float:left}
#successful-1{float:left}
#successful-2{float:left}
#successful-3{float:left}
#votingContent{display:inline-block}
.bbkonuinfo{float:right;color:#777}
.bankablok{width:48%;display:inline-block;margin:10px 0px}
.bankalogo{width:100%;float:left}
.bankalogo img{width:30%;float:left}
.bankalogo h4{float:right;font-weight:400;font-size:18px;line-height:42px}
.bankainfo{float:right;width:100%}
.bankainfo h5{font-size:14px;padding:2px 0}
.bankainfo h5 span{width:35%;float:left;font-weight:700}
.bankablok .line{margin:10px 0}
#newAddress h3{font-size:15px;font-weight:700}
.progresspayment{display:inline-block;padding:30px 0;width:100%;    margin-top: 50px;}
.progresspayment h4{font-size:17px;padding:15px}
.progresspayment h3{font-weight:700;    font-size: 22px;color:#2bb673;margin-top:25px}
#progressh3{color:#<?php echo $color1; ?>}
.balancepage{margin:15px 0;float:left;width:100%}
.balancepage .green-info{margin-bottom:10px}
.balancepage .fa-info-circle{float:left;font-size:70px;margin:25px 35px 55px 20px}
.balancepage h5{font-size:18px}
.tabcontentcon .yesilbtn{width:240px;float:right;font-size:15px}
.tabcontentcon .turuncbtn{width:240px;float:left;font-size:15px}
.tabcontentcon .mavibtn{width:240px;float:left;font-size:15px}
.tabcontentcon .redbtn{width:240px;float:right;font-size:15px}
.menuurunlink{width:100%}
#acdashboardnews{float:right;width:37%}
#acdashboardactivity{float:right;width:36%;margin-left:20px;font-size:14px;}
#turquise h1{font-size:26px;line-height:50px}
#SenderIDList tr td{border-bottom:1px solid #ccc}
.smsaccountbalanceinfo .fa-info-circle{float:left;font-size:80px;color:#00bcd4;margin-right:35px;margin-top:15px;margin-left:30px}
.smsucretleri tr td{border-bottom:1px solid #eee;padding:5px}
#raporlar table tr td{border-right:1px solid #eee;border-bottom:1px solid #eee}
#pre-register-countries label{float:left;width:50%;font-size:14px;margin-bottom:5px}
#baslikislemleri .modalDialog div{width:900px}
#baslikislemleri .dataTables_filter{display:none}
.sendsmstableinfo{width:100%}
.sendsmstableinfo tr td{padding:10px;border-bottom:1px solid #eee}
.sendsmstableinfo tr td img{margin-right:5px;float:left;margin-top:5px}
.sendsmstableinfo tr th{background:#eee}
#PnResult span{font-size:18px}
#PnResult{float:right;text-align:right;margin-top:10px}
.smspreviewinfo{padding:10px;border-bottom:1px solid #eee}
.durumraportable tr td{padding:5px}
#reports td img{margin-right:7px;margin-top:5px;float:left}
.internationalsmspage{margin-top: 25px;margin-bottom:25px;width:100%;float:left}
.internationalsmspage .leftblock{float:left;width:50%}
.internationalsmspage .leftblock h3{font-size:28px;margin-bottom:30px}
.internationalsmspage .leftblock h4{font-weight:300}
.internationalsmspage .rightblock{color:#474747;float:right;text-align:center;margin-top:25px;width:50%;min-height:350px;background-size:100% 100%;background-repeat:no-repeat}
.internationalsmspage .rightblocktitle{margin-bottom:20px;color:#<?php echo $color1; ?>;font-size:26px}
.internationalsmspage .rightblock .lbtn{border:2px solid #777;color:#777}
.internationalsmspage .rightblock .lbtn:hover{background:#777;color:#fff}
.internationalsmspage .rightblock .active{background:#777;color:#fff}
.internationalsmspage .rightblock select{width:50%;padding:20px}
.internationalsmspage .select2-container{text-align:left}
.internationalsmspage .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:40px}
.internationalsmspage .select2-container--default .select2-selection--single{height:auto;padding:8px;font-size:16px}
.internationalsmspage .select2-container--default .select2-selection--single .select2-selection__arrow{height:55px;right:15px}
.internationalsmspage .select2-selection__rendered img{margin-top:12px;margin-right:10px}
.sepetleft .lbtn{margin-bottom:20px}
.slidermio{float:left;width:100%}
.slidermio .list_carousel li{width:auto;height:auto}
.reference{width:100%;display:inline-block;margin-bottom:25px;text-align:center}
.referenceselect{float:left;width:100%;text-align:center;margin:25px 0px;}
.referenceselect select{font-size:18px;width:30%;color:#777;padding:15px 0}
.referenceselect option{font-size:17px}
.reference .anascriptlist{box-shadow:0 0 5px #eee}
.reference .anascriptlist:hover{box-shadow:0 0 10px #ccc}
.required-field-info{float:right;width:84%}
.mailgsmverify i{float:none;font-size:15px;margin:auto}
#ozet .tabcontentcon{width:85%}
.captchainput{width:110px;font-weight:600;font-size:15px;margin-left:5px}
.captcha-content{margin:auto;margin-top:20px;width:320px;text-align:center}
#captchainput{width:110px;font-weight:600;font-size:15px;margin:0px;margin-bottom:25px}
.captcha-content img {border-radius:7px;}
.required-field-info input:focus{padding-left:0}
.required-field-info input{padding:10px 0;margin-right:5px;font-size:14px}
.hesapbilgisi{display:inline-block;margin:3px;width:100%}
.hesapbilgititle{font-weight:600;font-size:15px}
.hesapbilgisi .yuzde25{width:35%;float:left;line-height:37px}
.hesapbilgisi .yuzde75{width:64%;}
.kisiselbilgiler{float:left;width:49%}
.digerbilgiler{float:right;width:49%}
.hesapinfobloktitle{float:left;width:100%;padding-bottom:15px;border-bottom:1px solid #eee;margin-bottom:15px;font-weight:600;font-size:18px;color:#<?php echo $color2; ?>}
.mailgsmverify strong{display:inline-block;width:220px;margin-right:20px;float:left;margin-top:15px}
.countryselect{display:inline-block;margin-top:7px;margin-left:15px;width:60px;height:30px;background-size:100% auto;text-align:center;padding-top:5px;background-repeat:no-repeat}
.countryselect a {color:#ffffff87;font-weight:bold;}
.countryselect a:hover {color:#ffffff;}
#selectLangCurrency{display:none;background-size:100% auto;box-shadow:none;background-position:center;background-color:transparent;color:white;text-align:center}
.langandcur{float:left;width:100%}
.langandcur img{display:inline-block;height:16px;margin-right:8px;margin-top:0px;margin-bottom:-3px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px}
.langcurclose{position:absolute;right:-10px;top:-10px;width:25px;height:25px;text-align:center;line-height:25px;background:#33333357;color:white;-webkit-border-radius: 100%;-moz-border-radius: 100%;border-radius: 100%;}
.langandcur .currencyitems a {width:31%;}
.activelangcur {opacity:0.45; filter:alpha(opacity=45);}
.langandcur h4 {float:left;width:100%;padding-bottom:10px;margin-bottom:15px;    font-size: 24px;    font-weight: 600;}
.langandcur a{display:inline-block;vertical-align:top;width: 31%;margin:5px;font-size:15px;color:#9d9d9d;padding:10px;border:1px solid #ffffff42;border-radius:50px}
.langandcur a:hover{border:1px solid #fff;color:#fff}
.currencyitems {margin-top:25px;}
.countryselectimg{width:22px;height:17px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;opacity:.7;filter:alpha(opacity=70)}
.countryselectimg:hover{opacity:1;filter:alpha(opacity=100)}
#othercountrycon{background-position:center center;float:left;width:100%;height:auto;background-size:100% auto;background-color:#333;color:#fff;font-weight:200;}
#othercountrycon a{color:#eee;font-weight:300;}
#othercountrycon #ch-currency h5 {width:24%}
#othercountrycon h2{font-size:18px;border-bottom:1px solid #515151;    font-weight: 200;}
#othercountrycon h5{font-size:14px;margin-bottom:10px;float:left;width:33%}
#othercountrycon h5 a:hover{text-decoration:underline}
#othercountrycon h5 img{float:left;margin-right:5px;width:20px;    margin-bottom: 5px; height:17px;margin-top:3px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px}
#fullwidth .head .countryselect a{padding:0;line-height:normal}
#fullwidth .head .countryselect a:hover{    background:none;}
#fullwidth .head .countryselect{line-height:normal;margin-top:10px;background-image:url(../images/map2.png)}
#fullwidth .head #othercountrycon h5 a{background:none}
#fullwidth .menu li a {font-weight:300;padding:0px 35px;border:none}
#fullwidth .menu ul li ul li a {    padding: 0 0 0 10px;}
#fullwidth .menu li a:hover{border:none}
#offer{position:absolute;font-size:12px;margin-top:-5px;margin-left:-35px;font-style:normal;background:#4caf50;line-height:normal;padding:3px 10px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;font-weight:400}
#ConvertBody{text-align:center;font-size:16px}
.categoriesproduct{display:inline-block;text-align:center;width:100%;margin-top:15px;margin-bottom:30px}
.categoriesproduct a img{height:50px;width:auto;float:left;margin-right:10px}
.categoriesproduct a{line-height:50px;margin:5px;font-size:16px;border:none;padding:5px 30px;border-bottom:2px solid #ccc}
.categoriesproduct a:hover{background:#d7d7d7;border-bottom:2px solid #ccc;color:#<?php echo $color1; ?>}
.categoriesproduct a i{font-size:30px;line-height:50px;margin-right:15px;float:left}
#category-button-active{background:#d7d7d7;border-bottom:2px solid #b0b0b0}
#tercihler .checkbox-custom-label,.radio-custom-label{margin: 2.5px 0px;}
#tercihler .tabcontentcon{width:55%;margin-top:30px;margin-bottom:30px}
#sifredegistir .tabcontentcon{margin-bottom:60px}
#datatable thead img{height:20px;opacity:.6;filter:alpha(opacity=60)}
.datatable thead img{height:20px;opacity:.6;filter:alpha(opacity=60)}
.hostozellk img{width:120px}
.sunucusipside .error{padding-top:15px}
.tablepaket{display:inline-block;margin-bottom:25px;vertical-align:top;-webkit-transform:perspective(1px) translateZ(0);transform:perspective(1px) translateZ(0);box-shadow:0 0 1px transparent;position:relative;    -webkit-box-shadow: 0px 20px 45px 0px rgba(0, 0, 0, 0.08);
    box-shadow: 0px 20px 45px 0px rgba(0, 0, 0, 0.08);
    border-radius: 7px;}
.categoriesproduct a{display:inline-block;vertical-align:middle;-webkit-transform:perspective(1px) translateZ(0);    border-radius: 50px;transform:perspective(1px) translateZ(0);box-shadow:0 0 1px transparent;position:relative;-webkit-transition-duration:.3s;transition-duration:.3s;-webkit-transition-property:transform;transition-property:transform}
.categoriesproduct a:before{pointer-events:none;position:absolute;z-index:-1;content:'';top:100%;left:5%;height:10px;width:90%;opacity:0;background:-webkit-radial-gradient(center,ellipse,rgba(0,0,0,.35) 0,transparent 80%);background:radial-gradient(ellipse at center,rgba(0,0,0,.35) 0,transparent 80%);-webkit-transition-duration:.3s;transition-duration:.3s;-webkit-transition-property:transform,opacity;transition-property:transform,opacity}
.categoriesproduct a:active,.categoriesproduct a:focus,.categoriesproduct a:hover{-webkit-transform:translateY(-5px);transform:translateY(-5px)}
.categoriesproduct a:active:before,.categoriesproduct a:focus:before,.categoriesproduct a:hover:before{opacity:1;-webkit-transform:translateY(5px);transform:translateY(5px)}
#check_results a{font-size:16px;font-weight:700}
.spinner{width:40px;height:40px;margin:30px auto;background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}
@-webkit-keyframes sk-scaleout {
0%{-webkit-transform:scale(0)}
100%{-webkit-transform:scale(1.0);opacity:0}
}
@keyframes sk-scaleout {
0%{-webkit-transform:scale(0);transform:scale(0)}
100%{-webkit-transform:scale(1.0);transform:scale(1.0);opacity:0}
}
.sss .ui-state-active,.ui-widget-content .ui-state-active,.ui-widget-header .ui-state-active,a.ui-button:active,.ui-button:active,.ui-button.ui-state-active:hover{   
    background: #eee;font-weight: 600;
    color: #<?php echo $color1; ?>;}

.sss .ui-state-default, .ui-state-hover {    color: #<?php echo $color2; ?>;}
div.angrytext{-webkit-animation:blink 3s ease-in 0 infinite normal;animation:blink 3s ease-in 0 infinite normal}

@-webkit-keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
@keyframes blink {
0%{opacity:1}
25%{opacity:0}
50%{opacity:1}
75%{opacity:0}
100%{opacity:1}
}
#karart{display:block;position:fixed;top:0;left:0;bottom:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:991}
.content-updown{width:85%}
.content-updown .formcon .yuzde70 select{width:60%}
.content-updown .tablepaket select{width:190px;padding:10px;text-align-last:center;font-size:20px;font-weight:600;margin-bottom:10px}
.content-updown .tablepaket .gonderbtn{margin-top:0;font-size:15px;padding:12px 0px;width:60%}
#currentpacket{width:320px;margin-bottom:0;display:none}
.content-updown .tablepaket span{font-size:14px;padding:4px 0}
.content-updown .tpakettitle{font-size:24px;height:40px;line-height:40px;margin:0px;margin-top:10px}
.content-updown .tpakettitle i{font-size:25px}
.meter{height:30px;position:relative;background:#bebebe;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;padding:0;-webkit-box-shadow:inset 0 -1px 1px rgba(255,255,255,0.3);-moz-box-shadow:inset 0 -1px 1px rgba(255,255,255,0.3);box-shadow:inset 0 -1px 1px rgba(255,255,255,0.3);text-shadow:0 0 2px #848484}
.meter div{position:absolute;z-index:5;width:100%;color:#fff;font-size:13px;text-align:center;font-weight:600;line-height:30px}
.meter > span{display:block;height:100%;-webkit-border-top-right-radius:3px;-webkit-border-bottom-right-radius:3px;-moz-border-radius-topright:3px;-moz-border-radius-bottomright:3px;border-top-right-radius:3px;border-bottom-right-radius:3px;-webkit-border-top-left-radius:3px;-webkit-border-bottom-left-radius:3px;-moz-border-radius-topleft:3px;-moz-border-radius-bottomleft:3px;border-top-left-radius:3px;border-bottom-left-radius:3px;background-color:#2bc253;background-image:-webkit-gradient(linear,left bottom,left top,color-stop(0,#2bc253),color-stop(1,#54f054));background-image:-moz-linear-gradient(center bottom,#2bc253 37%,#54f054 69%);-webkit-box-shadow:inset 0 2px 9px rgba(255,255,255,0.3),inset 0 -2px 6px rgba(0,0,0,0.4);-moz-box-shadow:inset 0 2px 9px rgba(255,255,255,0.3),inset 0 -2px 6px rgba(0,0,0,0.4);box-shadow:inset 0 2px 9px rgba(255,255,255,0.3),inset 0 -2px 6px rgba(0,0,0,0.4);position:relative;overflow:hidden}
.meter > span:after,.animate > span > span{content:"";position:absolute;top:0;left:0;bottom:0;right:0;background-image:-webkit-gradient(linear,0 0,100% 100%,color-stop(.25,rgba(255,255,255,.2)),color-stop(.25,transparent),color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.2)),color-stop(.75,rgba(255,255,255,.2)),color-stop(.75,transparent),to(transparent));background-image:-moz-linear-gradient(-45deg,rgba(255,255,255,.2) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.2) 50%,rgba(255,255,255,.2) 75%,transparent 75%,transparent);z-index:1;-webkit-background-size:50px 50px;-moz-background-size:50px 50px;-webkit-animation:move 2s linear infinite;-webkit-border-top-right-radius:8px;-webkit-border-bottom-right-radius:8px;-moz-border-radius-topright:8px;-moz-border-radius-bottomright:8px;border-top-right-radius:8px;border-bottom-right-radius:8px;-webkit-border-top-left-radius:20px;-webkit-border-bottom-left-radius:20px;-moz-border-radius-topleft:20px;-moz-border-radius-bottomleft:20px;border-top-left-radius:20px;border-bottom-left-radius:20px;overflow:hidden}
.animate > span:after{display:none}
@-webkit-keyframes move {
0%{background-position:0 0}
100%{background-position:50px 50px}
}
.orange > span{background-color:#f1a165;background-image:-moz-linear-gradient(top,#f1a165,#f36d0a);background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#f1a165),color-stop(1,#f36d0a));background-image:-webkit-linear-gradient(#f1a165,#f36d0a)}
.redx > span{background-image:-moz-linear-gradient(top,#f0a3a3,#f42323);background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#f0a3a3),color-stop(1,#f42323));background-image:-webkit-linear-gradient(#f0a3a3,#f42323)}
.nostripes > span > span,.nostripes > span:after{-webkit-animation:none;background-image:none}
#weak{background:#f44336;padding:6px;color:#fff;text-align:center;font-size:14px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#strong{background:#4CAF50;padding:6px;color:#fff;text-align:center;font-size:14px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#good{background:#cddc39;padding:6px;color:#fff;text-align:center;font-size:14px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
#renewal_list{width:50%;padding:5px;margin:auto}
#renewal_list select{text-align-last:center}
#ModifyWhois input{padding-left:0}
#haveAddress h5{font-size:16px}
#sendbta{font-size:14px}
.ModifyDns{display:inline-block;width:45%;text-align:center;border:1px solid #eee;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;min-height:300px;margin:20px;vertical-align:top}
#ModifyDns input{width:240px}
.ModifyDns .yuzde50{width:47%}
.ModifyDns input{padding-left:0}
#baslikislemleri table tr td{padding:10px;border-bottom:1px solid #eee}
#baslikislemleri table tr th{padding:10px}
#credit_list{width:50%;padding:5px;margin:auto}
#credit_list select{text-align-last:center}
.prereg-warning{font-weight:400;float:right;position:absolute;margin-left:15px;font-size:16px}
.domainlookuplist{width:70%;margin:auto}
.lookcolumtitle{background:#eee;display:inline-block;width:100%;font-weight:700;    border-radius: 7px;}
.lookcolum{width:25%;height:35px;line-height:35px;padding:10px 0;text-align:center;border-bottom:1px solid #eee;float:left}
.lookcolum .checkbox-custom-label{margin-right:-10px}
#tldok{color:#8BC34A;font-weight:700}
#tldno{color:#F44336;font-weight:700}
.tldhere{font-size:18px}
.tldavailable h4{color:#8BC34A;font-size:26px;line-height:45px}
#showTLDStatusUnavailable{color:#F44336}
.tldavailable{text-align:center;margin:35px 0}
.lookcolum .yesilbtn{padding:7px 0;margin:0;height:100%}
.tldlistfoot .lookcolum{border:none}
.spinnertld{line-height:45px}
.spinnertld > div{width:18px;height:18px;background-color:#ccc;border-radius:100%;display:inline-block;-webkit-animation:sk-bouncedelay 1.4s infinite ease-in-out both;animation:sk-bouncedelay 1.4s infinite ease-in-out both}
.spinnertld .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}
.spinnertld .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}
@-webkit-keyframes sk-bouncedelay {
0%,80%,100%{-webkit-transform:scale(0)}
40%{-webkit-transform:scale(1.0)}
}
@keyframes sk-bouncedelay {
0%,80%,100%{-webkit-transform:scale(0);transform:scale(0)}
40%{-webkit-transform:scale(1.0);transform:scale(1.0)}
}
#upgrade .ion-speedometer{float:left;font-size:70px;margin:0 35px 17px 20px;line-height:25px;margin-top:-5px}
ul.tab .ion-speedometer{font-size:19px;line-height:0}
.amount-thousands{font-size:18px;float:left;width:100%;margin-bottom:15px;color:#777}
.invoicex{max-width:900px;background:#fff;margin:25px auto;box-shadow:0 0 15px #ccc;    border-radius: 7px;}
.invoicex .padding{padding:40px}
.invoicex .tabcontentcon {    margin-bottom: 0px;}
.custbillinfo{float:left;width:40%;font-size:14px}
.companybillinfo{float:right;width:45%;font-size:14px;text-align:right}
.companybillinfo img{margin-bottom:25px;height:45px;width:auto}
.invoicestatus{float:left;width:40%;text-align:center;border:2px dotted #eee;font-size:28px}
.invoicepaymethod{font-size:14px;display:inline-block;float:left;width:100%;color:#a9a9a9}
.invoicestatus .invpaid{color:#8BC34A}
.invoicestatus .invwait{color:#<?php echo $color2; ?>}
.invoicestatus .invnopay{color:#F44336}
.invoicetimes{float:right;width:40%;margin-bottom:20px;margin-top:15px}
.invoicetimes .formcon .yuzde50{font-size:14px}
.invoiceidx{float:left;font-size:18px;width:40%;text-align:center;margin-top:20px}
.invoicedesc{margin-top:25px;border:1px solid #eee;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px}
.invoicedesc .formcon span{padding:0 10px}
.invoicedesc .formcon{padding:3px 0}
.invoicedesc .formcon .yuzde70{font-size:14px}
.invoicedesc .formcon .yuzde30{font-size:14px;text-align:center}
.otherincoivebtns{float:right;margin:7px 0px;z-index:5;position:relative}
.otherincoivebtns .sbtn{padding:4px 12px;border:none;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;width:auto;font-size:14px}
.otherincoivebtns .sbtn:hover{background:#<?php echo $color2; ?>;color:white;}
.otherincoivebtns .sbtn i{margin-right:5px}
.license-verify{float:left;width:100%;margin-bottom:80px}
.license-verify .pakettitle h2 span{font-size:18px;font-weight:300;color:#8d8d8d}
.license-verify-box{width:650px;margin:auto;margin-top:25px}
.license-verify-box input{padding:20px 0;font-size:18px}
.license-verification-result{text-align:center;width:100%;margin-top:25px}
.license-ok{background:#f6ffec;color:#75b22f;margin:auto;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.license-none{background:#fff2f1;color:#f44336;margin:auto;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
.license-none .gonderbtn{border:2px solid #f44336;color:#f44336;margin-top:20px;font-weight:600}
.license-none .gonderbtn:hover{color:#fff;background:#f44336}
.license-verification-result i{font-size:48px;margin-bottom:15px}
.faturabilgisi .red-info{border:none;}
.faturabilgisi .red-info h5{color:#<?php echo $text_color; ?>;font-size:16px;}
.resellericon{margin-left:5px;display:inline-block;margin-bottom:-8px;height:25px}
#payment-screen .bankablok{width:48.5%;margin:5px}
#payment-screen .green-info i{font-size:20px;margin:0;margin-top:2px;margin-right:10px}
#notifiballonalert{-webkit-animation:alert 2s linear 0 infinite normal;animation:alert 2s linear 0 infinite normal}
#orders-none  {    text-align: center;    margin-top: 55px;    display: inline-block;    width: 100%;}
#addons {width:90%;    margin: auto;}
 #upgrade-product-none{text-align:center;margin-top:55px;color:#F44336;font-weight:bold}
.style-toggle-active{margin-left:-5px}
#style-toggle{position:fixed;left:0px;top:25%;background:white;width:590px;margin-left:-294px;z-index:485;border-radius:3px;box-shadow:0px 0px 7px #ccc;-webkit-transition:all 0.5s ease-out;-moz-transition:all 0.5s ease-out;-ms-transition:all 0.5s ease-out;-o-transition:all 0.5s ease-out;transition:all 0.5s ease-out}
.styletheme{display:inline-block;box-shadow:0px 0px 10px #8e8e8e;margin:10px;text-align:center;line-height:130px;width:46%;height:130px;background-size:100% 100%;background-position:center;border-radius:3px;overflow:hidden}
.styletheme h5{color:white;background:rgba(0,0,0,0.6);-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out}
.styletheme h5:hover{opacity:0.0;filter:alpha(opacity=00)}
.style-toggle-button{float:right;background:white;padding:5px 15px;margin-right:-44px;font-size:22px;border-radius:3px;margin-top:27px;box-shadow:4px 0px 7px #ccc}
.style-toggle-button i{-webkit-animation:fa-spin 2s infinite linear;animation:fa-spin 2s infinite linear;margin-right:-3px}
.gprimage{height:70px;-webkit-filter:grayscale(100%);filter:grayscale(100%);float:left;opacity:0.5}
.gprimage:hover{-webkit-filter:grayscale(0%);filter:grayscale(0%);opacity:1.5}
.homedomainarea-con{width:75%;margin:auto}
.homedomainarea{-webkit-box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);width:100%;margin-top:-70px;z-index:50;position:relative;background:white;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px}
.homedomainarea h1{color:#<?php echo $color1;?>}
.homedomainarea h4{font-size:24px;font-weight:300;color:#<?php echo $color2;?>;margin:15px 0px}
.homedomainarea input:not([type="submit"]){border-radius:2.20588rem;width:60%;height:100%;border:0px;padding:20px 32px;-webkit-box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);box-shadow:0px 10px 45px 0px rgba(0,0,0,0.06);border:1px solid #f5f3f3;margin:25px 0px;font-size:22px;font-weight:300;color:#<?php echo $color2;?>}
.homedomainarea::-webkit-input-placeholder{color:#<?php echo $color2;?>}
.homedomainarea:-moz-placeholder{color:#<?php echo $color2;?>}
.homedomainarea::-moz-placeholder{color:#<?php echo $color2;?>}
.homedomainarea:-ms-input-placeholder{color:#<?php echo $color2;?>}
.homedomainarea input[type="submit"]:hover{background-color:#<?php echo $color2;?>}
.homedomainarea input[type="submit"]{border:0px;background-color:#<?php echo $color1;?>;border-radius:2.20588rem;color:#FFFFFF;margin-left:-155px;padding:20px 0px;position:absolute;margin-top:30px;display:inline-block;cursor:pointer;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;transition:all 0.4s ease;width:150px;font-size:16px}
.spottlds:nth-last-child(2){border:none}
.spottlds{display:inline-block;width:132px;margin:15px 10px;border-right:1px solid #ccc;padding:0px 10px}
.spottlds img{height:25px;float:left}
.spottlds h5{font-weight:900;color:#<?php echo $color2;?>}
.tableslogan{margin-top:20px;font-weight:300;font-size:26px}
#theme2 .homedomainarea-con{width:100%;background:#eeeeee;background:-moz-linear-gradient(top,#eeeeee 0%,#ffffff 100%);background:-webkit-linear-gradient(top,#eeeeee 0%,#ffffff 100%);background:linear-gradient(to bottom,#eeeeee 0%,#ffffff 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee',endColorstr='#ffffff',GradientType=0 )}
#theme2 .homedomainarea h1{margin-top:25px}
#theme2 .homedomainarea{margin-top:0px}
.anatanitim{background-repeat:no-repeat;background-position:center top;display:inline-block;background:black;position:relative;overflow:hidden;color:#ffffffe8;width:100%;margin:50px 0px;background-size:100% auto;padding:80px 0px}
.anatanitim video{margin-top:-150px;opacity:0.5;width:100%;position:absolute}
.anatanitim .gonderbtn{float:right;position:relative;z-index:4;margin-top:80px;font-size:18px;color:white;border:2px solid white;width:200px;margin-right:150px;border-radius:30px;text-align:center;padding:10px 0px}
.anatanitim .gonderbtn:hover{background:white;color:black}
.tanslogan{float:left;width:40%;z-index:5;font-weight:200;font-size:16px;font-family:'Raleway',sans-serif;line-height:24px}
.anatanitim video{margin-top:-150px;opacity:0.5;width:100%;position:absolute}
.tanslogan h2{border-bottom:1px solid #ffffff3d;padding-bottom:15px}
#empty_list {margin-top: 7%;    margin-bottom: 40px;color:#<?php echo $color2; ?>; text-align: center; display:none;}
#empty_list i {font-size:54px;margin-bottom:20px;}
#empty_list h4 {font-size:22px;}
#empty_list span {font-size:18px;}
#continueshopbtn{padding:10px 30px;margin-top:45px}
.result-content h4{color:#4CAF50;font-size:22px}
.siparisbilgileri .ui-state-active{background:#<?php echo $color2;?>;color:white}
.siparisbilgileri .ui-state-default{border-radius:10px}
.sepetsipinfo .totalamountinfo{border:none;padding-top:25px;padding-bottom:10px}
.sepetsipinfo .totalamountinfo strong{font-size:16px}
.sepetsipinfo .totalamountinfo h5{font-size:30px;color:#8bc34a}
#uyeolgiris{margin-bottom:3%;display:inline-block;width:100%}
#uyeolgiris input {padding:15px 0px;}
#uyeolgiris .intl-tel-input.separate-dial-code.allow-dropdown.iti-sdc-3 input, .intl-tel-input.separate-dial-code.allow-dropdown.iti-sdc-3 input[type=text], .intl-tel-input.separate-dial-code.allow-dropdown.iti-sdc-3 input[type=tel] {    padding-left: 84px;}
.faturabilgisi .yesilbtn{width:220px;float:right}
#NotificationForm .gonderbtn{margin-top:20px}
.sunucular .lbtn{padding:7px 18px;border:none;background:#eee;font-size:14px;border-radius:5px}
.sunucular .lbtn:hover{background:#81c04e}
#StepForm2 .alanadisorgu input{margin:5px 0px;font-size:18px}
#StepForm1 .alanadisorgu option{font-size:15px}
#StepForm1 .alanadisorgu optgroup{font-size:15px}
#StepForm2 .alanadisorgu h5{margin-bottom:25px}
#muspanel table.dataTable thead th{padding:14px 0px}
.datatbspan{color:#<?php echo $text_color;?>}
#muspanel .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active{cursor:default;color:#<?php echo $text_color;?>!important;border:1px solid #eee;background-color:#eee;border-radius:3px}
#muspanel .dataTables_wrapper .dataTables_paginate .paginate_button.current,.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{color:#<?php echo $text_color;?>!important;border:1px solid #eee;background-color:#eee}
#muspanel .ui-widget-content{color:#<?php echo $text_color;?>}
#muspanel .ui-state-active {background:#<?php echo $color2; ?>;    border-radius: 10px;}
#muspanel .ui-accordion .ui-accordion-header {   border-radius: 10px;}
#muspanel .dataTables_info {color: #<?php echo $text_color; ?>;}
#muspanel table.dataTable tbody tr{-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out}
#muspanel table.dataTable tbody tr:hover{background-color:#f3f3f3}
#muspanel .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:64px}
#muspanel .select2-container .select2-selection--single{height:64px}
#muspanel .select2-container--default .select2-selection--single .select2-selection__arrow{height:64px}
.amount_spot_view{position:relative;display:inline-block}
.amount_spot_view i{font-style:normal;font-size:18px;font-weight:400;position:absolute}
.currposleft{margin-left:-15px;left:0px}
.currposright{margin-right:-15px;right:0px}
.sepetsipinfo .amount_spot_view{margin-right:10px}
#total-amount-payable{margin-right:-10px}
.tablepaket .currposright{font-size:22px}
.products_features{line-height:28px}
.ddiscountnewprice{background:#fff;padding:2px 0px;text-transform:capitalize;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;font-weight:bold;width:60%;display:inline-block;color:#<?php echo $color1;?>;font-size:19px}
.uzantibox .amount_spot_view i{font-size:14px}
.uzantibox .currposright{margin-right:-10px}
.uzantibox .currposleft{margin-left:-10px}
.doldprice{text-decoration:line-through}
.dnewprice{color:white;position:relative;width:100%;margin-top:-10px;margin-bottom:7px}
.domdiscount{background:#fff;padding:2px 10px;text-transform:capitalize;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;color:#009595;font-size:15px}
.invoiceremind{text-align:center;width:99%;font-weight:300;display:inline-block}
.invoiceremind .red-info{width:100%;margin-top:10px;text-align:left;background:transparent;color:#<?php echo $text_color;?>;border:1px solid #<?php echo $text_color;?>} 
.invoiceremind .red-info i{float:none;margin-bottom:0;font-size:45px;color:#F44336;    margin: 0;}
.invoiceremind h4{display:inline-block;font-weight:700;font-size:18px}
@media only screen and (max-width:1025px) and (min-width:320px){.invoiceremind{margin-bottom:15px;font-size:13px}
.invoiceremind h4{font-size:16px}
.invoiceremind .lbtn{float:none;margin-top:7px}
.invoiceremind .padding20{padding:15px}
}
#payment-screen .red-info{display:inline-block;    background: none;width:100%;color:#<?php echo $text_color;?>;border:none;margin-top:10px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}
#payment-screen .red-info h5{font-size:15px}
.serverblokbtn a{border-radius:50px}
.homedomainarea .amount_spot_view i{font-size:14px;font-weight:600}
.homedomainarea .currposleft{margin-left:-12px}
.homedomainarea .currposright{margin-right:-12px}
.homedomainarea h4 .amount_spot_view{margin:15px;font-weight:700}
.alanadisorgu h1 .amount_spot_view{margin:0px 15px;font-weight:700}
#megamenu #kurumsalmenu{background-image:url(../images/kurumsalmenubg.jpg);padding:15px 0}
#megamenu #kurumsalmenulinks{float:left;font-size:15px;width:23%;margin-left:15px;text-shadow:.03em .03em #fff}
#megamenu #kurumsalmenulinks a{font-size:15px;color:#607D8B;padding-bottom:5px;font-weight:normal;font-family:'Titillium Web',sans-serif;padding:0px;line-height:35px;background:none;width:100%;float:left}
#megamenu #kurumsalmenulinks a:hover{padding-left:5px;color: #12232c;}
#megamenu #kurumsalmenulinks h4{font-size:16px;font-weight:700;  margin-bottom:10px;padding-bottom:10px;    border-bottom: 1px solid #607d8b36;color:#607D8B}
#megamenu #kurumsalmenulinks h3{font-size:22px; font-weight:700;color:#607D8B;line-height:28px;margin-bottom:15px;border:1px solid #607D8B;text-align:center;padding:10px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}
#megamenu #kurumsalmenulinks h3 span{font-size:18px;font-weight:400}
#corporatemenu {background-position: center center; background-size:100%;}
.sunucular .dataTables_wrapper table tr td {    font-size: 15px;    padding: 8px 0px;}
.orderperiodblock.active {    box-shadow: 0px 0px 10px #ccc;}
#clean-theme-client{background:#fafafa}
#clean-theme-client .moderncliendblock{width:100%;min-height:auto}
#clean-theme-client .mpaneltitle .sbtn{margin-right:15px}
#clean-theme-client .noentryblock{margin:20px 0px}
#clean-theme-client .mpanelleft{background:none}
.clean-theme-client-left-block{background:white}
#clean-theme-client .mpanelrightcon{background:white;}
.clean-theme-header{background:white}
.uzantibox{background:white}
#tesclsure{background:none}
.bbankaara .lbtn{border-radius:5px}
#clean-theme-client .alanadisorgu input{background:white}
.orderperiodblock{background:white}
.orderperiodblock.active{background:white}
#clean-theme-client .ui-widget-content {  background: rgb(255,255,255);
background: -moz-linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
background: -webkit-linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#fafafa",GradientType=1);}
#clean-theme-client .tabcontentcon .ui-widget-content {  background: rgb(255,255,255);
background: -moz-linear-gradient(360deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
background: -webkit-linear-gradient(360deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
background: linear-gradient(360deg, rgba(255,255,255,1) 0%, rgba(250,250,250,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#fafafa",GradientType=1);}
#SearchTerm {background:none;}


/* #mobile-mobile-devices */
@media only screen and (min-width:320px) and (max-width:1024px) {
#wrapper{width:95%;}
.clearmob{clear:both;display:block}
.menuAc{display:block;width:75px;float:right;text-align:center;position:absolute;top:-55px;font-size:30px;right:0;text-shadow: 0 0 10px #ccc;}
.sabithead .menuAc{display:block;width:20%;float:left;text-align:center;font-size:28px;position:absolute;top:0;left:-15px}
.sabithead .menu ul{top:53px}
.sabithead .menu ul li ul{top:0}
.sabithead .menu li a{padding:12px 15px;line-height:normal}
.sabithead #sepeticon{color:#fff;margin:10px;margin-right:20px;float:right}
.menu ul{display:none;position:absolute;float:left;width:100%;background:#<?php echo $color1; ?>}
.menu ul li{float:none}
#megamenuli{position:relative}
.menu{float:left;width:100%;}
.menu li{float:left;width:100%}
.menu li a{float:left;width:100%;font-size:15px;background:rgba(0,0,0,0.2);line-height:40px;padding:0;border-bottom:1px solid rgba(0,0,0,0.2)}
.menu li a span{padding-left:25px}
.menu ul li ul{width:100%;float:left;position:relative;top:0;left:0;z-index:1;display:none;margin:0;padding:0;font-size:16px}
.menu ul li ul li ul{width:100%;top:41px;left:0}
.menu li:hover a{background:rgba(0,0,0,0.4)}
.menu ul li ul li a{width:100%;font-size:14px;padding:0;padding-left:10px;font-weight:300}
.menu ul li ul li ul li a{padding-left:20px}
.head{width:92%}
.nomobilbtn{display:none}
.headbutonlar a{float:left;margin-right:20px;font-size:13px;margin-left:0}
.sosyalbtns{display:none}
.logo{float:left;position:relative;    margin-top: 0px;}
#muspanel .logo{margin-bottom:0}
.logo img{width:195px}
.slidetext-container{width:90%;margin-top:65%}
.slidetext-container h1{font-size:22px}
.slidetext-container p{width:100%;font-size:15px}
.domainhome{height:auto;padding:10px 0}
.hdomainslogan{margin-top:0;float:none;text-align:center;line-height:35px}
.hdomainslogan h4{font-size:16px}
.hdomainslogan h3{font-size:18px}
.hdomainsorgu{float:left;width:100%;margin-top:0}
.hsorgulabtn{position:absolute;margin-left:0;right:0;font-size:24px;margin-top:-48px;margin-right:10px}
.hdomainsorgu input{font-size:18px;border:none;-moz-box-sizing:border-box;box-sizing:border-box;text-align:center;padding:0;font-size:22px}
.domainfiyatlar{display:none}
.anatanitim{background-size:auto;padding-bottom:0;padding-bottom:30px}
.tanslogan{margin-top:30px;width:96%;margin-left:10px}
.tanslogan h2{font-size:22px}
.tablopaketler{height:auto;background-size:auto;background-position:center top;background-repeat:repeat;text-align:center}
.tablopaketler .gonderbtn{display:inline-block}
.tablepaket{float:none;width:90%;display:inline-block;margin:18px auto}
.anascript{background-repeat:repeat;background-position:top center;height:auto;background-size:auto}
.scriptkategoriler{width:100%}
.scriptkategoriler a{padding:5px 0 5px 10px;margin-bottom:4px;font-size:16px;width:95%}
.anascripler{float:left;width:100%;margin-top:15px}
.tumscriptbtn{margin-top:15px;width:85%;margin-bottom:20px}
.pakettitle h1{font-size:22px}
.pakettitle h2{font-size:20px}
.ozellik{width:100%;margin:20px 0}
.servisikon{height:90px;width:90px;font-size:36px;margin-right:0}
.servisikonalt{height:73px;width:73px;line-height:73px}
.ozellik h4{font-size:22px;margin-bottom:10px}
.ozellik p{font-size:15px;line-height:20px}
.servisinfos{width:100%}
.musterigorusleri .list_carousel{width:300px;margin:auto}
#foo2 li{width:300px;height:auto}
.yorumyapan{width:100%;margin-left:0}
.yorumyapan img{margin-right:10px;width:60px;height:60px}
.gorusgonderbtn{margin-top:0}
.pager{margin-top:-85px}
.anascriptlist img{height:auto;width:100%}
.modalDialog>div{width:93%;margin:15% auto;padding:5px 10px 12px}
.close{right:-2px;top:-3px}
.sabithead{display:none}
.footlogos{margin-bottom:10px}
.footlogos img{width:70px;height:auto;margin:10px}
.blogvehaber{height:auto;padding-bottom:25px}
.haberblog{width:100%;margin:0;margin-bottom:15px}
.haberblog .list_carousel{width:270px;margin:auto}
.haberblog .list_carousel li img{width:100%;margin-bottom:15px;}
.haberblog .list_carousel li{width:270px;margin:auto}
.haberblog .pager a{width:15px;height:15px;margin:2px}
.haberbloktitle h4{font-size:18px}
.istatistik{float:left;width:49%;display:inline-block;margin:35px 0px}
.ebultencont{width:95%}
.ebultencont i{margin-left:10px}
.ebultencont input{width:47%;font-size:12px}
.aboneolbtn{margin:5px;width:55px;font-size:14px;line-height:46px;padding:0px;width:110px}
.footslogan{line-height:normal;height:auto;text-align:center;padding:15px 0}
.footslogan h2{float:none}
.footinfos{float:none;width:94%;margin:12px;margin-bottom:20px;display:inline-block;vertical-align:top}
.footblok{float:none;width:42%;margin:12px;font-size:14px;display:inline-block;vertical-align:top}
.footend{height:auto;text-align:center;padding:15px 0}
#uyeolgirisbody .footend{position:relative}
.footend span{float:none;font-size:14px;line-height:normal}
.footsosyal{float:none;margin:auto;display:inline-block;margin-bottom:10px;margin-top:15px}
.footsosyal a{margin:0px 3px}
.istatistik i{font-size:90px;margin-top:-100px;margin-left:-40px}
.istatistik h1{font-size:36px}
.istatistik h2{font-size:18px;margin-top:0px}
#fullwidth .head{height:auto;line-height:normal}
#fullwidth .logo{height:auto;text-align:center;    float: none;    width: 140px;}
#fullwidth .logo img{width:170px;float:none}
.headmail i{margin-left:15px}
.headmail{display:none;float:none;margin-left:0;text-align:left}
#fullwidth .head a{padding:0 10px;margin-left:0;margin-right:0;font-size:13px;line-height:38px}
#fullwidth .headustlinks a{float:right}
.headinfospan{font-size:15px}
#fullwidth .menuAc{display:block;position:relative;float:left;text-align:center;top:0;font-size:28px;left:0;padding:0;margin-top:8px}
#fullwidth .sabithead .menuAc{display:block;position:relative;float:left;text-align:center}
.sabithead #wrapper{width:100%}
#fullwidth #sepeticon{margin-top:8px;position:absolute;z-index:22;color:#fff;font-size:28px;right:10px}
#fullwidth .sabithead #sepeticon{position:absolute;z-index:22;color:#fff;font-size:26px;right:7px}
#slider4 .slidetext-container h1{font-size:17px}
#slider4 .slidetext-container p{font-size:14px;width:100%;padding:0;margin:0;line-height:15px}
#slider4 .slidetext-container{width:90%;margin:10%;margin-top:10%}
#slider4 #largeredbtn{display:none}
.sayfabaslik{float:none;width:70%;text-align:center;margin:auto;margin-top:25px}
.alanadisorgu input{width:90%;margin-bottom:10px;font-size:15px;padding:24px 15px}
.transfercode input{width:75%;padding-top:24px;padding-bottom:24px;font-size:16px}
.transfercode{width:100%;margin-top:25px}
.domainsec .alanadisorgu{text-align:center}
.tescilsonuc tr td{line-height:normal}
.uzantibox{width:24%;margin:7px;margin-bottom:12px}
.tescilucretleri{width:100%}
#girisfootend{position:relative}
.uyeolgirishead .logo{float:none;width:70%;margin:auto;margin-top:20px;text-align:center}
.uyeolgirishead h1{display:none}
.uyeolgirisslogan{width:100%;margin-top:0}
#girisyapright{width:100%;margin-top:35px}
.hostozellk img{width:100px}
.hostozellk h4{font-size:18px}
.iletisimpage{float:left;text-align:center}
.iletisimblok{width:49%;margin-bottom:25px}
#compnayinfo{width:100%;text-align:center}
.iletisimslogan{font-size:18px;width:100%;margin-top:20px}
.googlemap{width:100%}
.iletisimformu{float:right;width:100%;margin-bottom:25px}
.iletisimformu .gonderbtn{float:right;width:100%;padding:10px 0;text-align:center;margin-top:10px}
#fullwidth .menu ul{position:relative;top:0}
.sayfaustheader{background-size:200% 100%;text-shadow:0 0 2px #000;height:160px}
#header2{height:145px;    background-size: auto 200%;}
#muspanel #header2{height:120px;margin-bottom:0;background-size:100%}
.listeleme{width:100%;margin-top:25px}
.list{width:100%;margin:0;margin-bottom:15px}
.list img{width:100%}
.sidebar{width:99%;margin-top:15px;margin-bottom:0}
.sayfacontent{width:100%;margin-bottom:15px;border:none}
.scriptrightside{width:98%;float:none;margin:auto;position:relative;top:0}
.sayfabaslik a{font-size:15px}
.scriptdetayinfo{float:none;width:97%;padding-right:0;margin:auto;border:none}
.kutubanner{display:none}
.sunucugereksinim{margin-bottom:20px}
.sunucustok{margin-left:0;margin-top:-30px}
.ilanasamax{width:31.9%;font-size:14px;line-height:20px}
.ilanasamax h3{width:50px;height:50px;line-height:50px;font-size:20px}
.asamaline{margin-top:47px;margin-bottom:-45px}
.ilanasamalar{margin-bottom:15px;margin-top:17px}
.uhtutar h4{font-size:16px}
.uhperiyod h5{font-size:16px}
.uhinfo h4 a{font-size:12px}
.siparisbilgileri table{width:100%}
.domainsec{width:100%}
.ui-accordion .ui-accordion-content{padding:15px}
.domainsec .btn{width:90%}
.siparisbilgileri table tr td{font-size:16px}
.sungenbil{width:100%}
.sunucusipside{width:100%;margin-top:20px}
.sipdvmtmmbtn .gonderbtn{width:85%}
.siparisbilgileri table tr td h4{font-size:16px}
.sayfabaslik h1{font-size:20px}
.sayfabaslik i{font-size:10px;margin:5px}
.sepetleft{width:100%}
.sepetright{width:100%}
.uhinfo{width:40%;font-size: 13px;}
.uhperiyod{font-size:13px}
.uhtutar{font-size:13px}
.uhsil a{font-size:15px}
.uhinfo h5{font-size:14px}
.uhperiyod select{width:100%;font-weight:500;font-size:14px}
.mpanelinfo{height:auto;line-height:20px;font-size:15px;text-align:center;padding:10px 0;margin-top:15px}
.sayfayolu{margin-bottom:10px;font-size:13px;float:left;    width: 100%;}
.mpaneltitle h4{font-size:16px;width:100%;float:left}
.destekinfo{width:44%;vertical-align:top}
#ticketfixed .destekinfo{width:44%;    margin-bottom: 8px;}
.destekinfo h5{font-size:15px}
.destekinfocon{padding:10px 0}
.destekinfo h4{font-size:14px}
.destekdosyaeki{width:100%}
.destekdetayright .gonderbtn{padding:10px 0;font-size:16px;margin-top:15px}
.header{-webkit-box-shadow:inset 0 110px 110px -45px rgba(0,0,0,0.75);-moz-box-shadow:inset 0 110px 110px -45px rgba(0,0,0,0.75);box-shadow:inset 0 110px 110px -45px rgba(0,0,0,0.75);padding-bottom:25px;background-size:auto 150%;height:auto;margin-bottom:20px;z-index:444}
#fullwidth #wrapper{width:100%}
.header #wrapper{width:100%}
.headerwhite{display:none}
.mpanelblok:first-child:nth-last-child(4),.mpanelblok:first-child:nth-last-child(4) ~ .mpanelblok{width:45%}
.mpanelblok{width:46%;min-height:130px;margin:5px;}
.mpanelblok h1{font-size:28px;margin-top:15px}
#turquise h1{font-size:22px;margin-top:25px;line-height:35px}
#destekcvpyaz .lbtn{float:left;margin-left:0;margin-right:0;font-size:14px}
.mpanelright{width:100%;margin-bottom:20px}
.mpanelleft{width:100%;margin-bottom:20px;margin-top:0}
.mpanelrightcon{padding:10px;margin-bottom: 20px;}
#muspanel .header{height:auto;margin-bottom:0;padding-bottom:0}
#muspanel .header .sayfabaslik{display:none}
.sepet{margin-top:0}
.destektalebiolustur .yesilbtn{width:100%}
.destektalebiolustur .ucte1{width:100%}
.faturaodenmis .yuzde30{width:100%}
.fattutarlar span {text-align:center}
.fattutarlar .yuzde40{width:100%}
.fattutarlar .yuzde20{width:100%}
.hizmetblok{width:100%;margin:10px 0}
.tabcontentcon{width:100%}
ul.tab li{width:50%}
ul.tab li a{padding:14px 0;width:100%;font-size: 14px;    line-height: 25px;}
.tabcontentcon h5{font-size:16px}
#smsgonder .yuzde50{width:100%}
.mobiltable{overflow:scroll}
.destekolsbtn{float:right}
.dttblegoster{width:50px}
.mobilgenislet{top:9px;left:4px;height:25px;width:25px;display:block;color:#999;border:1px solid #999;border-radius:4px;box-sizing:content-box;text-align:center;font-family:'Courier New',Courier,monospace;line-height:30px;font-size:30px;content:'+';float:left;margin-right:7px}
.paypasbutonlar{margin-top:20px;margin-bottom:-50px}
#header2 .paypasbutonlar{margin-top:0px;text-shadow:none;position:absolute;right:10px;top:3px}
#scriptlistesi{margin:0}
.langbtn{position:absolute;right:10px;top:45px}
#fullwidth .langbtn{float:right;margin-left:20px;margin-top:15px;font-size:16px;position:relative;right:auto;top:auto}
.guncellebtn{width:50%}
.msjyazan h4{font-size:14px;margin-top:-2px}
.bilgibanka h3{font-size:22px}
.bilgibanka h4{font-size:18px}
.bbankaara input{font-size:18px}
.encokokunanbasliklar h5{font-size:16px}
.bbankakonu{margin:auto;width:100%;margin-bottom:15px}
.bbkonuinfo{float:left}
#fullwidth .menu{background-repeat:repeat-x;height:60px}
.menucolor{height:60px}
.alanadisorgu h1{font-size:20px;margin-bottom:20px;margin-top:25px}
.urunozellikleri .fa-caret-right{display:none}
.urunozellikleri .fa-check-circle{display:none}
.urunozellik{float:none;border:1px solid #999;padding:15px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:80%;padding:15px;margin:auto;text-align:center;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-ms-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out;margin-bottom:20px}
.domainsec h5{float:none;margin-top:12px;font-size:15px;margin-left:0}
.siparisbilgileri .btn{font-size:16px}
.scriptozellks{margin:auto;margin-bottom:10px;width:100%}
.sunucusipside{position:-webkit-relative;position:relative}
.scripthoverinfo{display:none}
.uyeol{width:100%;margin-top:35px}
.songiris{font-size:13px;float:none}
#muspanel{background-size:AUTO}
.mblokbtn{font-size:13px}
.mpanelblok h2{font-size:14px}
#header2 .sayfabaslik{margin-top:30px;display:block;text-align:center;width:90%;padding:10px;min-height:75px}
.progresspayment{width:95%;margin:auto;margin-bottom:20px}
.progresspayment h4{font-size:13px;padding:10px;margin-bottom:10px}
.progresspayment h3{margin-top:10px;font-size:20px}
.balancepage .fa-info-circle{display:none}
.balanceinfo{font-size:14px}
.balancepage .hesapbilgilerim table tr td{font-size:13px}
#acdashboardactivity{width:100%;margin-left:0}
#acdashboardnews{width:100%}
.muspanelbloks #blue{display:none}
.modalDialog{position:absolute}
#pre-register-countries label{margin-bottom:3px;width:50%}
#baslikislemleri .modalDialog div{width:90%}
#raporlar .modalDialog div{width:90%}
#raporlar .modalDialog{position:fixed}
.referenceselect select{font-size:16px;width:80%}
.referenceselect option{font-size:16px}
.red-info i{display:none}
.required-field-info{width:100%;font-size:13px}
#ozet .tabcontentcon{width:100%}
.required-field-info input{padding:10px 0;margin-right:5px;width:100%;margin-bottom:5px}
.mailgsmverify{margin-bottom:15px}
.kisiselbilgiler{width:100%}
.digerbilgiler{width:100%;margin-top:25px}
.hesapbilgititle{font-size:13px}
.hesapbilgisi .yuzde25{line-height:normal}
.hesapbilgisi .yuzde75 input{font-size:13px;padding:7px 0}
.hesapbilgisi .yuzde75 select{font-size:13px;padding:7px 0}
.hesapbilgisi .yuzde75 textarea{font-size:13px;padding:7px 0}
.hesapbilgisi .yuzde75{font-size:13px}
.countryselect{margin-top:0;margin-left:0;    display: none;}
#fullwidth .head .countryselect{margin-top:10px;margin-left:10px}
.tablepaket:first-child:nth-last-child(4),.tablepaket:first-child:nth-last-child(4) ~ .tablepaket{width:90%}
.tablepaket:first-child:nth-last-child(8),.tablepaket:first-child:nth-last-child(8) ~ .tablepaket{width:90%}
.tablepaket:first-child:nth-last-child(12),.tablepaket:first-child:nth-last-child(12) ~ .tablepaket{width:90%}
#addNewAddressForm .yuzde30{width:49%}
#addNewAddressForm .yuzde25{width:49%}
#addNewAddressForm .yuzde15{width:49%}
#tercihler .tabcontentcon{width:100%;margin-top:30px;margin-bottom:50px}
#sifredegistir .tabcontentcon{width:100%;margin-top:30px;margin-bottom:50px}
.hostozellk{width:42%;font-size:14px}
.categoriesproduct a{font-size:15px;text-align:left}
.tescilsonuc table{width:95%}
#tesclsure{width:100%}
.dozelliklist{font-size:13px;width:100%;margin:20px 0px}
.domainfeatright{width:70%}
#check_results a{font-size:14px;font-weight:700}
.internationalsmspage .leftblock{width:100%}
.internationalsmspage .leftblock h3{font-size:20px;text-align:center}
.internationalsmspage .leftblock h4{font-weight:300;font-size:16px}
.internationalsmspage .rightblock{width:100%;margin-top:50px}
.internationalsmspage .rightblock h2{font-size:22px}
.internationalsmspage .rightblock select{width:70%}
.ticketinfos{width:100%}
.ticketdetail{width:100%;margin-bottom: 30px;}
.hizmetblok:first-child:nth-last-child(2),.hizmetblok:first-child:nth-last-child(2) ~ .hizmetblok{width:100%}
.hizmetblok:first-child:nth-last-child(4),.hizmetblok:first-child:nth-last-child(4) ~ .hizmetblok{width:100%}
.hizmetblok:nth-child(n+4):nth-child(-n+5){width:100%}
.hizmetblok:nth-child(n+6):nth-child(-n+7){width:100%}
.hizmetblok:first-child:nth-last-child(6),.hizmetblok:first-child:nth-last-child(6) ~ .hizmetblok{width:100%}
#ModifyWhois input{width:49%;font-size:13px}
.tabcontentcon .yesilbtn{width:100%}
.tabcontentcon .turuncbtn{width:100%}
.tabcontentcon .mavibtn{width:100%}
.tabcontentcon .redbtn{width:100%}
.green-info i{display:none}
.green-info p{margin:0;font-size:13px}
.ModifyDns{width:100%;min-height:auto;margin:0;margin-bottom:20px}
.bankablok{width:100%;margin:0;margin-bottom:10px}
#payment-screen .bankablok{width:100%;margin:0;margin-bottom:10px}
#NotificationForm .yuzde40{width:95%}
.bankainfo h5 span{width:100%}
.domainlookuplist{width:100%}
.tldavailable h4{line-height:normal;font-size:22px}
.tldhere{font-size:15px}
.lookcolum{font-size:14px}
.tldlistfoot .lookcolum{width:50%}
.sss #accordion h3{font-size:15px}
.sss #accordion div{font-size:13px}
.content-updown .yuzde30{width:100%}
.content-updown .yuzde70{width:100%}
.content-updown .yuzde50{width:100%}
#addNewEmail .yuzde50inpt{width:100%}
#addNewEmail .yuzde50{width:100%}
#addNewEmail .incelebtn{width:100%;text-align:center;padding:10px 0;margin-top:5px;margin-bottom:5px}
.invoicex{max-width:100%;margin:0;margin-bottom:25px}
.invoicex .padding{padding:15px}
.custbillinfo{width:100%}
.companybillinfo{width:100%;text-align:left;margin-bottom:25px}
.invoicestatus{width:100%}
.invoicetimes{width:100%;margin-bottom:0}
.faturaodenmis{margin:30px 0}
.companybillinfo img{display:block}
.invoiceidx{width:100%}
.invoicedesc .padding20{padding:0}
.license-verify-box{width:100%}
.license-verification-result h4{font-size:18px}
.license-none{width:100%}
.license-ok{width:100%}
#addons {width:100%; }
#fullwidth .menu li a {    padding: 0px; }
#muspanel #fullwidth{  margin-bottom: -15px;}
.langcurclose{top:-1px;right:-3px;}
.langandcur a {width:46%;}
ul.tab li a.active{border-bottom:2px solid #009595;background:#009595;color:white}
.gprimage{float:none;margin-left:0px;margin-top:0px;margin-bottom:10px}
.headbutonlar{display:none}
#mobmenu {position:absolute;top:0px;width:100%;background:#<?php echo $color2; ?>;    z-index: 100;}
#mobmenu ul{margin:0;margin-top:50px;padding:0}
#mobmenu ul li a{color:white}
#mobmenu ul li ul li a{padding-left:20px}
#mobmenu ul li{color:white;list-style-type:none}
#mobmenu ul .inner{overflow:hidden;display:none;float:left;width:100%}
#mobmenu ul .inner.show{}
#mobmenu ul li ul{margin-top:0px}
.mobmenu ul li ul li{padding-left:0}
#mobmenu ul li a.toggle{width:100%;display:block;background:#<?php echo $color2;?>;color:#fefefe;border-radius:0.15em;transition:background .3s ease}
#mobmenu ul li ul li a.toggle {padding-left:20px}
#mobmenu ul li ul li ul li a  {padding-left:35px}
#mobmenu ul li a.toggle:hover{background:rgba(0,0,0,0.18)}
#mobmenu ul a span{padding:0px 20px}
#mobmenu ul a{float:left;width:100%;padding:14px 0px;border-bottom:.1em solid #0000001a;color:#6c8193;font-size:15px}
#mobmenu .headbutonlar{float:none;display:inline-block;text-align:center;width:100%;margin-top:20px}
#mobmenu .headbutonlar a{float:left;margin-left:20px;font-size:13px}
#mobmenu #sepeticon{font-size:26px;float:right;color:#fff;margin-top:-7px;margin-right:27px}
#mobmenu .menuAc{top:50px}
.homedomainarea-con{width:93%}
.homedomainarea-con .padding30{padding:10px}
.homedomainarea h1{font-size:26px;margin-top:15px}
.homedomainarea input:not([type="submit"]){width:83%;padding:20px;font-size:18px}
.homedomainarea input[type="submit"]{width:110px;font-size:14px;padding:19px 0px;margin-left:-115px}
.spottlds{width:30%;border:none;text-align:center}
.spottlds img{float:none}
.homedomainarea h4{font-size:18px}
#home .pakettitle{margin-top:0px}
.tableslogan{font-size:18px}
.anascriptlist{margin-bottom:25px}
.musyorum{font-size:15px}
.istatistik h2{font-size:18px}
.istatistik h1{font-size:36px}
.ebulten{background-size:auto 100%}
.footer{padding:30px 0}
.footslogan h4{font-size:18px}
.footslogan h2{font-size:24px;margin-top:10px}
.footcopyright{text-align:center}
.fullwidthhead{text-align:center}
#mobmenu #megamenu{position:relative;padding:0px;margin-top:0px;background-size:auto}
#mobmenu #megamenuservice{width:44%}
#mobmenu #megamenuservice a{color:#<?php echo $color2;?>}
#mobmenu #megamenuservice .padding20{padding:5px}
#mobmenu #megamenu h4{color:#<?php echo $color2;?>}
#fullwidth #mobmenu{position:relative;float:left}
#fullwidth #mobmenu .headbutonlar{margin-top:0px}
#fullwidth #mobmenu .headbutonlar a{float:left;color:white;border-bottom:.1em solid #0000001a;font-size:13px;margin:0px;width:48%;padding:12px 0px;border-radius:0px}
#fullwidth #mobmenu #megamenuservice a{color:#ffffffd6}
#fullwidth #mobmenu .padding30{text-align:center;padding:20px 5px}
#fullwidth #mobmenu #megamenuservice .padding20{padding:10px 7px;display:inline-block}
#fullwidth #mobmenu .digerhmzinfo{float:none;padding: 15px;width:100%;position:relative;display:inline-block}
.anatanitim{background-size:auto;padding-bottom:60px;padding-top:50px}
.anatanitim .gonderbtn{float:left;margin-top:10px;font-size:16px;width:200px;margin-right:0px}
.anatanitim video{width:320%;background:#000}
.tanslogan{margin-top:30px;width:96%;margin-left:10px}
.tanslogan{margin-top:0px;width:100%;margin-left:0px;font-size:15px;position:relative}
#fullwidth .anatanitim #wrapper{width:90%}
.domainozellikler{background-size:auto 100%}
.domainsec .ui-accordion .ui-accordion-content{padding:15px 0px}
.domainsec select{width:98%}
#checkButton{border:0px;background-color:#8BC34A;border-radius:2.20588rem;color:#FFFFFF;margin-left:auto;padding:18px 0px;position:relative;margin-top:0px;margin-bottom:10px;display:inline-block;cursor:pointer;-webkit-transition:all 0.4s ease;-o-transition:all 0.4s ease;transition:all 0.4s ease;width:150px;font-size:16px}
#megamenu #kurumsalmenulinks{width:100%;margin-left:0px;margin-bottom:15px}
#corporatemenu{background-size:auto 100%}
.cd-top{height:40px;width:40px;bottom:20px;right:20px}
.tescilucretleri table tr td{padding:10px 0px;font-size:13px}
.tescilucretleri table tr th{padding:10px 0px;font-size:14px}
.tescilucretleri h4{margin-bottom:20px;font-size:20px}
.langandcur h4{font-size:19px}
.captcha-content{width:250px;transform:scale(0.8);margin-left:-20px}
.content-updown .tablepaket select{margin-bottom:15px;margin-left:auto;margin-right:auto;display:block}
.green-info .padding15{width:auto;padding:20px}
.blue-info .padding15{width:auto;padding:20px}
.red-info .padding15{width:auto;padding:20px}
.green-info .padding20{width:auto;padding:20px}
.blue-info .padding20{width:auto;padding:20px}
.red-info .padding20{width:auto;padding:20px}

}
/* #mobile-device-end */

/* #other-mobile-device{clear:both} */
@media only screen and (min-width:320px) and (max-width:374px) {
.slidetext-container{margin-top:65%}
}
@media only screen and (min-width:768px) and (max-width:1023px) {
.slidetext-container{margin-top:30%}
}
@media only screen and (min-width:568px) and (max-height:320px) {
.slidetext-container{margin-top:30%}
.slidetext-container h1{font-size:18px}
.slidetext-container p{width:100%;font-size:14px}
#largeredbtn{padding:5px 40px;font-size:14px}
}
@media only screen and (min-width:665px) and (max-width:759px) {
.cd-top{right:20px;bottom:20px}
.slidetext-container{width:90%;margin-top:30%}
.slidetext-container h1{font-size:22px}
.slidetext-container p{width:100%;font-size:16px}
#largeredbtn{padding:5px 40px;font-size:14px}
}
@media only screen and (min-width:320px) and (max-width:1023px) {
.mioslidertext{color:#fff;position:relative;left:0;width:100%;text-align:center}
}
@media only screen and (min-width:1024px) and (max-width:1248px) {
#wrapper{width:95%}
}
@media only screen and (min-width:665px) and (max-width:759px) {
.cd-top{right:20px;bottom:20px}
}
@media only screen and (min-width:950px) and (max-width:1156px) {
#fullwidth .menu li a{padding:0px 25px}
.menu li a{padding-left:18px;padding-right:18px}
}
@media only screen and (min-width:1023px) {
.cd-top{height:60px;width:60px;right:30px;bottom:30px;border-radius:7px}
}

/*  #Other-media-mobile-devices-end */