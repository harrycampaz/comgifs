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
                    ?></p>
            </div>
            
        </div>
    </div>
</footer>
	


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    
       

    
   
    <?php if (isset($view)) { ?>
    <script type="text/javascript">
      $("#denunciar").click(function() {      
                      
           /* instrucciones javascript*/ 
           if(confirm('Esta seguro que desea reportar este GiF ?')){
              $.ajax({
            url: "http://comgifs.com/gifs/denunciar/<?=$datos['imagen']?>",
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
</body>
</html>