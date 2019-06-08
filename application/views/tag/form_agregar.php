<h3>Agregar Etiqueta</h3>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'add_etiqueta',
            'class' => 'form-horizontal');
        echo form_open('tag/add_tag', $attributes);

        $tag = array(
            'name' => 'tag',
            'id' => 'tag',
            'class' => 'form-control',
            'placeholder' => 'Etiqueta');
        $submit = array(
            'name' => 'enviar',
            'id' => 'enviar',
            'value' => 'Agregar',
            'class' => 'btn btn-success');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../tag'");
        echo form_input($tag);
        echo form_submit($submit);
        echo form_button($cancelar, 'Cancelar');
        ?>
    </div>
</div>