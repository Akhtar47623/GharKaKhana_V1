$(function () {
    //single delete
    $(document).on("click", ".remove", function (e) {
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

    //single status update
    $(document).on("click", ".softdestory", function (e) {
        var table_id = $(this).attr('id');
        var id = $(this).data('id');
        var action = $(this).data("action");
        var message = $(this).data("message");
        bootbox.confirm({
            title: '<i class="fa fa-exclamation-triangle"></i> Alert',
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
                        type: 'post',
                        dataType: 'json',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: id},
                        success: function (res) { // What to do if we succeed
                            toastr.options = {'positionClass': "toast-bottom-left"}
                            if (res.status == 'success') {
                                toastr.success(res.msg);
                                $('#' + table_id).DataTable().ajax.reload(); //datatable refresh
                            } else {
                                toastr.error(res.msg);
                            }
                        }
                    });
                }
            }
        });
    });

    //checkbox selection
    $('#master').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked', false);
        }
    });

    $('#masterimageactivity').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".imageactivity_sub_chk").prop('checked', true);
        } else {
            $(".imageactivity_sub_chk").prop('checked', false);
        }
    });

    $('#masterincludedeexcluded').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".includedeexcluded_sub_chk").prop('checked', true);
        } else {
            $(".includedeexcluded_sub_chk").prop('checked', false);
        }
    });

    $('#masterfaqactivity').on('click', function (e) {
        if ($(this).is(':checked', true)) {
            $(".faqactivity_sub_chk").prop('checked', true);
        } else {
            $(".faqactivity_sub_chk").prop('checked', false);
        }
    });

    //multi delete
    $('.delete_all').on('click', function (e) {
        var boxtitle = "<i class='fa fa-exclamation-triangle'></i> Alert.";
        var allVals = [];
        $(".sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });
        $(".imageactivity_sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });
        $(".includedeexcluded_sub_chk:checked").each(function () {
            allVals.push($(this).attr('data-id'));
        });
        $(".faqactivity_sub_chk:checked").each(function () { //masterfaqactivity
            allVals.push($(this).attr('data-id'));
        });


        if (allVals.length <= 0) {
            bootbox.alert({
                size: "small",
                title: boxtitle,
                message: $(this).data("message_error_alert"),
                className: 'bb-alternate-modal'
            });
        } else {
            var action = $(this).data("action");
            var tableId = $(this).data("table_id");
            bootbox.confirm({
                title: boxtitle,
                message: $(this).data("message_confirm_alert"),
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
                            type: 'POST',
                            dataType: "json",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            cache: false,
                            data: {ids: allVals.join(",")},
                            success: function (res) { // What to do if we succeed
                                toastr.options = {'positionClass': "toast-bottom-left"}
                                if (res.status == 'success') {
                                    toastr.success(res.msg);
                                    $("#master").prop('checked', false);
                                    $("#masterincludedeexcluded").prop('checked', false);
                                    $("#masterimageactivity").prop('checked', false);
                                    $("#masterfaqactivity").prop('checked', false);
                                    window.location.reload();
                                   // $('#' + tableId).DataTable().ajax.reload(); //datatable refresh
                                } else {
                                    toastr.error(res.msg);
                                }
                            }
                        });
                    }
                }
            });
        }
    });
    $('.numeric').bind('keyup paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    //Initialize Select2 Elements
    //$('.select2').select2();
});

var urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results[1] || 0;
}

var convertToSlug = function (Text) {
    var cnvt = Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    $("#slug").val(cnvt);
    $("#slugdata").val(cnvt);
}

//single feature update
var updateFeature = function (e) {
    var id = $(e).attr('data-id');
    var featured = (e.checked) ? 'Y' : 'N';
    var action = $(e).attr('data-action');
    var tableId = $(e).attr('data-tableId');
    $.ajax({
        url: action,
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, featured: featured},
        success: function (res) { // What to do if we succeed
            toastr.options = {'positionClass': "toast-bottom-left"}
            if (res.status === 'success') {
                toastr.success(res.msg);
                $('#' + tableId).DataTable().ajax.reload(); //datatable refresh
            } else {
                toastr.error(res.msg);
            }
        }
    });
}
 
$('.toggle-class').change(function() {        
    var status = $(this).prop('checked') == true ? 'A' : 'I'; 
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
  
// var updateStatus = function (e) {
//     var id = $(e).attr('data-id');
//     var status = (e.checked) ? 'A' : 'I'; 
//     var action = $(e).attr('data-action');
//     var tableId = $(e).attr('data-tableId');
// 	$.ajax({
//         url: action,
//         type: 'post',
//         dataType: 'json',
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         data: {id: id, status: status},
//         success: function (res) { // What to do if we succeed
//             toastr.options = {'positionClass': "toast-bottom-left"}
//             if (res.status === 'success') {
//                 toastr.success(res.msg);
//                 $('#' + tableId).DataTable().ajax.reload(); //datatable refresh
//             } else {
//                 toastr.error(res.msg);
//             }
//         }
//     });
// }


