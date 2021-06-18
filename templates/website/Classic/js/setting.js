

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

    $('#foo5).carouFredSel({
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

		



    jQuery(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 10,
            time: 3000
        });
    });