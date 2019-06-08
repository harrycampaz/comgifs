<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if ($end != 1) { ?>  

    <header><h1><?= $signup ?></h1></header>
<?php } else {
    ?>

    <header><h2><?= $signup ?></h2></header>
<?php } ?>
<hr/>
<section class="row">
    <article class="col-lg-5">
        <?php
        $attributes = array('id' => 'register',
            'class' => 'form-horizoltal');
        echo form_open('login/check_register', $attributes);

        $label = array('class' => 'control-label');

        $name = array(
            'name' => 'name',
            'id' => 'inputname',
            'placeholder' => $name,
            'class' => 'form-control',
            'value' => set_value('name'));
        $email = array(
            'name' => 'email',
            'id' => 'inputemail',
            'class' => 'form-control',
            'placeholder' => 'E-mail',
            'value' => set_value('email'));

        $username = array(
            'name' => 'username',
            'id' => 'inputUsername',
            'class' => 'form-control',
            'placeholder' => 'Username',
            'value' => set_value('username'));
        $password = array(
            'name' => 'password',
            'id' => 'input_Password',
            'class' => 'form-control',
            'placeholder' => $password);
        $repassword = array(
            'name' => 're_password',
            'class' => 'form-control',
            'id' => 'inputre_Password',
            'placeholder' => $repassword);
        $check = array(
            'name' => 'check',
            'id' => 'check',
            'checked' => TRUE,
            'value' => 'accept'
        );

        $submit = array('type' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $send);
        ?>



        <?= form_input($name); ?>
        <p class="text-error"><?= strip_tags(form_error('name')) ?></p>


        <?= form_input($email); ?>
        <p class="text-error"><?= strip_tags(form_error('email')) ?></p>

        <?= form_input($username); ?>
        <p class="text-error"><?= strip_tags(form_error('username')) ?></p>

        <?= form_password($password); ?>
        <p class="text-error"><?= strip_tags(form_error('password')) ?></p>

        <?= form_password($repassword); ?>
        <p class="text-error"><?= strip_tags(form_error('re_password')) ?></p>

        <?= anchor(base_url() . 'terminos', $term . '  '); ?>

        <?php echo form_checkbox($check); ?>
        <p class="text-error"><?= strip_tags(form_error('check')) ?></p>

        <?php echo $recaptcha_html; ?>
        <?= $this->session->flashdata('error'); ?>
        <br/>
        <?= form_submit($submit); ?>


        </form>
    </article>


<br/>





    <?php
    if (isset($datos_r)) {
        foreach ($datos_r as $datos_reco):
            ?>
            <article class="col-lg-3">
                <div class="thumbnail">
                    <strong><?= anchor('profile/user/' . $datos_reco['username'], $datos_reco['username']) ?></strong>
                    <?php if ($end == 1) { ?>  
                        <h5 title="<?= $datos_reco['titulo'] ?>"><?php echo substr($datos_reco['titulo'], 0, 60) ?>..</h5>
                    <?php } ?>


                    <a class = 'thumbnail' href="<?= base_url() ?>gifs/view/<?= $datos_reco['imagen'] ?>"><img src= "<?= base_url() ?>uploads/thumbs/<?= $datos_reco['imagen'] ?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" alt="<?= $datos_reco['titulo']; ?>" width="150" height="100" title ="<?= $datos_reco['titulo'] ?>"/></a>

                    <?= anchor('gifs/gifs_categoria/' . $datos_reco['id_categoria'], $datos_reco['nombre_categoria']) ?>
                    <br /><strong class ="muted"> <i class="icon-eye-open"></i> <?php echo ' : ' . $datos_reco['vista'] ?></strong>
                    <br /><b class ="muted"><i class="icon-time"></i> <?php echo $datos_reco['fecha'] ?></b>


                </div>
            </article>
        <?php endforeach ?>
    <?php } ?>   

</section>
