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

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function seo_creator(lang){
    var title,stitle,seo_title,seo_keywords,seo_description;
    title   = $("input[name='title["+lang+"]']").val();
    title   = $.trim(title);
    title   = title.replace( /\s\s+/g, ' ');
    stitle  = $("input[name='sub_title["+lang+"]']").val();
    stitle  = $.trim(stitle);
    stitle  = stitle.replace( /\s\s+/g, ' ');

    seo_title       = title;
    seo_keywords    = stitle;
    seo_description = stitle;
    if(seo_keywords != ''){
        seo_keywords = seo_keywords.split(" ");
        seo_keywords = seo_keywords.slice(0,19);
        seo_keywords = seo_keywords.join(",");
    }

    $("input[name='seo_title["+lang+"]']").val(seo_title);
    $("input[name='seo_keywords["+lang+"]']").val(seo_keywords);
    $("textarea[name='seo_description["+lang+"]']").val(seo_description);
}

function strip_tags(html){
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function convertToSlug(text){
    text = transliterate(text);
    return text.toString().toLowerCase()
        .replace(/\//g, '-')            // Replace slash
        .replace(/\.|,/g, '-')            // Replace point
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}
function read_image_file(input,preview_id){
    var defaultImage = $(input).data("default-image");
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+preview_id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }else{
        if(defaultImage != undefined)
            $('#'+preview_id).attr('src',defaultImage);
    }
}

function unset_GET(parameter,url) {
    url = url == null ? window.location.href : url;
    var urlparts= url.split('?');
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}

function _GET(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function set_GET(key,value,uri) {
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

Object.length2 = function(obj){
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

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
        possible += '![]{}()%&*$#^<>~@|';
    }
    var text = '';
    for(var i=0; i < size; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function MioAjaxElement(element,external_options){
    var button = $(element);
    if(button.attr("data-pending") != undefined) return false;

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

    var form,form_id;

    if(options.form != undefined) form = options.form;
    else form = options.form_id != undefined ? $("#"+options.form_id) : $(element).closest("form");

    form_id = form.attr("id");

    button.attr("data-pending","true");

    if(options != undefined && options.type == "direct"){

        if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
            var before_text  = button.html();
            button.html(options.waiting_text);
        }
        output = options.result;
        var wmethod = (options.method != undefined && options.method != '') ? options.method : "GET";
        var wdata   = (options.data != undefined && options.data != '') ? options.data : $(form).serialize();
        $.ajax({
            url:options.action != undefined ? options.action : form.attr("action"),
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

            button.removeAttr("data-pending");
            if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                button.html(before_text);
            }
        });

    }else{

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
                if(!document.getElementById(output)){
                    window[output](response);
                }
                else $("#"+output).html(response).fadeIn(200);
                button.removeAttr("data-pending");
                if(options != undefined && options.waiting_text != undefined && options.waiting_text != '') button.html(before_text);
            },
            error: function(res) {
                console.log("Error : "+res);
                button.removeAttr("data-pending");
                if(options != undefined && options.waiting_text != undefined && options.waiting_text != '') button.html(before_text);
            }
        }).submit();
    }
}

var ajax_output;
function MioAjax(options,returnResponse,getAjax){

    if(options.form != undefined){
        options.action = options.form.attr("action");
        options.method = options.form.attr("method");
        options.data   = options.form.serialize();
    }

    if(options.action !== undefined && options.action !== ''){
        var button,before_text;
        if(options.button_element !== undefined) button = $(options.button_element);

        if(button){
            if(button.attr("data-pending") != undefined) return {done:function(){}};

            button.attr("data-pending","true");
            if(options != undefined && options.waiting_text != undefined && options.waiting_text != ''){
                before_text  = button.html();
                button.html(options.waiting_text);
            }
        }

        $.ajaxSetup({ cache: false });
        var ajax = $.ajax({
            url:options.action,
            method:options.method != undefined && options.method != '' ? options.method : 'GET',
            data:options.data != undefined ? options.data : false,
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
                    if(options.output === undefined && options.result !== undefined) options.output = options.result;
                    var output = options.output !== undefined ? options.output : "ajax_response";
                    if(!document.getElementById(output)) window[output](result);
                    else $("#"+output).html(result).fadeIn(200);
                }
            },
            error: function(xhr, errorString, exception) {
                console.log("xhr.status="+xhr.status+" error="+errorString+" exception=|"+exception+"|");

                if(button && before_text){
                    button.removeAttr("data-pending");
                    button.html(before_text);
                }
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


function open_modal(modal_id,options){
    lastDropModal = modal_id;

    $("#"+modal_id).iziModal('destroy');
    $("#"+modal_id).iziModal(get_modal_options_generate(options));

    $("#"+modal_id).iziModal('open');
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


var requesting_now = false,current_bubble_count = 0,current_bubbles={};
function updateOnline(){
    if(requesting_now) return false;
    if(windowActive === "off") return false;

    requesting_now = true;
    current_bubble_count = localStorage.getItem("bubble_count");
    if(current_bubble_count === 'null' || current_bubble_count === null || current_bubble_count === '') current_bubble_count = 0;
    current_bubble_count = parseInt(current_bubble_count);
    var request = MioAjax({
        action:update_online_link,
        data:{
            operation: "update_online",
            title: document.title,
        },
        method:"POST",
    },true,true);
    request.done(function(response){
        response = getJson(response);
        requesting_now = false;
        var r_bubble_count = parseInt(response.bubble_count);

        if(r_bubble_count > 0 && r_bubble_count > current_bubble_count && response.sound === true)
            document.getElementById("notice_audio").play();

        localStorage.setItem("bubble_count",r_bubble_count);

        if(response.bubbles !== undefined && !$.compare(current_bubbles,response.bubbles)){
            current_bubbles = response.bubbles;
            $(response.bubbles).each(function(k,v){
                var _parse = v.split("|");
                var _k     = _parse[0];
                var _v     = parseInt(_parse[1]);
                $(".menu_"+_k+"_bubble").css("display",(_v > 0 ? 'inline-block' : 'none')).html(_v);
            });
        }

    });
}

function open_tab(evt, tabName,owner){
    var gtab,dtab,link,wrap_owner = "#tab-"+owner;
    $(wrap_owner+" > .tabcontent").css("display","none");
    $(wrap_owner+"> ul .tablinks").removeClass("active");
    $("#"+owner+"-"+tabName).css("display","block");
    $(evt).addClass("active");
    gtab     = _GET(owner);
    dtab     = $(evt).attr("data-tab");
    if((gtab == '' || gtab == null || gtab == undefined) && dtab == 1){
        // empty
    }else{
        link     = set_GET(owner,dtab);
    }
    var title = $("title").html();
    window.history.pushState("object or string",title,link);
}

function select2_iformat(element) {
    var originalOption = element.element;
    return $('<span>'+element.text+ '</span>');
}

function select2_sortable($select2){
    var ul = $select2.next('.select2-container').first('ul.select2-selection__rendered');
    ul.sortable({
        items       : 'li:not(.select2-search__field)',
        tolerance   : 'pointer',
        stop: function() {
            $($(ul).find('.select2-selection__choice').get().reverse()).each(function() {
                var id = $(this).data('data').id;
                console.log("ID: "+id);
                var option = $select2.find('option[value="' + id + '"]')[0];
                $select2.prepend(option);
            });


            /*$select2.on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);

                $element.detach();
                $(this).append($element);
                $(this).trigger("change");
            });*/

        }
    });
}

function isMobile(){
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4)))
    {
        return true;
    } else
    {
        return false;
    }
}

function isHTML(str) {
    var a = document.createElement('div');
    a.innerHTML = str;

    for (var c = a.childNodes, i = c.length; i--; ) {
        if (c[i].nodeType == 1) return true;
    }

    return false;
}

jQuery.extend({
    compare: function (arrayA, arrayB){
        return JSON.stringify(arrayA) === JSON.stringify(arrayB);
    }
});

function html_entity_decode(str){
    var txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}

function html_entities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
if(is_logged !== undefined && is_logged){
    var windowActive = "on";

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