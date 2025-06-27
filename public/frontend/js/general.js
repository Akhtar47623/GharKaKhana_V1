
// JavaScript Document
var $ = jQuery.noConflict();

//Preloader
$(window).on("load", function() {
    $('#preloader').fadeOut(2000);
    $('.wrapper').addClass('show');

    
});

$(document).ready(function () {

	$('.enumenu_ul').responsiveMenu({
        'menuIcon_text': '',
        onMenuopen: function () {}
    });

    $(".selectbox").selectbox();

	BodyPadding();

	$(".header-search a").click(function(event){
		event.stopPropagation();
		$(".header-search-wrap").toggleClass("open");
		setTimeout(function(){
			$('.orig').focus()
		},500)});
	$(".header-search-wrap").on("click",function(event){
		event.stopPropagation()
	});

	LocationField();

	$(".messages-btn").click(function(){
		$(".message-popup").addClass("active");
		$("body").addClass("chat-popup-open");
	});

	$(".site-header").on("click", function(event){
		event.stopPropagation();
	});

	$(".messages-list").on("click", function(event){
		event.stopPropagation();
	});

	$(".message-popup-wrap").on("click", function(event){
		event.stopPropagation();
	});

    

	// $(".messages-list ul li").click(function(e){
		
	// 	e.preventDefault();
	// 	var dataAttr = $(this).data("attr");		
	// 	$(".messages-list ul li").removeClass("active")
	// 	$(this).addClass("active");
	// 	$(".messages-chat-list").removeClass("active");    
	// 	$(".messages-chat-list[data-source='"+dataAttr+"']").addClass("active");
	// });

	

	$('.message-popup-tab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion
        width: 'auto', //auto or any width like 600px
        fit: true, // 100% fit in a container
        tabidentify: 'hor_1', // The tab groups identifier
        
    });

	$('.banner-slider').slick({
	 	slidesToShow: 1,
	 	slidesToScroll: 1,
	 	arrows: true,
	 	dots: false,
	 	infinite: false,
	 	speed: 1200,
	 	autoplay: true,
  		autoplaySpeed: 5000,
	});
    $('.popular-list-wrap').slick({
  
	  	infinite: false,
	  	speed: 300,
	  	arrows: true,
	  	slidesToShow: 3,
	  	slidesToScroll: 1,
	  	appendArrows: '.slider-nav',
	  	responsive: [
	    {
	      	breakpoint: 1024,
	      	settings: {
	        	slidesToShow: 2,
	        	slidesToScroll: 1,
	        	infinite: true,
	        }
	    },
	    {
	      	breakpoint: 640,
	      	settings: {
	        	slidesToShow: 1,
	        	slidesToScroll: 1
	      	}
	    },
	    {
	      	breakpoint: 480,
	      	settings: {
	        	slidesToShow: 1,
	        	slidesToScroll: 1
	      	}
	    }
	    
	  ]
	});
	$('.header-link a.sign-in-btn').click(function(event){
		event.stopPropagation();
		$('.signin-popup').addClass('active');
		$('.signup-popup').removeClass('active');
		$('body').addClass('open-popup');
	});

	$('.header-link a.sign-up-btn').click(function(event){
		event.stopPropagation();
		$('.signup-popup').addClass('active');
		$('.signin-popup').removeClass('active');
		$('body').addClass('open-popup');
	});
	
	$(".header-link").on("click",function(event){
		event.stopPropagation()
	});	

	$(".logged-in a.user-icon").click(function(event){
		event.stopPropagation();
    	$(this).next(".user-login-info").toggleClass("active");
    });

    $(".user-login-info").on("click",function(event){
		event.stopPropagation()
	});

    $(".cart-icon").click(function(event){
		event.stopPropagation();
    	$(".mini-cart-sec").addClass("active");
    });

    $(".expand-cart").click(function(event){
		event.stopPropagation();
		$(this).toggleClass("active");
    	$(".mini-cart-top").toggleClass("active");
    });

    $(".cart-close").click(function(event){
		event.stopPropagation();
    	$(".mini-cart-top").removeClass("active");
    	$(".expand-cart").removeClass("active");
    });

	$(".onoffswitch-label").click(function(){
    	$(".form-main ul li.option-box").toggleClass("active");
    	$("#option1").attr("required", true);
    });

    $(".onoffswitch-label1").click(function(){
    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
    });

    $(".onoffswitch-label3").click(function(){
    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
    });

    $(".onoffswitch-label5").click(function(){
    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
    });

    $(".onoffswitch-label7").click(function(){
    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
    });

    $(".onoffswitch-label9").click(function(){
    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
    });	

    

});

$(document).on("click", function(){
	$("body").removeClass("chat-popup-open");
    $(".message-popup").removeClass("active");
    $(".messages-chat-list").removeClass("active");
});
 // $(document.body).on('click', '.togBtn' ,function(){
 //    	$(this).parents(".option-box-wrap ul").find("li.rate-hide-show").toggleClass("active");
 //    });

 function BodyPadding(){
 	var HeaderHeight = $(".site-header").outerHeight();
	$("body").css("padding-top", HeaderHeight);
 }
window.paginate = function (anchor) {
   
    var lastAttemptedUrl = null;
    
    lastAttemptedUrl = $(anchor).attr('page-href');
    if ($('select[name="per_page"]').length > 0) {
        lastAttemptedUrl = replaceQueryParams('per_page', lastAttemptedUrl, $('select[name="per_page"] option:selected').val());
    }
    var country_id = $('#country_id').val();
	$.ajax({
		url: lastAttemptedUrl,
		type: "GET",
		dataType: "json",
		data: {country_id: country_id },
		success:function(data) {
			if(data.status=='success'){
			$('.our-chef-sec').html(data.view);
			} else {
			// toaster();
			}
		}
	});
    return true;
};

$(document).on("click",function(){
	$('.signup-popup').removeClass('active');
	$('.signin-popup').removeClass('active');
	$(".user-login-info").removeClass("active");
	$('body').removeClass('open-popup');
});

$(document).on("click",function(){
	$(".header-search-wrap").removeClass("open")
});

$(window).resize(function() {
    LocationField();
    BodyPadding();
});

var flag;
var $this;
function LocationField() {
    if (window.innerWidth <= 1024 && (typeof flag == "undefined" || flag)) {
        flag = false;
        $(".header-location").appendTo($(".header-location-wrap-mob"));
    } else if (window.innerWidth > 1024 && (typeof flag == "undefined" || !flag)) {
        flag = true;
        $(".header-location").appendTo($(".header-location-wrap"));
    }
}

$('#drpdwn-countrynm').on('change', function (e) {
    var countryID = $("option:selected", this).val(); 
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    $.ajax({
        url:BASEURL+'save-location',
        method: 'POST',
        data : {
            countryID:countryID, 
        },
        success: function (res) {
            window.location = BASEURL;

        }
    });
});