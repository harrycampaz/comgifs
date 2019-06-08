$(document).ready(function(){
			        $("#buscar_form").validate({
			            rules:{
			              buscar_text:{
			                	minlength: 3,
			                	required:true,
			            	},
			            },
			            messages:{
								     buscar_text:{
									      minlength:"Min 3 caracteres",
								},
						},
						submitHandler:function(){
								//form.url.value=location.href;
								form.submit();
							}
       			})
			})