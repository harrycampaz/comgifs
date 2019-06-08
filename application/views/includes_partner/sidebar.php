<!-- sidebar
================================================== -->
<nav class="col-lg-4">

    <div class="well"  style="padding: 8px;">

        <header><strong><?= $category_li ?></strong></header>

        <?php foreach ($categoria as $categoria_item): ?>

            <a href="<?= base_url() . 'gifs/gifscategoria/' . $categoria_item['id_categoria'] ?>"><?= $categoria_item['nombre_categoria'] ?></a> | 

        <?php endforeach; ?>


    </div>

    <div class="well" style="padding: 8px;">
        <header><strong><?= $tags_li ?></strong></header>

        <?php foreach ($tag as $tag_item): ?>

            <a href="<?= base_url() . 'gifs/gifsetiquetas/' . $tag_item['nombre_etiqueta'] ?>"><?= $tag_item['nombre_etiqueta'] ?></a> |

        <?php endforeach; ?>


    </div>

    <div class="well" style="padding: 8px;">
        <header><strong>Partner</strong></header>

        <a href="<?= base_url() . 'partner/all_gifs/' ?>">Todos los GIFS</a> <br/>
        <a href="<?= base_url() . 'partner/meses/' ?>">Ingresos Ultimos Meses</a>


    </div>
</nav>

