
<?php if ($end != 1) { ?>  

    <header><h1><?= $signin ?></h1></header>
<?php } else {
    ?>

    <header><h2><?= $signin ?></h2></header>
<?php } ?>
<hr/>
<section class="row">
    <article class="col-lg-5">
        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');
        $attributes = array('id' => 'login',
            'role' => "form");
        echo form_open('login/check', $attributes);

        $label = array('class' => 'control-label');

        $username = array(
            'name' => 'username',
            'id' => 'inputUsername',
            'class' => 'form-control',
            'placeholder' => 'Username o Email');
        $password = array(
            'name' => 'password',
            'id' => 'inputPassword',
            'class' => 'form-control',
            'placeholder' => 'Password');
        $submit = array('type' => 'submit',
            'class' => 'btn',
            'value' => 'Sign in');
        ?>


        <?= form_label('Username', 'inputUsername', $label); ?>

        <?= form_input($username); ?>
        <p class="text-error"><?= strip_tags(form_error('username')) ?></p>



        <?= form_label('Password', 'inputPassword', $label); ?>

        <?= form_password($password); ?>
        <p class="text-error"><?= strip_tags(form_error('password')) ?></p>
        <?= form_submit($submit); ?>
        <br/>

        <?= anchor('profile/rest_pass', $forgot); ?><br />
        <?= anchor('login/register', $signup, array('title' => $signup)) ?>


        </form>
    </article>
</section>