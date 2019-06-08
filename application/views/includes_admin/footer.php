<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	 </div>   
</div>
 <hr />
<footer>
    <div class="container">
        <div class="row">
            <div class="span6">
				<p class="muted">© 2013 comGIFS, LLC - Page rendered in <strong>{elapsed_time}</strong> seconds</p>
            </div>
            <div class="span2 offset4">
                
            </div>
        </div>
    </div>
</footer>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    
    <?php if (isset($register_js)) { ?>
    	<script type="text/javascript" src="<?=base_url()?>js/funciones/<?=$register_js?>"></script>
    	<script type="text/javascript">
	      var x;
	      x=$(document);
	      x.ready(register);

	      function register(){
	        var x=$("#inputname");
	        x.focus();
	        $('#register').each (function(){
			  this.reset();
			});

	      }
		</script>
    <?php } ?>
                
                
    <script src="<?=base_url()?>js/bootstrap.min.js"></script>
</body>
</html>
