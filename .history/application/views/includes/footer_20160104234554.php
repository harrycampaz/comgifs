<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>



</div>
<hr />
<footer  style="text-align:right">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="muted">© 2013 ComGIFS, LLC 
                    <?php
                    echo anchor(base_url() . 'terminos', 'Términos de Uso   -    ');
                    echo anchor(base_url() . 'terminos/privacidad', 'Política De Privacidad - ');
                    echo anchor('http://www.comgifs.blogspot.com/', ' Blog ', 'target = "_blank" ');
                    ?></p>
            </div>

        </div>
    </div>
</footer>

<?php if (isset($banner)) { ?>


    <br/>
    <br/>

<?php } ?>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<?php if (isset($mivideo)) { ?>
    <script type="text/javascript" src="<?= base_url() ?>js/funciones.js"></script>
<?php } ?>
<?php if (isset($banner)) { ?>
    <script type="text/javascript">
        $("#denunciar").click(function() {

            /* instrucciones javascript*/
            if (confirm('Esta seguro que desea reportar este GiF ?')) {
                $.ajax({
                    url: "http://www.comgifs.com/gifs/denunciar/<?= $datos['imagen'] ?>",
                    context: document.body
                }).done(function() {
                    $("#denunciar").attr('disabled', '-1');
                });
            }
            else {
                return false;
            }

        });
    </script>



<?php } ?>


<script>
    function confirmar(mensaje)
    {
        if (confirm(mensaje))
            return true;
        else
            return false;
    }

</script>
<?php if (isset($register_js)) { ?>
    <script type="text/javascript" src="<?= base_url() ?>js/funciones/<?= $register_js ?>"></script>

    <script type="text/javascript">
    var x;
    x = $(document);
    x.ready(register);

    function register() {
        var x = $("#inputname");
        x.focus();
        $('#register').each(function() {
            this.reset();
        });

    }
    </script>
<?php } ?> 


<script type="text/javascript">
    var x;
    x = $(document);
    x.ready(login);

    function login() {
        var x = $("#inputUsername");
        x.focus();
        $('#login').each(function() {
            this.reset();
        });

    }
</script>
<script type="text/javascript" src="<?= base_url() ?>js/funciones/<?= $login_js ?>"></script>

<script src="<?= base_url() ?>js/bootstrap.min.js"></script>



<script>
  (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
          (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
              m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-44519625-1', 'comgifs.com');
  ga('send', 'pageview');

</script>

<br/>
</body>
</html>