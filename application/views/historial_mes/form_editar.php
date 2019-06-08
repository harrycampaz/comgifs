<h3>Editar Historial Mes: <?=$mes['mes_username'];?></h3>
<hr/>

<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if(isset($mes)){       
       
        $valor_pago = $mes['valor_pago_mes'];
       
        $impresiones_mes = $mes['impresiones_mes'];
  }
  else{
      
        $valor_pago = set_value('valor_pago');
        
        $impresiones_mes = set_value('impresiones_mes');
  }
  $attributes = array('id' => 'edit_par',
                        'class'=>'form-horizontal');
  echo form_open_multipart('historial_mes/check_mes', $attributes);


  $label = array('class' => 'control-label');

  $valor_pago = array(
                  'name' => 'valor_pago',
                  'id' => 'inputvalor_pago',
                  'class' => 'form-control',
                  'placeholder' => 'Valor del Pago',
                  'value' => $valor_pago);
 
 
  $impresiones_mes = array(
                  'name' => 'impresiones_mes',
                  'id' => 'input_$impresiones',
                  'class' => 'negro',
                  'placeholder' => 'Impresiones',
                  'value' => $impresiones_mes);

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Actualizar' );
  $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick'=>"location.href='../historial_mes'");

?>
  
  
  <div class="control-group">
    <?=form_label('Valor pago','',$label);?>
    <div class="controls">
      <?=form_input($valor_pago);?>

      <p class="text-error"><?=strip_tags(form_error('valor_pago')) ?></p>
    </div>
  </div>

  <div class="control-group">
    <?=form_label('Impresiones por mes','',$label);?>
    <div class="controls">
      <?=form_input($impresiones_mes);?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <?php 
      echo form_hidden('id_historial_mes', $mes['id_historial_mes']);
      echo form_submit($submit);
      echo form_button($cancelar,'Cancelar');?>
    </div>
  </div>
</form>