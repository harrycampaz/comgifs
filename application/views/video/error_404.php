<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h2>La imagen <?=$video_error?> no se encuentra</h2>
<?php echo anchor(base_url(),$home, array('title'=>'Inicio', 'class' => 'btn btn-danger btn-large'))?>
<?php if ($end != 1) { ?>  
<header>
<h3><?=$more?> Videos</h3></header>
<?php } 
else { ?>
<header>
<h3><strong><?=$more?> Videos</strong></h3></header>
<?php } ?>
 <hr />
 
     <?php
if (isset($datos)) {
    foreach ($datos as $datos_item):
        ?>
        <article class="col-lg-6">

            <a href="<?php echo base_url() . 'videos/view/' . $datos_item['enlace'] ?>">
                <div class="thumbnail" style="text-align: center">
                    <?php if ($end == 1) { ?>  
                        <h4 title="<?= $datos_item['titulo']; ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h4>
                    <?php } else { ?>
                        <h5 title="<?= $datos_item['titulo']; ?>"><?php echo substr($datos_item['titulo'], 0, 40) ?>..</h5>
                    <?php } ?>                   
                    <?php echo $datos_item['video'] ?>
                </div>
                </a>
                  <?= anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?>
                    <strong class ="muted"> | <span class="glyphicon glyphicon-eye-open"></span><?php echo ' : ' . $datos_item['vistas'] ?></strong>
                    <b class ="muted"> | <?php echo $datos_item['fecha'] ?></b>
            <hr/>
        </article>

    <?php endforeach ?>

<?php } ?> 