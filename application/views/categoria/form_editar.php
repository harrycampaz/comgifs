<h3>Editar Etiqueta</h3>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');

        if (empty($value)) {
            $value = set_value('categoria');
        }
        echo validation_errors();
        $attributes = array('id' => 'editar_categoria',
            'class' => 'form-horizontal');
        echo form_open('categoria/update_categoria', $attributes);

        $categoria = array(
            'name' => 'categoria',
            'id' => 'categoria',
            'class' => 'form-control',
            'value' => $value);
        $submit = array(
            'name' => 'enviar',
            'id' => 'enviar',
            'value' => 'Guardar',
            'class' => 'btn btn-success');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../categoria'");
        echo form_hidden('segment', $get);
        echo form_input($categoria);
        echo form_submit($submit);
        echo form_button($cancelar, 'Cancelar');
        ?>
    </div>
</div>