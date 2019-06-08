$(document).ready(function() {
    $.validator.addMethod("regex", function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    }, "Alfanumerico o '_' , '-'");

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
            name: {
                required: "Campo obligatorio",
                minlength: "Por favor al menos 5 caracteres"
            },
            username: {
                required: "Campo obligatorio"
                
            },
            email: {
                required: "Campo obligatorio",
               
                email: "Por favor ingrese un correo valido"
            },
            password: {
                required: "Campo obligatorio",
                rangelength: "Por favor al menos 5 caracteres"
            },
            re_password: {
                required: "Campo obligatorio",
                equalTo: "Contraseñas no coinciden"
            },
            check: {
                required: "Por favor acepte los terminos"
            }
  },
        submitHandler: function() {
            //form.url.value=location.href;
            form.submit();
        }
    });
});