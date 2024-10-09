<?php

function create_notifications_archived_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'notifications_archived';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            original_id INT NOT NULL,
            user_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            type VARCHAR(50),
            origin_type VARCHAR(50),
            origin_id INT,
            status VARCHAR(20) DEFAULT 'unread',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY original_id (original_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_notifications_archived_table');
?>
