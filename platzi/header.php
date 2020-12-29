<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>



</head>
<body>
    
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4">
                <img src="<?php echo get_template_directory_uri();?>/assets/img/logo.png" alt="alexei suzdalenko wordpress" />
            </div>
            <div class="col-8">
               <?php wp_nav_menu(array(
                   'theme_location' => 'top_menu',       // localizacion del menu ¿top_menu functions.php?
                   'menu_class'     => 'menu-principal', // classe de ul
                   'container_class'=> 'container-menu'  // classe de div que envuelve todo
               ));   ?> 
            </div>
        </div>
    </div>
</header>