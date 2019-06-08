<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3>Admin categoria</h3>
<table class="table table-striped">
	<tr>
		<td><strong>ID Categoria</strong></td>
		<td><strong>Nombre de categoria</strong></td>
		<td><strong>Editar</strong></td>
		<td><strong>Eliminar</strong></td>
	</tr>
	
		<?php foreach ($categoria as $categoria_item):?>
		<tr>
		  		<td><?=$categoria_item['id_categoria']?></td>
                <td><?=$categoria_item['nombre_categoria']?></td>
				
				<td> <a class="btn btn-info" href="<?=base_url()?>categoria/form_editar/<?=$categoria_item['id_categoria']?>"><span class="glyphicon glyphicon-edit"></span></a> </td>
				<td> <a class="btn btn-danger" href="<?=base_url()?>categoria/delete_categoria/<?=$categoria_item['id_categoria']?>" onclick="return confirmar('Esta seguro que quiere eliminar este usuario ?')"><span class="glyphicon glyphicon-remove-circle"></span></a> </td>
 	   </tr>
			 
        <?php endforeach;?>
	
</table>
<a class="btn btn-success" href="<?=base_url()?>categoria/form_add"><span class="glyphicon glyphicon-plus"></span> Categoria</a>
