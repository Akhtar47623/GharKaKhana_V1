$(function () { //must
    if($('#cuisineList').length){
       $('#cuisineList').DataTable({
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
    $("#frmCuisine").validate({
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
        rules: {
            name: {
                alpha:true
            }
        },
        messages: {
            name:{
                alpha: 'Only Alphabet allowed'
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
                url: $('#frmCuisine').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL+'cuisine';
                        // $('#frmLocation')[0].reset();
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
    $.validator.addMethod('checkextension', function (value, element) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'JPG', 'JPEG', 'PNG'];
        var filename = $('#image').val();

        if (filename) {
            if ($.inArray(filename.split('.').pop().toLowerCase(), fileExtension) == -1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }, 'Only jpg & png files are allowed.');
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var filerdr = new FileReader();
        filerdr.onload = function (e) {
            $('#previewImage').html('<img src="' + e.target.result + '" class="img-thumbnail" height="100px" width="100px"/>');
        }
        filerdr.readAsDataURL(input.files[0]);
    } else {
        $('#previewImage').html('');
    }
}

