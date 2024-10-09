<?php

function create_disqualified_leads_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'disqualified_leads';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NULL,
            email VARCHAR(255) NULL,
            cpf_cnpj VARCHAR(20) NULL,
            phone VARCHAR(20) NULL,
            mobile_phone VARCHAR(20) NULL,
            postal_code VARCHAR(10) NULL,
            address VARCHAR(255) NULL,
            address_number VARCHAR(10) NULL,
            complement VARCHAR(255) NULL,
            province VARCHAR(255) NULL,
            city VARCHAR(255) NULL,
            uf VARCHAR(2) NULL,
            reason VARCHAR(255) NOT NULL,
            vendor_id INT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_disqualified_leads_table');

?>
