$(document).ready(function () { 
    $('#cbody').show(500);   
    $(document).on("click", ".delete-img", function (e) {
        var table_id = $(this).attr('id');
        var action = $(this).data("action");
        var message = $(this).data("message");
        var pagerefresh = ($(this).data("pagerefresh")) ? $(this).data("pagerefresh") : 0;
        bootbox.confirm({
            message: message,
            buttons: {
                "confirm": {
                    label: "YES",
                    className: "btn btn-default btn-flat btn-sm"
                },
                "cancel": {
                    label: "NO",
                    className: "btn btn-default btn-flat btn-sm"
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: action,
                        type: 'DELETE',
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {},
                        success: function (res) { // What to do if we succeed
                            toastr.options = {'positionClass': "toast-bottom-left"}
                            if (res.status == 'success') {
                                toastr.success(res.msg);
                                if (pagerefresh == 0) {
                                 
                                    window.location.reload();
                                }
                            } else {
                                toastr.error(res.msg);
                            }
                        }
                    });
                }
            }
        });
    });
});

Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) 
            {
                 Dropzone.forElement('#dropzone').removeAllFiles(true);
               $('#gellery').load(document.URL + ' #gellery');
            },
            error: function(file, response)
            {
               return false;
            }
};