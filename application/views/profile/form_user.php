<h3>Ingrese E-mail o Username</h3>
<hr />
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$attributes = array('id' => 'update',
    'class' => 'form');
echo form_open('profile/by_email', $attributes);

$label = array('class' => 'control-label');

$email = array(
    'name' => 'email',
    'id' => 'email',);

$submit = array('type' => 'submit',
    'class' => 'btn',
    'value' => 'Enviar');

?>


<div class="control-group">
    <?= form_label('E-mail', '', $label); ?>
    <div class="controls">
        <p class="text-error"><?=strip_tags(form_error('email')) ?></p>
        <?= form_input($email); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo form_submit($submit);
       
        ?>
    </div>
</div>

</form>

<strong> O </strong>

<?php

$attributes = array('id' => 'update',
    'class' => 'form');
echo form_open('profile/by_username', $attributes);

$label = array('class' => 'control-label');

$username = array(
    'name' => 'username',
    'id' => 'username',);

$submit2 = array('type' => 'submit',
    'class' => 'btn',
    'value' => 'Enviar');

?>


<div class="control-group">
    <?= form_label('Username', '', $label); ?>
    <div class="controls">
        <p class="text-error"><?=strip_tags(form_error('username')) ?></p>
        <?= form_input($username); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php echo form_submit($submit2);

        ?>
    </div>
</div>

</form>

