<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><a id="facepaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical_link);?>&display=popup&ref=plugin&src=share_button"><i class="fa fa-facebook" aria-hidden="true"></i></a>

<a id="twitpaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($canonical_link);?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

<a id="googlepaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode($canonical_link);?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

<a id="linkedpaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($canonical_link);?>&title=&summary=&source="><i class="fa fa-linkedin" aria-hidden="true"></i></a>

<script language="javascript" type="text/javascript">
    var win=null;
    function NewWindow(mypage,myname,w,h,scroll,pos){
        if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
        if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
        else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
        settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
        win=window.open(mypage,myname,settings);}
</script>