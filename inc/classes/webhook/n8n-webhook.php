<?php
function register_whatsapp_webhook_endpoint() {
    add_rewrite_rule('^webhook-whatsapp/?', 'index.php?whatsapp_webhook=1', 'top');
}
add_action('init', 'register_whatsapp_webhook_endpoint');

function add_query_vars($vars) {
    $vars[] = 'whatsapp_webhook';
    return $vars;
}
add_filter('query_vars', 'add_query_vars');

function handle_whatsapp_webhook_request() {
    global $wp_query;

    if (isset($wp_query->query_vars['whatsapp_webhook'])) {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Registrar o log do conteúdo recebido
        $theme_dir = get_template_directory();
        $log_file = $theme_dir . '/whatsapp_webhook_log.txt';
        file_put_contents($log_file, print_r($data, true), FILE_APPEND);

        if (!empty($data)) {
            // Processar a mensagem do WhatsApp aqui
            $thread_id = $data['thread_id'];
            $sender = $data['sender'];
            $message = $data['message'];

            // Novos parâmetros
            $convert_lead = isset($data['convert_lead']) ? $data['convert_lead'] : null;
            $lead_name = isset($data['lead_name']) ? $data['lead_name'] : null;
            $lead_phone = isset($data['lead_phone']) ? $data['lead_phone'] : null;

            // Verificar se já existe um post com o mesmo thread_id
            $existing_posts = get_posts(array(
                'post_type'  => 'leads',
                'meta_key'   => 'thread',
                'meta_value' => $thread_id,
                'numberposts' => 1,
            ));

            if (!empty($existing_posts)) {
                $post_id = $existing_posts[0]->ID;
            } else {
                // Criar um novo post do tipo 'leads'
                $post_id = wp_insert_post(array(
                    'post_type'   => 'leads',
                    'post_title'  => $thread_id,
                    'post_status' => 'publish',
                ));
                // Adicionar metadado 'thread' ao post
                update_post_meta($post_id, 'thread', $thread_id);
            }

            if ($post_id) {
                // Recuperar grupos existentes, se houver
                $existing_groups = get_post_meta($post_id, 'group', true);
                if (empty($existing_groups)) {
                    $existing_groups = array();
                }

                // Adicionar novas informações ao grupo
                $group_data = array(
                    'sender'  => $sender,
                    'message' => $message,
                    'date' => current_time('mysql'),
                );
                $existing_groups[] = $group_data;

                // Atualizar o metadado do grupo
                update_post_meta($post_id, 'group', $existing_groups);

                // Atualizar ou adicionar novos metadados
                if ($convert_lead == 1) {
                    update_post_meta($post_id, 'lead_status', 'lead_discovered');
                    distribute_lead($post_id);
                    if ($lead_name) {
                        // Atualizar o título do post para o lead_name recebido
                        wp_update_post(array(
                            'ID'         => $post_id,
                            'post_title' => $lead_name,
                        ));
                        update_post_meta($post_id, 'lead_name', $lead_name);
                    }
                    if ($lead_phone) {
                        update_post_meta($post_id, 'lead_phone', $lead_phone);
                    }
                }
            }
        }

        // Retornar uma resposta adequada
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        exit;
    }
}
add_action('template_redirect', 'handle_whatsapp_webhook_request');

