<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3>Admin User</h3>
<table class="table table-striped">
    <tr>
        <td><a href="<?= base_url() ?>user/index/id_user">ID</a></td>
        <td><a href="<?= base_url() ?>user/index/myname">Nombre</a></td>
        <td><a href="<?= base_url() ?>user/index/username">Username</a></td>
        <td><strong>Avatar</strong></td>
        <td><strong>email</strong></td>
        <td><strong>gifs</strong></td>
        <td><strong>Web</strong></td>
        <td><strong>Ubicacion</strong></td>
        <td><a href="<?= base_url() ?>user/index/estado">Estado</a></td>
        <td><a href="<?= base_url() ?>user/index/strike">#Strike</a></td>
        <td><a href="<?= base_url() ?>user/index/fecha_registro">Fecha</a></td>
        <?php if (isset($accion)) { ?>

            <td><a href="<?= base_url() ?>user/index/roles_id_rol">rol</a></td>
        <?php } else { ?>
            <td><strong>ROL</strong></td>
        <?php } ?>
        <td><a href="<?= base_url() ?>user/index/estrellas">Estrellas</a></td>
        <td><strong>Eliminar</strong></td>
    </tr> 

    <?php foreach ($users as $users_item): ?>
        <tr>
            <td><?= $users_item['id_user'] ?></td>
            <td><?= $users_item['myname'] ?></td>
            <?php if (isset($accion)) { ?>

                <td><a href="<?= base_url()?>user/edit_user/<?= $users_item['id_user'] ?>"><?= $users_item['username'] ?></a></td>
            <?php } else { ?>
                <td><?= $users_item['username'] ?></td>
            <?php } ?>
                <td><a href="<?= base_url() ?>profile/user/<?= $users_item['username'] ?>"><img src="<?= base_url() ?>avatar/<?=$users_item['avatar']?>" width="100" height="100"/></a> <br/> <a href="<?= base_url() ?>user/restaurar_avatar/<?=$users_item['id_user']?>">Restaurar</a> </td>
            <td><?= $users_item['email'] ?></td>
            <td><?= $users_item['gifs'] ?></td>
            <td><?= $users_item['website'] ?></td>
            <td><?= $users_item['ubicacion'] ?></td>
            <td><a class = 'btn' href="<?= base_url() ?>user/edit_estado/<?= $users_item['estado'] ?>/<?= $users_item['id_user'] ?>"><?= $users_item['estado'] ?></a></td>
            <td><a class = 'btn' href="<?= base_url() ?>user/sumar_strike/<?= $users_item['id_user'] ?>/<?= $users_item['strike'] ?>"><?= $users_item['strike'] ?></a>
            <hr />
            <a href="<?= base_url() ?>reporte/reportar/<?= $users_item['id_user'] ?>">Reportar</a>

            <a href="<?= base_url() ?>user/zero_strike/<?= $users_item['id_user'] ?>">Restaurar</a>
            </td>
            <td><?= $users_item['fecha_registro'] ?></td>
            <td><?= $users_item['rol'] ?></td>
            <td><?= $users_item['estrellas'] ?> 
                <a href="<?= base_url() ?>user/accion_estrella/sumar/<?= $users_item['id_user'] ?>">+</a>/
                <a href="<?= base_url() ?>user/accion_estrella/restar/<?= $users_item['id_user'] ?>">-</a>
            </td>
            <td> <a class="btn btn-danger" href="<?= base_url() ?>user/delete_user/<?= $users_item['username'] ?>" onclick="return confirmar('Esta seguro que quiere eliminar el Usuario')"><span class="glyphicon glyphicon-remove-circle"></span></a> </td>
        </tr>

    <?php endforeach; ?>

</table>
<?= $this->pagination->create_links() ?>

