<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ($end != 1) { ?>  
 <header style="text-align:center">
        <h1><?= $welcome ?></h1>
    </header>
    <br />
    <h3><?= $most_viewed ?></h3>
<?php } else {
    ?>

    <strong><?= $most_viewed ?></strong>
<?php } ?>
<hr />
<div class="row"> 
<?php foreach ($most_view as $most_item):
    ?>
        <article class="col-lg-3">
            <div class="thumbnail">

                <h5><strong><?= anchor('profile/user/' . $most_item['username'], $most_item['username']) ?></strong></h5>
    <?php if ($end == 1) { ?>  
                    <h6 title="<?= $most_item['titulo'] ?>"><?php echo substr($most_item['titulo'], 0, 60) ?>..</h6>
                <?php } ?>


                <a class= "thumbnail" href="<?= base_url() ?>gifs/view/<?= $most_item['imagen'] ?>"><img src= "<?= base_url() ?>uploads/thumbs/<?= $most_item['imagen'] ?>"   alt="<?= $most_item['titulo'] ?>"  data-src="holder.js/160x120" style="width: 160px; height: 120px;" title ="<?= $most_item['titulo'] ?>"/></a>
                <h4> <?= anchor('gifs/gifscategoria/' . $most_item['id_categoria'], $most_item['nombre_categoria']) ?></h4>
                <strong class ="muted"><span class="glyphicon glyphicon-eye-open"></span> <?php echo ' : ' . $most_item['vista'] ?></strong>
                <br /><b class ="muted"> <?php echo $most_item['fecha'] ?></b>

            </div>
        </article>
<?php endforeach ?>
</div>
    <?php
    $attributes = array('id' => 'mas_vistos',
        'class' => 'form-horizontal');
    echo form_open('gifs/destacado', $attributes);
    $mas_vistos = array(
        'name' => 'mas_visto',
        'id' => 'mas_visto',
        'value' => $more,
        'class' => 'btn btn-primary');
    echo form_submit($mas_vistos);
    ?>
</form>

<?php if ($end != 1) { ?>  
   
    <h3><?= $most_recent ?></h3>
<?php } else {
    ?>

    <header><strong><?= $most_recent ?></strong></header>
<?php } ?>
<hr />
<div class="row">

    <?php foreach ($datos as $datos_item): ?>
        <article class="col-lg-3">
            <div class="thumbnail">
                <h5><strong><?= anchor('profile/user/' . $datos_item['username'], $datos_item['username']) ?></strong></h5>
    <?php if ($end == 1) { ?>  
                    <h6 title="<?= $datos_item['titulo'] ?>"><?php echo substr($datos_item['titulo'], 0, 60) ?>..</h6>
                <?php }
                ?>

                <a class = 'thumbnail' href="<?= base_url() ?>gifs/view/<?= $datos_item['imagen'] ?>"><img src= "<?= base_url() ?>uploads/thumbs/<?= $datos_item['imagen'] ?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" alt="<?= $datos_item['titulo']; ?>" title ="<?= $datos_item['titulo'] ?>"/></a>
                <h4><?= anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?></h4>
                <strong class ="muted"> <span class="glyphicon glyphicon-eye-open"></span> <?php echo ' : ' . $datos_item['vista'] ?></strong>
                <br/><b class ="muted"><?php echo $datos_item['fecha'] ?></b>
            </div>
        </article>
<?php endforeach ?>

</div>

<?php
$attributes = array('id' => 'ver_nuevos',
    'class' => 'form-horizontal');
echo form_open('gifs/ultimos', $attributes);
$ver_nuevos = array(
    'name' => 'ver_nuevo',
    'id' => 'ver_nuevo',
    'value' => $more,
    'class' => 'btn btn-primary');
echo form_submit($ver_nuevos);
?>
</form>