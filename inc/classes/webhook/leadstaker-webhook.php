<?php
function handle_leadstaker_webhook(WP_REST_Request $request)
{
    $body = $request->get_body();
    $decoded_body = json_decode($body, true);

    // Capturar as informações desejadas
    $nome = $decoded_body['answers']['Nome'] ?? '';
    $telefone = $decoded_body['answers']['Telefone'] ?? '';
    $originURL = $decoded_body['originURL'] ?? '';

    // Verificar se já existe um lead com o mesmo telefone
    $existing_lead = new WP_Query(array(
        'post_type' => 'leads',
        'meta_query' => array(
            array(
                'key' => 'lead_phone',
                'value' => $telefone,
                'compare' => '='
            )
        )
    ));

    if ($existing_lead->have_posts()) {
        return new WP_REST_Response('Lead with this phone number already exists.', 409);
    }

    // Inserir o novo post no CPT 'leads'
    $post_data = array(
        'post_title' => $nome,
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'leads',
    );

    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, 'lead_phone', $telefone);
        update_post_meta($post_id, 'originURL', $originURL);
        update_post_meta($post_id, 'lead_status', 'lead_discovered');
        update_post_meta($post_id, 'lead_assigned_team_id', 748);

        $representante_nome = 'N/A';

        // Verificar se a URL de origem contém 'dnacarebrasil.com.br'
        if (strpos($originURL, 'dnacarebrasil.com.br') !== false) {
            // Distribuir o lead para a equipe comercial e obter o objeto do representante
            $representante = distribute_lead($post_id);

            if ($representante) {
                $representante_nome = $representante->first_name . ' ' . $representante->last_name;
            }
        }

        // Caminhos para os arquivos onde o conteúdo será salvo
        $dir_path = WP_CONTENT_DIR . '/webhooks/CRM/leadstaker/';
        $file_path_txt = $dir_path . 'leadstaker.txt';
        $file_path_csv = $dir_path . 'leadstaker.csv';
        $file_path_json = $dir_path . 'leadstaker_json.txt';

        // Verificar e criar diretórios se não existirem
        if (!file_exists($dir_path)) {
            wp_mkdir_p($dir_path);
        }

        // Conteúdo a ser escrito no arquivo de texto
        $content_txt = "Nome: " . $nome . "\nTelefone: " . $telefone . "\nRepresentante: " . $representante_nome . "\nOrigem: " . $originURL . "\n";

        // Conteúdo a ser escrito no arquivo CSV
        $content_csv = $nome . "," . $telefone . "," . $representante_nome . "," . $originURL . "\n";

        // Escrever no arquivo de texto
        file_put_contents($file_path_txt, $content_txt, FILE_APPEND);

        // Escrever no arquivo CSV
        $header = "nome,telefone,representante,source\n";
        if (!file_exists($file_path_csv)) {
            file_put_contents($file_path_csv, $header);
        }
        file_put_contents($file_path_csv, $content_csv, FILE_APPEND);

        // Conteúdo a ser escrito no arquivo JSON
        $content_json = print_r($decoded_body, true);
        file_put_contents($file_path_json, $content_json, FILE_APPEND);

        return new WP_REST_Response('Webhook received, processed successfully, lead created, and assigned if applicable.', 200);
    } else {
        return new WP_REST_Response('Failed to create lead.', 500);
    }
}

// Registrar a URL do webhook
add_action('rest_api_init', function () {
    register_rest_route('webhooks/v1', '/leadstaker', [
        'methods' => 'POST',
        'callback' => 'handle_leadstaker_webhook',
        'permission_callback' => '__return_true',
    ]);
});
?>
