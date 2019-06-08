<?php
setlocale(LC_MONETARY, 'en_US');
?>
<hr />
<div class="row">
    <div class="col-md-4">
        <h4>Ingresos este MES</h4>

        <strong class="text-success"><?= money_format('%i', $ingresos) ?></strong>

    </div>
    <div class="col-md-4"><h4>Paginas vistas</h4>
        <p><?= number_format($pag_vistas, 0, ",", ".") ?></p>
    </div>
    
    <div class="col-md-4"><h4>Impresiones AD</h4>
        <p><?= number_format($impresiones_actual, 0, ",", ".") ?></p>
    </div>
    
    <div class="col-md-4"> <h4>Partner</h4> 
        <strong class="text-info"><?=$partner?></strong>
    </div>
</div>

<a href="<?= base_url() ?>buspartner/pagar_money/<?php echo $partner. "/" . $ingresos . "/" . $pag_vistas . "/". $impresiones_actual ?>" onclick="return confirmar('Estas seguro que deseas deseas hacer la transación ?')"><button class="btn-warning">
                            Pagar
                        </button></a>
