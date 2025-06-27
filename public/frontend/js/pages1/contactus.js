//new 
$(function () { //must
    if($('#contactList').length){
       $('#contactList').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      }); 
    }
    if($('html').attr('lang')=='es'){
        $.extend( $.validator.messages, {
            required: "Este campo es obligatorio.",
            email: "Por favor, escribe una dirección de correo válida.",        
        } );
    }
    $("#frmContact").validate({
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
            $(".loader-btn").show();
            $.ajax({
                url: $('#frmContact').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        $(".loader-btn").hide();
                        localStorage.setItem('message', message);
                        $('.alert-success').show().html(message);
                        $("#frmContact")[0].reset();
                    } else {
                        $(".loader-btn").hide();
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $(".loader-btn").hide();
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });   
    $(".btn-refresh").click(function(){
        $.ajax({
            type:'GET',
            url:BASEURL+'refresh-captcha',
            success:function(data){
                $(".captcha span").html(data.captcha);
            }
        });
    }); 
});
