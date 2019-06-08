<h3>Agregar Partner</h3>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'editar_categoria',
            'class' => 'form-horizontal');
        echo form_open('buspartner/check_partner', $attributes);

        $username = array(
            'name' => 'username',
            'id' => 'username',
            'class' => 'form-control',
            'placeholder' => 'Partner');
        $correo = array(
            'name' => 'correo',
            'id' => 'correo',
            'class' => 'form-control',
            'placeholder' => 'E - Mail');
        $submit = array(
            'name' => 'enviar',
            'id' => 'enviar',
            'value' => 'Agregar',
            'class' => 'btn btn-success');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../buspartner'");
        ?>
        <div class="control-group">
            <div class="controls">
                <?= form_input($username); ?>
                <p class="text-error"><?=strip_tags(form_error('username')) ?></p>
            </div>
            <br/>
            <div class="controls">
                <?= form_input($correo); ?>
                <p class="text-error"><?=strip_tags(form_error('correo')) ?></p>
            </div>
             <br/>
            <div class="controls">
                <?= form_submit($submit); ?>
            </div>
              <br/>
            <div class="controls">
                <?= form_button($cancelar, 'Cancelar'); ?>

            </div>
        </div>
    </div>
