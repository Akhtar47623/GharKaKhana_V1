jQuery(window).on('scroll load', function () {
	// header on scroll shrink
	if ( jQuery(this).scrollTop() > 0 ) {
		jQuery('.header-wrap').addClass( "shrink-nav" );
	} else {
		jQuery('.header-wrap').removeClass( "shrink-nav" );
	}
});

jQuery(window).on('load', function() {
	//jQuery(".pre-loader").fadeOut("medium");
	/*==============================================================*/
	// mobile menu toggle init
	/*==============================================================*/
	jQuery("<span class='nav-link-toggle'><div class='fa fa-angle-down'></div></span>").insertBefore(jQuery('.menu ul.sub-menu'))	
	var link = jQuery(".nav-link-toggle");
	jQuery(".menu").on('click', '.nav-link-toggle', function(e) {
		e.preventDefault();
		jQuery(this).toggleClass('menu-show');
		jQuery(this).siblings('ul.sub-menu').slideToggle();
		return false;
	});

});



jQuery(document).ready(function() {
	/*==============================================================*/
	// tooltip init
	/*==============================================================*/
	jQuery('[data-toggle="tooltip"]').tooltip()

	$(".modal-second-level").on('click', function() {
		setTimeout(function(){
			$("body").addClass("modal-open");
		}, 500);
	});

	$('.star').raty({
		path: 'public/frontend/images/',
		half: function() {
			return $(this).attr('data-half');
		},
		readOnly: function() {
			return $(this).attr('data-readOnly');
		},
		score: function() {
			return $(this).attr('data-score');
		}
	});

	/*==============================================================*/
	// data color,bgcolor & border start
	/*==============================================================*/
	jQuery("[data-color]").each(function() {
		jQuery(this).css('color', jQuery(this).attr('data-color'));
	});
	jQuery("[data-bgcolor]").each(function() {
		jQuery(this).css('background-color', jQuery(this).attr('data-bgcolor'));
	});
	jQuery("[data-border]").each(function() {
		jQuery(this).css('border', jQuery(this).attr('data-border'));
	});
	/*==============================================================*/
	// data color,bgcolor & border end
	/*==============================================================*/


	/*==============================================================*/
	// menu
	/*==============================================================*/
	jQuery('[data-toggle="menu"]').on('click', function () {
		jQuery('.header-right').toggleClass('menu-show');
	});

	/*==============================================================*/
	// slick sliders
	/*==============================================================*/

	// Home
	jQuery('.home-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: true,
		variableWidth: true,
		adaptiveHeight: true,
		infinite: true,
		//fade: true,
		arrows: false,
		dots: true,
		responsive: [
		{
			breakpoint: 768,
			settings: {
				centerMode: false,
				arrows: false,
				variableWidth: false,
			}
		}
		]
	});

	jQuery('.choose-artist-wrap > ul').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: false,
		variableWidth: true,
		adaptiveHeight: true,
		infinite: true,
		autoplay: true,
		//fade: true,
		dots: false,
		arrows: false,
		responsive: [
		{
			breakpoint: 767,
			settings: {
				arrows: false,
				variableWidth: false,
			}
		}
		]
	});

	$('.modal').on('shown.bs.modal', function (e) {
		$('.choose-artist-wrap > ul').slick('setPosition');
	})



	// data id section scroll
	jQuery('.goto-section').on('click',function (e) {
		e.preventDefault();
		var target = jQuery(this).data('id');
		jQuery('html, body').stop().animate({
			'scrollTop': jQuery("#"+target).offset().top - 110
		}, 1600, 'swing', function () {
		});
	});

	jQuery('.browse-by-genre-list a').on('click',function(){
		//jQuery('.browse-by-genre-list a').removeClass('select');
		jQuery(this).toggleClass('select');
	});

	jQuery('.choose-genre-list .box').on('click',function(){
		//jQuery('.choose-genre-list .box').removeClass('select');
		jQuery(this).toggleClass('select');
	});

	jQuery('.choose-artist-list ul li').on('click',function(){
		//jQuery('.choose-artist-list ul li').removeClass('select');
		jQuery(this).toggleClass('select');
	});

	jQuery('[data-toggle="like"]').on('click', function () {
		jQuery(this).toggleClass('active');
	});

	jQuery('.concert-send-btn .cta-link').on('click', function () {
		jQuery(this).hide();
		jQuery(this).siblings('.send-btn').show();
	});

	

});
/*==============================================================*/
// Image to svg convert start
/*==============================================================*/
SVGInject(document.querySelectorAll("img.svg"));
/*==============================================================*/
// Image to svg convert end
/*==============================================================*/