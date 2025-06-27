var $ = jQuery.noConflict();


$(document).ready(function () {

    
   
    /*$('.enumenu_ul').responsiveMenu({
        'menuIcon_text': '',
        onMenuopen: function () { }
    });*/

    $(".mob-chef-profile-btn").click(function(){
        $(this).toggleClass("active");
        $(".chef-profile-sidebar").slideToggle();
    });
    
    $('.gallery-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        infinite: true,
        speed: 1200,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 640,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
    
    
    $('.gallery-slider').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
    });

    $('#parentHorizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion
        width: 'auto', //auto or any width like 600px
        fit: true, // 100% fit in a container
        tabidentify: 'hor_1', // The tab groups identifier
        
    });

    // Child Tab
    $('.ChildVerticalTab_1').easyResponsiveTabs({
        type: 'vertical',
        width: 'auto',
        fit: true,
        tabidentify: 'ver_1', 
    });

    $('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',
    });

    $('.popup-modal').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',     
    });
    $('.message-modal').click(function(){
        $('#profile_id').val($(this).data('id'));
    });
    $('.message-modal').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',     
    });

    $('.popup-product-img-wrap').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image...',
        mainClass: 'mfp-img-mobile',
    });

    $('.menu-label-popup').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image...',
        mainClass: 'mfp-img-mobile',
    });



    $('.rating-popup-tab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true,   // 100% fit in a container
        tabidentify: 'hor_1',
        closed: 'accordion', // Start closed if in accordion view
        activate: function(event) { // Callback function if tab is switched
        var $tab = $(this);
        var $info = $('#tabInfo');
        var $name = $('span', $info);
        $name.text($tab.text());
        $info.show();
        }
    });

    var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "";
    var moretext = "Show more";
    var lesstext = "Show less";
    

    $('.reviewed-content').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '</span><span class="morecontent"><span>' + h + '</span><div class="more_text"><a href="" class="morelink">' + moretext + '</a></div></span>';
            $(this).html(html);
        }
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(".moreellipses").removeClass("active");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(".moreellipses").addClass("active");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
    $("#frmMessage").validate({

        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            return false;
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $.ajax({
                url: $('#frmMessage').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        $('input[type="text"],textarea').val('');
                          
                        $('.alert-success').show().html(message);
                    } else {
                          
                        $('.alert-danger').show().html(message);                        
                    } 
                },
            });
        }
    });
    $("form").each(function() {
        $(this).validate({
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            errorPlacement: function (error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.parent().find('span.select2'));
                } else if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                    // else just place the validation message immediatly after the input
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
            },
            rules: {
                'rradio[]':{required:true},
                'rcheckboxes[]': {required: true,minlength: 1},
                'available_date':{required:true}                
            },
            messages: {
                'rradio[]': {
                    required: "Required One",
                },
                'rcheckboxes[]': {
                    required: "Required One or More",
                    
                },
                              
            },            
            focusInvalid: true,
            submitHandler: function (form) { 
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).attr('action'),
                    type:"POST",
                    data:$(this).serialize(),
                    success:function(response){
                        
                    },
                });            
            }
            
        });
              
    });

    $('input[type="checkbox"].price-field').change(function(e){
        
        let price = parseFloat($(this).data('price'));
        let form = $(this).closest('form');
        let count = parseInt(form.find('.count').text());
        let existingPriceHidden = parseFloat(form.find('.hidden-aggre').val());
        let existingPrice = parseFloat(form.find('.aggre').text());

        if ($(this).is(":checked")) { 

            form.find('.aggre').text((parseFloat(existingPrice) + (parseFloat(price) * count)).toFixed(2));
            form.find('.hidden-aggre').val(parseFloat(existingPriceHidden) + parseFloat(price));
        } else {        
            form.find('.aggre').text((parseFloat(existingPrice) - (parseFloat(price) * count)).toFixed(2));
            form.find('.hidden-aggre').val(parseFloat(existingPriceHidden) - parseFloat(price));
        }

        e.stopImmediatePropagation();
    })

    var prevPrice;
    $('input[type=radio].price-field').mouseup(function(){
        prevPrice =  $(this).closest('form').find('input[type=radio]:checked').data('price') || 1; 
    }).change(function(e){
        let price = parseFloat($(this).data('price'));
        let form = $(this).closest('form');
        let count = parseInt(form.find('.count').text());
        let existingPriceHidden = parseFloat(form.find('.hidden-aggre').val());
        let existingPrice = parseFloat(form.find('.aggre').text());
        if($(this).is(":checked")){
                var extraPrice = $(this).data('price');
                form.find('.aggre').text((parseFloat(existingPrice) + (parseFloat(extraPrice) * count)).toFixed(2));
                form.find('.hidden-aggre').val(parseFloat(existingPriceHidden) + parseFloat(extraPrice));               
        }
        existingPriceHidden = parseFloat(form.find('.hidden-aggre').val());
        existingPrice = parseFloat(form.find('.aggre').text());
        if(prevPrice !== 1){
            form.find('.aggre').text((parseFloat(existingPrice) - (parseFloat(prevPrice) * count)).toFixed(2));
            form.find('.hidden-aggre').val(parseFloat(existingPriceHidden) - parseFloat(prevPrice));
        }        
    })
    $('.plus').click(function(e){
        let form = $(this).closest('form');
        let count = parseInt(form.find('.count').text());
        form.find('.count').html(++count);
        form.find('.qty').val(count);
        let existingPriceHidden = parseFloat(form.find('.hidden-aggre').val());
        let existingPrice = parseFloat(form.find('.aggre').text());
        form.find('.aggre').text((parseFloat(existingPrice) + parseFloat(existingPriceHidden)).toFixed(2)); 
        e.stopImmediatePropagation();
    })
    $('.minus').click(function(e){
        let form = $(this).closest('form');
        let existingCountHidden = parseInt(form.find('.hidden-count').val());
        let count = parseInt(form.find('.count').text());

        if(count>existingCountHidden){
            form.find('.count').html(--count);
            form.find('.qty').val(count);
            let existingPriceHidden = parseFloat(form.find('.hidden-aggre').val());
            let existingPrice = parseFloat(form.find('.aggre').text());
            form.find('.aggre').text((parseFloat(existingPrice) - parseFloat(existingPriceHidden)).toFixed(2));
            e.stopImmediatePropagation();
        }
    })
    $(".datepicker").click(function() {
            
            let form = $(this).closest('form');
            let weekDay = form.find('.hidden-schedule').val();                
            const obj = JSON.parse(weekDay);
            var disableDays = [];
            if(obj.mon!=1){
                disableDays.push(1);
            }
            if(obj.tue!=1){
                disableDays.push(2);
            }
            if(obj.wed!=1){
                disableDays.push(3);
            }
            if(obj.thu!=1){
                disableDays.push(4);
            }
            if(obj.fri!=1){
                disableDays.push(5);
            }
            if(obj.sat!=1){
                disableDays.push(6);
            }
            if(obj.sun!=1){
                disableDays.push(0);
            }
            if(obj.recurring==1){dy=14;}else{dy=7;}
        $(this).datepicker({
            daysOfWeekDisabled: disableDays,
            startDate: '+'+obj.lead_time+'d',
            endDate: '+'+dy+'d',
        }).datepicker( "show" ).on("changeDate", function(e) {
            d=e.date;
            let weekday = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][d.getDay()]
            var str='',str1='',str2='';
            if(weekday=='Mon'){
                str=obj.mon_start_time.slice(0,-3) +' - '+obj.mon_end_time.slice(0,-3);
                str1=obj.mon_start_time.slice(0,-3);
                str2=obj.mon_end_time.slice(0,-3);
            }
            if(weekday=='Tue'){
                str=obj.tue_start_time.slice(0,-3) +' - '+obj.tue_end_time.slice(0,-3);
                str1=obj.tue_start_time.slice(0,-3);
                str2=obj.tue_end_time.slice(0,-3);
            }
            if(weekday=='Wed'){
                str=obj.wed_start_time.slice(0,-3) +' - '+obj.wed_end_time.slice(0,-3);
                str1=obj.wed_start_time.slice(0,-3);
                str2=obj.wed_end_time.slice(0,-3);
            }
            if(weekday=='Thu'){
                str=obj.thu_start_time.slice(0,-3) +' - '+obj.thu_end_time.slice(0,-3);
                str1=obj.thu_start_time.slice(0,-3);
                str2=obj.thu_end_time.slice(0,-3);
            }
            if(weekday=='Fri'){
                str=obj.fri_start_time.slice(0,-3) +' - '+obj.fri_end_time.slice(0,-3);
                str1=obj.fri_start_time.slice(0,-3);
                str2=obj.fri_end_time.slice(0,-3);
            }
            if(weekday=='Sat'){
                str=obj.sat_start_time.slice(0,-3) +' - '+obj.sat_end_time.slice(0,-3);
                str1=obj.sat_start_time.slice(0,-3);
                str2=obj.sat_end_time.slice(0,-3);                
            }
            if(weekday=='Sun'){
                str=obj.sun_start_time.slice(0,-3) +' - '+obj.sun_end_time.slice(0,-3);
                str1=obj.sun_start_time.slice(0,-3);
                str2=obj.sun_end_time.slice(0,-3);
            }
            let form = $(this).closest('form');
            form.find('.time').val(str);
            form.find('.start-time').val(str1);
            form.find('.end-time').val(str2);
        });
    });

});




