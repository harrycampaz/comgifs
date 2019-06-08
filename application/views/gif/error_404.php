<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h2>La imagen <?=$imagen?> no se encuentra</h2>
<?php echo anchor(base_url(),$home, array('title'=>'Inicio', 'class' => 'btn btn-danger btn-large'))?>
<?php if ($end != 1) { ?>  
<header>
<h3><?=$most_viewed?></h3></header>
<?php } 
else { ?>
<header>
<h3><strong><?=$most_viewed?></strong></h3></header>
<?php } ?>
 <hr />
 <section class="row">
            <?php foreach ($most_view as $most_item):
        ?>
     <article class="col-lg-3">
                <div class="thumbnail">
        
                       <h5><strong><?= anchor('profile/user/'.$most_item['username'],$most_item['username'])?></strong></h5>
                       <h6 title="<?=$most_item['titulo']?>"><?php echo substr($most_item['titulo'],0,18)?>..</h6>
                        <a class= "thumbnail" href="<?=base_url()?>gifs/view/<?=$most_item['imagen']?>"><img src= "<?=base_url()?>uploads/thumbs/<?=$most_item['imagen']?>"   alt="<?=$most_item['titulo']?>"  data-src="holder.js/160x120" style="width: 160px; height: 120px;" title ="<?=$most_item['titulo']?>"/></a>
                       <h4> <?= anchor('gifs/gifs_categoria/'.$most_item['id_categoria'],$most_item['nombre_categoria'])?></h4>
                        <strong class ="muted"><span class="glyphicon glyphicon-eye-open"></span> <?php echo ' : '.$most_item['vista']?></strong>
                        <br /><b class ="muted"> <?php echo $most_item['fecha']?></b>
                   
                </div>
     </article>
        <?php endforeach?>
 </section>
    <?php
        $attributes = array('id' => 'mas_vistos',
                        'class'=>'form-horizontal');
        echo form_open('gifs/destacado', $attributes);
        $mas_vistos = array(
            'name' => 'mas_visto',
            'id' => 'mas_visto',
            'value' => $more,
            'class' => 'btn btn-primary');
        echo form_submit($mas_vistos);
        ?>
    </form>