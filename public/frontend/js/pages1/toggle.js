$('.togBtn').change(function() {
    var status = $(this).prop('checked') == true ? '1' : '0';
    var id = $(this).data('id');
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
});

$('.changeBtn').change(function() {
    var visibility = $(this).prop('checked') == true ? '1' : '0';
    var id = $(this).data('id');
    var action = $(this).attr('data-action');      
    $.ajax({
        url: action,
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, visibility: visibility},
            success: function (res) { // What to do if we succeed
                toastr.options = {'positionClass': "toast-bottom-left"}
                if (res.status === 'success') {
                    toastr.success(res.msg);
                } else {
                    toastr.error(res.msg);
                }
            }
    });        
});