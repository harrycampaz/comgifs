<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'eliminar_cuenta',
                        'class'=>'form-horizontal');
        echo form_open('profile/check_delete', $attributes);
        
        $password = array(
            'name' => 'password',
            'id' => 'password',
            'placeholder' => 'Password');
        $submit = array(
            'name' => 'eliminar',
            'id' => 'eliminar',
            'value' => 'Eliminar',
            'class' => 'btn btn-danger');

        echo form_hidden('username', $user);
        echo form_password($password);
        echo form_submit($submit);
?>