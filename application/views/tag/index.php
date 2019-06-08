<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3>Admin Etiquetas</h3>
<table class="table table-striped">
    <tr>
        <td><strong>ID Tag</strong></td>
        <td><strong>Nombre de Tag</strong></td>
        <td><strong>Editar</strong></td>
        <td><strong>Eliminar</strong></td>
    </tr>

    <?php foreach ($tag as $tag_item): ?>
        <tr>
            <td><?= $tag_item['id_etiqueta'] ?></td>
            <td><?= $tag_item['nombre_etiqueta'] ?></td>

            <td> <a class="btn btn-info" href="<?= base_url() ?>tag/form_editar/<?= $tag_item['id_etiqueta'] ?>"><span class="glyphicon glyphicon-edit"></span></a> </td>
            <td> <a class="btn btn-danger" href="<?= base_url() ?>tag/delete_tag/<?= $tag_item['id_etiqueta'] ?>" onclick="return confirmar('Esta seguro que quiere eliminar este usuario ?')"><span class="glyphicon glyphicon-remove-circle"></span></a> </td>
        </tr>

    <?php endforeach; ?>

</table>
<a class="btn btn-success" href="<?= base_url() ?>tag/form_add"><span class="glyphicon glyphicon-plus"></span> Tag</a>
