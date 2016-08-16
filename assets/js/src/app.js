'use strict';

var viewportWidth = 0;

var mobileCheck = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (mobileCheck.Android() || mobileCheck.BlackBerry() || mobileCheck.iOS() || mobileCheck.Opera() || mobileCheck.Windows());
    }
};

var isMobile = (mobileCheck.any()) ? true : false;

function showHeaderNested($this) {
	if(isMobile || viewportWidth <= 670) {
		if($($this).parent().find('.header-nested').css('display') !== 'block') {
			$($this).parent().find('.header-nested').css('display','block');
			$($this).addClass('expanded');
		} else {
			$($this).parent().find('.header-nested').css('display','none');
			$($this).removeClass('expanded');
		}
	}
}

$(window).resize(function() {
	viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	$('.mega-menu').removeClass('active');
	$('.mega-menu-pip').css('display', 'none');
	$('.feature a.button').removeClass('active');
	$('.dropdown').slideUp('fast');
});

if(isMobile) {
	var lastScrollTop = 0;
	var countUp, countDown;
	$(window).on('scroll', function() {
	    var st = $(this).scrollTop();
	    var $header = $('header');

	    //set intial sticky waiting
	    if(st > 80) {
	    	$header.addClass('waiting');

		    if(st < lastScrollTop) { //scrolling up
		        //console.log('up '+countUp);
		        countDown = 0;
		        countUp++;
		        if(countUp > 10) {
		        	$header.addClass('sticky');
		        	$header.removeClass('unsticky');
		        }
		    }
		    else { //scrolling down
		        // console.log('down '+countDown);
		        countUp = 0;
		        countDown++;
		        if(countDown > 10) {
		        	if($header.hasClass('sticky')) {
		        		$header.addClass('unsticky');
		        		$header.removeClass('sticky');
		        	}
		        }
		    }
	    } 

	    if(st === 0) {
	    	$header.removeClass('waiting');
	    	$header.removeClass('sticky');
	    	$header.removeClass('unsticky');
	    }
	    lastScrollTop = st;
	});
}

$(document).ready(function() {

	viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

	/********************************************************/
	/* dropdown menus
	/********************************************************/
	var $body, $navItem, $dropdown, $navID, $navCall, $subnav;

	$body = $('body');
	$navItem = $('nav.main ul li a');
	$dropdown = $('.dropdown');

	$navItem.mouseover(function() {
		if(!isMobile && viewportWidth > 670) {

			$('.mega-menu').removeClass('active');
			$('.feature a.button').removeClass('active');
			$('.mega-menu-pip').css('display', 'none');

			$navID = $(this).attr('rel');
			$subnav = $('#subnav'+$navID).html();
			$dropdown.html($subnav);
			$dropdown.slideDown('fast');
		}
	});

	$dropdown.mouseleave(function() {
		$dropdown.delay().slideUp('fast');
	});


	/********************************************************/
	/* mega menus
	/********************************************************/
	var $featureButton, $megaMenu, $megaMenuPip;

	$featureButton = $('.feature a.button');
	$megaMenu = $('.mega-menu');
	$megaMenuPip = $('.mega-menu-pip');

	$featureButton.mouseover(function() {
		if(viewportWidth > 1024) {
			$dropdown.slideUp('fast');

			$featureButton.removeClass('active');
			var $loc = $(this).position();
			var $locParent = $(this).parent().position();
			var $style = $(this).attr('class');
			$navID = $(this).attr('rel');
			$subnav = $('#subnav'+$navID).html();
			// $megaMenu.html($subnav+'<span class="pip"></span>');
			$megaMenu.html($subnav);

			var $totalWidth = 0;
			$('.mega-menu ul').each(function() {  
				$totalWidth += parseInt($(this).width() + 60);
			});
			$megaMenu.css('top', $loc.top+40);
			//ensure menu does not hang off edge
			var $leftPos = $loc.left+$locParent.left+31;
			var $docLeft = parseInt($('.body').css('margin-left'));
			var $docRight = $docLeft + parseInt($('.body').css('width'));

			if($leftPos < parseInt($totalWidth) / 2) { //overhang left
				$leftPos = parseInt($totalWidth) / 2;
			} else if(($docLeft + $leftPos + ($totalWidth/2)) > $docRight) { //overhang right
				$leftPos -= ($docLeft + $leftPos + ($totalWidth/2)) - $docRight;
				if(viewportWidth < 1260) {
					$leftPos -= 40;
				}
			}
			$megaMenu.css('left', $leftPos);
			$megaMenu.removeClass('sectionRed sectionOrange sectionGreen sectionBlue sectionPurple');
			$megaMenu.addClass($style);
			$megaMenu.css('width', $totalWidth);
			$megaMenu.addClass('active');

			// $megaMenuPip.css('left',$loc.left + (($locParent.right-$locParent.left)/2));
			$megaMenuPip.css('left',$loc.left+$locParent.left+25).css('top', $loc.top+36).css('display','block');

			$(this).addClass('active');	
		}	
	});

	$megaMenu.mouseleave(function() {
		$featureButton.removeClass('active');
		$megaMenu.removeClass('active');
		$megaMenuPip.css('display', 'none');
	});

	/********************************************************/
	/* mobile
	/********************************************************/

	var $mobileToggle = $('.mobile-nav');
	var $header = $('header');
	$mobileToggle.click(function() {
		if($header.hasClass('mobilenav')) {
			$header.removeClass('mobilenav');
			$mobileToggle.html('j');
		} else {
			$header.addClass('mobilenav');
			$mobileToggle.html('d');
		}
	});

	var $featureMobile = $('.feature');

	$featureMobile.click(function() {
		if(isMobile || viewportWidth <= 670) {
			window.location = $(this).attr('rel');
		}
	});


	//Mobile subnav
	var $nestedNav = $('nav.main li.nested a');
	$nestedNav.click(function(e) {
		if(isMobile || viewportWidth <= 670) {
			e.preventDefault();
			if(!$(this).parent().hasClass('expanded')) {
				$navID = $(this).attr('rel');
				$subnav = $('#subnav'+$navID).html();
				$(this).parent().append($subnav).addClass('expanded');
			} else {
				$(this).parent().find('.body').remove();
				$(this).parent().removeClass('expanded');
			}
		}
	});

	/********************************************************/
	/* people
	/********************************************************/
	var $content, $id, $text, $name, $title, $image, $counterNext, $counterPrev;
	var $people = $('.person');
	var $overlay = $('.overlay');
	var $overlayImage = $('.overlay-image');
	var $overlayContent = $('.overlay-content');
	var $mask = $('.mask');
	var $overlayClose = $('.overlay-close');
	var $overlayNext = $('.overlay-next');
	var $overlayPrev = $('.overlay-prev');
	var $overlayNav = $('.overlay-next, .overlay-prev');

	$people.click(function() {
		$id = $(this).attr('id');
		$name = $(this).find('.person-name').html();
		$title = $(this).find('.person-title').html();
		$image = $(this).find('.person-banner').html();
		$text = $(this).find('.person-text').html();
		$counterNext = $(this).find('.person-next').html();
		$counterPrev = $(this).find('.person-prev').html();

		$content = '<div class="overlay-name">'+$name+'</div>';
		$content += '<div class="overlay-title">'+$title+'</div>';
		$content += $text;

		$overlayImage.html('<img src="'+$image+'" />');
		$overlayContent.html($content);
		$overlayNext.attr('rel', 'person'+$counterNext);
		$overlayPrev.attr('rel', 'person'+$counterPrev);

		$mask.fadeIn('fast');
		$overlay.fadeIn('slow');

		$body.addClass('fixed');
	});

	$overlayNav.click(function() {
		var $src = $(this).attr('rel');

		$id = $('#'+$src).attr('id');
		$name = $('#'+$src).find('.person-name').html();
		$title = $('#'+$src).find('.person-title').html();
		$image = $('#'+$src).find('.person-banner').html();
		$text = $('#'+$src).find('.person-text').html();
		$counterNext = $('#'+$src).find('.person-next').html();
		$counterPrev = $('#'+$src).find('.person-prev').html();

		$content = '<div class="overlay-name">'+$name+'</div>';
		$content += '<div class="overlay-title">'+$title+'</div>';
		$content += $text;

		$overlayImage.html('<img src="'+$image+'" />');
		$overlayContent.html($content);
		$overlayNext.attr('rel', 'person'+$counterNext);
		$overlayPrev.attr('rel', 'person'+$counterPrev);
	});

	$overlayClose.click(function() {
		$mask.fadeOut('slow');
		$overlay.fadeOut('fast');

		$body.removeClass('fixed');
	});

	if(!isMobile) {
		var $socialIcons = $('ul.social img');
		var $normalState;
		$socialIcons.mouseover(function() {
			$normalState = $(this).attr('src');
			var $hoverState = $(this).attr('rel');
			$(this).attr('src', $hoverState);
		}).mouseleave(function() {
			$(this).attr('src', $normalState);
		});
	}

});

