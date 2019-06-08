$(document).ready(function(){
	

        $("#login").validate({
            rules:{
              username:{
                required:true,
      
            	},
              password:{
                required:true,
                minlength: 6
              },
            },
            messages:{
					     username:{
						      required:"Campo obligatorio.",
						     
						     
					     },
					     password:{
						      required:"Campo obligatorio.",
						      minlength:"Minimo 6 caracteres.",
					},
			},
			submitHandler:function(){
					//form.url.value=location.href;
					form.submit();
				}
       })
})