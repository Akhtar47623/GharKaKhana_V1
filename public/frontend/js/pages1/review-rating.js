
$(function() {
	$('div#chef').raty({
		start: 2.5,
		showHalf: true,
		hintList:     ['bad', 'poor', 'regular', 'good', 'gorgeous'],
		scoreName: function(){
			return $(this).attr('id');
		},

	});	
	$('div#del').raty({
		start: 2.5,
		showHalf: true,
		hintList:     ['bad', 'poor', 'regular', 'good', 'gorgeous'],
		scoreName: function(){
			return $(this).attr('id');
		},

	});

	$("#frmReview").validate({

		rules: {
			'chef':{required:true},
			'del': {required: true}      
		},
		ignore: [],		                      
		focusInvalid: true,
		submitHandler: function (form) { 
			$.ajax({
				url: $('#frmReview').attr('action'),
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,

				success:function(res){
					if (res.status == 200) {
			        		window.location = BASEURL;
			        	}

				},
			});            
		}      		
	});

	$(document).on("click", "#btnSkip", function (e) {
		var uuid = $('#review_uuid').val();
		var action = $(this).data("action");
		e.preventDefault();     
		$.ajax({
			url: action,
			type: 'POST',
			dataType: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {uuid:uuid,},
			        success: function (res) { // What to do if we succeed
			        	if (res.status == 200) {
			        		window.location = BASEURL;
			        	}
			        }
			    });
	});
});		
