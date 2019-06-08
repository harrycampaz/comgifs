    <div class="col-lg-8"> <!--inicio Contenido-->
    	
    <?php  
      if(isset($mensaje)){
        echo $mensaje;
      } ?>
      
      <?php if($end != 1) { ?>
      
      <div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <strong>¡ATENCIÓN!</strong> Ya te puedes unir GRATIS a la mejor comunidad ONLINE de GIFS,  Que esperas !!  <?= anchor('login/register', $signup, array('title' => 'Registrarme')) ?>
	</div>
	

	
      <?php } ?>
     