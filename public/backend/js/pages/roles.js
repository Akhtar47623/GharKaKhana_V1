$(function () { //must
    if($('#rolesdata').length){
       $('#rolesdata').DataTable({
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
    $("#frmRoles").validate({
        
        rules: {
            name: {
                alpha:true
            }
        },
        messages: {
            name:{
                alpha: 'Only alphabet allowed'
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
                url: $('#frmRoles').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL + 'roles';

                        //$('#frmLocation')[0].reset();
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

    $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z ]+$/);
    });
});