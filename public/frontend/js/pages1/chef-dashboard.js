// JavaScript Document
var $ = jQuery.noConflict();
function jset(){
    var no = $('#menus').val();
    for(i=1;i<no;i++){
        
        /* More item (Regular)*/

        $(".item"+i+" li").hide();
        $("#more"+i+"").hide();
        if ($(".item"+i+" li").length > 2) {
            console.log($(".item"+i+" li").length);
            $("#more"+i).show();
        }
        $(".item"+i+" li").slice(0, 2).show();
        $("#more"+i).click(function(){
            $(".item"+i+" li").slice($(".item"+i+" li").filter(':visible').length - 1, $(".item"+i+" li").filter(':visible').length + 2).fadeIn();
            if ($(".item"+i+" li").filter(':visible').length >= $(".item"+i+" li").length) {
                $("#more"+i).hide();
            }
        });
    }
}
$(document).ready(function () {
    
    jset();

    /* More item (Discount)*/
    var list = $("#discount li");
    var numToShow = 2;
    var button = $("#more-discount");
    var numInList = list.length;
    list.hide();
    button.hide();
    if (numInList > numToShow) {
        button.show();
    }
    list.slice(0, numToShow).show();
    button.click(function(){
        var showing = list.filter(':visible').length;
        list.slice(showing - 1, showing + numToShow).fadeIn();
        var nowShowing = list.filter(':visible').length;
        if (nowShowing >= numInList) {
            button.hide();
        }
    });

    $(".dashboard-item-box h3").on("click", function() {
        $(this).next().slideToggle('slow');
        $(this).toggleClass('active');
    });

    $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true,   // 100% fit in a container
        closed: 'accordion', // Start closed if in accordion view
        tabidentify: 'hor_1',
        activate: function(event) { // Callback function if tab is switched
        var $tab = $(this);
        var $info = $('#tabInfo');
        var $name = $('span', $info);
        $name.text($tab.text());
        $info.show();
        }
    });

    $(".flag").click(function(){
        $(this).toggleClass("active");
    });


    // $(".delete-img").click(function(){
    //     $(this).parents("li").hide();
    // });

    

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

    
    $('.allBtn').click(function() {
        
        var status = $(this).attr('status');
        var allVals = [];
        $(".togBtn").each(function () {
            allVals.push($(this).attr('data-id'));
        });
        var action = $(this).attr('data-action'); 
        $.ajax({
            url: action,
            type: 'post',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {ids: allVals.join(","), status: status},
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

    
});