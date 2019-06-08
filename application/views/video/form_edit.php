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
<script src="//cdn.ckeditor.com/4.5.4/standard/ckeditor.js"></script>
<script>
    function InsertHTML() {
        // Get the editor instance that we want to interact with.
        var editor = CKEDITOR.instances.editor1;
        var value =  <?php echo json_encode($video_item[0]['descripcion'])?>  


        // Check the active editing mode.
        if (editor.mode == 'wysiwyg')
        {
            // Insert as plain text.
            // http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertText
            editor.insertHtml(value);
        }
        else
            alert('You must be in WYSIWYG mode!');
    }
</script>
<section class="row">
    <article class="col-lg-12">
        <?php
        if (isset($video_item)) {
            $titulo = $video_item[0]['titulo'];
            $avatar = $video_item[0]['avatar_video'];
            $video = $video_item[0]['video'];
            $categoria = $video_item[0]['id_categoria'];
        } else {
            $titulo = set_value('titulo');
            $video = set_value('video');
            $descripcion = set_value('descripcion');
            $categoria = set_value('categoria');
        }
        $attributes = array('id' => 'registrar_gif',
            'role' => "form");

        echo form_open('videos/check_edit', $attributes);

        $titulo = array(
            'name' => 'titulo',
            'id' => 'titulo',
            'maxlength' => 180,
            'rows' => '4',
            'cols' => '40',
            'placeholder' => 'Titulo',
            'class' => 'form-control negro',
            'value' => $titulo,
        );

        $video = array(
            'name' => 'video',
            'id' => 'video',
            'maxlength' => 2500,
            'rows' => '3',
            'cols' => '34',
            'class' => 'form-control negro',
            'placeholder' => 'Inserta el video al Articulo',
            'value' => $video,
            'onKeyDown' => "textCounter(this.form.video,this.form.remLen,1500)",
            'onKeyUp' => "textCounter(this.form.video,this.form.remLen,1500)");

        $check = array(
            'name' => 'check',
            'id' => 'check',
            'checked' => FALSE,
            'value' => 'accept'
        );

        $avatar = array(
            'name' => 'avatar',
            'id' => 'avatar',
            'maxlength' => 2000,
            'class' => 'form-control negro',
            'placeholder' => 'Avatar del Articulo',
            'value' => $avatar,
        );

        $submit = array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => 'Enviar',
            'class' => 'btn btn-primary'
        );
        ?>

        <div class="form-group">
            <?php
            echo form_input($avatar);
            ?>
            <p class="text-error"><?= strip_tags(form_error('avatar')) ?></p>
        </div>
        <div class="form-group">
            <?php
            echo form_input($titulo);
            ?>
            <p class="text-error"><?= strip_tags(form_error('titulo')) ?></p>
        </div>

        <div class="form-group">

            <textarea cols="100" id="editor1" name="editor1" rows="10">

            </textarea>

            <script>
                // Replace the <textarea id="editor1"> with an CKEditor instance.
                CKEDITOR.replace('editor1');
            </script>

        </div>

        <input onclick="InsertHTML();" type="button" value="Insert Text">

        

        <div class="form-group">
            <?php
            echo form_input($video);
            ?>
            <p class="text-error"><?= strip_tags(form_error('video')) ?></p>
        </div>
        <div class="form-group">
            <?php
            echo form_checkbox($check);
            ?> <span>Es un LINK</span>
            <p class="text-error"><?= strip_tags(form_error('check')) ?></p>
        </div>

        <div class="form-group">
            <?php
            echo form_label('Categoria :  ');
            echo form_dropdown('categoria', $select_categoria, $categoria, "id='categoria'");
            ?>
            <p class="text-error"><?= strip_tags(form_error('categoria[]')) ?></p>
        </div>

        <?php
        echo form_hidden('enlace', $video_item[0]['enlace']);
        echo form_submit($submit);
        ?>

        </form>

    </article

</section>