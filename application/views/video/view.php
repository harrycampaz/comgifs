<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>

    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 30px; height: 0; overflow: hidden;
    }

    .video-container iframe,
    .video-container object,
    .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>
<?php if ($end != 1) { ?>  

    <header><h1><?php echo $video['titulo']; ?></h1></header>
<?php } else {
    ?>
    <header><h3><?php echo $video['titulo']; ?></h3></header>
<?php } ?>
<hr/>
<section class="row">

    <div class="col-lg-12">

        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= base_url() ?>videos/view/<?= $video['enlace'] . "/" . $p ?>" data-lang="es" data-related="@FunnyDeportes">Twittear</a>
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


        <div class="fb-like"  data-href="<?= base_url() ?>videos/view/<?= $video['enlace'] . "/" . $p ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>



        <br/>

        <br/>



        <div style="text-align: center">
            <?php if (isset($video['avatar_video'])) { ?>
                <div style="text-align: center">
                    <?php echo '<img src="' . $video['avatar_video'] . '" class="img-responsive"/>'; ?>
                </div>
            <?php } ?>
            <?php if (!(isset($myname))) { ?>

<!--                <div style="text-align:center">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                     comgifs_sidebar_1 
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:336px;height:280px"
                         data-ad-client="ca-pub-4780835939148340"
                         data-ad-slot="3874380399"></ins>
                    <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <p style="color: white">Seguros De Coche, Seguros Baratos , Mejor Seguro, Seguro De Salud,comparador seguros salud, Salud Privada, Salud Internacional </p>
   
                </div>-->

            <?php } ?>
        </div>
        <br/>
        <?php echo $video['descripcion'] ?>

        <?php if (!empty($video['video'])) { ?>
            <div class="video-container">
                <?php echo $video['video']; ?>
            </div>
        <?php } ?>
        <div style="text-align: center">
<!--            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
             comgifs_sidebar_2 
            <ins class="adsbygoogle"
                 style="display:inline-block;width:336px;height:280px"
                 data-ad-client="ca-pub-4780835939148340"
                 data-ad-slot="1023599198"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>-->
            
                </div>
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_url = '<?= base_url() ?>videos/view/<?= $video['enlace'] ?>';
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



</section>