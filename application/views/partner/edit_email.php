<h3>Editar correo de Pago</h3>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');

        if (isset($correo_paypal)) {
            $correo = $correo_paypal;
        } else {
            $correo = set_value('correo_pago');
        }
        echo validation_errors();
        $attributes = array('id' => 'plus_dia',
            'class' => 'form-horizontal');
        echo form_open('partner/check_paypal_mail', $attributes);

        $correo = array(
            'name' => 'correo_pago',
            'id' => 'correo_pago',
            'class' => 'form-control',
            'placeholder' => 'Correo para Pago',
            'value' => $correo);
        $submit = array(
            'name' => 'enviar',
            'id' => 'enviar',
            'value' => 'Actualizar',
            'class' => 'btn btn-info');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../partner'");
        echo form_input($correo);
        echo form_submit($submit);
        ?><br/><br/>
        <?php
        echo form_button($cancelar, 'Cancelar');
        ?>
    </div>
</div>