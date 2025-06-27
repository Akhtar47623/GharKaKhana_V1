
    var $messages = $('.messages-content'),
    d,h,m,
    i = 0;

    $(window).load(function () 
    {
        $messages.mCustomScrollbar();       
    });
    
    function updateScrollbar() 
    {
      $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
        scrollInertia: 10,
        timeout: 0 });
    }

    function insertMessage() {
        msg = $('.message-input').val();
        if ($.trim(msg) == '') {
            return false;
        }
        $('<div class="message right">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
        $('.message-input').val(null);
        updateScrollbar();
        
    }

    function insertTicketMessage() {
        msg = $('#ticketMessage').val();
        if ($.trim(msg) == '') {
            return false;
        }
        $('<div class="message right">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
        $('#ticketMessage').val(null);
        updateScrollbar();
        
    }

    $(".messages-btn").click(function(){
        $.ajax({
            url: BASEURL + 'get-chef-list',
            type: 'get',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (res) {
                if(res){
                    $(".message-popup").addClass("active");
                    $("#user-list").empty();
                    $("#ticket-list").empty();
                    $("#user-list").append(res['output']);
                    $("#ticket-list").append(res['ticket']);
                    msgchat();
                    ticketchat();
                                
                }else{

                }
            }

        });
    });
    function msgchat(){
        $(".messages-list #user-list li").click(function(e){
            e.preventDefault();
            var dataAttr = $(this).data("attr");
            var name = $(this).find("h3").text();
            $('#to_id').val(dataAttr);
          
            $("#mess-chat-list").attr("data-source", dataAttr);
         
            $.ajax({
                type:"get",
                url:BASEURL+"get-chef-messages",
                data:{id:dataAttr},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(res){
                    if(res){
                        $("#message-chat .messages-content .mCSB_container").empty();
                        $("#message-chat .messages-content .mCSB_container").append(res);
                        updateScrollbar();
                        $(".messages-list ul li").removeClass("active")
                        // $(this).addClass("active");
                        $(".messages-chat-list").removeClass("active");    
                        $(".messages-chat-list[data-source='"+dataAttr+"']").addClass("active");
                        $("#mess-chat-list h6").html(name);                        
                    }
                }
            });
        });       
    }
    function ticketchat(){
         $(".messages-list #ticket-list li").click(function(e){
            e.preventDefault();
            var dataAttr = $(this).data("attr");
            var orderId = $(this).data("orderid");
            var ticketId = $(this).data("ticketid");
            var name = $(this).find("h3").text();
            $('#order_id').val(orderId);
            $('#ticket_id').val(ticketId);
            $('#ticket_to_id').val(dataAttr);
            $("#ticket-chat-list").attr("data-source", dataAttr);
            $.ajax({
                type:"get",
                url:BASEURL+"get-ticket-messages",
                data:{id:dataAttr,order_id:orderId},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:function(res){
                    if(res){
                        $("#ticket-chat .messages-content .mCSB_container").empty();
                        $("#ticket-chat .messages-content .mCSB_container").append(res);
                        updateScrollbar();
                        $(".messages-list ul li").removeClass("active")
                        // $(this).addClass("active");
                        $(".messages-chat-list").removeClass("active");    
                        $(".messages-chat-list[data-source='"+dataAttr+"']").addClass("active");
                        $("#ticket-chat-list h6").html(name);                    
                    }
                }
            });
        });       

    }
    $('#message-submit').click(function () {
        msg = $('#custMessage').val();
        id=$('#to_id').val();
        if ($.trim(msg) == '') {
            return false;
        }
        $.ajax({
            type:"POST",
            url:BASEURL+"add-chef-message",
            data:{message:msg,id:id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
                    insertMessage(msg);
                }else{
              
                }
            }
        });
        
        
    });
    $('#ticket-submit').click(function () {
        msg = $('#ticketMessage').val();

        to_id=$('#ticket_to_id').val();
        ticket_id=$('#ticket_id').val();
        order_id=$('#order_id').val();
       
        if ($.trim(msg) == '') {
            return false;
        }
        $.ajax({
            type:"POST",
            url:BASEURL+"add-ticket-message",
            data:{message:msg,to_id:to_id,ticket_id:ticket_id,order_id:order_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res){
                    insertTicketMessage(msg);
                }else{
              
                }
            }
        });
        
        
    });
    
    $(".back-chat-btn").click(function(){
        $(this).parent().removeClass("active");
        $.ajax({
            url: BASEURL + 'get-chef-list',
            type: 'get',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (res) {
                if(res){
                    $(".message-popup").addClass("active");
                    $("#user-list").empty();
                    $("#ticket-list").empty();
                    $("#user-list").append(res['output']);
                    $("#ticket-list").append(res['ticket']);
                    msgchat();
                    ticketchat();
                                
                }else{

                }
            }

        });
    });
