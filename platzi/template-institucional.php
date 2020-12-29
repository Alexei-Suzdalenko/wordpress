<?php
/*
Template Name: Pagina Institucional
*/

get_header(); ?>
// template-institucional.php da vista a una pagina - страница
// tiene dos campos personalizados titulo y image

<main class="container">
    <?php if(have_posts()){
        while(have_posts()){
            the_post(); ?>
            
            <h1 class="my-3"><?php the_title();?></h1>
            <?php the_content();?>
      <?php  }
    } 
    
    $field = get_fields();

    echo $field['titulo'] . '<br>'. '<img src="'. $field['imagen']["url"]. '" />';

  
    ?>
</main>

<?php get_footer(); ?>