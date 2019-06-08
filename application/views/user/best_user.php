<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>
<h3><?=$best?></h3>
        
        
        <hr/>
        
        <tr>
        <?php 
        if(isset($datos_user) && $datos_user != 0){
        foreach ($datos_user as $user_item):
 
        ?>
        <div class="col-lg-3">
                    <div class="thumbnail">
                        <ul>
                        	<li><strong><?= anchor('profile/user/'.$user_item['username'],$user_item['username'])?></strong></li>
                        	<li class ="muted"><?php echo $user_item['ubicacion']?></li>
                        	<li class ="muted"><span class="glyphicon glyphicon-star-empty"></span>: <?php echo $user_item['estrellas']?></li>
                        	<li class ="muted"><?php echo $user_item['fecha_registro']?></li>
                        </ul>
                   </div>
        </div>
        <?php endforeach?>

        <?php } ?>  
        