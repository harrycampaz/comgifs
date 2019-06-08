<h3>Historial por Mes</h3> 
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<div class="panel panel-default"">
    <!-- Default panel contents -->
    <div class="panel-heading">Un lider es alguien que conoce el camino, anda el camino y muestra el camino</div>
    <table class="table table-striped" style="text-align: center">
        <tr>
            <td><a href="<?= base_url() ?>historial_mes/index/id_historial_mes">ID</td>
            <td><a href="<?= base_url() ?>historial_mes/index/mes_username">Username</td>
            <td><a href="<?= base_url() ?>historial_mes/index/valor_pago_mes">Valor pago mes</td> 
                   <td><a href="<?= base_url() ?>historial_mes/index/fecha_mes">Fecha/Hora</td>
            <td><a href="<?= base_url() ?>historial_mes/index/pag_vistas_mes">Visitas por mes</td>          
     

            <td><strong>Editar</strong></td>
        </tr>
        <?php foreach ($mes as $mes_item): ?>     
            <tr> 

                <td><?= $mes_item['id_historial_mes']; ?></td>
                <td><?= $mes_item['mes_username']; ?></td>
                <td><p class="bg-success"><?= money_format('%i', $mes_item['valor_pago_mes']) ?></p></td>     
                <td><?= $mes_item['fecha_mes']; ?></td>
                 <td><small> <strong>AD:</strong> <?= number_format($mes_item['impresiones_mes'], 0, ",", ".") ?><br />
                        <strong>VP:</strong> <?= number_format($mes_item['pag_vistas_mes'], 0, ",", ".") ?> </small></td>

                <td><a href="<?= base_url() ?>historial_mes/editar_mes/<?= $mes_item['id_historial_mes']; ?>"><button class="btn-info">  <span class="glyphicon glyphicon-edit"></span></button></a> </td>                
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->pagination->create_links() ?>