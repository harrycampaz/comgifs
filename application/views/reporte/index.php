<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<h3>Reportes</h3> 
<table class="table table-striped">
	<tr>
		<td><a href="<?=base_url()?>reporte/index/id_pena">ID_reporte</a></td>
		<td>Reporte</td>
		<td><a href="<?=base_url()?>reporte/index/username">Username</a></td>
		<td><a href="<?=base_url()?>reporte/index/fecha_suspencion">Fecha</td>
	</tr>
	<?php foreach ($reporte as $reporte_item): ?>
	<tr>
		<td><?=$reporte_item['id_pena']?></td>
		<td><?=$reporte_item['reporte']?></td>
		<td><a href="<?=base_url()?>profile/user/<?=$reporte_item['username']?>"><?=$reporte_item['username']?></a></td>
		<td><?=$reporte_item['fecha']?></td>
	</tr>
	<?php endforeach; ?>

</table>