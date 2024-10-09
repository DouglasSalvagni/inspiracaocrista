<?php // Adicionar uma nova página ao menu administrativo
add_action('admin_menu', 'register_custom_admin_page');

function register_custom_admin_page() {
    add_menu_page(
        'Listar Tabelas do Banco de Dados',
        'Listar Tabelas',
        'manage_options',
        'listar-tabelas',
        'display_table_contents',
        'dashicons-database',
        20
    );
}

// Função que exibe o conteúdo das tabelas especificadas
function display_table_contents() {
    global $wpdb;

    // Array com as tabelas que queremos listar
    $tables = array(
        $wpdb->prefix . 'assinantes',
        $wpdb->prefix . 'sales'
    );

    // Verificar se uma tabela foi selecionada
    $selected_table = isset($_POST['table_select']) ? sanitize_text_field($_POST['table_select']) : '';

    echo '<div class="wrap">';
    echo '<h1>Listar Tabelas do Banco de Dados</h1>';

    // Formulário para selecionar a tabela
    echo '<form method="post">';
    echo '<label for="table_select">Selecione a Tabela:</label> ';
    echo '<select id="table_select" name="table_select">';
    echo '<option value="">-- Selecione uma tabela --</option>';
    foreach ($tables as $table) {
        $table_name = str_replace($wpdb->prefix, '', $table);
        $selected = ($table === $selected_table) ? 'selected' : '';
        echo '<option value="' . esc_attr($table) . '" ' . $selected . '>' . esc_html(ucfirst($table_name)) . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" value="Exibir Tabela" class="button button-primary" />';
    echo '</form>';

    // Adicionar o CSS para ajustar as colunas à largura do conteúdo e permitir rolagem lateral
    echo '<style>
        .widefat-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        .widefat {
            width: 100%;
            border-collapse: collapse;
        }
        .widefat th, .widefat td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        .widefat th {
            background-color: #f1f1f1;
        }
        .widefat td {
            white-space: nowrap; /* Ensure content stays on one line */
        }
        .widefat {
            table-layout: auto; /* Adjust the width of the table columns based on the content */
        }
        .widefat th.id-column, .widefat td.id-column {
            width: 50px; /* Adjust this value as necessary for the maximum width of 5 characters */
            max-width: 50px; /* Ensure the column does not exceed the specified width */
            text-align: center; /* Center the text in the id column */
        }
    </style>';

    // Exibir o conteúdo da tabela selecionada
    if (!empty($selected_table) && in_array($selected_table, $tables)) {
        $table_name = str_replace($wpdb->prefix, '', $selected_table);
        echo '<h2>' . esc_html(ucfirst($table_name)) . '</h2>';

        $results = $wpdb->get_results("SELECT * FROM $selected_table", ARRAY_A);

        if (empty($results)) {
            echo '<p>Nenhum registro encontrado na tabela ' . esc_html($table_name) . '.</p>';
        } else {
            echo '<div class="widefat-container">';
            echo '<table class="widefat fixed" cellspacing="0">';
            echo '<thead>';
            echo '<tr>';

            // Header
            foreach ($results[0] as $key => $value) {
                $class = $key === 'id' ? 'class="id-column"' : '';
                echo '<th ' . $class . '>' . esc_html($key) . '</th>';
            }

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Body
            foreach ($results as $row) {
                echo '<tr>';
                foreach ($row as $key => $value) {
                    $class = $key === 'id' ? 'class="id-column"' : '';
                    echo '<td ' . $class . '>' . esc_html($value) . '</td>';
                }
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>'; // End of .widefat-container
        }
    }

    echo '</div>';
}
 ?>