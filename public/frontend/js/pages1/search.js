$(document).ready(function(){
    if($('#sortby').val()==0){
        $("#menu-data").show();
        $("#chef-data").hide();
        $("#menu-filter").show();
        $("#chef-filter").hide();
    }else{
        $("#menu-data").hide();
        $("#chef-data").show();
        $("#menu-filter").hide();
        $("#chef-filter").show();
    }
    $('#sortby').on('change', function() {

        if ( this.value == '0')
        {
            $("#menu-data").show();
            $("#chef-data").hide();
            $("#menu-filter").show();
            $("#chef-filter").hide();
        }
        else
        {
            $("#menu-data").hide();
            $("#chef-data").show();
            $("#menu-filter").hide();
            $("#chef-filter").show();
        }
    });

    $(".search-result-mob").click(function(){
        $(this).toggleClass("active");
        $(".search-result-mob-wrap").slideToggle();
    });

    $(".header-search-wrap").toggleClass("open");
        setTimeout(function(){
            $('.orig').focus()
        },500);
    });

    $( function() {
        var c = $('#currency').val();
        
        $( "#slider-range" ).slider({
            min:0,
            max:2000,
            value: 200 ,
            slide: function( event, ui ) {               
                $( "#amount" ).val( c+"" +"0" + " - "+ c + ui.value );
            }
        });
        $( "#amount" ).val( c+"" + "0" +
          " - "+ c + $( "#slider-range" ).slider( "value" ) );

        var loader="<div class='loading-sec'><img src='"+BASEURL+"public/frontend/images/loader.gif'/></div>";

        $('#slider-range .ui-slider-handle').on('click',function(){
            $('.search-result-list-wrap').html(loader); 
            var min_price=0;
            var max_price=$( "#slider-range" ).slider( "value");
            var qs="min_price="+min_price+"&max_price="+max_price;
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:$(location).attr('href'),
                type:'GET',
                data:qs,
                success:function(output){
                 $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                 $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
        });
        // $('#slider-range').find('.ui-slider-handle').first().hide();
        $( "#slider-range1" ).slider({
           
            min: 0,
            max: 50,
            value: 2,
            slide: function( event, ui ) {
                $( "#miles" ).val( "0 Miles - "+  ui.value +" Miles" );
            }
        });
        $( "#miles" ).val( "0 Miles - " + $("#slider-range1").slider("value")+ " Miles");
        
        $('#slider-range1 .ui-slider-handle').on('click',function(e){
            $('.search-result-list-wrap').html(loader);
            var min_miles=0;
            var max_miles=$( "#slider-range1" ).slider( "value");
            var qs="min_miles="+min_miles+"&max_miles="+max_miles;
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:$(location).attr('href'),
                type:'GET',
                data:qs,
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        // $('#slider-range1').find('.ui-slider-handle').first().hide();
        $('.rate').on('click',function(e){
            $('.search-result-chef').html(loader);
            var data = $(this).data('href');
            var r=$(this).data('id');
            var qs="rating="+r;
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                data:qs,
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });

        $('.popularity').on('click',function(e){
            $('.search-result-chef').html(loader);
            var data = $(this).data('href');
            var qs="popularity=desc";
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                data:qs,
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        $('.price').on('click',function(e){
            $('.search-result-list-wrap').html(loader);
            var data = $(this).data('href');
            var order = $(this).data('order');
            var qs="price="+order;
            
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname+ '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        $('.service').on('click',function(e){
            $('.search-result-list-wrap').html(loader);
            var data = $(this).data('href');
            var service = $(this).data('service');
            if(service=="pickup"){service=1}else{service=3}
            var qs="service="+service;
            
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname+ '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        $('.recently').on('click',function(e){
            $('.search-result-list-wrap').html(loader);
            var data = $(this).data('href');           
            var qs="recently=yes";            
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname+ '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        
        $('.availability').on('click',function(e){
            $('.search-result-list-wrap').html(loader);
            var data = $(this).data('href');           
            var qs="availability=asc";            
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname+ '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
        });
        $('.new-chef').on('click',function(e){
            $('.search-result-chef').html(loader);
            var data = $(this).data('href');
            var qs="popularity=desc";
            if (history.pushState) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ qs;
                window.history.pushState({path:newurl},'',newurl);
            }
            $.ajax({
                url:data,
                type:'GET',
                data:qs,
                success:function(output){
                    $(".search-result-list-wrap").load(" .search-result-list-wrap > *");
                    $(".search-result-chef").load(" .search-result-chef > *");                    
                }
            });
            e.stopImmediatePropagation();
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

        $('.popup-product-img-wrap').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
        });

        $('.menu-label-popup').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
        });
        $('.clear-filter').on('click',function(){
            var uri = window.location.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
                location.reload();
            }
        });
    });

