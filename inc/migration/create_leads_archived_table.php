<?php

function create_leads_archived_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'leads_archived';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            original_id INT NOT NULL,
            lead_name VARCHAR(255) NOT NULL,
            lead_email VARCHAR(255) NOT NULL,
            lead_phone VARCHAR(50) NOT NULL,
            lead_cpf_cnpj VARCHAR(20) NOT NULL,
            lead_company VARCHAR(255) NOT NULL,
            lead_position VARCHAR(255) NOT NULL,
            lead_source VARCHAR(50) NOT NULL DEFAULT 'other',
            lead_status VARCHAR(50) NOT NULL,
            deal_value DECIMAL(10, 2) NOT NULL,
            deal_stage VARCHAR(50) NOT NULL,
            expected_close_date DATE NOT NULL,
            last_contacted_date DATE NOT NULL,
            contact_method VARCHAR(50) NOT NULL,
            next_action_date DATE NOT NULL,
            next_action_description TEXT NOT NULL,
            activity_log LONGTEXT NOT NULL,
            lead_notes TEXT NOT NULL,
            lead_priority VARCHAR(50) NOT NULL DEFAULT 'low',
            lead_assigned_to VARCHAR(50) NOT NULL,
            assigned_team_id VARCHAR(50) NOT NULL,
            lead_tags LONGTEXT NOT NULL,
            lead_type VARCHAR(50) NOT NULL DEFAULT 'pf',
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'create_leads_archived_table');


/**
 * Atualiza a estrutura da tabela 'assinantes' no banco de dados.
 */
function update_leads_archived_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'leads_archived';

    // Verifica se a coluna 'deal_pj_discount' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'assigned_team_id'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN assigned_team_id VARCHAR(50) NOT NULL AFTER lead_assigned_to;");
    }
}

add_action('after_setup_theme', 'update_leads_archived_table');