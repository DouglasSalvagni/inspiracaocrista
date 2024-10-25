<?php

function create_assinantes_frases_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes_frases';
    $assinantes_table_name = $wpdb->prefix . 'assinantes';
    $frases_table_name = $wpdb->prefix . 'frases';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            assinante_id INT NOT NULL,
            frase_id INT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (assinante_id) REFERENCES $assinantes_table_name(id) ON DELETE CASCADE,
            FOREIGN KEY (frase_id) REFERENCES $frases_table_name(id) ON DELETE CASCADE
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_assinantes_frases_table');

