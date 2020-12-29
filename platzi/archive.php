<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-12 text-center">
        <?php the_archive_title(); the_title(); ?>
        </div>
    </div>
    <?php if(have_posts()){
        while(have_posts()){
            the_post(); ?>
                <div class="col-4 text-center-single-archive">
                    <a href="<?php the_permalink();?>">
                        <?php the_post_thumbnail('large');?>
                        <h4><?php the_title();?></h4>
                    </a>
                </div>
        <?php }
    }
    ?>
</div>

<?php get_footer(); ?>
<p>archive.php || si no existe el category.php function archive.php || si creamos categoria propia(producto) functiona archive.php si no - index.php</p>