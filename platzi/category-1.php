<?php get_header(); ?>

<h1>category-1.php = id 1 (category novedades)</h1>

<?php if(have_posts()){
        while(have_posts()){
            the_post(); ?>
            
            <h1><?php the_title(); ?></h1>
            <p><?php the_excerpt(); ?></p>  <!-- imprimir el rusumen de la entrada -->
            <p><?php the_category(); ?></p>  
            <p><?php the_author(); ?></p>  
            <p><?php the_date(); ?></p> 
            

            <div class="row">
                <div class="col-6">
                    <?php the_post_thumbnail('large'); ?>
                </div>
                <div class="col-6">
                    <?php the_content(); ?>
                </div>
            </div>   

      <?php  }
    } ?>

<?php get_footer(); ?>