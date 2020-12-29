<>Single-Producto php || si no existe single.php || si no existe || singular.php</>

<main class="container">
    <?php if(have_posts()){
        while(have_posts()){
            the_post(); 
            
            $taxonomy = get_the_terms(get_the_ID(), 'categoria-productos');
            
            ?>
            
            <h1>El producto es: <?php the_title(); ?></h1>
            

            <div class="row">
                <div class="col-6">
                    <?php the_post_thumbnail('small'); ?>
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
           <?php // solo sacamos productos de su misma categoria y taxonometria
             $args = array(
                 'post_type' => 'producto', 
                 'posts_per_page' => 3,
                 'order' => 'ASC',
                 'orderby' => 'title',
                // 'cat' => 2
                 'tax_query' => array(
                     array(
                         'taxonomy' => 'categoria-productos',
                         'field'   => 'slug',
                         'terms'    => $taxonomy[0]->slug
                     )
                 ),
                );
             $productos = new WP_Query($args);

             if($productos->have_posts()){
                 while($productos->have_posts()){
                     $productos->the_post(); ?>
                   <div class="col-4">
                    <figure>
                        <?php the_post_thumbnail('small');?>
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