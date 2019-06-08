<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  echo validation_errors();
 
  if(isset($gif)){
  		$titulo = $gif[0]['titulo'];
  		$etiquetas = $gif[0]['etiquetas'];
  		$categoria = $gif[0]['id_categoria'];

  }
  else{
  		$titulo =  set_value('titulo');
  		$etiquetas = set_value('Etiquetas');
  		$categoria = set_value('id_categoria');
  }
  $attributes = array('id' => 'register',
                        'class'=>'form-horizontal');
  echo form_open('#', $attributes);

  $label = array('class' => 'control-label');

  $titulo = array(
                  'name' => 'titulo',
                  'id' => 'inputitulo',
       'class' => 'form-control',
                  'placeholder' => 'Nombre',
                  'value' => $titulo);
  $etiquetas = array(
                  'name' => 'etiqueta',
                  'id' => 'inputetiqueta',
       'class' => 'form-control',
                  'placeholder' => 'Etiquetas',
                  'value' => $etiquetas);
  

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Actualizar' );

?>
  <div class="control-group">
    <?=form_label('Titulo','',$label);?>
    <div class="controls">
      <?=form_input($titulo);?>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('etiquetas','',$label);?>
    <div class="controls">
      <?=form_textarea($etiquetas);?>  
    </div>
  </div>
  <div class="control-group">
    <?=form_label('categoria','',$label);?>
    <div class="controls">
       <?=form_dropdown('categoria', $select_categoria, '3',"id='categoria'");?>
    </div>
  </div>
   <div class="control-group">
    <div class="controls">
      <?=form_submit($submit);?>
    </div>
  </div>
</form>