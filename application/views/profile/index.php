<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h2 class="muted">Informacion Basica</h2>
<hr/>
<div class="col-lg-4">
	<img src="<?=base_url()?>/avatar/<?=$usuario['avatar']?>"/>
</div>
<div class="col-lg-4">
<ul>
		<li><strong> Mi Nombre:</strong> <?=$usuario['myname']?></li>
		<li><strong>Nombre de usuario:</strong> <?=$usuario['username']?></li>
		<li><strong>Correo electronico:</strong> <?=$usuario['email']?></li>
		<li><strong>Ubicacion: </strong><?=$usuario['ubicacion']?></li>
		<li><strong>Web site: </strong><a href="<?=$usuario['website']?>" target="_blank"><?=$usuario['website']?></a></li>
		<li><strong>Fecha de registro:</strong> <?=$usuario['fecha_registro']?></li>

	<?=anchor('profile/edit_user','Editar mi cuenta', array('title'=>'Editar mi cuenta'));?>
</ul>
</div>
<?php 
	if($numero > 0){
		echo anchor('profile/user/'.$usuario['username'],'Imagenes subidas : ', array('title'=>'Imagenes de'.$usuario['username']));
	?>
	<span class="badge badge-info"><?=$numero?></span>
<?php
	}
	else
	{
	?>
	<p class = 'text-info'>Imagenes subidas : <span class="badge badge-info"><?=$numero?></span></p>
	<?php
	}
	?>
<hr/>
<?=anchor('profile/update_password','Cambiar Contraseña', array('title'=>'Editar mi cuenta','class' =>'btn btn-warning',));?>
<hr/>
<div class="col-lg-10">
	
<hr />
<?=anchor('profile/delete_user/'.$usuario['username'],'Eliminar Cuenta', array('title'=>'Eliminar mi cuenta','onclick'=>"return confirmar('Esta seguro que desea eliminar su cuenta?')"));?>
</div>