//new
$(function () { //must
    if($('html').attr('lang')=='es'){    
        $.extend( $.validator.messages, {
            required: "Este campo es obligatorio."                                                      
        });
    }
    var cityId;
    $("#frmPickupDelivery").validate({
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

        focusInvalid: true,
        submitHandler: function (form) {
            $("#loader").show();
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmPickupDelivery').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        $("#loader").hide();
                        localStorage.setItem('message', message);
                        toastr.success(message, "Top Right", {
                        timeOut: 3000,closeButton: !0,
                        debug: !1,newestOnTop: !0,progressBar: !0,
                        positionClass: "toast-top-right",preventDuplicates: !0,onclick: null,showDuration: "500",
                        hideDuration: "2000",extendedTimeOut: "2000",showEasing: "swing",hideEasing: "linear",showMethod: "fadeIn", hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        window.location = BASEURL+'pickup-delivery';
                        // $('#frmLocation')[0].reset();
                    } else {
                        $("#loader").hide();
                         toastr.error(message, "Top Right", {
                        positionClass: "toast-top-center",timeOut: 3000,
                        closeButton: !0, debug: !1,newestOnTop: !0,
                        progressBar: !0,preventDuplicates: !0,onclick: null,showDuration: "500",hideDuration: "1000",
                        extendedTimeOut: "2000",showEasing: "swing", hideEasing: "linear",showMethod: "fadeIn",hideMethod: "fadeOut",
                        tapToDismiss: !1
                        })
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $("#loader").hide();
                        toastr.error("'Ooops...Something went wrong. Please try again.'", "Top Right", {
                    positionClass: "toast-top-right",timeOut: 3000,closeButton: !0,
                    debug: !1,newestOnTop: !0,progressBar: !0,preventDuplicates: !0,
                    onclick: null,showDuration: "500", hideDuration: "1000",extendedTimeOut: "2000",
                    showEasing: "swing",hideEasing: "linear", showMethod: "fadeIn",hideMethod: "fadeOut",
                    tapToDismiss: !1
                    })
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    }); 

    $('#pickup_delivery').change(function(){
        opt=$(this).val();
        if(opt==1){
            $('#delivery').hide();
            $('#pickup').show(); 
        }
        if(opt==2){
            $('#pickup').show();
            $('#delivery').show(); 
        }
        if(opt==3){
            $('#pickup').hide();
            $('#delivery').show();
        }
    });
    $('#btnSetDefaultAddress').click(function(e) {
        $.ajax({
            type:"GET",
            url:BASEURL+"get-chef-address",
            success:function(res){
                $("#state").val(res.state_id).change();
                cityId=res.city_id;
                $('#address').val(res.address);
                $('#zipcode').val(res.zip_code);
                $('#mobile').val(res.mobile);
            }

        });

    });
    $('#state').change(function(){
        var stateID = $(this).val();    
        if(stateID){
            $.ajax({
                type:"GET",
                url:BASEURL+"get-city-lists?state_id="+stateID,
                success:function(res){
                    if(res)
                    {
                        $("#city").empty();
                        $("#city").append('<option>Select City ...</option>');
                        $.each(res,function(key,value){
                            $("#city").append('<option value="'+key+'">'+value+'</option>');
                        });
                        $('#city option[value="'+cityId+'"]').attr("selected", "selected");
                        
                        $("select#city").selectpicker('refresh');
                       
                    }
                    else
                    {
                        $("#city").empty();
                    }
                }

            });

        }
        else
        {
            $("#city").empty();
        }      

    });
});