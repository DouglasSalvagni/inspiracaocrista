<?php
function registrar_post_types_leads()
{
  register_post_type(
    'leads',
    array(
      'labels' =>  createLabelsCPT('Lead', 'Leads', true),
      'public' => false,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'has_archive' => false,
      'capability_type' => 'post',
      'hierarchical' => false,
      'menu_position' => 23,
      'menu_icon' => 'dashicons-backup',
      'supports' => array('title')
    )
  );
}
add_action('init', 'registrar_post_types_leads');
