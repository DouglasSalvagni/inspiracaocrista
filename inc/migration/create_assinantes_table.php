<?php

function create_assinantes_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes';
    $sales_table_name = $wpdb->prefix . 'sales';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            birth_date DATE NULL,
            cpf_cnpj VARCHAR(20) NOT NULL,
            phone VARCHAR(20) NULL,
            mobile_phone VARCHAR(20) NULL,
            postal_code VARCHAR(10) NOT NULL,
            address VARCHAR(255) NOT NULL,
            address_number VARCHAR(10) NOT NULL,
            complement VARCHAR(255) NULL,
            province VARCHAR(255) NOT NULL,
            city VARCHAR(255) NULL,
            uf VARCHAR(255) NULL,
            entity_type VARCHAR(50) NOT NULL,
            subscription_status ENUM('ACTIVE', 'SUSPENDED') NOT NULL DEFAULT 'SUSPENDED',
            subscription_start_date DATE NOT NULL,
            asaas_customer_id VARCHAR(255) NOT NULL,
            asaas_subscription_id VARCHAR(255) NOT NULL,
            subscription_value DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            vendor_id INT NULL,
            related_to INT NULL,
            sale_id INT NULL,
            role_type ENUM('TITULAR', 'DEPENDENTE') NOT NULL DEFAULT 'TITULAR',
            split_removed TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY cpf_cnpj_unique (cpf_cnpj),
            FOREIGN KEY (sale_id) REFERENCES $sales_table_name(id) ON DELETE SET NULL
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Chama a função para atualizar a estrutura da tabela
    update_assinantes_table_structure();
}

/**
 * Atualiza a estrutura da tabela 'assinantes' no banco de dados.
 */
function update_assinantes_table_structure() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes';
    $sales_table_name = $wpdb->prefix . 'sales';

    // Verifica se a coluna 'sale_id' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'sale_id'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN sale_id INT NULL;");
        $wpdb->query("ALTER TABLE $table_name ADD CONSTRAINT fk_sale_id FOREIGN KEY (sale_id) REFERENCES $sales_table_name(id) ON DELETE SET NULL;");
    }

    // Verifica se a coluna 'role_type' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'role_type'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN role_type ENUM('TITULAR', 'DEPENDENTE') NOT NULL DEFAULT 'TITULAR';");
    }

    // Verifica se a coluna 'role_type' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'asaas_subscription_id'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN asaas_subscription_id VARCHAR(255) NOT NULL AFTER asaas_customer_id;");
    }

    // Verifica se a coluna 'subscription_value' precisa ser atualizada
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'subscription_value'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN subscription_value DECIMAL(10,2) NOT NULL DEFAULT 0.00;");
    }

    // Verifica se a coluna 'base_price' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'base_price'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN base_price DECIMAL(10,2) NULL AFTER subscription_value;");
    }

    // Verifica se a coluna deal_billing_cycle já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_billing_cycle'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_billing_cycle ENUM('monthly', 'yearly') NOT NULL DEFAULT 'monthly' AFTER base_price;");
    }

    // Verifica se a coluna 'deal_pj_discount' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_pj_discount'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_pj_discount DECIMAL(5,2) NULL DEFAULT 0 AFTER base_price;");
    }

    // Verifica se a coluna 'deal_pj_discount' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_pj_number_dependents'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_pj_number_dependents INT NOT NULL DEFAULT 0 AFTER deal_pj_discount;");
    }

    // Verifica se a coluna 'entity_type' precisa ser atualizada
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'entity_type'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN entity_type VARCHAR(50) NOT NULL AFTER uf;");
    }

    // Verifica se a coluna 'entity_type' precisa ser atualizada
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'birth_date'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN birth_date DATE NULL AFTER email;");
    }

    // modificar coluna subscription_status
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'subscription_value'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN subscription_status ENUM('ACTIVE', 'SUSPENDED', 'PENDING') NOT NULL DEFAULT 'PENDING';");
    }
}

add_action('after_setup_theme', 'create_assinantes_table');

?>
