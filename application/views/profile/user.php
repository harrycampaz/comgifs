<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h2 class="muted">Perfil</h2>
<hr/>

	<div class="col-lg-4">
		<img src="<?=base_url()?>/avatar/<?=$usuario['avatar']?>"<img/>
	</div>
	<div class="col-lg-6">
		<ul>
		
			<li><strong>Mi Nombre:</strong> <?=$usuario['myname']?></li>
			<li><strong>Nombre de usuario:</strong> <?=$usuario['username']?></li>
			<li><strong>Ubicacion: </strong><?=$usuario['ubicacion']?></li>
			<li><strong>Web site: </strong><a href="<?=$usuario['website']?>" target="_blank"><?=$usuario['website']?></a></li>
			<li><strong>Fecha: </strong><?=$usuario['fecha_registro']?></li>
			<li><strong>Estrellas: 

            <?php for($i = 0 ; $i < $usuario['estrellas']; $i++) {?>

                <span class="glyphicon glyphicon-star-empty"></span>
            <?php } ?>

            </li>

			<li><span class="badge badge-info">Gif : <?=$numero?></span></li>
	</ul>
</div>


<div class="col-lg-12">
<hr />
<?php if($numero > 0) { ?>
 
      
        <?php foreach ($datos as $datos_item): ?>
           <div class="col-lg-3">
                <div class="thumbnail">
                        
                        <?= anchor('gifs/gifscategoria/'.$datos_item['id_categoria'],$datos_item['nombre_categoria'])?>
                    
                    <?php if ($end == 1) { ?>  
                    <h5 title="<?= $datos_item['titulo'] ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h5>
                <?php } ?>
                    
                    
                        
                        <a class = 'thumbnail' href="<?=base_url()?>gifs/view/<?=$datos_item['imagen']?>"><img src= "<?=base_url()?>uploads/thumbs/<?=$datos_item['imagen']?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" title ="<?=$datos_item['titulo']?>"/></a>
                        <?php
                        if(isset($accion)){?>
                        <p>
                            <a class="btn btn-info" href="<?=base_url()?>gifs/editar_gif/<?=$datos_item["imagen"]?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <a class="btn btn-danger" href="<?=base_url()?>gifs/delete_gif/<?=$datos_item["imagen"]?>" onclick="return confirmar('Esta seguro que desea eliminar este GIF ?')"><span class="glyphicon glyphicon-remove-circle"></span></a> 
                        </p>
                        <?php } ?>
						<strong class ="muted"> <span class="glyphicon glyphicon-eye-open"></span><?php echo ' '.$datos_item['vista']?></strong>
						<p class ="muted"><i class="icon-time"></i> <?php echo $datos_item['fecha']?></p>
                    </div>
           </div>
           
        <?php endforeach?>
        
    </ul>
    <?=$this->pagination->create_links()?>
    <?php } 
    else {?>
    	<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>No hay GIFS</strong></div>

    <?php }
    ?>
</div>