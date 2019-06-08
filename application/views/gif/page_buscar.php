<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h3><?= $encabezado ?></h3>

<h4>Users</h4>
<hr/>
<section class="row">

    <?php
    if (isset($dato_user) && $dato_user != 0) {
        foreach ($dato_user as $user_item):
            ?>
            <article class="col-lg-3">
                <div class="thumbnail">
                    <ul>
                        <li><strong><?= anchor('profile/user/' . $user_item['username'], $user_item['username']) ?></strong></li>

                        <li class ="muted "><span class="
                                                  glyphicon glyphicon-star-empty"></span>: <?php echo $user_item['estrellas'] ?></li>
                        <li class ="muted "><?php echo $user_item['fecha_registro'] ?></li>
                        <li class ="muted "><?php echo $user_item['ubicacion'] ?></li>
                    </ul>
                </div>
            </article>
        <?php endforeach ?>

    <?php } ?>  
</section>

<h4>Gifs</h4> 
<hr />

<section class="row">
    <?php
    if (isset($datos) && $datos != 0) {
        foreach ($datos as $datos_item):
            ?>
            <article class="col-lg-3">
                <div class="thumbnail">
                    <strong><?= anchor('profile/user/' . $datos_item['username'], $datos_item['username']) ?></strong>
                    
                     <?php if ($end == 1) { ?>  
                    <h5 title="<?= $datos_item['titulo'] ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h5>
                <?php } ?>
                    
                    
                    <a class = 'thumbnail' href="<?= base_url() ?>gifs/view/<?= $datos_item['imagen'] ?>"><img src= "<?= base_url() ?>uploads/thumbs/<?= $datos_item['imagen'] ?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" alt="<?= $datos_item['titulo']; ?>" width="150" height="100" title ="<?= $datos_item['titulo'] ?>"/></a>
                    <?= anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?>
                    <br /><strong class ="muted"><span class="glyphicon glyphicon-eye-open"></span><?php echo ' : ' . $datos_item['vista'] ?></strong> 
                    <br /><?php echo $datos_item['fecha'] ?></b>

                </div>
            </article>
        <?php endforeach ?>
    <?php } ?>   
</section>


<div class="col-lg-12" style="text-align:center">

    <?= $this->pagination->create_links() ?>
</div>
