<!-- sidebar
================================================== -->

<nav class="col-lg-4">

<div class="well" style="padding: 8px;">
 <div style="text-align:center">
 	<a href="https://twitter.com/comgifs" target = "_blank" ><img src="<?= base_url() ?>img/Twitter-Bird.png" alt="Twitter"></a>
        <a href="https://www.facebook.com/comgifs" target = "_blank" ><img src="<?= base_url() ?>img/Facebook.png" alt="Facebook"></a>   
        <a href="https://plus.google.com/u/0/+Comgifs/posts" target = "_blank" ><img src="<?= base_url() ?>img/Google-Plus.png" alt="Google PLUS"></a>
  </div>
    </div>
    
    <div class="well" style="padding: 8px;">
			<div style="text-align:center">
		 
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- comgifs250Mixto -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:250px;height:250px"
			     data-ad-client="ca-pub-4780835939148340"
			     data-ad-slot="3082304796"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
			
			
			</div>
	    </div>
    

 <div class="well"  style="padding: 8px;">
                
     <header><strong><?=$category_li?></strong></header>
 
          <?php foreach ($categoria as $categoria_item):?>
        
                    <a href="<?=  base_url().'gifs/gifscategoria/'.$categoria_item['id_categoria']?>"><?=$categoria_item['nombre_categoria']?></a> | 
       
          <?php endforeach;?>
           
          
      </div>

      <div class="well" style="padding: 8px;">
          <header><strong><?=$tags_li ?></strong></header>
           
           <?php foreach ($tag as $tag_item):?>
        
                    <a href="<?=  base_url().'gifs/gifsetiquetas/'.$tag_item['nombre_etiqueta']?>"><?=$tag_item['nombre_etiqueta']?></a> |
       
          <?php endforeach;?>
          
           
      </div>
       <div class="well" style="padding: 8px;">
           <header><strong><?=$best?></strong></header>
          
          <?php foreach ($best_users as $best_item):?>
        
                    <a href="<?= base_url().'profile/user/'.$best_item['username']?>"><?=$best_item['username']?></a> |
       
          <?php endforeach;?>
        
  
    </div>
</nav>

  