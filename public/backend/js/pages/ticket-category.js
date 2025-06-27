$(function () { //must
    $("#frmTicketCat").validate({
        errorElement: 'span',
        errorClass: 'help-block error-help-block',
        errorPlacement: function (error, element) {
            return false;
        },
        focusInvalid: true,
        submitHandler: function (form) {
            var $btn = $('#btnSubmit');
            $.ajax({
                url: $('#frmTicketCat').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    var message = res.message;
                    if (res.status == 200) {
                        localStorage.setItem('message', message);
                        window.location = BASEURL + 'ticket-category';

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
});

$(function() {
$('.toggle_class').change(function() {
  var status = $(this).prop('checked') == true ? '1' : '0'; 
    var id = $(this).data('id');
    $.ajax({
      type: "post",
      dataType: "json",
      url: 'changestatuscat',
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {'status': status, 'id': id},
      success: function(data){
        console.log(data.success)
      }
    });
  })
  })
