<h1>Cambiar Contraseña / </h1>
<hr/>
<div class="row">
    <div class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'update',
            'class' => 'form-horizontal');
        echo form_open('profile/check_update_password', $attributes);
        
        $label = array('class' => 'control-label');

        $old_password = array(
            'name' => 'old_password',
            'id' => 'old_password',
            'class' => 'form-control');
        $password = array(
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control');

        $re_password = array(
            'name' => 're_password',
            'id' => 're_password',
            'class' => 'form-control');


        $submit = array('type' => 'submit',
            'class' => 'btn btn-primary',
            'value' => 'Actualizar');
        $cancelar = array(
            'name' => 'cancelar',
            'id' => 'cancelar',
            'class' => 'btn btn-danger',
            'onClick' => "location.href='../profile'");
        ?>
        <div class="control-group">
            <?= form_label('Contraseña Actual', '', $label); ?>
            <div class="controls">
                <?= form_password($old_password); ?>
            </div>
        </div>
        <div class="control-group">
            <?= form_label('Nueva contraseña', '', $label); ?>
            <div class="controls">
                <?= form_password($password); ?>
            </div>
        </div>
        <div class="control-group">
            <?= form_label('Reperir nueva contraseña', '', $label); ?>
            <div class="controls">
                <?= form_password($re_password); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php echo form_submit($submit);
                echo form_button($cancelar, 'Cancelar');
                ?>
            </div>
        </div>
<?= form_fieldset_close() ?>
        </form>
    </div>
</div>