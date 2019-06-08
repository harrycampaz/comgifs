<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title><?= ucfirst($title) ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if (isset($view)) { ?>
            <meta name="twitter:card" content="photo">
            <meta name="twitter:site" content="@comgifs">
            <meta name="twitter:creator" content="@comgifs">
            <meta name="twitter:url" content="<?= base_url() ?>gifs/view/<?= $datos['imagen'] . "/" . $p ?>/">
            <meta name="twitter:title" content="<?= ucfirst($datos['titulo']) ?>">
            <meta name="twitter:image:src" content="<?= base_url() ?>uploads/<?= $datos['imagen'] ?>">
            <meta name="twitter:domain" content="http://www.comgifs.com">


        <?php } ?>

        <?php if (isset($mivideo)) { ?>
            <meta name="twitter:card" content="photo">
            <meta name="twitter:site" content="@comgifs">
            <meta name="twitter:creator" content="@comgifs">
            <meta name="twitter:url" content="<?php echo base_url() ?>videos/view/<?= $video['enlace'] . '/' . $p ?>/">
            <meta name="twitter:title" content="<?= ucfirst($video['titulo']) ?>">
            <meta name="twitter:image:src" content="<?= $video['avatar_video'] ?>">
            <meta name="twitter:domain" content="http://www.comgifs.com">


        <?php } ?>
        <meta name="google-site-verification" content="__DkcncvesbFhjniFSwSda4ShjA61qKjGppqSlEWIUM" />
        <meta name="msvalidate.01" content="928C0A777098822903887D2AD80B8F05" />
        <meta name="description" content="<?= ucfirst($title) ?> - ComGifs el mejor sitio web para DESCARGAR, SUBIR y COMPARTIR imágenes animadas GIF"/>
        <meta name="keywords" content="imágenes gif , gifs,animado gif,  gif de anime, compartir gif,  BBM, Blackberry,animated gif, imagenes animadas gratis, animaciones de humor, gifs de fútbol, gifs messi, gifs cristiano ronaldo, gif real madrid" />


        <link rel="shortcut icon" href="<?= base_url() ?>iconos/favicon.ico">


        <link rel="stylesheet" href="<?= base_url() ?>css/style.css">
        <link href="<?= base_url() ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>css/bootswatch.min.css" rel="stylesheet">


    </head>

    <body>


        <script language="javascript" type="text/javascript">
            lz = "http://ocio.leadzu.com/inter_request.php?m=1FHOSITE31113X1&a=&ip=2&lgid=" + ((new Date()).getTime() % 2147483648) + Math.random();
            document.write("<scr" + "ipt language=javascript type=text/javascript src=" + lz + "></scr" + "ipt>");
        </script>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=567907506565624&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>


        <!-- Navbar
          ================================================== -->

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?= base_url() ?>"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;ComGIFS</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">GIFS<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('gifs/ultimos', $most_recent, array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('gifs/destacado', $most_viewed, array('title' => $most_viewed)) ?></li>

                            </ul>
                        </li>
                        <li><?php echo anchor('gifs/aleatorio', $fun, array('title' => $fun, 'id' => 'diviertete')) ?></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $best ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url() ?>profile/bestuser/6">VIP</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/5"><img src="<?= base_url() ?>img/estrella10.png" alt="5 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/4"><img src="<?= base_url() ?>img/estrella8.png"  alt="4 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/3"><img src="<?= base_url() ?>img/estrella6.png"  alt="3 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/2"><img src="<?= base_url() ?>img/estrella4.png"  alt="2 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/1"><img src="<?= base_url() ?>img/estrella2.png"  alt="1 estrellas GIFS"></a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">Videos<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('videos/ultimos', 'Ultimos', array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('videos/destacados', 'Destacados', array('title' => $most_viewed)) ?></li>

                            </ul>
                        </li>
                        <li>
                            <style type="text/css">
                                @import url(http://www.google.com/cse/api/branding.css);
                            </style>
                            <div class="cse-branding-bottom">
                                <div class="cse-branding-form">
                                    <form action="http://www.google.com.co" id="cse-search-box">
                                        <div>
                                            <input type="hidden" name="cx" value="partner-pub-4780835939148340:1137043595" />
                                            <input type="hidden" name="ie" value="UTF-8" />
                                            <input type="text" name="q" size="20" />
                                            <input type="submit" name="sa" value="Buscar" />
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </li>


                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $signin ?><b class="caret"></b></a>
                            <div class="dropdown-menu">

                                <?php
                                $attributes = array('id' => 'login',
                                    'class' => 'correr');
                                echo form_open('login/check', $attributes);

                                $label = array('class' => 'control-label');

                                $username = array(
                                    'name' => 'username',
                                    'id' => 'inputUsername',
                                    'class' => 'form-control',
                                    'placeholder' => 'Username o Email');
                                $password = array(
                                    'name' => 'password',
                                    'id' => 'inputPassword',
                                    'class' => 'form-control',
                                    'placeholder' => 'Password');
                                $submit = array('type' => 'submit',
                                    'class' => 'btn btn-primary',
                                    'value' => $signin);
                                ?>

                                <?= form_input($username); ?>
                                <p class="text-error"><?= strip_tags(form_error('username')) ?></p>

                                <?= form_password($password); ?>
                                <p class="text-error"><?= strip_tags(form_error('password')) ?></p>

                                <?= form_submit($submit); ?><br/>

                                <?= anchor('profile/rest_pass', $forgot); ?> <br />
                                <?= anchor('login/register', $signup, array('title' => 'Registrarme')) ?>

                                </form>

                            </div>
                        </li>
                        <li><?= anchor('login/register', $signup, array('title' => 'Registrarme', 'id' => 'registrar')) ?><li>
                    </ul>
                </div>

            </div>
        </nav>


        <div class="container">
            <div class="row"><!--inicio row-->


