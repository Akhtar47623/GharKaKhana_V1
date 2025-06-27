
$(function () { //must
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#frmValidate").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
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
                url: $('#frmValidate').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {                        
                        window.location = BASEURL+'chef-sign-in';
                    } else {                         
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });
    $('#reSend').click(function() {
                var txt = $('#email').val();
                if (txt == '') {
                    $('.alert-danger').show().html('Please enter email');
                }else{
                    $('.loader-btn').show();
                    $.ajax(
                    {
                        type: "POST",
                        url: BASEURL + "resend",
                        data: {txt: txt},
                        success: function (res) {
                            var message = res.message;
                            if (res.status == 200) {
                                $('.loader-btn').hide();
                                localStorage.setItem('message', message);
                                window.location = BASEURL + 'thank-you';
                            } else {
                               $('.loader-btn').hide();
                                $('.alert-danger').show().html(message);                               
                            }
                        }                        
                    });
                }  
            }) 
    });

 