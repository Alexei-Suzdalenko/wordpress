// da vista a el inicio - fron-page.php // это главная страница, всегда
<?php get_header(); ?>

<main class="container">
    <?php if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
    <?php  }
    } ?>
</main>

<section>
    <select class="form-control" name="categorias-productos" id="categorias-productos">
        <option value="">Todas las categorias</option>
        <?php $terms = get_terms('categoria-productos', array('hide_empty' => true)); ?>
        <?php foreach ($terms as $term) {
            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
        }; ?>
    </select>
    <div id="resultado-productos"></div>
</section>

<h1>Novedades</h1>
<div id="res">res</div>








<?php get_footer(); ?>