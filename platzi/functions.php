<?php

function init_template()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    // creamos menu, añadimos botones en wp-admin, insertamos menu en header con function wp_nav_menu
    register_nav_menus(
        array(
            'top_menu' => 'Menu Principal Creado en Functions.php',
            'bottom_menu' => 'Menu en el foooter',
        )
    );
}
add_action('after_setup_theme', 'init_template');


function assets()
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css', '', 'all');
    wp_register_style('montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap', '', 'all');
    wp_enqueue_style('estilos', get_stylesheet_uri(), array('bootstrap', 'montserrat'), '1.0', 'all');
    wp_register_script('poper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js', '', true);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js', array('jquery', 'poper'), '123', true);
    wp_enqueue_script('custom', get_template_directory_uri() . '/assets/js/custom.js', '', '1.0', true);

    // выводит в html source переменную js, var pg = {"ajaxurl":"http:\/\/localhost\/wp-admin\/admin-ajax.php"};
    wp_localize_script('custom', 'pg', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'apiurl' => home_url('wp-json/pg/v1/'),
    ));
}
add_action('wp_enqueue_scripts', 'assets');


function sidebar()
{
    // creamos sidebar(cumple mision de footer), añadimos elementos en wp-admin, le llamamos en footer para que aparezca
    register_sidebar(
        array(
            'name' => 'Pie de pagina',
            'id' => 'footer',
            'description' => 'Zona de Widgets para pie de pagina',
            'before_title' => '<p>',
            'after_title' => '</p>',
            'before_widget' => '<div id="%1$s" class= "%2$s">',
            'after_widget'  => '</div>',
        )
    );
}
add_action('widgets_init', 'sidebar');


// añadimos nuevo tipo de POST en console word press !
function productos_type()
{
    $labels = array(
        'name'               => 'Producto name',
        'singular_name'      => 'Producto singular name',
        'menu_name'          => 'Producto menu name',
        //  'public'             => true,                    
        //  'show_in_menu'       => true,
        //  'can_export'         => true,
        //  'publicly_queryable' => true,
        //  'show_ui' => true
    );
    $args =   array(
        'supports'          => array('category', 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'post-formats'),
        'label'             => 'producto',
        'labels'            => $labels,
        'public'            => true,
        'has_archive'       => true,
        'show_in_rest'      => true,
        'rewrite'           => true,
        'show_in_nav_menus' => true,
        'description'       => 'my custom product',
        'menu_icon'         => 'dashicons-store',
        'menu_position'     => 5,
    );
    register_post_type('producto', $args);
}
add_action('init', 'productos_type');


// añadir nuevo tipo de imagen
add_image_size('custom_size', 1300, 1300, true);


// creamos Categorias de Productos - taxonometry
function register_tax()
{
    $arg = array(
        'hierarchical' => true,
        'labels' => array('name' => 'Categorias de Productos', 'singular' => 'Categoria de Producto'),
        'show_in_nav_menu' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'categoria-productos')
    );
    register_taxonomy('categoria-productos', array('producto'), $arg);
}
add_action('init', 'register_tax');


// hook para que puedan usar usuarios logeados y no logeados
add_action("wp_ajax_nopriv_pgFiltroProductos", "pgFiltroProductos");
// hook para que puedan usar usuarios logeados y no logeados
add_action("wp_ajax_pgFiltroProductos", "pgFiltroProductos");
function pgFiltroProductos()
{
    $return = [];
    $args = array(
        'post_type' => 'producto',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
    );

    if ($_POST['categoria']) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categoria-productos',
                'field'   => 'slug',
                'terms'    => $_POST['categoria']
            )
        );
    };
    $productos = new WP_Query($args);

    if ($productos->have_posts()) {
        while ($productos->have_posts()) {
            $productos->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_id(), 'large'),
                'link'   => get_the_permalink(),
                'titulo' => get_the_title()
            );
        }
    }
    wp_send_json($return);
}


// registramos custom API
function pedidoNovedades($data)
{
    $return = [];
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $data['cantidad'],
        'order' => 'ASC',
        'orderby' => 'title',
    );

    $novedades = new WP_Query($args);

    if ($novedades->have_posts()) {
        while ($novedades->have_posts()) {
            $novedades->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_id(), 'large'),
                'link'   => get_the_permalink(),
                'titulo' => get_the_title()
            );
        }
    }
    return $return;
}
function novedadesAPI()
{
    register_rest_route(
        'pg/v1',
        '/novedades/(?P<cantidad>\d+)',
        array('methods' => 'GET', 'callback' => 'pedidoNovedades', 'permission_callback' => '__return_true')
    );
}
add_action('rest_api_init', 'novedadesAPI');


// registro de bloque para el uso de react!!!
function pgRegisterBlock()
{
    $assets = include_once get_template_directory() . '/block/build/index.asset.php';
    wp_register_script(
        'pg-block',
        get_template_directory_uri() . '/blocks/build/index.js',
        $assets['dependencies'],
        $assets['version']
    );
    register_block_type('pg/basic', array('editor_script' => 'pg-block'));
}
add_action('init', 'pgRegisterBlock');
