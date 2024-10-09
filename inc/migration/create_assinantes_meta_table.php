<?php

function create_assinantes_meta_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes_meta';
    $assinantes_table_name = $wpdb->prefix . 'assinantes';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            meta_id BIGINT(20) NOT NULL AUTO_INCREMENT,
            assinante_id INT NOT NULL,
            meta_key VARCHAR(255) NULL,
            meta_value LONGTEXT NULL,
            PRIMARY KEY (meta_id),
            KEY assinante_id (assinante_id),
            FOREIGN KEY (assinante_id) REFERENCES $assinantes_table_name(id) ON DELETE CASCADE
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_assinantes_meta_table');
?>
