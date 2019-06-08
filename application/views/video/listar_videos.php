<table class="table table-condensed">

    <tr>
        <td><a href="<?= base_url() ?>videos/listar/id_video">ID</td>       
        <td><a href="<?= base_url() ?>videos/listar/titulo">Titulo</td>
       <td><a href="<?= base_url() ?>videos/listar/nombre_categoria">Categoria</td>
        <td><a href="<?= base_url() ?>videos/listar/vistas">Vitas</td>
        <td><a href="<?= base_url() ?>videos/listar/fecha">Fecha</td>
        <td></td>
        <td></td>
    </tr>

    <?php
    if (isset($datos)) {
        foreach ($datos as $datos_item):
            ?>
            <tr>
                <td><?php echo $datos_item['id_video'] ?></td>

                <td><?php echo substr($datos_item['titulo'], 0, 60) ?>..</td>
                <td><?php echo anchor('gifs/gifscategoria/' . $datos_item['id_categoria'], $datos_item['nombre_categoria']) ?></td>
                <td><?php echo $datos_item['vistas'] ?></td>
                <td><?php echo $datos_item['fecha'] ?></td>
                <td><a href="<?= base_url() ?>videos/editar_video/<?php echo $datos_item['enlace'] ?>" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></td>
                <td><a href="<?= base_url() ?>videos/borrar/<?php echo $datos_item['enlace'] ?>"  class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></td>

            </tr>

        <?php endforeach ?>

    <?php } ?> 

</table>
<div class="col-lg-12" style="text-align:center">

    <?= $this->pagination->create_links() ?>
</div>



