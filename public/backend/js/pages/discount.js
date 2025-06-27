$(function () { //must
    $("#frmDiscount").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            if (element.hasClass('select2')) {
                error.insertAfter(element.parent().find('span.select2'));
            } else if (element.parent('.input-group').length ||
                element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules:{
            country: {
                required: true
            },
            state: {
                required: true,
            },
            promocode: {
                required: true
            },
            vendor_discount: {
                required: true,
                digits:true
            },
            total_coupon:{
                required: true,
                digits:true
            },
            minimum_order_value:{
                required: true,
                digits:true
            },
            start_date:{
                required: true
            },
            expired_date:{
                required: true
            },
           
        },
          messages: {
            country: {
                required: "Please Select Country"
            },
            state: {
                required: "Please Select State",
            },
            promocode: {
                required: "Please Enter Promocode"
            },
            vendor_discount: {
                required: "Enter Company Discount",
                digits:"Enter Only Number"
            },
            total_coupon:{
                digits:"Enter Only Number"
            },
            minimum_order_value:{
                digits:"Enter Only Number"
            },
            start_date:{
                required: "Please Select Starts Date"

            },
            expired_date:{
                required: "Please Select Expired Date"
            },

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
                url: $('#frmDiscount').attr('action'),
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
                        window.location = BASEURL+'discount';
                        // $('#frmLocation')[0].reset();
                    } else {
                        $("#loader").hide();
                        $('.alert-danger').show().html(message);
                        $btn.html($btn.data('text'));
                        $btn.attr('disabled', false);
                    }
                },
                error: function (err) {
                    $("#loader").hide();
                    $('.alert-danger').show().html('Ooops...Something went wrong. Please try again.');
                    $btn.html($btn.data('text'));
                    $btn.attr('disabled', false);
                }
            });
        }
    });
    
});
function randomString() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    return randomstring;
}

$("#start_date").datepicker({
    todayBtn:  1,
    autoclose: true,
    format:"yyyy/mm/dd"
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#expired_date').datepicker('setStartDate', minDate);
    $('#expired_date').datepicker('setDate', minDate); 
});

$("#expired_date").datepicker({ format:"yyyy/mm/dd",autoclose: true})
    .on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#start_date').datepicker('setEndDate', maxDate);
    });
  $('#country_id').change(function(){
        var countryID = $(this).val();    
        if(countryID){
            $.ajax({
            type:"GET",
            url:BASEURL+"get-state-list?country_id="+countryID,
            success:function(res){
                if(res['0'])
                {
                    $("#state_id").empty();
                    $("#state_id").append('<option>Select State ...</option><option value="0">ALL</option>');
                    $.each(res['0'],function(key,value){
                    $("#state_id").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
                else
                {
                    $("#state_id").empty();
                }
            }

        });

        }
        else
        {
            $("#state_id").empty();
        }      

    });
