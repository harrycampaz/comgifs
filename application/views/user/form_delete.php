<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
        echo validation_errors();
        $attributes = array('id' => 'eliminar_cuenta',
                        'class'=>'form-horizontal');
        echo form_open('user/check_delete_user', $attributes);
        
        $password = array(
            'name' => 'password',
            'id' => 'password',
             'class' => 'form-control',
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