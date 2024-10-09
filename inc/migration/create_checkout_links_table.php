<?php

function create_checkout_links_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'checkout_links';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            uuid VARCHAR(36) NOT NULL,
            lead_id BIGINT(20) NOT NULL,
            plan_id BIGINT(20) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            expires_at DATETIME NOT NULL,
            payment_status VARCHAR(20) DEFAULT 'pending' NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY uuid (uuid)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_checkout_links_table');

?>
