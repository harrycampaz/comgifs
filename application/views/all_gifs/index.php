<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<h3>Todas las gifs</h3> 
<table class="table table-striped">
    <tr>
        <td><a href="<?= base_url() ?>all_gifs/index/id_imagen">ID</td>
        <td><a href="<?= base_url() ?>all_gifs/index/titulo">Titulo</td>
        <td><strong>Gifs</strong></td>
        <td><a href="<?= base_url() ?>all_gifs/index/video"><strong>Video</strong></a></td>
        <td><a href="<?= base_url() ?>all_gifs/index/username">Autor</td>
        <td><a href="<?= base_url() ?>all_gifs/index/nombre_categoria">Categoria</td>
        <td><a href="<?= base_url() ?>all_gifs/index/fecha">Fecha</td>
        <td><a href="<?= base_url() ?>all_gifs/index/vista">Vistas</td>
        <td><strong>Editar</strong></td>
        <td><strong>Eliminar</strong></td>
    </tr>

<?php foreach ($gifs as $gifs_item): ?>
        <tr>
            <td><?= $gifs_item['id_imagen'] ?></td>
            
            <td><?= $gifs_item['titulo'] ?></td>
            <td><a href="<?= base_url() ?>gifs/view/<?= $gifs_item['imagen'] ?>"><img src="<?= base_url() ?>uploads/thumbs/<?= $gifs_item['imagen'] ?>" height="100" width="100" alt="<?= $gifs_item['titulo'] ?>"></a></td>
            
            <td>
                <?php if (isset($gifs_item['video'])) { ?>
                <p class="text-success"><span class="glyphicon glyphicon-ok"></span></p>
                    <?php } else {
                    ?>
                    <p class="text-error"><span class="glyphicon glyphicon-ban-circle"></span></p>
    <?php } ?>

            </td>

            <td><?= anchor('all_gifs/user_gifs/' . $gifs_item['username'], $gifs_item['username']) ?></td>
            <td><?= $gifs_item['nombre_categoria'] ?></td>
            <td><?= $gifs_item['fecha'] ?></td>
            <td><?= $gifs_item['vista'] ?></td>

            <td> <a class="btn btn-info" href="<?= base_url() ?>gifs/editar_gif/<?= $gifs_item['imagen'] ?>"><span class="glyphicon glyphicon-edit"></span> </a> </td>
            <td> <a class="btn btn-danger" href="<?= base_url() ?>gifs/delete_gif/<?= $gifs_item['imagen'] ?>" onclick="return confirmar('Estas seguro que deseas eliminar este gif ?')"><span class="glyphicon glyphicon-remove-circle"></span> </a> </td>
        </tr>

<?php endforeach; ?>

</table>
<?= $this->pagination->create_links() ?>
<div class="col-lg-12">
<a class="btn btn-success" href="<?= base_url() ?>gifs/subir_gif"><span class="glyphicon glyphicon-plus"></span>  Gifs</a>
</div>