$(document).ready(function() {
    $.validator.addMethod("regex", function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    }, "Alphanumeric");

    $("#register").validate({
        rules: {
            name: {
                required: true,
                minlength: 5
            },
            email: {
                required: true,
                email: true
            },
            username: {
                rangelength: [3, 12],
                required: true,
                regex: "^[a-zA-Z0-9_-]+$"
            },
            password: {
                required: true,
                rangelength: [6, 20]
            },
            re_password: {
                required: true,
                equalTo: "#input_Password"
            },
            check: {
                required: true
            }

        },
        messages: {
            
            check: {
                required: "Please accept the terms"
            }
        },
        submitHandler: function() {
            //form.url.value=location.href;
            form.submit();
        }
    });
});