<?php

function create_assinantes_archived_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes_archived';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            cpf_cnpj VARCHAR(20) NOT NULL,
            phone VARCHAR(20) NULL,
            mobile_phone VARCHAR(20) NULL,
            postal_code VARCHAR(10) NOT NULL,
            address VARCHAR(255) NOT NULL,
            address_number VARCHAR(10) NOT NULL,
            complement VARCHAR(255) NULL,
            province VARCHAR(255) NOT NULL,
            city VARCHAR(255) NULL,
            uf VARCHAR(2) NULL,
            entity_type VARCHAR(50) NOT NULL,
            subscription_status VARCHAR(50) NOT NULL,
            subscription_start_date DATE NOT NULL,
            asaas_customer_id VARCHAR(255) NOT NULL,
            asaas_subscription_id VARCHAR(255) NOT NULL,
            subscription_value DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            vendor_id INT NULL,
            related_to INT NULL,
            role_type ENUM('TITULAR', 'DEPENDENTE') NOT NULL DEFAULT 'TITULAR',
            split_removed TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            archived_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    } 
}

add_action('after_setup_theme', 'create_assinantes_archived_table');


/**
 * Atualiza a estrutura da tabela 'assinantes' no banco de dados.
 */
function update_assinantes_archived_table_structure() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes_archived';
    $sales_table_name = $wpdb->prefix . 'sales';

    // Remove UNIQUE constraint on 'cpf_cnpj' if it exists
    $index = $wpdb->get_results("SHOW INDEX FROM $table_name WHERE Key_name = 'cpf_cnpj_unique'");
    if (!empty($index)) {
        $wpdb->query("ALTER TABLE $table_name DROP INDEX cpf_cnpj_unique;");
    }

    // Modify 'sale_id' column to be NULLABLE
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN sale_id INT NULL;");
    // Drop existing foreign key constraint if it exists
    $constraints = $wpdb->get_results("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = 'sale_id' AND CONSTRAINT_SCHEMA = DATABASE();");
    foreach ($constraints as $constraint) {
        $wpdb->query("ALTER TABLE $table_name DROP FOREIGN KEY {$constraint->CONSTRAINT_NAME};");
    }
    // Re-add foreign key constraint
    $wpdb->query("ALTER TABLE $table_name ADD CONSTRAINT fk_archived_sale_id FOREIGN KEY (sale_id) REFERENCES $sales_table_name(id) ON DELETE SET NULL;");

    // Modify 'role_type' column
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN role_type ENUM('TITULAR', 'DEPENDENTE') NULL DEFAULT 'TITULAR';");

    // Modify 'asaas_subscription_id' column
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN asaas_subscription_id VARCHAR(255) NULL;");

    // Modify 'subscription_value' column
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN subscription_value DECIMAL(10,2) NULL DEFAULT 0.00;");

    // Modify 'base_price' column (add if it doesn't exist)
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'base_price'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN base_price DECIMAL(10,2) NULL;");
    } else {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN base_price DECIMAL(10,2) NULL AFTER subscription_value;");
    }

    // Modify 'deal_billing_cycle' column (add if it doesn't exist)
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_billing_cycle'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN deal_billing_cycle ENUM('monthly', 'yearly') NULL DEFAULT 'monthly';");
    } else {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_billing_cycle ENUM('monthly', 'yearly') NULL DEFAULT 'monthly' AFTER base_price;");
    }

    // Modify 'deal_pj_discount' column (add if it doesn't exist)
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_pj_discount'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN deal_pj_discount DECIMAL(5,2) NULL DEFAULT 0;");
    } else {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_pj_discount DECIMAL(5,2) NULL DEFAULT 0 AFTER base_price;");
    }

    // Modify 'deal_pj_number_dependents' column (add if it doesn't exist)
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_pj_number_dependents'");
    if (!empty($column)) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN deal_pj_number_dependents INT NULL DEFAULT 0;");
    } else {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_pj_number_dependents INT NULL DEFAULT 0 AFTER deal_pj_discount;");
    }

    // Modify 'entity_type' column
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN entity_type VARCHAR(50) NULL;");

    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'birth_date'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN birth_date DATE NULL AFTER email;");
    }

    // Modify 'subscription_status' column
    $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN subscription_status ENUM('ACTIVE', 'SUSPENDED', 'PENDING') NULL DEFAULT 'PENDING';");

    // Modify other columns to be NULLABLE as needed
    $columns_to_modify = [
        'name' => 'VARCHAR(255)',
        'email' => 'VARCHAR(255)',
        'cpf_cnpj' => 'VARCHAR(20)',
        'postal_code' => 'VARCHAR(10)',
        'address' => 'VARCHAR(255)',
        'address_number' => 'VARCHAR(10)',
        'province' => 'VARCHAR(255)',
        'subscription_start_date' => 'DATE',
        'asaas_customer_id' => 'VARCHAR(255)',
        'vendor_id' => 'INT',
        'related_to' => 'INT',
        'split_removed' => 'TINYINT(1) DEFAULT 0',
    ];

    foreach ($columns_to_modify as $column_name => $definition) {
        $wpdb->query("ALTER TABLE $table_name MODIFY COLUMN $column_name $definition NULL;");
    }
}



add_action('after_setup_theme', 'update_assinantes_archived_table_structure');

?>
