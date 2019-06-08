<h3>Cargar dinero Actual de <?=$partner_hi?></h3>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'plus_dia',
            'class' => 'form-horizontal');
        echo form_open('buspartner/check_plus_money', $attributes);

        $username = array(
            'name' => 'money',
            'id' => 'money',
            'class' => 'form-control',
            'placeholder' => 'Dinero a Sumar');
       $impresiones = array(
            'name' => 'impresiones',
            'id' => 'impresiones',
            'class' => 'form-control',
            'placeholder' => 'Impresiones a Sumar');
        $submit = array(
            'name' => 'enviar',
            'id' => 'enviar',
            'value' => 'Sumar',
            'class' => 'btn btn-success');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../buspartner'");
        echo form_input($username);
         echo form_input($impresiones);
        echo form_hidden('partner_hi', $partner_hi);
        echo form_submit($submit);
        ?><br/><br/>
        <?php
        echo form_button($cancelar, 'Cancelar');
        ?>
    </div>
</div>