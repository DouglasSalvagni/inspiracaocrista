<?php 
/**
 * Cria a tabela 'sales' no banco de dados.
 */
function create_sales_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales';

    // Verifica se a tabela já existe
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            sale_date VARCHAR(255) NOT NULL,
            sale_amount DECIMAL(10,2) NOT NULL,
            deal_amount DECIMAL(10,2) NULL,
            sale_confirmed VARCHAR(255) NOT NULL,
            sale_received VARCHAR(255) NOT NULL,
            sale_status VARCHAR(255) NOT NULL,
            sale_vendor_id INT NULL,
            sale_team_id INT NULL,
            sale_asaas_subscription_id VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Chama a função para atualizar a estrutura da tabela
    update_sales_table_structure();
}

/**
 * Atualiza a estrutura da tabela 'sales' no banco de dados.
 */
function update_sales_table_structure() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales';

    // Verifica se a coluna 'deal_amount' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'deal_amount'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN deal_amount DECIMAL(10,2) NULL AFTER sale_amount;");
    }

    // Verifica se a coluna 'sale_team_id' já existe, caso contrário, adiciona
    $column = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'sale_team_id'");
    if (empty($column)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN sale_team_id INT NULL AFTER sale_vendor_id;");
    }

    // Aqui você pode adicionar mais verificações e alterações conforme necessário
}

add_action('after_setup_theme', 'create_sales_table');

?>
