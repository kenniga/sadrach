jQuery(document).ready(function($) {
	'use strict';

	handleCoverBgImage($);
	logoInTheMiddle($);
	handleBgColor($);
	setTransitionForCreativeTopItems($, 0);
	handleHmbMenu($);
	handleQuotes($);
	runMasonryGallery($);
	runMasonryBlog($)
	stickyMenu($);
	backToTop($);
	clickOnSearchIcon($);
	handleMobile($);
	handleVideoImageContainer($);
	handleAlbumImageContainer($);
	justifiedGallery($);
	ajaxVcCfResponsive($);
	runUnslider($);
	handleParallax($);
	handleGoToNextSection($);
	hanldeJsLinks($);
	setTimeout(function(){
		setContentHeight($);	
	}, 400);	


	$(window).scroll(function() {
         stickyMenu($);
    });

	$(window).on("debouncedresize", function(event) {
		runMasonryGallery($);
		runMasonryBlog($);
		handleVideoImageContainer($);
		handleAlbumImageContainer($);
		ajaxVcCfResponsive($);
		setTimeout(function(){
			setContentHeight($);	
		}, 400);
		
	});
});

function runMasonryGallery($) {
	if (!$('.lc_masonry_container').length) {
		return;
	}

	var $grid = $('.lc_masonry_container').imagesLoaded( function() {
		$grid.masonry({
			itemSelector: '.lc_masonry_brick',
			percentPosition: true,
			columnWidth: '.brick-size',
		}); 
	});
}

function runMasonryBlog($) {
	if (!$('.lc_blog_masonry_container').length) {
		return;
	}

	var $grid = $('.lc_blog_masonry_container').imagesLoaded( function() {
		var default_width = $('.blog-brick-size').width(); /*$('.lc_blog_masonry_brick').first().width();*/
		var default_height = 3/4 * default_width;
		var is_grid_layout = false;
		var no_portrait_allowed = false;
		var fixed_content_height_mobile = 1.6;

		if ($grid.hasClass("grid_container")) {
			is_grid_layout = true;
		}

		if ((2 * default_width - $grid.width()) > 1) {
			no_portrait_allowed = true;
		}

		$('.lc_blog_masonry_brick').each(function(){
			
				if ($(this).hasClass('has_thumbnail')) {
					
					var $image = $(this).find('img.lc_masonry_thumbnail_image');
					var img_src = $image.attr("src");

					var $cover_div = $(this).find(".brick_cover_bg_image");
					$cover_div.addClass("lc_cover_bg");
					$cover_div.css("background-image", "url("+img_src+")");
					
					var imageObj = new Image();
					imageObj.src = $image.attr("src");

					if (is_grid_layout || no_portrait_allowed) {
						$(this).css("width", default_width);
						$(this).css("height", default_height);
						if (default_width < 380) {
							$(this).css("height", fixed_content_height_mobile * default_height);
						}
					} else {
						if (imageObj.naturalWidth / imageObj.naturalHeight >= 1.6) {
							$(this).addClass("landscape_brick");
							$(this).css("width", 2*default_width);
							$(this).css("height", default_height);
						} else if (imageObj.naturalHeight / imageObj.naturalWidth >= 1.5) {
							$(this).addClass("portrait_brick");
							$(this).css("width", default_width);
							$(this).css("height", 2*default_height);
						} else {
							$(this).css("width", default_width);
							$(this).css("height", default_height);
						}
					}
				} else {
						$(this).css("width", default_width);
						$(this).css("height", default_height);
						if (default_width < 380) {
							$(this).css("height", fixed_content_height_mobile * default_height);
						}
				}
		});


		$grid.masonry({
			itemSelector: '.lc_blog_masonry_brick',
			percentPosition: true,
			columnWidth: '.blog-brick-size',
		});
		$grid.fadeTo("400", 1);
	});
}

function handleQuotes($) {
	$('blockquote').each(function(){
		$(this).prepend($('<i class="fa fa-quote-right" aria-hidden="true"></i>'));
	});
}

function handleCoverBgImage($) {
	$( ".lc_swp_background_image" ).each(function() {
		var imgSrc = $(this).data("bgimage");

		$(this).css("background-image", "url("+imgSrc+")");
		$(this).css("background-position", "center center");
		$(this).css("background-repeat", "no-repeat");
		$(this).css("background-size","cover");
	});		
}

function handleBgColor($) {
	$( ".lc_swp_overlay" ).each(function() {
		var bgColor = $(this).data("color");
		
		$(this).parent().css("position", "relative");
		
		$(this).css({
			"background-color" : bgColor,
			"position" : "absolute"
		});
	});

	$( ".lc_swp_bg_color" ).each(function() {
		var bgColor = $(this).data("color");
		$(this).css("background-color", bgColor)
	});
}

function handleHmbMenu($) {
	$( ".hmb_menu" ).hover(
		function() {
			$(this).find('.hmb_line').addClass('hover');
		}, function() {
			$(this).find('.hmb_line').removeClass('hover');
		}
	);

	$('.hmb_menu').click(function() {
		$(this).find('.hmb_line').toggleClass('click');

		if ($(this).hasClass('hmb_creative')) {
			$('.nav_creative_container').toggleClass('visible_container');

			var resetValues = $('.nav_creative_container .creative_menu ul.menu > li').hasClass('menu_item_visible') ? 1 : 0;
			setTransitionForCreativeTopItems($, resetValues);
			$('.nav_creative_container .creative_menu ul.menu > li').toggleClass('menu_item_visible');
		}

		if ($(this).hasClass('hmb_mobile')) {
				if ($('header').hasClass('sticky_enabled')) {
					$("body").animate({ scrollTop: 0 }, 400, function(){
							showMobileMenuContainer($);
					});
				} else {
					showMobileMenuContainer($);
				}
			}		
		});
}

var setTransitionForCreativeTopItems = function($, resetValues) {
	if (!$(".nav_creative_container").length) {
		return;
	}

	if (resetValues == 1) {
		$('.nav_creative_container .creative_menu ul.menu > li').each(function(){
			$(this).css({
				"-webkit-transition-delay"	: "0s",
				"-moz-transition-delay"		: "0s",
				"transition-delay"			: "0s"
			});
		})

		return;
	}

	var start_delay = 2;
	var elt_duration = "";
	$('.nav_creative_container .creative_menu ul.menu > li').each(function(){
		start_delay += 1;
		if (start_delay < 10) {
			elt_duration = "0."+start_delay+"s";
		} else {
			elt_duration = start_delay/10+"s";
		}

		$(this).css({
			"-webkit-transition-delay"	: elt_duration,
			"-moz-transition-delay"		: elt_duration,
			"transition-delay"			: elt_duration
		});
	});
}

var showMobileMenuContainer = function($) {
	$('.mobile_navigation_container').toggle();
	$('.mobile_navigation_container').toggleClass('mobile_menu_opened');	
}

function setContentHeight($) {
	if (!$('#lc_swp_content').length) {
		return;
	}
	$('#lc_swp_content').css("min-height", "");

	var totalHeight = $('#lc_swp_wrapper').height();
	if ($('#heading_area').length > 0) {
		totalHeight -= $('#heading_area').height();
	}
	if ($('#footer_sidebars').length) {
		totalHeight -= $('#footer_sidebars').height();
	}

	if ($('.lc_copy_area ').length) {
		totalHeight -= $('.lc_copy_area').height();
	}

	var minContentHeight = $('#lc_swp_content').data("minheight");
	if ($('#lc_swp_content').length) {
		if (totalHeight > minContentHeight) {
			$('#lc_swp_content').css('min-height', totalHeight);
		}
	}

	if ($('.lc_copy_area').length) {
		$('.lc_copy_area').css("opacity", "1");
	}
}

function stickyMenu($) {
	if (!$('header').hasClass('lc_sticky_menu')) {
		return;
	}
	if ($('.mobile_navigation_container').hasClass('mobile_menu_opened')) {
		return;
	}

	var triggerSticky = 100;
	if ($(window).scrollTop() > triggerSticky) {
		enableSticky($);
	} else {
		disableSticky($);
	}
}

var enableSticky = function($) {
	if ($('header').hasClass('sticky_enabled')) {
		return;
	}

	$('header').css("visibility", "hidden")
	$('header').addClass('sticky_enabled');
	$('header').css("visibility", "visible");
}

var disableSticky = function($) {
	var element = $('header');
	if ($(element).hasClass('sticky_enabled')) {
			$(element).removeClass('sticky_enabled');

			if(0 == $(element).attr("class").length) {
				$(element).removeAttr("class");
			}
	}
}

var backToTop = function($) {
	if (!$('.lc_back_to_top_btn').length) {
		return;
	}

	var backToTopEl = $('.lc_back_to_top_btn');
	$(backToTopEl).click(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});

	$(window).scroll(function() {
		if ($(window).scrollTop() < 200) {
			$(backToTopEl).hide();
		} else {
			$(backToTopEl).show('slow');
		}
	});	
}


var clickOnSearchIcon = function($) {
	$('.trigger_global_search').click(function(){
		$('#lc_global_search').show();
	});

	$('.close_search_form').click(function(){
		$('#lc_global_search').hide();
	});

	$(document).keyup(function(e) {
		/* escape key maps to keycode `27`*/
	    if (e.keyCode == 27) { 
			$('#lc_global_search').hide();
	    }
	});	
}

var handleMobile = function($) {
	$('nav.mobile_navigation').find('ul li.menu-item-has-children > a').click(function(event){
		event.preventDefault();
		$(this).parent().find('> ul').toggle('300');
	});
}

var handleVideoImageContainer = function($) {
	if (!$('.video_image_container').length) {
		return;
	}

	$('.video_image_container').each(function() {
		var no_px_width = parseFloat($(this).css('width'));
		$(this).css("height", no_px_width * 9/16);
		$(this).parent().parent().css("opacity", 1);
	});
}

var handleAlbumImageContainer = function($) {
	if (!$('.album_image_container').length) {
		return;
	}

	$('.album_image_container').each(function() {
		var no_px_width = parseFloat($(this).css('width'));
		$(this).css("height", no_px_width);
		$(this).parent().parent().css("opacity", 1);
	});	
}

var justifiedGallery = function($) {
	if (!$('.lc_swp_justified_gallery').length) {
		return;
	}

	$(".lc_swp_justified_gallery").each(function() {
		var rowHeight = $(this).data("rheight");
		if (!$.isNumeric(rowHeight)) {
			rowHeight = 180;
		}

		$(this).justifiedGallery({
			rowHeight: rowHeight,
			lastRow: 'justify',
			margins: 0,
			captions: false,
			imagesAnimationDuration: 400
		});

		$(this).find("img").fadeTo("600", 0.6);
		$(this).parent().find('.view_more_justified_gallery').fadeTo("400", 1);
	});

	setTimeout(function(){
		$('.img_box').find("img").addClass("transition4");
	}, 600);

}

var ajaxVcCfResponsive = function($) {
	if (!$(".vc_lc_contactform").length) {
		return;
	}

	var containerWidth = $(".vc_lc_contactform").width();
	if (containerWidth <= 768) {
		$(".vc_lc_contactform").find(".vc_lc_element").removeClass("three_on_row");
	} else {
		$(".vc_lc_contactform").find(".three_on_row_layout").addClass("three_on_row");
	}
}

var runUnslider = function($) {
	$('.lc_reviews_slider').unslider({
		arrows: {
			prev: '<a class="unslider-arrow prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>',
			next: '<a class="unslider-arrow next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>',
		},
		autoplay: false,
		delay: 4000,
		speed: 400
	});
}

var handleParallax = function($) {
	$( ".lc_swp_parallax" ).each(function() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$(this).addClass("ai_swp_no_scroll");
		} else {
			$(this).css("background-position", "50% 0");
			var $parallaxObject = $(this);
			
			$(window).scroll(function() {
				var yPos = -($(window).scrollTop() / $parallaxObject.data("pspeed")); 
				var newCoord = '50% '+ yPos + 'px';
				
				$parallaxObject.css("background-position", newCoord);
			});
		}
	});	
}

var  handleGoToNextSection = function($) {
	if (!$('.goto_next_section').length) {
		return;
	}

	var animateIcon = function(targetElement, speed){
	    $(targetElement).css({'padding-top':'0px'});
	    $(targetElement).css({'opacity':'1'});
	    $(targetElement).animate(
	        {
	        	'padding-top'	: "25px",
	        	"opacity"		: "0"
	    	},
	        {
	        duration: speed,
	        complete: function(){
	            animateIcon($('.goto_next_section i'), speed);
	            }
	        }
	    );
	};
	setTimeout(function(){
		animateIcon($('.goto_next_section i'), 2000);
	}, 3000);
	
	$('.goto_next_section').click(function(){
		var $nextRow = $(this).parents('.vc_row').next();
		if($nextRow.length) {
			$('html, body').animate({
        		scrollTop: $nextRow.offset().top
    		}, 1200);
		}
	});

}

var hanldeJsLinks = function($) {
	if (!$('.lc_js_link').length) {
		return;
	}

	$('.lc_js_link').click(function(event) {
		event.preventDefault();
		var newLocation = $(this).data("href");
		var newWin = '';
		if ($(this).data("target")) {
			newWin = '_blank';
		}
		window.open(newLocation, newWin);
	});
}

var logoInTheMiddle = function($) {
	if (!$('.centered_menu').length) {
		return;
	}

	var middleMenuPosition = Math.ceil($(".header_inner.centered_menu ul.menu > li").length / 2);
	$(".header_inner.centered_menu ul.menu > li:nth-child(" + middleMenuPosition + ")").after('<li class="logo_menu_item"></li>');	
	$('#logo').detach().appendTo('li.logo_menu_item');
	$('#logo').css("opacity", "1");
	$(".header_inner.centered_menu").animate({ opacity: 1 }, "slow");
}