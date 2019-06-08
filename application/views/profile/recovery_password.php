<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  echo validation_errors();
  $attributes = array('id' => 'update',
                        'class'=>'form-horizontal');
  echo form_open('profile/check_new_pass', $attributes);
  echo form_fieldset('Recuperar Contraseña');
  $label = array('class' => 'control-label');

 
  $password = array(
                  'name' => 'password',
                  'id' => 'password',);
          
  $re_password = array(
                  'name' => 're_password',
                  'id' => 're_password',);
          

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Actualizar' );

?>
  
  <div class="control-group">
    <?=form_label('Nueva contraseña','',$label);?>
    <div class="controls">
      <?=form_password($password);?>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('Reperir nueva contraseña','',$label);?>
    <div class="controls">
      <?=form_password($re_password);?>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php 
      echo form_hidden('username', $username);
      echo form_hidden('code', $code);
      echo form_submit($submit);?>
    </div>
  </div>
    <?=form_fieldset_close()?>
</form>