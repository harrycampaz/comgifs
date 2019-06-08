<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">

    function textCounter(field, countfield, maxlimit) {
        if (field.value.length > maxlimit) // if too long...trim it!
            field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
        else
            countfield.value = maxlimit - field.value.length;
    }
    // End -->
</script>

<header> <h1><?= $upload ?></h1></header>
<hr />
<section class="row">
    <article class="col-lg-5">
        <?php
        $attributes = array('id' => 'registrar_gif',
            'role' => "form");

        echo form_open_multipart('gifs/do_upload', $attributes);

        $titulo = array(
            'name' => 'titulo',
            'id' => 'titulo',
            'maxlength' => 120,
            'rows' => '4',
            'cols' => '40',
            'placeholder' => $title_holder,
            'class' => 'form-control negro',
            'value' => set_value('titulo'),
            'onKeyDown' => "textCounter(this.form.titulo,this.form.remLen,120)",
            'onKeyUp' => "textCounter(this.form.titulo,this.form.remLen,120)",
        );
        $userfile = array(
            'name' => 'userfile',
            'id' => 'upload',
            'value' => set_value('userfile')
        );
        $etiquetas = array(
            'name' => 'etiquetas',
            'id' => 'etiquetas',
            'maxlength' => 160,
            'rows' => '3',
            'cols' => '34',
            'class' => 'form-control negro',
            'placeholder' => $tag_holder,
            'value' => set_value('etiquetas')
        );
        $check = array(
            'name' => 'check',
            'id' => 'check',
            'checked' => TRUE,
            'value' => 'accept'
        );
        $submit = array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => $upload,
            'class' => 'btn btn-primary'
        );
        ?>

        <div class="form-group">
            <?php
            echo form_textarea($titulo);
            ?>
            <input readonly type="text" name="remLen" size="3" maxlength="3" value="120" class="input-small" />
            <p class="text-error"><?= strip_tags(form_error('titulo')) ?></p>
        </div>
        <div class="form-group">
            <?php
            echo form_upload($userfile);
            ?>
            <p class="text-error"><?= strip_tags($error) ?></p>
        </div>
        <div class="form-group">
            <?php
            //echo form_label('Descripcion: ');
            echo form_textarea($etiquetas);
            ?> 
        </div>
        <div class="form-group">
            <?php
            echo form_label('Categoria: ');
            echo form_dropdown('categoria', $select_categoria, '1', "id='categoria'");
            ?>
            <p class="text-error"><?= strip_tags(form_error('categoria[]')) ?></p>
        </div>
        <div class="form-group">
            <?php
            echo anchor(base_url() . 'terminos', $term . '  ');
            echo form_checkbox($check);
            ?>
            <p class="text-error"><?= strip_tags(form_error('check')) ?></p>
        </div>
        <?php echo form_submit($submit); ?>

        </form>

    </article>


<aside>

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
                    <br /><strong class ="muted"><span class="glyphicon glyphicon-eye-open"></span> <?php echo ' : ' . $datos_reco['vista'] ?></strong>
                    <br /><b class ="muted"> <?php echo $datos_reco['fecha'] ?></b>



                </div>
            </article>
        <?php endforeach ?>
    <?php } ?>   

</aside>