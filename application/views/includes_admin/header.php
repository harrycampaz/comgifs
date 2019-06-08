<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title><?= ucfirst($title) ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <meta name="description" content="ComGifs - sube, descarga y comparte imagenes animadas gifs muy divertidas ya sea de deporte,humor, para Blackberry Messenger (BBM) y mucho mas TODO ES COMPLETAMENTE GRATIS, compartirlas en las redes sociales facebook o twitter, una gran opcion para tumblr."/>
        <meta name="keywords" content="imagenes,animado gif, imagenes en gif, gif de anime ,imágenes con gif,imágenes de gif
              Android, Apple iOS, iPhone, iPad, iPod, Windows Phone, Windows
              compartir gif por BBM, Blackberry,whatsapp, tablets, gifs, cafe gif, animated gif,animaciones
              dibujos animados, imagenes animadas gratis, galerias de gifs, animaciones de humor, comic, cine, 
              gifs animados, gif animados, gif, animado, animados, gifs animados, gitfs animados, gif animadas, animadas" />

        <link rel="shortcut icon" href="<?= base_url() ?>iconos/favicon.ico">



        <script src='http://www.comgifs.com/Externos/video.js' type='text/javascript'></script>
        <link href="<?= base_url() ?>css/bootstrap.min.css" rel="stylesheet">

        <link href="<?= base_url() ?>css/bootswatch.min.css" rel="stylesheet">

        <link rel="stylesheet" href="<?= base_url() ?>css/style.css">

    </head>

    <body>


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

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?= base_url() ?>"><span class="glyphicon glyphicon-home"></span>&nbsp; ComGIFS</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <li><?php echo anchor('gifs/subirgif', $upload, array('title' => $upload)) ?></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">GIFS<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('gifs/ultimos', $most_recent, array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('gifs/destacado', $most_viewed, array('title' => $most_viewed)) ?></li>

                            </ul>
                        </li>

                        <li><?php echo anchor('gifs/aleatorio', $fun, array('title' => $fun, 'id' => 'diviertete')) ?></li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">Videos<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('videos/ultimos', 'Ultimos', array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('videos/destacados', 'Destacados', array('title' => $most_viewed)) ?></li>
                                <li><?php echo anchor('videos/add_videos', 'Subir Video', array('title' => $most_viewed)) ?></li>
                                <li><?php echo anchor('videos/listar', 'Listar Video', array('title' => 'Listar Videos')) ?></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $best ?><b class="caret"></b></a>
                            <ul class="dropdown-menu" id="swatch-menu">
                                <li><a href="<?= base_url() ?>profile/bestuser/6">VIP</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/5"><img src="<?= base_url() ?>img/estrella10.png" alt="5 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/4"><img src="<?= base_url() ?>img/estrella8.png"  alt="4 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/3"><img src="<?= base_url() ?>img/estrella6.png"  alt="3 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/2"><img src="<?= base_url() ?>img/estrella4.png"  alt="2 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/1"><img src="<?= base_url() ?>img/estrella2.png"  alt="1 estrellas GIFS"></a></li>
                            </ul>
                        </li>

                        <li>

                            <?php
                            $attributes = array('id' => 'buscar_form',
                                'class' => 'navbar-form');
                            echo form_open('gifs/gifsbuscar', $attributes);
                            $buscar_text = array(
                                'name' => 'buscar_text',
                                'placeholder' => $search_placeholder,
                                'class' => 'form-control'
                            );
                            echo form_input($buscar_text);
                            ?>
                            <button type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </form>

                        </li>


                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i>&nbsp;<?= ucwords($myname) ?><b class="caret"></b></a>
                            <ul class="dropdown-menu" id="swatch-menu">
                                <li><?php echo anchor('profile/user/' . $user, 'Perfil', array('title' => 'Perfil')) ?></li>
                                <li class="divider"></li>
                                <li><?php echo anchor('profile/', '<span class="glyphicon glyphicon-edit"></span> Editar perfil', array('title' => 'Perfil')) ?></li>
                                <li><?= anchor('login/logout', '<span class="glyphicon glyphicon-off"></span> Cerrar sesión', array('title' => 'Cerrar sesion')) ?></li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </div>

        </nav>

        <!-- Masthead
        ================================================== -->


        <div class="container"><!--inicio container-->
            <div class="row"><!--inicio row-->

