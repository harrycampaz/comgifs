<h3>Editar Perfil</h3>
<hr/>

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if(isset($usuario)){
        $name = $usuario['myname'];
        $email = $usuario['email'];
        $username = $usuario['username'];
        $ubicacion = $usuario['ubicacion'];
        $website = $usuario['website'];
        $rol = $usuario['roles_id_rol'];
        $estrellas = $usuario['estrellas'];
  }
  else{
        $name =  set_value('name');
        $email = set_value('email');
        $username = set_value('username');
        $ubicacion = set_value('ubicacion');
        $website = set_value('website');
        $rol = set_value('website');
  }
  $attributes = array('id' => 'register',
                        'class'=>'form-horizontal');
  echo form_open_multipart('user/check_update', $attributes);


  $label = array('class' => 'control-label');

  $name = array(
                  'name' => 'name',
                  'id' => 'inputname',
                  'class' => 'form-control',
                  'placeholder' => 'Nombre',
                  'value' => $name);
  $email = array(
                  'name' => 'email',
                  'id' => 'inputemail',
                  'class' => 'form-control',
                  'placeholder' => 'E-mail',
                  'value' => $email);
  
  $username = array(
                  'name' => 'username',
                  'id' => 'inputUsername',
                  'class' => 'form-control',
                  'placeholder' => 'Username',
                  'value' => $username);
  
$estrellas = array(
                  'name' => 'estrellas',
                  'id' => 'estrellas',
                  'class' => 'negro',
                  'value' => $estrellas);
  $ubicacion = array(
                  'name' => 'ubicacion',
                  'id' => 'inputUbicacion',
                  'class' => 'negro',
                  'placeholder' => 'Ubicacion (Opcional)',
                  'value' => $ubicacion);

  $website = array(
                  'name' => 'website',
                  'id' => 'inputwebsite',
                  'class' => 'negro',
                  'placeholder' => 'website (Opcional)',
                  'value' => $website);

  $submit = array('type' => 'submit',
                  'class' => 'btn',
                  'value' => 'Actualizar' );
  $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick'=>"location.href='../user'");

?>
  <div class="control-group">
    <?=form_label('Nombre','',$label);?>
    <div class="controls">
      <?=form_input($name);?>
      <p class="text-error"><?=strip_tags(form_error('name')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('E-mail','',$label);?>
    <div class="controls">
      <?=form_input($email);?>
      <p class="text-error"><?=strip_tags(form_error('email')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('Username','',$label);?>
    <div class="controls">
      <?=form_input($username);?>

      <p class="text-error"><?=strip_tags(form_error('username')) ?></p>
    </div>
  </div>

  <div class="control-group">
    <?=form_label('Roles','',$label);?>
    <div class="controls">
      <?php
        echo form_dropdown('rol', $roles, $rol,"id='rol'");
      ?>
    </div>
  </div>

  <div class="control-group">
    <?=form_label('estrellas','',$label);?>
    <div class="controls">
      <?=form_input($estrellas);?>
    </div>
  </div>

  <div class="control-group">
    <?=form_label('Ubicacion','',$label);?>
    <div class="controls">
      <?=form_input($ubicacion);?>
      <p class="text-error"><?=strip_tags(form_error('ubicacion')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('Mi Website','',$label);?>
    <div class="controls">
      <?=form_input($website);?>
      <p class="text-error"><?=strip_tags(form_error('website')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php 
      echo form_hidden('id_user', $usuario['id_user']);
      echo form_submit($submit);
      echo form_button($cancelar,'Cancelar');?>
    </div>
  </div>
</form>

 