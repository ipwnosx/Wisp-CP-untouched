function ckplcySetCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function ckplcyGetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function ckplcyCheckCookie() {
    var ckplcy_cookie_popup_visited=ckplcyGetCookie("cookie_pop_visited");
    if (ckplcy_cookie_popup_visited === ''){
        setTimeout(function () {

            $("body").append(ckplcy_cookie_popup_html);

            var close   = document.getElementsByClassName('mio-cookie-popup__c-p-close')[0];
            var card    = document.getElementsByClassName('mio-cookie-popup__c-p-card')[0];
            var button  = document.getElementsByClassName('mio-cookie-popup__c-p-button')[0];


            card.classList.add('mio-cookie-popup--opened');
            card.classList.remove('mio-cookie-popup--closed');
            card.addEventListener('click', function (e) {
                if (e.target === close | e.target === button) {
                    card.classList.remove('mio-cookie-popup--opened');
                    card.classList.add('mio-cookie-popup--closed');
                    ckplcySetCookie("cookie_pop_visited", true, 365);
                    $("#mio-cookie-popup").remove();
                }
            });
        }, 1000);
    }
};

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function open_tab(evt, tabName,owner){
    var gtab,dtab,link,wrap_owner = "#tab-"+owner;
    $(wrap_owner+" > .tabcontent").css("display","none");
    $(wrap_owner+"> ul .tablinks").removeClass("active");
    $("#"+owner+"-"+tabName).css("display","block");
    $(evt).addClass("active");
    gtab     = gGET(owner);
    dtab     = $(evt).attr("data-tab");
    if((gtab == '' || gtab == null || gtab == undefined) && dtab == 1){
        // empty
    }else{
        link     = sGET(owner,dtab);
    }
    var title = $("title").html();
    window.history.pushState("object or string",title,link);
}

function gGET(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function sGET(key,value,uri) {
    if (!uri) uri = window.location.href;
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

function strip_tags(html){
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

function getJson(str) {
    var parse;
    try {
        parse = JSON.parse(str);
    } catch (e) {
        return false;
    }
    return parse;
}

function json_decode(str){
    return getJson(str);
}

function json_encode(obj){
    return JSON.stringify(obj);
}

function in_array(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

String.prototype.rtrim = function(s) {
    return this.replace(new RegExp(s + "*$"),'');
};

function checkStrength(password) {
    var strength = 0
    if (password.length < 6) return 'weak';
    if (password.length > 7) strength += 1;
// If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
// If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1;
// If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;
// If it has two special characters, increase strength value.
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;
// Calculated strength value, we can return messages
// If value is less than 2
    if (strength < 2)
        return 'weak';
    else if (strength == 2)
        return 'good';
    else
        return 'strong';
}

// Generate a password string
function randString(options){

    if(typeof options == "object" && options.characters != undefined && options.characters != '') var characters = options.characters;
    else var characters = "A-Z,a-z,0-9";
    if(typeof options == "object" && options.size != undefined && options.size != '') var size = options.size;
    else var size = 16;

    var dataSet = characters.split(',');
    var possible = '';
    if($.inArray('a-z', dataSet) >= 0){
        possible += 'abcdefghijklmnopqrstuvwxyz';
    }
    if($.inArray('A-Z', dataSet) >= 0){
        possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if($.inArray('0-9', dataSet) >= 0){
        possible += '0123456789';
    }
    if($.inArray('#', dataSet) >= 0){
        possible += '!@#$%^&*?_~';
    }
    var text = '';
    for(var i=0; i < size; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function MioAjaxElement(element,external_options){
    var button = $(element);
    if(button.attr("data-pending") != undefined) {
        console.log("Please your wait... Button pending");
    }else{
        var output,option,options;

        if(external_options){
            options = external_options;
        }else{
            option = button.attr("mio-ajax-options");
            options = getJson(option);
        }

        if(options != undefined && options.before_function != undefined){
            var beforeCall = window[options.before_function]();
            if(!beforeCall) return false;
        }

        if(options != undefined && options.type == "direct"){
            button.attr("data-pending","true");

            if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                var before_text  = button.html();
                button.html(options.waiting_text);
            }
            output = options.result;
            var wmethod = (options.method != undefined && options.method != '') ? options.method : "GET";
            var wdata   = (options.data != undefined && options.data != '') ? options.data : false;
            $.ajax({
                url:options.action,
                method:wmethod,
                data:wdata,
            }).done(function (result) {
                button.removeAttr("data-pending");
                if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                    button.html(before_text);
                }

                if(!document.getElementById(output)){
                    window[output](result);
                }else{
                    $("#"+output).html(result);
                    $("#"+output).fadeIn(400);
                }
            }).fail(function() {
                console.log("Failed Request! URL Address: "+options.action);
            });

        }else{

            button.attr("data-pending","true");

            var form = options.form != undefined ? options.form : $(element).closest("form");
            var form_id = form.attr("id");

            if(options != undefined && options.result != undefined) output = options.result;
            else output = "mio_success";

            var file_upload = false;

            $("#"+form_id+" input:file").each(function (key, item) {
                var val = $(item).val();
                if(val != undefined && val != ''){
                    file_upload = true;
                }
            });


            var before_text  = button.html();
            var replace_button_text = false;

            if(options != undefined && options.progress_text != undefined && options.progress_text != ''){
                var progress_text = options.progress_text;
                progress_text = progress_text.replace('{progress}','<span id="percent">0%</span>');
            }

            if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                var waiting_text = options.waiting_text;
            }

            if(waiting_text != undefined && waiting_text != '')
                replace_button_text = waiting_text;

            if(file_upload && progress_text != undefined && progress_text != '')
                replace_button_text = progress_text;


            if(replace_button_text != undefined && replace_button_text && replace_button_text != '')
                button.html(replace_button_text);


            if(file_upload){
                var bar = $("#"+form_id+" #bar");
                var percent = $("#"+form_id+" #percent");
            }

            $(form).ajaxForm({
                beforeSend: function() {
                    if(file_upload){
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    }
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    if(file_upload){
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        if(percentComplete == 100)
                            button.html(waiting_text);
                    }
                },
                success:function(response){
                    if(!document.getElementById(output)) window[output](response);
                    else $("#"+output).html(response).fadeIn(200);
                    button.removeAttr("data-pending");
                    if(options != undefined && options.waiting_text != undefined && options.waiting_text != '') button.html(before_text);
                }
            }).submit();
        }
    }
}

var ajax_output;
function MioAjax(options,returnResponse,getAjax){
    if(options.action != undefined && options.action != ''){
        var button,before_text;
        if(options.button_element != undefined) button = $(options.button_element);

        if(button){
            if(button.attr("data-pending") != undefined) return {done:function(){}};

            button.attr("data-pending","true");
            if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                before_text  = button.html();
                button.html(options.waiting_text);
            }
        }

        $.ajaxSetup({ cache: false });
        var form_data = options.form != undefined ? options.form.serialize() : false;
        var get_data = options.data != undefined ? options.data : form_data;
        var ajax = $.ajax({
            url:options.action,
            method:options.method != undefined && options.method != '' ? options.method : 'GET',
            data:get_data,
            cache:false,
            async:getAjax ? true : false,
            success:function (result){

                if(button && before_text){
                    button.removeAttr("data-pending");
                    button.html(before_text);
                }

                if(returnResponse){
                    ajax_output = result;
                }
                else{
                    var output = options.output != undefined ? options.output : "ajax_response";
                    if(!document.getElementById(output)) window[output](result);
                    else $("#"+output).html(result).fadeIn(200);
                }
            },
            error: function(xhr, errorString, exception) {
                console.log("xhr.status="+xhr.status+" error="+errorString+" exception=|"+exception+"|");
            }
        });

    }
    if(getAjax){
        return ajax;
    }else if(returnResponse){
        return ajax_output;
    }
    else return false;
}


$(document).ready(function(){
    $(".mio-ajax-submit").click(function(){
        MioAjaxElement(this);
    });

    // Auto Select Pass On Focus
    $('input[rel="aselect"]').on("click", function () {
        $(this).select();
    });

});

function transliterate(s){
    s = String(s);

    var char_map = {
        // Latin
        'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
        'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
        'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
        'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
        'ß': 'ss',
        'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
        'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
        'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
        'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
        'ÿ': 'y',

        // Latin symbols
        '©': '(c)',

        // Greek
        'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
        'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
        'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
        'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
        'Ϋ': 'Y',
        'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
        'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
        'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
        'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
        'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

        // Turkish
        'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
        'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',

        // Russian
        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
        'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
        'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
        'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
        'Я': 'Ya',
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
        'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
        'я': 'ya',

        // Ukrainian
        'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
        'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

        // Czech
        'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
        'Ž': 'Z',
        'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
        'ž': 'z',

        // Polish
        'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
        'Ż': 'Z',
        'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
        'ż': 'z',

        // Latvian
        'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
        'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
        'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
        'š': 's', 'ū': 'u', 'ž': 'z'
    };

    // Transliterate characters to ASCII
    for (var k in char_map) {
        s = s.replace(RegExp(k, 'g'), char_map[k]);
    }
    
    return s;
}
var lastDropModal;

function alert_error(title,options){

    if(lastDropModal != '' && $("#"+lastDropModal).css("display")=="block"){
        swal({
            type:"error",
            title:warning_modal_title,
            text:title,
            timer: options.timer != undefined ? options.timer : false,
        });

        return false;
    }

    if(document.getElementById("modal-alert")) $("#modal-alert").remove();
    $("body").append('<div id="modal-alert" class="iziModal"></div>');

    var subtitle;
    if(title.length>80){
        subtitle    = title;
        title       = warning_modal_title;
    }
    $("#modal-alert").iziModal('destroy');
    $("#modal-alert").iziModal({
        overlay:false,
        title: title,
        subtitle:subtitle,
        icon: 'fa fa-ban',
        headerColor: '#CC0000',
        width: 600,
        timeout: typeof options == "object" && options.timer != undefined ? options.timer : false,
        timeoutProgressbar: typeof options == "object" && options.timer != undefined ? true : false,
        transitionIn: 'fadeInDown',
        transitionOut: 'fadeOutDown',
        loop: true,
        pauseOnHover: true,
        history:false,
        onResize: function(){
            return false;
        },
    });
    $("#modal-alert").iziModal('open');
}

function alert_success(title,options){

    if(lastDropModal != '') close_modal(lastDropModal);

    if(document.getElementById("modal-alert")) $("#modal-alert").remove();
    $("body").append('<div id="modal-alert" class="iziModal"></div>');

    var subtitle;
    if(title.length>80){
        subtitle    = title;
        title       = success_modal_title;
    }

    $("#modal-alert").iziModal('destroy');
    $("#modal-alert").iziModal({
        overlay:false,
        title: title,
        subtitle:subtitle,
        icon: 'fa fa-check',
        headerColor: '#50B800',
        width: 600,
        timeout: typeof options == "object" && options.timer != undefined ? options.timer : false,
        timeoutProgressbar: typeof options == "object" && options.timer != undefined ? true : false,
        transitionIn: 'fadeInDown',
        transitionOut: 'fadeOutDown',
        loop: true,
        pauseOnHover: true,
        history:false,
    });
    $("#modal-alert").iziModal('open');
}

function close_modal(modal_id,modal_class){
    if(modal_id != '') $("#"+modal_id).iziModal('close');
    if(modal_class != '') $("."+modal_class).iziModal('close');
}

function get_modal_options_generate(options){
    if(!options || typeof options != "object") options = {};
    var modal_options   = {
        transitionIn: 'fadeInDown',
        transitionOut: 'fadeOutDown',
        bodyOverflow: true,
        history:false,
        appendTo:false,
    };
    return $.extend( options, modal_options);
}

function open_modal(modal_id,options){
    lastDropModal = modal_id;

    $("#"+modal_id).iziModal('destroy');
    $("#"+modal_id).iziModal(get_modal_options_generate(options));

    $("#"+modal_id).iziModal('open');
}






jQuery(document).ready(function($){
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.cd-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

});

if(typeof(is_logged) == "undefined") var is_logged = false;
if(is_logged !== undefined && is_logged && update_online_link !== undefined){
    var windowActive = "on",requesting_now=false;
    function updateOnline(){
        if(requesting_now) return false;
        if(windowActive === "off") return false;

        requesting_now = true;

        var request = MioAjax({
            action:update_online_link,
            data:{
                operation: "update_online",
                title: document.title,
            },
            method:"POST",
        },true,true);
        request.done(function(response){
            requesting_now = false;
        });
    }
    setInterval(updateOnline,10000);
    setTimeout(updateOnline,2000);
    document.addEventListener('visibilitychange',function(){
        if (document.visibilityState == "hidden"){
            windowActive = "off";
        } else {
            windowActive = "on";
        }
    }, false);

    var interval_id;
    $(window).focus(function() {
        if (!interval_id)
            interval_id = setInterval(function(){
                windowActive = "on";
            }, 1000);
    });

    $(window).blur(function() {
        clearInterval(interval_id);
        windowActive = "off";
    });

    $(document).mousemove(function(){
        if(windowActive == 'off')
        {
            windowActive = "on";
            if(!interval_id)
            interval_id = setInterval(function(){
                windowActive = "on";
            }, 1000);

        }
    });
}

(function( $ ){

    $.fn.extend({
        credit: function ( args ) {

            $(this).each(function (){


                // Set defaults
                var defaults = {
                    auto_select:true
                }

                // Init user arguments
                var args = $.extend(defaults,args);

                // global var for the orginal input
                var credit_org = $(this);

                // Hide input if css was not set
                credit_org.css("display","none");

                // Create credit control holder
                var credit_control = $('<div></div>',{
                    class: "credit-input"
                });

                // Add credit cell inputs to the holder
                for ( i = 0; i < 4; i++ ) {
                    credit_control.append(
                        $("<input />",{
                            class: "credit-cell",
                            placeholder: "0000",
                            maxlength: 4
                        })
                    );
                }

                // Print the full credit input
                credit_org.after( credit_control );

                // Global var for credit cells
                var cells = credit_control.children(".credit-cell");

                /**
                 * Set key press event for all credit inputs
                 * this function will allow only to numbers to be inserted.
                 * @access public
                 * @return {bool} check if user input is only numbers
                 */
                cells.keypress(function ( event ) {
                    // Check if key code is a number
                    if ( event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57) ) {
                        // Key code is a number, the `keydown` event will fire next
                        return false;
                    }
                    // Key code is not a number return false, the `keydown` event will not fire
                    return true;
                });

                /**
                 * Set key down event for all credit inputs
                 * @access public
                 * @return {void}
                 */
                cells.keydown(function ( event ) {
                    // Check if key is backspace
                    var backspace = ( event.keyCode == 8 );
                    // Switch credit text length
                    switch( $(this).val().length ) {
                        case 4:
                            // If key is backspace do nothing
                            if ( backspace ) {
                                return;
                            }
                            // Select next credit element
                            var n = $(this).next(".credit-cell");
                            // If found
                            if (n.length) {
                                // Focus on it
                                n.focus();
                            }
                            break;
                        case 0:
                            // Check if key down is backspace
                            if ( !backspace ) {
                                // Key is not backspace, do nothing.
                                return;
                            }
                            // Select previous credit element
                            var n = $(this).prev(".credit-cell");
                            // If found
                            if (n.length) {
                                // Focus on it
                                n.focus();
                            }
                            break;
                    }
                });

                // On cells focus
                cells.focus( function() {
                    // Add focus class
                    credit_control.addClass('c-focus');
                });

                // On focus out
                cells.blur( function() {
                    // Remove focus class
                    credit_control.removeClass('c-focus');
                });

                /**
                 * Update orginal input value to the credit card number
                 * @access public
                 * @return {void}
                 */
                cells.keyup(function (){
                    // Init card number var
                    var card_number = '';
                    // For each of the credit card cells
                    cells.each(function (){
                        // Add current cell value
                        card_number = card_number + $(this).val();
                    });
                    // Set orginal input value
                    credit_org.val( card_number );
                });


                if ( args["auto_select"] === true ) {
                    // Focus on the first credit cell input
                    credit_control.children(".credit-cell:first").focus();
                }

            });

        }
    });

})(jQuery);