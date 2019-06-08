<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<h3>Todos los gifs</h3> 
<table class="table table-striped">
    <tr>
        <td><a href="<?= base_url() ?>partner/all_gifs/id_imagen">ID</td>
        <td><a href="<?= base_url() ?>partner/all_gifs/titulo">Titulo</td>
        <td><strong>Gifs</strong></td>
        <td><a href="<?= base_url() ?>partner/all_gifs/video"><strong>Video</strong></a></td>
        <td><a href="<?= base_url() ?>partner/all_gifs/nombre_categoria">Categoria</td>
        <td><a href="<?= base_url() ?>partner/all_gifs/fecha">Fecha</td>
        <td><a href="<?= base_url() ?>partner/all_gifs/vista">Vistas</td>
    </tr>

<?php foreach ($gifs as $gifs_item): ?>
        <tr>
            <td><?= $gifs_item['id_imagen'] ?></td>
            <td><?= $gifs_item['titulo'] ?></td>
            <td><a href="<?= base_url() ?>gifs/view/<?= $gifs_item['imagen'] ?>"><img src="<?= base_url() ?>uploads/thumbs/<?= $gifs_item['imagen'] ?>" height="100" width="100" alt="<?= $gifs_item['titulo'] ?>"></a></td>
            <td>
                <?php if (isset($gifs_item['video'])) { ?>
                <p class="text-success"><span class="glyphicon glyphicon-ok"></span> </p>
                        <?php
                }else { ?>
                <p class="text-error"> <span class="glyphicon glyphicon-ban-circle"></span> </p>
              <?php  }?>
                
            </td>
            <td><?= $gifs_item['nombre_categoria'] ?></td>
            <td><?= $gifs_item['fecha'] ?></td>
            <td><?= $gifs_item['vista'] ?></td>
        </tr>

<?php endforeach; ?>

</table>
<?= $this->pagination->create_links() ?>
<div class="col-lg-12">
<a class="btn btn-success" href="<?= base_url() ?>gifs/subir_gif"><span class="glyphicon glyphicon-plus"></span>  Gifs</a>
</div>