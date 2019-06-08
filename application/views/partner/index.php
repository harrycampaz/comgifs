<div class="row">
    <div class="col-lg-6">
        
    </div>
    <div class="col-lg-6">
        <h4>Correo de Paypal:</h4><?= $datos['correo_pago'] ?> <a href="<?= base_url() ?>partner/edit_correo"> - Editar</a>
    </div>
</div>
<?php
setlocale(LC_MONETARY, 'en_US');
?>
<hr />
<div class="row">
    <div class="col-md-4">
        <h4>Ingresos actuales <abbr title="Los ingresos se actualizan a las 13:00 Hora Miami(GMT-4) de cada dia" class="initialism">
                <span class="glyphicon glyphicon-question-sign"></span></abbr></h4>

        <strong class="text-success"><?= money_format('%i', $datos['ingresos_actuales']) ?></strong>
        <p class="bg-info">Actualización: <?= date("Y-m-d", strtotime($datos['act_ingresos'])) ?></p>
    </div>
    
    <div class="col-md-4"><h4>Visitas a la página<abbr title="Este mes" class="initialism">
                <span class="glyphicon glyphicon-question-sign"></span></abbr></h4>

        <p><?= number_format($datos['impresiones_actual'], 0, ",", ".") ?></p>
    </div>
    <div class="col-md-4"> <h4>Saldo actual. </h4> 
        <strong class="text-info"><?= money_format('%i', $datos['ultimo_pago']) ?></strong>
    </div>
</div>

<div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading">
        Ingresos de los ultimos 7 dias
    </div>


    <table class="table table-striped" style="text-align: center">
        <tr>
            <td><a href="<?= base_url() ?>partner/index/valor_pago_dia">Ingresos obtenidos </td>
            <td><a href="<?= base_url() ?>partner/index/pag_vistas_dia">Paginas vistas</td>
            <td><a href="<?= base_url() ?>partner/index/fecha_dia">Fecha</td>

        </tr>

        <?php
        if (isset($historial_dia)) {

            foreach ($historial_dia as $dia_item):
                ?>
                <tr>
                    <td>
                      
                            <p class="bg-success">
                           
                            <?= money_format('%i', $dia_item['valor_pago_dia']) ?>
                        </p>
                    </td>
                    <td><?= number_format($dia_item['impresiones_dia'], 0, ",", ".") ?></td>
                    <td><?= date("Y-m-d", strtotime($dia_item['fecha_dia'])) ?></td>
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
</div>

<hr />
<br/>
<div class="panel panel-default"> 
    <!-- Default panel contents -->
    <div class="panel-heading">
        Pago más reciente
    </div>


    <table class="table table-striped" style="text-align: center">
        <tr>
            <td>Saldo</td>
            <td>Fecha</td>

        </tr>

        <?php
        if (isset($historial_pagos)) {

            foreach ($historial_pagos as $pago_item):
                ?>
                <tr>
                    <td>

                        <p class="bg-success">

                            <?= money_format('%i', $pago_item['valor_pago']) ?>
                        </p>
                    </td>

                    <td><?= date("Y-m-d", strtotime($pago_item['fecha_pago'])) ?></td>
                </tr>
                <?php
            endforeach;
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                <p>No hay pagos registrados.</p>
            </div>
        <?php } ?>
</div>

</table>