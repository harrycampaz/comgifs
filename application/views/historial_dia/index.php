<h3>Historial por Dias</h3> 
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<div class="panel panel-default"">
    <!-- Default panel contents -->
    <div class="panel-heading">Caerse esta permitido, levantarse es obligatorio </div>
    <table class="table table-striped" style="text-align: center">
        <tr>
            <td><a href="<?= base_url() ?>historial_dia/index/id_historial_dia">ID</td>
            <td><a href="<?= base_url() ?>historial_dia/index/dia_username">Username</td>
            <td><a href="<?= base_url() ?>historial_dia/index/valor_pago_dia">Valor pago</td>           
            <td><a href="<?= base_url() ?>historial_dia/index/fecha_dia">Fecha/Hora</td>

            <td><strong>Editar</strong></td>
        </tr>
        <?php foreach ($dia as $dia_item): ?>     
            <tr> 

                <td><?= $dia_item['id_historial_dia']; ?></td>
                <td><?= $dia_item['dia_username']; ?></td>

                <td><p class="bg-success"><?= money_format('%i', $dia_item['valor_pago_dia']) ?></p></td>

               
                <td><?= $dia_item['fecha_dia']; ?></td>

                <td><a href="#"><button class="btn-info">  <span class="glyphicon glyphicon-edit"></span></button></a> </td>                
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->pagination->create_links() ?>