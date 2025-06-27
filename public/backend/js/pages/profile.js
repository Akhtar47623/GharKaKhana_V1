$(function () {
    $("form[id='usersbasic']").validate({
        errorElement: 'span',
        rules: {
            first_name: "required",
            last_name: "required",
            phone:"required",
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            first_name: "Please enter first name.",
            last_name: "Please enter last name.",
            phone:"Please enter phone number",   
            email: "Please enter a valid email address.",
        },
        submitHandler: function (form) {
            
            form.submit();
            //profileUpdate("usersbasic");
        }
    });
    $("form[id='userspassword']").validate({
        
        errorElement: 'span',
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_confirm: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "What is your password?",
                minlength: "Your password must contain more than 6 characters"
            },
            password_confirm: {
                required: "You must confirm your password",
                minlength: "Your password must contain more than 6 characters",
                passwordMatch: "Your Passwords Must Match" // custom message for mismatched passwords
            }
        },
        submitHandler: function (form) {
            profileUpdate("userspassword");
        }
    });
    var profileUpdate = function (form) {
        toastr.options = {"positionClass": "toast-bottom-left"};
        $.ajax({
            type: "POST",
            url: $('#' + form).attr('action'),
            data: $("#" + form).serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.msg);
                    window.setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.msg);
                }
            }
        });
        return false;
    }
});

