<h3>Editar Etiqueta</h3>
<hr/>
<div class="row">
    <div class="col-lg-5">

        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');

        if (empty($value)) {
            $value = set_value('tag');
        }
        echo validation_errors();
        $attributes = array('id' => 'editar_tag',
            'class' => 'form-horizontal');
        echo form_open('tag/update_tag', $attributes);

        $tag = array(
            'name' => 'tag',
            'id' => 'tag',
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
            'onClick' => "location.href='../tag'");
        echo form_hidden('segment', $get);
        echo form_input($tag);
        echo form_submit($submit);
        echo form_button($cancelar, 'Cancelar');
        ?>
    </div>
</div>