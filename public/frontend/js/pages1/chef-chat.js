
	jQuery('.bell-link').on('click',function(){
		
	        $.ajax({
	            url: BASEURL + 'get-cust-list',
	            type: 'get',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            success: function (res) {
	                if(res){
	                	jQuery('.chatbox').addClass('active');
	                    $("#DZ_W_Contacts_Body .contacts").empty();
	                    $('#DZ_W_Contacts_Body11 .contacts').empty();
	                    
	                    $("#DZ_W_Contacts_Body .contacts").append(res['output']);
	                    $("#DZ_W_Contacts_Body11 .contacts").append(res['ticket']);
	                    //$("#ticket-list").append(res['ticket']);
	                    msg();
	                    ticket();
	                    chat_history();
	                    seen_msg();
	                    seen_tic();
	                                
	                }
	            }

	        });	
	});
	function chat_history(){
		jQuery('#messages .dz-chat-user-box .dz-chat-user').on('click',function(){
			 jQuery('#messages .dz-chat-user-box').addClass('d-none');
			 jQuery('#messages .dz-chat-history-box').removeClass('d-none');
		}); 

		jQuery('#messages .dz-chat-history-back').on('click',function(){
			$.ajax({
	            url: BASEURL + 'get-cust-list',
	            type: 'get',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            success: function (res) {
	                if(res){
	                	$("#DZ_W_Contacts_Body .contacts").empty();                    
	                    $("#DZ_W_Contacts_Body .contacts").append(res['output']);
	                    msg();                              
	                }
	            }
	        });
			jQuery('#messages .dz-chat-user-box').removeClass('d-none');
			jQuery('#messages .dz-chat-history-box').addClass('d-none');
		}); 

		jQuery('#tickets .dz-chat-user-box .dz-chat-user').on('click',function(){
			 jQuery('#tickets .dz-chat-user-box').addClass('d-none');
			 jQuery('#tickets .dz-chat-history-box').removeClass('d-none');
		}); 

		jQuery('#tickets .dz-chat-history-back').on('click',function(){
			$.ajax({
	            url: BASEURL + 'get-cust-list',
	            type: 'get',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            success: function (res) {
	                if(res){
	                	$('#DZ_W_Contacts_Body11 .contacts').empty();
	                	$("#DZ_W_Contacts_Body11 .contacts").append(res['ticket']);
	                    ticket();  
	                }
	            }
	        });
			jQuery('#tickets .dz-chat-user-box').removeClass('d-none');
			jQuery('#tickets .dz-chat-history-box').addClass('d-none');
		});
	}
	function msg(){
		
		$('.msg').click(function() {
			var id = $(this).data('id');
			$('#to_id').val(id);
			var name = $(this).find("#name").text();
			$.ajax({
				url: BASEURL+'show-message',
				type: 'post',
				dataType: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
					id:id,
				},
				success: function (res) {					
					if(res){
						jQuery('#messages .dz-chat-user-box').addClass('d-none');
			  			jQuery('#messages .dz-chat-history-box').removeClass('d-none');
						$('#DZ_W_Contacts_Body3').empty();
						$("#DZ_W_Contacts_Body3").append(res);
						$("#DZ_W_Contacts_Body3").stop().animate({ scrollTop: $("#DZ_W_Contacts_Body3")[0].scrollHeight}, 1000);
						$("#msg-user-nm").html("Message with"+" "+ name);
						
					}else{
						
						$('#DZ_W_Contacts_Body3').empty();
					}

				}

			});
		});
	}
	function ticket(){
		$('.tic').click(function() {
			
			var id = $(this).data('id');
			var order_id = $(this).data('orderid');
			var ticketId =$(this).data('ticketid');
			var name = $(this).find("#ticName").text();
			
			 $('#orderId').val(order_id);
			 $('#toId').val(id);
			 $('#closeTicket').attr('data-ticketid',ticketId);
	       
			$.ajax({
				url: BASEURL+'show-ticket',
				type: 'post',
				dataType: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: {
					id:id,order_id:order_id
				},
				success: function (res) {
					if(res){
						jQuery('#tickets .dz-chat-user-box').addClass('d-none');
						jQuery('#tickets .dz-chat-history-box').removeClass('d-none');
						$('#DZ_W_Contacts_Body1').empty();
						$("#DZ_W_Contacts_Body1").append(res);
						$("#DZ_W_Contacts_Body1").stop().animate({ scrollTop: $("#DZ_W_Contacts_Body1")[0].scrollHeight}, 1000);	
						$("#tic-user-nm").html("Message with"+" "+ name);
										
					}else{
						
						$('#DZ_W_Contacts_Body1').empty();
					}

				}

			});
		});
	}
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
							$("#DZ_W_Contacts_Body3").append(res.output);
							$('#DZ_W_Contacts_Body3').stop().animate({ scrollTop: $('#DZ_W_Contacts_Body3')[0].scrollHeight}, 1000);				

						}
					},
				});
			}
		});
	});
	$(function () { //must
		$("#frmTicketMessage").validate({

			errorElement: 'span',
			errorClass: 'help-block error-help-block',
			errorPlacement: function (error, element) {
				return false;
			},
			focusInvalid: true,
			submitHandler: function (form) {
				var $btn = $('#btnTicSubmit');
					
				$.ajax({
					url: $('#frmTicketMessage').attr('action'),
					type: "POST",
					data: new FormData(form),
					contentType: false,
					cache: false,
					processData: false,
					success: function (res) {
						var message = res.message;
						if (res.status == 200) {
							$('#frmTicketMessage')[0].reset();
							$("#DZ_W_Contacts_Body1").append(res.output);
							$('#DZ_W_Contacts_Body1').stop().animate({ scrollTop: $('#DZ_W_Contacts_Body1')[0].scrollHeight}, 1000);				

						}
					},
				});
			}
		});
	});
	function seen_msg(){
		$('.msg').click(function() {
			
	         var id = $(this).data('id');
	        
	        $.ajax({
	            url: 'seen-message',
	            type: 'post',
	            dataType: 'json',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: {
	                id:id,
	            },
	            success: function (res) {
	                if(res){
	                	
	                }else{
	                   
	                }
	        }
	            
	        });
	    });
	}
	function seen_tic(){
		$('.tic').click(function() {
			
	        var id = $(this).data('id');
			var order_id = $(this).data('orderid');
	        $.ajax({
	            url: 'seen-ticket',
	            type: 'post',
	            dataType: 'json',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: {
	                id:id,order_id:order_id
	            },
	            success: function (res) {
	                if(res){
	                	
	                }else{
	                   
	                }
	        }
	            
	        });
	    });
	}
    $('.closeTicket').click(function() {      
   
	    var id = $(this).data('id');
	    var action = $(this).attr('data-action');
	     var ticket_id = $(this).data('ticketid');
	     
	    $.ajax({
	        url: action,
	        type: 'post',
	        dataType: 'json',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	        data: {id: id, ticket_id: ticket_id},
	        success: function (res) { // What to do if we succeed
	            toastr.options = {'positionClass': "toast-bottom-left"}
	            if (res.status === 'success') {
	            	toastr.success(res.msg);
	            	window.location.href = BASEURL+ "chef-dashboard";

	            } else {
	            	toastr.error(res.msg);
	            }
	        }
	    });        
	})
	jQuery('.chatbox-close').on('click',function(){
		jQuery('.chatbox').removeClass('active');
		location.reload();
	});
