<h3>Editar Perfil</h3>
<hr/>
<div class="row">
<div class="col-lg-5">

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if(isset($usuario)){
  		$name = $usuario['myname'];
  		$email = $usuario['email'];
  		$username = $usuario['username'];
  		$ubicacion = $usuario['ubicacion'];
      $website = $usuario['website'];
  }
  else{
  		$name =  set_value('name');
  		$email = set_value('email');
  		$username = set_value('username');
  		$ubicacion = set_value('ubicacion');
      $website = set_value('website');
  }
  $attributes = array('id' => 'register',
                        'class'=>'form-horizontal');
  echo form_open_multipart('profile/check_update', $attributes);

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
  

  $ubicacion = array(
                  'name' => 'ubicacion',
                  'id' => 'inputUbicacion',
                  'class' => 'form-control',
                  'placeholder' => 'Ubicacion/Place (Opcional)',
                  'value' => $ubicacion);

  $website = array(
                  'name' => 'website',
                  'class' => 'form-control',
                  'id' => 'inputwebsite',
                  'placeholder' => 'website (Opcional)',
                  'value' => $website);
  $userfile = array(
    'name' => 'userfile',
    'id' => 'upload',);

  $submit = array('type' => 'submit',
                  'class' => 'btn btn-primary',
                  'value' => 'Actualizar' );
  $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick'=>"location.href='../profile'");

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
    <?=form_label('Avatar','',$label);?>
    <div class="controls">
     <?=form_upload($userfile);?>
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
      <p class="text-error"><?=strip_tags(form_error('web_site')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <?=form_label('Notificar por E-mail las tendencias','',$label);?>
    <div class="controls">
      <select name="notificar">
        <option value="'0'">No</option>
        <option value="'1'">Yes</option>
      </select>
      <p class="text-error"><?=strip_tags(form_error('notificar')) ?></p>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <?php echo form_submit($submit);
      echo form_button($cancelar,'Cancelar');?>
    </div>
  </div>

</form>

</div>
</div>