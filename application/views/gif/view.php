<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if ($end != 1) { ?>  

    <header><h1><?= ucfirst($datos['titulo']) ?></h1></header>
<?php } else {
    ?>
    <header><h3><?= ucfirst($datos['titulo']) ?></h3></header>
<?php } ?>
<hr/>

<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 comgifs_sidebar_1 
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-4780835939148340"
     data-ad-slot="3874380399"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>-->

<section class="row">

    <div class="col-lg-8">


	
        <div class="thumbnail">          
            <h4> <strong><span class="glyphicon glyphicon-user"></span> </strong><?= anchor('profile/user/' . $datos['username'], $datos['username']) ?> </h4>
            <h5> <strong class ="text-info">|<span class="glyphicon glyphicon-eye-open"></span><?php echo' : ' . $datos['vista'] ?> | </strong>
                <?= anchor('gifs/gifscategoria/' . $datos['id_categoria'], $datos['nombre_categoria']) ?></h5>
           <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= base_url() ?>gifs/view/<?= $datos['imagen']."/".$p ?>/" data-lang="es" data-related="@Frases_App">Twittear</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
            
              <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                <g:plusone></g:plusone>

                
                <div class="fb-like"  data-href="http://www.comgifs.com/gifs/view/<?= $datos['imagen'] ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>


               <?php if ($end != 1) { ?>

                <hr />
		

               
                 <?php if (!(isset($myname))) { ?>
                 
                  <img src="<?= base_url() ?>uploads/<?= $datos['imagen'] ?>" data-src="holder.js/500x200"style="width: 100%; height: 100%;" alt="<?= ucfirst($datos['titulo']) ?>">
                 
<!--                 <div style="text-align:center">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			 Comgifs_AdactableDesktop 
			<ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-4780835939148340"
			     data-ad-slot="1711254395"
			     data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
	         </div>-->
			
		<?php } ?>
               
			
		            

            <?php } else { ?>
                <hr />
                
                <img src="<?= base_url() ?>uploads/<?= $datos['imagen'] ?>" data-src="holder.js/500x200" alt="<?= ucfirst($datos['titulo']) ?>">
			
			
<!--			<div style="text-align:center">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			 Comgifs_AdactableDesktop 
			<ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-4780835939148340"
			     data-ad-slot="1711254395"
			     data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
	         </div>-->
			

            <?php } ?>	
            
            <hr/>

            <span class="glyphicon glyphicon-tags"></span>
            <?php
            if (!empty($datos['etiquetas'])) {

                $etiquetas = explode(',', $datos['etiquetas']);

                for ($i = 0; $i < count($etiquetas); $i++) {
                    $etiquetas[$i] = trim($etiquetas[$i]);
                    if ($etiquetas[$i] != "") {
                        echo anchor('gifs/gifsetiquetas/' . $etiquetas[$i], $etiquetas[$i], '');
                        echo ", ";
                    }
                }
            }
            ?>


            <p class ="muted"> <?php echo $datos['fecha'] ?></p>
            <form class="form">
                <button type="button" id="denunciar" title="Reportar" ><span class="glyphicon glyphicon-ban-circle"></span></button>
            </form>
            <?php
            $attributes = array('id' => 'ver_nuevos', 'class' => 'form');
            echo form_open('gifs/aleatorio', $attributes);
            ?>
            <button type="submit" title="Random"  ><span class="glyphicon glyphicon-random"></span></button>
            </form>
            <?php
            $attributes = array('id' => 'ver_nuevos', 'class' => 'form');
            echo form_open('gifs/forzar_descarga', $attributes);
            echo form_hidden('descarga', base_url() . 'uploads/' . $datos['imagen']);
            ?>
            <button type="submit" title="Descargar"><?= $download ?> <span class="glyphicon glyphicon-download-alt"></span></button>
            </form>

            <?php
            $attributes = array('id' => 'ver_nuevos', 'class' => 'form');
            echo form_open('gifs/subirgif', $attributes);
            ?>
            <button type="submit" title="Subir"><span class="glyphicon glyphicon-open"></span></button>
            </form>


        </div>







        <div id="disqus_thread"></div>
        <script type="text/javascript">
                /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                var disqus_url = '<?= base_url() ?>gifs/view/<?= $datos['imagen'] ?>';
                    var disqus_shortname = 'comgifs'; // required: replace example with your forum shortname

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script');
                        dsq.type = 'text/javascript';
                        dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>




    </div>


    <article class="col-lg-3"> 
        <br/>
        <h3>Gifs Relacionados</h3>
        <hr />
	   
        <?php
        if (isset($datos_r)) {
            foreach ($datos_r as $datos_reco):
                ?>

                <div class="thumbnail">
                    <strong><?= anchor('profile/user/' . $datos_reco['username'], $datos_reco['username']) ?></strong>

                    <?php if ($end == 1) { ?>  
                        <h5 title="<?= $datos_reco['titulo'] ?>"><?php echo substr($datos_reco['titulo'], 0, 60) ?>..</h5>
                    <?php } ?>

                    <a class = 'thumbnail' href="<?= base_url() ?>gifs/view/<?= $datos_reco['imagen'] ?>"><img src= "<?= base_url() ?>uploads/thumbs/<?= $datos_reco['imagen'] ?>" data-src="holder.js/160x120" style="width: 160px; height: 120px;" alt="<?= $datos_reco['titulo']; ?>" width="150" height="100" title ="<?= $datos_reco['titulo'] ?>"/></a>

                    <?= anchor('gifs/gifscategoria/' . $datos_reco['id_categoria'], $datos_reco['nombre_categoria']) ?>
                    <br /><strong class ="muted"> <span class="glyphicon glyphicon-eye-open"></span> <?php echo ' : ' . $datos_reco['vista'] ?></strong>
                    <br /><b class ="muted"><?php echo $datos_reco['fecha'] ?></b>

                </div>


            <?php endforeach ?>
        <?php } ?>   








    </article>


</section>