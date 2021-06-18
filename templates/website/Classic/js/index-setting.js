$(function() {

				 $('#foo2').carouFredSel({
					auto: true,
					pagination: "#pager2",
                    prev: '#prev2',
					next: '#next2',
					mousewheel: false,
					scroll : {
					fx : "fade",
					items: 1,
					easing : "linear",
					pauseOnHover : true,
					duration : 1000
					}
				});
				
				 $('#foo3').carouFredSel({
					auto: true,
					pagination: "#pager3",
                    prev: '#prev3',
					next: '#next3',
					mousewheel: false,
					scroll : {
					fx : "scroll",
					items: 1,
					easing : "quadratic",
					pauseOnHover : true,
					duration : 1000
					}
				});
				
				$('#foo4').carouFredSel({
					auto: true,
					pagination: "#pager4",
                    prev: '#prev3',
					next: '#next3',
					mousewheel: false,
					scroll : {
					fx : "scroll",
					items: 1,
					easing : "quadratic",
					pauseOnHover : true,
					duration : 1000
					}
				});

    $('#foo5').carouFredSel({
        auto: true,
        pagination: "#pager5",
        prev: '#prev5',
        next: '#next5',
        mousewheel: false,
        scroll : {
            fx : "scroll",
            items: 1,
            easing : "quadratic",
            pauseOnHover : true,
            duration : 1000
        }
    });

			});

    $(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 10,
            time: 3000
        });

        // Tabs Plugins
        var tab_active_id = "paketaktifbtn";
        $(".products_list").each(function(){
            var wrap = $(this);
            $(".miotab-labels a:first",wrap).attr("id",tab_active_id);
            $(".miotab-contents .miotab-content:first",wrap).css("display","block");
            var tab_first = $(".miotab-labels a:first",wrap);
            var bg_image  = tab_first.attr("data-background-image");
            var def_bg_image  = wrap.attr("data-background-image");
            if(bg_image != undefined && bg_image != ''){
                wrap.css("background","url("+bg_image+")");
            }else{
                if(def_bg_image != undefined && def_bg_image != ''){
                    wrap.css("background","url("+def_bg_image+")");
                }
			}

            $(".miotab-labels a",wrap).click(function(){
            	var target = $(this).attr("data-target");
                var active_content = $(".miotab-contents .miotab-content#"+target,wrap);
                if(active_content.length !=0){
                    var index = $(this).index();
                    $(".miotab-labels a",wrap).removeAttr("id");
                    $(this).attr("id",tab_active_id);

                    var display = active_content.css("display");
                    if(display == undefined || display == 'none'){
                        var background = $(this).attr("data-background-image");
                        if(background != '' && background != undefined) $(wrap).css("background-image","url("+background+")");
                        $(".miotab-contents .miotab-content",wrap).css("display","none");
                        active_content.css("display","block");
                    }

                }
            });
		});


    });