<h3>Mis Partner</h3> 
<?php
setlocale(LC_MONETARY, 'en_US');

$visitas_total = 0;
$ingresos_total = 0;
?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Cuando más tiempo pase sin que actúes más dinero estás dejando de ganar</div>
    <table class="table table-striped" style="text-align: center">
        <tr>
            <td><a href="<?= base_url() ?>buspartner/index/id_partner">ID</td>
            <td><a href="<?= base_url() ?>buspartner/index/username">Username</td>
            <td><a href="<?= base_url() ?>buspartner/index/ingresos_actuales">Ingresos Actuales</td>
            <td><a href="<?= base_url() ?>buspartner/index/pag_vistas_actuales">Paginas vistas Actuales</td>
            <td><a href="<?= base_url() ?>buspartner/index/ultimo_pago"> Saldo Actual</td>
            <td><a href="<?= base_url() ?>buspartner/index/fecha_registro">Fecha</td>
            <td><strong>Act. Ingresos</strong></td>
            <td><strong>Editar</strong></td>
            <td><a href="<?= base_url() ?>buspartner/index/estado">Estado</td>
            <td><strong>Pagar MES</strong></td>
           
        </tr>

        <?php foreach ($partner as $partner_item): ?>
            <?php if ($partner_item['estado'] === '0') { ?>
                <tr class="danger">
                <?php } elseif ($partner_item['ingresos_actuales'] >= 50) { ?>
                <tr class="success">
                <?php } else { ?>
                <tr> 
                <?php } ?>
                <td><?= $partner_item['id_partner']; ?></td>
                <td><?= $partner_item['username']; ?> <br /> <?= $partner_item['correo_pago']; ?></td>

                <td><p class="bg-success"><?= money_format('%i', $partner_item['ingresos_actuales']) ?></p></td>
                <td><small> <strong>AD:</strong> <?= number_format($partner_item['impresiones_actual'], 0, ",", ".") ?><br />
                        <strong>VP:</strong> <?= number_format($partner_item['pag_vistas_actuales'], 0, ",", ".") ?> </small></td>
                <td><p class="text-primary"><?= money_format('%i', $partner_item['ultimo_pago']) ?> </p>
                
                    <a href="<?= base_url() ?>buspartner/done_paypal/<?php echo $partner_item['username'] . "/" . $partner_item['ultimo_pago'] ?>"><button class="btn-info">
                            Paypal
                        </button></a>
                    
                </td>
                <td><?= $partner_item['fecha_registro']; ?></td>
                <td><a href="<?= base_url() ?>buspartner/plus_money/<?= $partner_item['username']; ?>"><button class="btn-success">
                            <span class="glyphicon glyphicon-usd"></span>
                        </button></a></td>
                <td><a href="<?= base_url() ?>buspartner/edit_partner/<?= $partner_item['username']; ?>"><button class="btn-info">  <span class="glyphicon glyphicon-edit"></span></button></a> </td>
                <td><?php if ($partner_item['estado'] === '0') { ?>
                        <a href="<?= base_url() ?>buspartner/update_estado/<?= $partner_item['username']; ?>/1"><button class="btn-danger">
                                <span class="glyphicon glyphicon-ban-circle"></span>
                            </button></a>
                    <?php } else { ?>
                        <a href="<?= base_url() ?>buspartner/update_estado/<?= $partner_item['username']; ?>/0"><button class="btn-primary">
                                <span class="glyphicon  glyphicon-ok"></span>
                            </button></a>
                    <?php } ?> </td>
                <td><a href="<?= base_url() ?>buspartner/confirmar_mes/<?php echo $partner_item['username'] . "/" . $partner_item['ingresos_actuales'] . "/" . $partner_item['pag_vistas_actuales'] ."/".$partner_item['impresiones_actual'] ?>"><button class="btn-warning">
                            Pagar MES
                        </button></a></td>
                
                <?php
                $visitas_total += $partner_item['impresiones_actual'];
                $ingresos_total += $partner_item['ingresos_actuales']
                ?>
            </tr>
        <?php endforeach; ?>


    </table>
</div>
<?= $this->pagination->create_links() ?>
<div class="row">
    <div class="col-md-4">
        <a class="btn btn-success" href="<?= base_url() ?>buspartner/form_buspartner"><span class="glyphicon glyphicon-plus"></span>Partner</a>
    </div>
    <div class="col-md-4"> Visitas Totales: <p class="text-info"><?= number_format($visitas_total, 0, ",", ".") ?> </p></div>

    <div class="col-md-4">
        Total a pagar: <p class="text-primary"><?= money_format('%i', $ingresos_total) ?></p>
    </div>

</div>