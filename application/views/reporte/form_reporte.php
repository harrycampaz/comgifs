<h3>Reporte</h3>
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  $attributes = array('id' => 'register',
                        'class'=>'form-horizontal');
  echo form_open('reporte/check_reporte', $attributes);
  $label = array('class' => 'control-label');

  
  $reporte = array(
                  'name' => 'reporte',
                  'id' => 'inputreporte',
                  'class' => 'negro',
                  'placeholder' => 'Escribe aqui el reporte',
                  'maxlength' => 200,
                  'rows'	=>	'3');
  

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Reportar' );

?>
 
  <div class="control-group">
    <?=form_label('Reporte','',$label);?>
    <div class="controls">
      <?=form_textarea($reporte);?>
      <p class="text-error"><?=strip_tags(form_error('reporte')) ?></p>  
    </div>
  </div>
 
   <div class="control-group">
    <div class="controls">
    	<?php echo form_hidden('usuario', $usuario);
      			echo form_submit($submit);?>
    </div>
  </div>

</form>