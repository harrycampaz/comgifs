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

<script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>

<section class="row">
    <article class="col-lg-12">
        <?php
        $attributes = array('id' => 'subir_video',
            'role' => "form");

        echo form_open('videos/check_video', $attributes);

        $titulo = array(
            'name' => 'titulo',
            'id' => 'titulo',
            'maxlength' => 180,
            'rows' => '4',
            'cols' => '40',
            'placeholder' => 'Titulo',
            'class' => 'form-control negro',
            'value' => set_value('titulo'),
        );
        $avatar = array(
            'name' => 'avatar',
            'id' => 'titulo',
            'maxlength' => 500,
            'rows' => '4',
            'cols' => '40',
            'placeholder' => 'Enlace del Avatar',
            'class' => 'form-control negro',
            'value' => set_value('avatar'),
        );

        $video = array(
            'name' => 'video',
            'id' => 'video',
            'maxlength' => 2500,
            'rows' => '3',
            'cols' => '34',
            'class' => 'form-control negro',
            'placeholder' => 'Codigo del video si tiene',
            'value' => set_value('video'),
            'onKeyDown' => "textCounter(this.form.video,this.form.remLen,1500)",
            'onKeyUp' => "textCounter(this.form.video,this.form.remLen,1500)");
        
        $check = array(
            'name' => 'check',
            'id' => 'check',
            'checked' => FALSE,
            'value' => 'accept'
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
            
           <textarea name="descripcion" id="editor1" rows="10" cols="80">
                Descripcion Aqui
            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'descripcion' );
            </script>
        
            
        </div>
        
        <div class="form-group">
            <?php
            //echo form_label('Descripcion: ');
            echo form_textarea($video);
            ?> 

            <input readonly type="text" name="remLen" size="3" maxlength="3" value="1500" class="input-small" />
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
            echo form_dropdown('categoria', $select_categoria, '1', "id='categoria'");
            ?>
            <p class="text-error"><?= strip_tags(form_error('categoria[]')) ?></p>
        </div>

        <?php echo form_submit($submit); ?>

        </form>

    </article

</section>