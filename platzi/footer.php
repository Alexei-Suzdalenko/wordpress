<footer>
    <div class="container">
        <?php dynamic_sidebar('footer');?>
    </div>
    <br><h1>FOOTER</h1>
    <div>
    <?php wp_nav_menu(array(
                   'theme_location' => 'bottom_menu',       // localizacion del menu ¿top_menu functions.php?
                   'menu_class'     => 'menu-principal', // classe de ul
                   'container_class'=> 'container-menu'  // classe de div que envuelve todo
               ));   ?> 
    </div>
</footer>

<?php wp_footer( ); ?>

</body>
</html>