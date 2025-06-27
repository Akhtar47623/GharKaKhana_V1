
$(function () { //must
    $("#frmTaxes").validate({
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
            var $btn = $('#btnSubmit');
            $btn.html($btn.data('loading-text'));
            $btn.attr('disabled', true);
            $('.alert').hide();

            $.ajax({
                url: $('#frmTaxes').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL+'taxes';
                        
                    } else {
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.val());
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.val());
                    $btn.attr('disabled', false);
                }
            });
        }

    });
    $('select').select2({}).on("change", function (e) {
        $(this).valid()
    });
    
    $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    });


});


  
    $('#country').change(function(){
        var countryID = $(this).val();    
        if(countryID){
            $.ajax({
            type:"GET",
            url:BASEURL+"get-state-list?country_id="+countryID,
            success:function(res){
                if(res)
                {
                    $("#state").empty();
                    $("#currency").empty();
                    $("#state").append('<option>Select State ...</option>');
                    $.each(res['0'],function(key,value){
                    $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                    $("#currency").append('<option>Select Currency ...</option>');
                    $.each(res['1'],function(key,value){
                    $("#currency").append('<option value="'+value+'">'+value+'</option>');
                    });
                }
                else
                {
                    $("#state").empty();
                }
            }

        });

        }
        else
        {
            $("#state").empty();
        }      

    });
    $('#state').change(function(){
        var stateID = $(this).val();    
        if(stateID){
            $.ajax({
            type:"GET",
            url:BASEURL+"get-city-list?state_id="+stateID,
            success:function(res){
                if(res)
                {
                    $("#city").empty();
                    $("#city").append('<option>Select City ...</option>');
                    $.each(res,function(key,value){
                    $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });
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
    