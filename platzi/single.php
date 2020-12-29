// single.php da vista a una entrada - запись и nuevos tipos de post que creamos
<?php get_header(); ?>
<?php bloginfo('name'); ?> <br>
<?php bloginfo('description'); ?> <br>
<?php bloginfo('wpurl'); ?> <br>
<?php bloginfo('admin_email'); ?> <br>
<?php bloginfo('charset'); ?><br>
<?php bloginfo('version'); ?> <br>
<?php bloginfo('language'); ?><br>
<?php bloginfo('stylesheet_directory'); ?> <br>

<main class="container">
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
            <?php get_template_part('template-parts/post', 'navigation'); ?>
      <?php  }
    } ?>

    <div class="lista-productos">
        <h2 class="text-center">Productos</h2>
        <div class="row">
           <?php
             $args = array(
                 'post_type' => 'producto', 
                // 'post_per_page' => -1,
                // 'order' => 'ASC',
                // 'orderby' => 'title',
                // 'cat' => 2
                );
             $productos = new WP_Query($args);

             if($productos->have_posts()){
                 while($productos->have_posts()){
                     $productos->the_post(); ?>
                   <div class="col-4">
                    <figure>
                        <?php the_post_thumbnail('large');?>
                    </figure>
                    <h4 class="text-center">
                       <a href="<?php the_permalink();?>">
                            <?php the_title();?>
                        </a>
                    </h4>
                   </div>
            <?php }
             }
             ?>
          </div>
    </div>
</main>

<?php get_footer('single'); ?>