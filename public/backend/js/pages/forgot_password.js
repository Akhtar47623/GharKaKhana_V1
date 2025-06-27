$(function() {
    $('#forgot_password').submit(function(evt) {
        evt.preventDefault();
        var formData = new FormData(this);
        $("#ErrorMessagesSection").css("display","none");
        $("#btnSubmit").html('<i class="fa fa-spinner"></i> Please wait...');
        $('#btnSubmit').attr('disabled','disabled');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            dataType:'json',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.status == '1'){
                    //console.log(res);
                    window.location.href = res.redirect;
                } else { 
                    $('#btnSubmit').removeAttr('disabled');
                    $("#btnSubmit").html('<i class="fa fa-sign-in"></i> Login');
                    $("#ErrorMessagesSection").css("display","block");
                    $("#ErrorMessages").html(res.msg);
                }
            },
            error : function ( jqXhr, json, errorThrown ) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each( errors.errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; 
                });
                if(errorsHtml!=""){
                    $('#btnSubmit').removeAttr('disabled');
                    $("#btnSubmit").html('<i class="fa fa-sign-in"></i> Login');
                    //toastr.error( errorsHtml , "Validation Fail.");
                    $("#ErrorMessagesSection").css("display","block");
                    $("#ErrorMessages").html(errorsHtml);
                }
            }
        });
    });
});