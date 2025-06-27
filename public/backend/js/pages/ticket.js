$(function () { //must
    $("#frmMessage").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            return false;
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $.ajax({
                url: $('#frmMessage').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    console.log(res);
                    var message = res.message;
                    if (res.status == 200) {
                      
                        $('#frmMessage')[0].reset();
                        $(".direct-chat-messages").append(res.output);
                        $('.direct-chat-messages').stop().animate({ scrollTop: $('.direct-chat-messages')[0].scrollHeight}, 1000);
                       
                    } 
                },
            });
        }
    });
});
    $('.toggle_class').click(function() {      
    var status = $(this).prop('checked') == true ? '1' : '0'; 
    var id = $(this).data('id');
    var action = $(this).attr('data-action');
    var tableId = $(this).attr('data-tableId'); 
    var action = $(this).attr('data-action');
    $.ajax({
        url: action,
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, status: status},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                } else {
                    toastr.error(res.msg);
                }
            }
        });        
})
$('.seen_sms').click(function() {
       
         var id = $(this).data('id');
         $('#closeTicket').attr('data-id',id);
         $('#ticket_id').val(id);

        $.ajax({
            url: 'seenmessage',
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id:id,
            },
            success: function (res) {
                if(res){
                    $('.direct-chat-messages').empty();
                    $(".direct-chat-messages").append(res);
                    $("#modal-default").modal('show');
                    $('.direct-chat-messages').stop().animate({ scrollTop: $('.direct-chat-messages')[0].scrollHeight}, 1000);

                }else{
                    $('.direct-chat-messages').empty();
                }

        }
            
        });
    });
