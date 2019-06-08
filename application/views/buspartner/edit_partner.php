<h3>Editar Partner</h3>
<hr/>

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if(isset($partner)){       
        $username = $partner['username'];
        $correo = $partner['correo_pago'];
        $ingresos_actuales = $partner['ingresos_actuales'];
        $ultimo_pago = $partner['ultimo_pago'];
  }
  else{
        $username = set_value('username');
        $correo = set_value('correo_pago');
        $ingresos_actuales = set_value('ingresos_actuales');
        $ultimo_pago = set_value('ultimos_ingresos');
  }
  $attributes = array('id' => 'edit_par',
                        'class'=>'form-horizontal');
  echo form_open_multipart('buspartner/check_update_part', $attributes);


  $label = array('class' => 'control-label');

  $username = array(
                  'name' => 'username',
                  'id' => 'inputusename',
                  'class' => 'form-control',
                  'placeholder' => 'username',
                  'value' => $username);
  $correo = array(
                  'name' => 'correo_pago',
                  'id' => 'inputemail',
                  'class' => 'form-control',
                  'placeholder' => 'E-mail',
                  'value' => $correo);
 
  $ingresos_actuales = array(
                  'name' => 'ingresos_actuales',
                  'id' => 'inputingresos_actuales',
                  'class' => 'negro',
                  'placeholder' => 'ingresos_actuales',
                  'value' => $ingresos_actuales);

  $ultimo_pago = array(
                  'name' => 'ultimo_pago',
                  'id' => 'inputultimo_pago',
                  'class' => 'negro',
                  'placeholder' => 'ultimo_pago',
                  'value' => $ultimo_pago);

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Actualizar' );
  $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick'=>"location.href='../buspartner'");

?>
  
  
  <div class="control-group">
    <?=form_label('Username','',$label);?>
    <div class="controls">
      <?=form_input($username);?>

      <p class="text-error"><?=strip_tags(form_error('username')) ?></p>
    </div>
  </div>
<div class="control-group">
    <?=form_label('Correo de Paypal','',$label);?>
    <div class="controls">
      <?=form_input($correo);?>
      <p class="text-error"><?=strip_tags(form_error('correo')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('Ingresos Actuales','',$label);?>
    <div class="controls">
      <?=form_input($ingresos_actuales);?>
    </div>
  </div>

  <div class="control-group">
    <?=form_label('ultimos pagos','',$label);?>
    <div class="controls">
      <?=form_input($ultimo_pago);?>
      <p class="text-error"><?=strip_tags(form_error('ultimo_pago')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php 
      echo form_hidden('yoPartner', $partner['username']);
      echo form_submit($submit);
      echo form_button($cancelar,'Cancelar');?>
    </div>
  </div>
</form>