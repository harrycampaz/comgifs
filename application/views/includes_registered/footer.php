<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<hr />
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <p class="muted">© 2013 ComGIFS, LLC 
                    <?php
                    echo anchor(base_url() . 'terminos', 'Términos de Uso   -    ');
                    echo anchor(base_url() . 'terminos/privacidad', 'Política De Privacidad - ');
                    echo anchor('http://www.comgifs.blogspot.com/', ' Blog ', 'target = "_blank" ');
                    ?>
                
                | <?= anchor('login/logout', '<span class="glyphicon glyphicon-off"></span>  Cerrar sesión', array('title' => 'Cerrar sesion')) ?></li>
                            </p>
            </div>
            
        </div>
    </div>
</footer>
	


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>


    
       

    
   
    <?php if (isset($view)) { ?>
    <script type="text/javascript">
      $("#denunciar").click(function() {      
                      
           /* instrucciones javascript*/ 
           if(confirm('Esta seguro que desea reportar este GiF ?')){
              $.ajax({
            url: "http://www.comgifs.com/gifs/denunciar/<?=$datos['imagen']?>",
            context: document.body
          }).done(function() {
          $("#denunciar").attr('disabled','-1');
        }); 
           } 
           else{
            return false;
           }     
             
      });
      </script>
      <?php }?>

      <script src="<?=base_url()?>js/bootstrap.min.js"></script>
      
       <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-44519625-1', 'comgifs.com');
		  ga('send', 'pageview');

	</script>
</body>
</html>