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
        <?php if (isset($view)) { ?>
            <meta name="twitter:card" content="photo">
            <meta name="twitter:site" content="@comgifs">
            <meta name="twitter:creator" content="@comgifs">
            <meta name="twitter:url" content="<?= base_url() ?>gifs/view/<?= $datos['imagen'] ?>">
            <meta name="twitter:title" content="<?= ucfirst($datos['titulo']) ?>">
            <meta name="twitter:image:src" content="<?= base_url() ?>uploads/<?= $datos['imagen'] ?>">
            <meta name="twitter:domain" content="http://www.comgifs.com">


        <?php } ?>

        <?php if (isset($mivideo)) { ?>
            <meta name="twitter:card" content="photo">
            <meta name="twitter:site" content="@comgifs">
            <meta name="twitter:creator" content="@comgifs">
            <meta name="twitter:url" content="<?= base_url() ?>videos/view/<?= $video['enlace'] . '/' . $p ?>">
            <meta name="twitter:title" content="<?= ucfirst($video['titulo']) ?>">
            <meta name="twitter:image:src" content="<?= $video['avatar_video'] ?>">
            <meta name="twitter:domain" content="http://www.comgifs.com">


        <?php } ?>
        <meta name="google-site-verification" content="__DkcncvesbFhjniFSwSda4ShjA61qKjGppqSlEWIUM" />
        <meta name="msvalidate.01" content="928C0A777098822903887D2AD80B8F05" />
        <meta name="description" content="ComGifs es un sitio web para subir, descargar y compartir (Facebook, twitter) imágenes animadas gifs, encontrar las mejores imágenes graciosas,Fútbol (Real Madrid, Barcelona, Manchester United,Cristiano Ronaldo, Bale, Messi, Neymar), También gif para BBM Blackberry y mucho mas - alternativa para tumblr y imgur."/>
        <meta name="keywords" content="imagenes,animado gif, imagenes en gif, gif de anime ,imágenes con gif,imágenes de gif
              Android, Apple iOS, iPhone, iPad, iPod, Windows Phone, Windows
              compartir gif por BBM, Blackberry,whatsapp, tablets, gifs, cafe gif, animated gif,animaciones
              dibujos animados, imagenes animadas gratis, galerias de gifs, animaciones de humor, comic, cine, 
              gifs animados, gif animados, gif, animado, animados, gifs animados, gitfs animados, gif animadas, animadas" />

        <link rel="shortcut icon" href="<?= base_url() ?>iconos/favicon.ico">



        <link href="<?= base_url() ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>css/bootswatch.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css">

    </head>


    <body>
        <!-- Navbar
          ================================================== -->

        <nav class="navbar navbar-inverse navbar-fixed-top">
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

                      
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">GIFS<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('gifs/ultimos', $most_recent, array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('gifs/destacado', $most_viewed, array('title' => $most_viewed)) ?></li>

                            </ul>
                        </li><li><?php echo anchor('gifs/aleatorio', $fun, array('title' => $fun, '', 'id' => 'diviertete')) ?></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="">Articulos<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo anchor('videos/ultimos', 'Ultimos', array('title' => $most_recent)) ?></li>
                                <li><?php echo anchor('videos/destacados', 'Destacados', array('title' => $most_viewed)) ?></li>
                                <li><?php echo anchor('videos/add_videos', 'Crear Nuevo', array('title' => "Crear")) ?></li>
                                <li><?php echo anchor('videos/MisPost', 'Mis Articulos', array('title' => 'Listar Videos')) ?></li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href=""><?= $best ?><b class="caret"></b></a>
                            <ul class="dropdown-menu" id="swatch-menu">
                                <li><a href="<?= base_url() ?>profile/best_user/6">VIP</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/5"><img src="<?= base_url() ?>img/estrella10.png" alt="5 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/4"><img src="<?= base_url() ?>img/estrella8.png"  alt="4 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/3"><img src="<?= base_url() ?>img/estrella6.png"  alt="3 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/2"><img src="<?= base_url() ?>img/estrella4.png"  alt="2 estrellas GIFS"></a></li>
                                <li><a href="<?= base_url() ?>profile/bestuser/1"><img src="<?= base_url() ?>img/estrella2.png"  alt="1 estrellas GIFS"></a></li>
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
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i>&nbsp;<?= ucwords($myname) ?><b class="caret"></b></a>
                            <ul class="dropdown-menu" id="swatch-menu">
                                <li><?php echo anchor('profile/user/' . $user, 'Perfil', array('title' => 'Perfil')) ?></li>
                                <li><?php echo anchor('partner/', '<span class="glyphicon glyphicon-usd"></span> Ingresos', array('title' => 'Ingresos')) ?></li>
                                <li class="divider"></li>
                                <li><?php echo anchor('profile/', '<span class="glyphicon glyphicon-edit"></span> Editar perfil', array('title' => 'Perfil')) ?></li>
                                <li><?= anchor('login/logout', '<span class="glyphicon glyphicon-off"></span>  Cerrar sesión', array('title' => 'Cerrar sesion')) ?></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>


        <div class="container"><!--inicio container-->
            <div class="row"><!--inicio row-->



