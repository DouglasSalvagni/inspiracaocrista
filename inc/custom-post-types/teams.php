<?php

function register_team_post_type()
{
    $labels = array(
        'name' => 'Times',
        'singular_name' => 'Time',
        'add_new' => 'Adicionar Novo',
        'add_new_item' => 'Adicionar Novo Time',
        'edit_item' => 'Editar Time',
        'new_item' => 'Novo Time',
        'view_item' => 'Ver Time',
        'search_items' => 'Procurar Times',
        'not_found' => 'Nenhum time encontrado',
        'not_found_in_trash' => 'Nenhum time encontrado na lixeira',
        'menu_name' => 'Times',
    );

    $args = array(
        'labels' => $labels,
        'public' => false, // Defina como true se quiser que os times sejam públicos
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor'),
        'has_archive' => false,
        'rewrite' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
    );

    register_post_type('team', $args);
}
add_action('init', 'register_team_post_type');
