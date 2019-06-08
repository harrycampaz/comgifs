
<div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading">
        Ingresos de los ultimos 7 meses
    </div>


    <table class="table table-striped" style="text-align: center">
        <tr>
            <td><a href="<?= base_url() ?>partner/index/valor_pago_mes">Ingresos obtenidos </td>
            <td><a href="<?= base_url() ?>partner/index/pag_vistas_mes">Paginas vistas</td>
            <td><a href="<?= base_url() ?>partner/index/fecha_mes">Fecha</td>

        </tr>

        <?php
        if (isset($historial_meses)) {

            foreach ($historial_meses as $mes_item):
                ?>
                <tr>
                    <td>
                        <?php if ($mes_item['valor_pago_mes'] >= 50) { ?>
                            <p class="bg-success">
                            <?php } else { ?>
                            <p class="bg-danger">
                            <?php } ?>
                            <?= money_format('%i', $mes_item['valor_pago_mes']) ?>
                        </p>
                    </td>
                    <td><?= number_format($mes_item['impresiones_mes'], 0, ",", ".") ?></td>
                    <td><?= date("Y-m", strtotime($mes_item['fecha_mes'])) ?></td>
                </tr>
                <?php
            endforeach;
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                <p>Historial Vació.</p>
            </div>
        <?php } ?>
</div>

</table>