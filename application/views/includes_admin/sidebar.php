<!-- sidebar
================================================== -->

<nav class="col-lg-4">

    <div class="well"  style="padding: 8px;">
        <ul class="nav nav-list">        
            <li class="nav-header">Partner</li>
            <hr/>
            <li><?php echo anchor('buspartner', 'Partner', array('title' => 'Partner')) ?></li>
            <li><?php echo anchor('historial_dia', 'Historial por dias', array('title' => 'Historial por dias')) ?></li>
             <li><?php echo anchor('historial_mes', 'Historial por meses', array('title' => 'Historial por meses')) ?></li>
            
            <hr/>
             <li class="nav-header">GIFS</li>
            <li><?php echo anchor('all_gifs', 'Todos los GIF', array('title' => 'Todos los GIFS')) ?></li>
            <li><?php echo anchor('user', 'User', array('title' => 'User')) ?></li>
            <li><?php echo anchor('categoria', 'Categoria', array('title' => 'Categoria')) ?></li>
            <li><?php echo anchor('reporte', 'Reportes', array('title' => 'Reportes')) ?></li>
            <li><?php echo anchor('tag', 'tag', array('title' => 'Tag')) ?></li>
        </ul>
    </div>
    <div class="well"  style="padding: 8px;">
        <ul class="nav nav-list">        
            <li class="nav-header"><?= $category_li ?></li>
            <hr/>
            <?php foreach ($categoria as $categoria_item): ?>

                <a href="<?= base_url() . 'gifs/gifscategoria/' . $categoria_item['id_categoria'] ?>"><?= $categoria_item['nombre_categoria'] ?></a> | 

            <?php endforeach; ?>

        </ul>
    </div>

    <div class="well" style="padding: 8px;">
        <ul class="nav nav-list">


            <li class="nav-header"><?= $tags_li ?></li>
            <hr>

            <?php foreach ($tag as $tag_item): ?>

                <a href="<?= base_url() . 'gifs/gifsetiquetas/' . $tag_item['nombre_etiqueta'] ?>"><?= $tag_item['nombre_etiqueta'] ?></a> |

            <?php endforeach; ?>

        </ul>
    </div>
    <div class="well" style="padding: 8px;">
        <ul class="nav nav-list">
            <li class="nav-header"><?= $best ?></li>
            <hr>

            <?php foreach ($best_users as $best_item): ?>

                <a href="<?= base_url() . 'profile/user/' . $best_item['username'] ?>"><?= $best_item['username'] ?></a> |

            <?php endforeach; ?>
        </ul>

    </div>
</nav>

