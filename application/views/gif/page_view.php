<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ($end != 1) { ?>  

    <header><h1><?= $encabezado ?></h1></header>
<?php } else {
    ?>

    <header><h2><?= $encabezado ?></h2></header>
<?php } ?>

<section>



    <hr />

    <?php
    if (isset($datos)) {
        foreach ($datos as $datos_item):
            ?>

            <article class="col-lg-3">
                <div class="thumbnail">
                    <strong><?= anchor('profile/user/' . $datos_item['username'], $datos_item['username']) ?></strong>
 <?php if ($end == 1) { ?>  
                    <h6 title="<?= $datos_item['titulo']; ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h6>
                <?php } ?>
                    <a class = 'thumbnail' href="<?= base_url() ?>gifs/view/<?= $datos_item['imagen'] ?>">
                        <img src= "<?= base_url() ?>uploads/thumbs/<?= $datos_item['imagen'] ?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" alt="<?= $datos_item['titulo']; ?>" width="150" height="100" rel="tooltip" title ="<?= $datos_item['titulo'] ?>"/></a>

                    <?= anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?>
                    <br /><strong class ="muted"> <span class="glyphicon glyphicon-eye-open"></span><?php echo ' : ' . $datos_item['vista'] ?></strong>
                    <br /><b class ="muted"><?php echo $datos_item['fecha'] ?></b>


                </div>
            </article>
        <?php endforeach ?>

    <?php } ?>  
</section>  

<div class="col-lg-12" style="text-align:center">

    <?= $this->pagination->create_links() ?>
</div>
