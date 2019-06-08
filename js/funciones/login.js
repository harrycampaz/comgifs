$(document).ready(function(){
	

        $("#login").validate({
            rules:{
              username:{
                required:true
               
            	},
              password:{
                required:true,
                minlength: 6
              }
            },
           
			submitHandler:function(){
					//form.url.value=location.href;
					form.submit();
				}
       });
});