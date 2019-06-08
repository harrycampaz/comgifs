<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ($end != 1) { ?>  

    <header><h1><?= $encabezado ?></h1></header>
<?php } else {
    ?>

    <header><h2><?= $encabezado ?></h2></header>
<?php } ?>

<hr/>



<?php
if (isset($datos)) {
    foreach ($datos as $datos_item):
        ?>
        <article class="col-lg-4">

            <a  href="<?php echo base_url() . 'videos/view/' . $datos_item['enlace'] ?>">
                <div style="text-align: center">
                    <?php if ($end == 1) { ?>  
                        <h5 title="<?= $datos_item['titulo']; ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h5>

                        <?php
                        if ($datos_item['avatar_video']) {
                            echo '<img src="' . $datos_item['avatar_video'] . '" class="img-responsive"/>';
                        } else {
                            ?>
                            <img src="http://static.djbooth.net/pics-artist/bowwow.jpg" class="img-responsive" />
                        <?php } ?>
                    <?php } else { ?>
                        <h5 title="<?= $datos_item['titulo']; ?>"><?php echo substr($datos_item['titulo'], 0, 30) ?>..</h5>

                        <?php
                        if ($datos_item['avatar_video']) {
                            echo '<img src="' . $datos_item['avatar_video'] . '" height="200" width="200"/>';
                        } else {
                            ?>
                            <img src="http://static.djbooth.net/pics-artist/bowwow.jpg" height="200" width="200" />
                        <?php } ?>
                    <?php } ?>  
                </div>
            </a>
            <?= anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?>
            <strong class ="muted"> | <span class="glyphicon glyphicon-eye-open"></span><?php echo ' : ' . $datos_item['vistas'] ?></strong>
            <b class ="muted"> | <?php echo $datos_item['fecha'] ?></b> |  <a href="<?php echo base_url() . 'videos/view/' . $datos_item['enlace'] ?>">Ver</a>
            <hr/>
        </article>

    <?php endforeach ?>

<?php } ?> 

<div class="col-lg-12" style="text-align:center">

    <?= $this->pagination->create_links() ?>
</div>
