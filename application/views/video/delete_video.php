
<div style="text-align: center">

    <h2>     <?php echo $video_item['titulo'] ?></h2>


    <?php echo $video_item['video'] ?>
    <br/>
    <br/>
    <p class="label label-info"> <?php echo $video_item['nombre_categoria'] ?></p>
</div>

<a href="<?= base_url() ?>videos/confirmar_borrar/<?php echo $video_item['id_video'] ?>"  class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
