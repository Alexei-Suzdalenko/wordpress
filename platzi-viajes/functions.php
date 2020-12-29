<?php 
// añadir un nuevo role en la lista de los roles.... add users
function add_role_viajero(){
    // remove_role('viajero');
    add_role(
        'viajero', 'Viajero', [
            'read' => true, 'edit_posts' => true, 'upload_files' => true, 'publish_posts' => true, 'delete_posts' => true,
            'edit_published_posts' => true, 'delete_published_posts' => true
        ]
    );
}
add_action('init', 'add_role_viajero');


// añadir nuevo tipo de entrada
function wporg_custom_post_type() {
    register_post_type('ruta',
        array(
            'labels'      => array(
                'name'          => __('Mis rutas', 'textdomain'),
                'singular_name' => __('Mi ruta', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => true,
                'show_in_rest'=> true 
        )
    );
}
add_action('init', 'wporg_custom_post_type');

// añadir nuevo tipo de entrada
function wporg_custom_post_type_viaje() {
    register_post_type('viaje',
        array(
            'labels' => array('name' => __('Mis Viajes', 'textdomain'), 'singular_name' => __('Mi viaje', 'textdomain'),),
            'supports'    => array('title', 'editor', 'author', 'thumbnail'),     
            'show_in_menu'=> true,
            'show_ui'     => true,
            'public'      => true,
            'has_archive' => true,
            'show_in_rest'=> true 
        )
    );
}
add_action('init', 'wporg_custom_post_type_viaje');

// hook
function holaMundo(){
    echo 'Hola mundo';
}
add_action('wp_head', 'holaMundo');

function add_administrador_tema_role() { //nombre de nuestra función, puede ser el nombre que quieras
    // remove_role( 'administrador_tema' );
    add_role(
        'administrador_tema', //Nombre de role.
        'Administrador Tema', //Nombre que se visualará en la creación o página de opciones de usuarios.
       array(    
            'read' => true, //Permite el acceso al dashboard del adminitrador.
            'switch_themes' => true, //Permite el cambio de temas.
            'edit_themes'   => true, //Permite editar archivos desde el administrado de archivos del tema.
            'edit_theme_options' => true, //Permite modificar Widgets,Menús, Personalizar.
            'install_themes'    => true,  //Permite instalar temas nuevos.
            'update_themes' => true, //Permite actualizar temas instalados.
            'delete_themes' => true, //Permite eliminar temas.

            )   //Array con las capabilities
    );
}
//add_action(Hook, Nombre de la función)
add_action('init', 'add_administrador_tema_role');
