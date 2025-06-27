    
$(document).ready(function() {
    $("#frmDeliveryDetail").validate({
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
            var timezone = moment().utcOffset(0, true).format("YYYY-MM-DD h:mm A");
            var formData = new FormData($("#frmDeliveryDetail")[0]);
            formData.append('timezone',timezone); //id is the variable that has the data that I need
            $.ajax({
                url: $('#frmDeliveryDetail').attr('action'),
                type: "POST",
                data: formData,
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
                        location.reload();
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
    var nameType = $.fn.dataTable.absoluteOrder( 
        {
            value: 'PENDING', position: '0'
        },
        {
            value: 'CANCEL', position: '1'
        },
        {
            value: 'ACCEPTED', position: '2'
        },
        {
            value: 'READY', position: '3'
        },
        {
            value: 'DELIVERY', position: '4'
        },
        {
            value: 'DELIVERED', position: '5'
        });
 
        $('#orderList').DataTable( {
            columnDefs: [
            { targets: 5, type: nameType }
            ]
        });
    });
    // <script>
    //     $( document ).ready(function() {
    //         $('#timezone').val(moment().utcOffset(0, true).format("YYYY-MM-DD h:mm A"))
    //     });        
    // </script>
    //order status change
    $('.change-status').click(function(event) {
        var id = $(this).data('id');
        var action = $(this).attr('data-action');
        var status = $(this).attr('data-status');
        var timezone = moment().utcOffset(0, true).format("YYYY-MM-DD h:mm A");
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id,status:status,timezone:timezone},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                    location.reload();
                } else {
                    toastr.error(res.msg);
                }
            }
        });
              
    });
    $(document).on("click", "#orderId", function(){ 
        var oid = $(this).data('id');

        var del_time=$(this).data('time');
        $('#order_id').val(oid);
        $('#del_time').val(del_time);
    });