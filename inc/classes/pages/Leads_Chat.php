<?php

require_once (ABSPATH . 'vendor/autoload.php');

use GuzzleHttp\Client;

//DISPONIBILIZA ACTION AJAX
add_action('init', ['Leads_Chat', 'init_actions']);
class Leads_Chat extends Base_Page
{
    private int $user_id;

    public function __construct($user_id = NULL)
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));

        $this->add_style('glightbox', get_template_directory_uri() . '/assets/libs/glightbox/css/glightbox.min.css');
        $this->add_script('glightbox-js', get_template_directory_uri() . '/assets/libs/glightbox/js/glightbox.min.js', [], null, true, 71);
        $this->add_script('fgEmojiPicker-js', get_template_directory_uri() . '/assets/libs/fg-emoji-picker/fgEmojiPicker.js', [], null, true, 72);
        $this->add_script('chat-js', get_template_directory_uri() . '/assets/js/chat.js', [], null, true, 73);
        // $this->add_script('chat-init-js', get_template_directory_uri() . '/assets/js/chat.init.js', [], null, true, 73);

        if ($user_id && is_int($user_id)) {
            $this->user_id = $user_id;
        } else {
            $this->user_id = get_current_user_id();
        }
    }

    public static function init_actions()
    {
        add_action('wp_ajax_load_messages', [__CLASS__, 'load_messages']);
        add_action('wp_ajax_nopriv_load_messages', [__CLASS__, 'load_messages']);
        add_action('wp_ajax_send_message', [__CLASS__, 'send_message']);
        add_action('wp_ajax_nopriv_send_message', [__CLASS__, 'send_message']);
        add_action('wp_ajax_check_unread_messages', [__CLASS__, 'check_unread_messages']);
        add_action('wp_ajax_nopriv_check_unread_messages', [__CLASS__, 'check_unread_messages']);
    }

    public function render()
    {
        $leads = $this->get_user_leads();
        $current_lead_id = isset($_GET['lead_id']) ? intval($_GET['lead_id']) : null;
        $current_lead = null;

        if ($current_lead_id) {
            foreach ($leads as $lead) {
                if ($lead['ID'] == $current_lead_id) {
                    $current_lead = $lead;
                    break;
                }
            }
        }

        $vars = compact('leads', 'current_lead');
        $this->render_view('pages/leads-chat', $vars);
    }
    private function get_user_leads()
    {
        $args = [
            'post_type' => 'leads',
            'meta_query' => [
                'relation' => 'AND',
            ],
            'posts_per_page' => -1
        ];

        $args['meta_query'][] = [
            'key' => 'lead_assigned_to',
            'value' => $this->user_id,
            'compare' => '='
        ];

        $query = new WP_Query($args);
        $leads = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $lead_image = get_post_meta(get_the_ID(), 'lead_image', true);
                if (!$lead_image) {
                    $lead_image = get_template_directory_uri() . '/assets/images/users/user-dummy-img.jpg';
                }

                $messages = get_post_meta(get_the_ID(), 'group', true);
                $last_message_time = !empty($messages) ? end($messages)['date'] : null;

                $leads[] = [
                    'ID' => get_the_ID(),
                    'title' => get_the_title(),
                    'lead_status' => get_post_meta(get_the_ID(), 'lead_status', true),
                    'lead_phone' => get_post_meta(get_the_ID(), 'lead_phone', true),
                    'deal_value' => get_post_meta(get_the_ID(), 'deal_value', true),
                    'status' => get_post_meta(get_the_ID(), 'lead_status', true),
                    'lead_tags' => get_post_meta(get_the_ID(), 'lead_tags', true),
                    'company' => get_post_meta(get_the_ID(), 'lead_company', true),
                    'next_action_description' => get_post_meta(get_the_ID(), 'next_action_description', true),
                    'date' => get_the_date('Y-m-d H:i:s'),
                    'priority' => get_post_meta(get_the_ID(), 'lead_priority', true),
                    'thread' => get_post_meta(get_the_ID(), 'thread', true),
                    'messages' => get_post_meta(get_the_ID(), 'group', false),
                    'lead_image' => $lead_image,
                    'last_message_time' => $last_message_time // Adiciona a data/hora da última mensagem
                ];
            }
            wp_reset_postdata();
        }

        // Ordenar os leads pela data/hora da última mensagem em ordem decrescente
        usort($leads, function ($a, $b) {
            if ($a['last_message_time'] == $b['last_message_time']) {
                return 0;
            }
            return ($a['last_message_time'] < $b['last_message_time']) ? 1 : -1;
        });

        return $leads;
    }


    public static function load_messages()
    {
        check_ajax_referer('general_nonce', 'security');

        $lead_id = isset($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
        $only_unread = isset($_POST['only_unread']) ? filter_var($_POST['only_unread'], FILTER_VALIDATE_BOOLEAN) : false;

        if ($lead_id > 0) {
            $messages = get_post_meta($lead_id, 'group', true);

            if (!empty($messages)) {
                // Se only_unread for true, filtra as mensagens não lidas
                if ($only_unread) {
                    $unreadMessages = array_filter($messages, function ($message) {
                        return !$message['read'];
                    });

                    // Marca as mensagens não lidas como lidas
                    foreach ($messages as &$message) {
                        if (!$message['read']) {
                            $message['read'] = true;
                        }
                    }
                    update_post_meta($lead_id, 'group', $messages);

                    // Retorna apenas as mensagens não lidas
                    wp_send_json_success(array_values($unreadMessages));
                } else {
                    // Marcar todas as mensagens como lidas se não estiver filtrando apenas as não lidas
                    foreach ($messages as &$message) {
                        if (!$message['read']) {
                            $message['read'] = true;
                        }
                    }
                    update_post_meta($lead_id, 'group', $messages);

                    wp_send_json_success(array_values($messages));
                }
            } else {
                wp_send_json_error('No messages found');
            }
        } else {
            wp_send_json_error('Invalid lead ID');
        }
    }



    public static function send_message()
    {
        check_ajax_referer('general_nonce', 'security');

        $lead_id = isset($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
        $message_content = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
        if ($lead_id > 0 && !empty($message_content)) {
            $messages = get_post_meta($lead_id, 'group', true);

            if (!$messages) {
                $messages = [];
            }

            // Obtém o first_name do usuário atual
            $current_user = wp_get_current_user();
            $first_name = $current_user->first_name;

            $new_message = [
                'sender' => $first_name ? $first_name : 'Agente', // Usa o first_name ou 'Agente' como fallback
                'message' => $message_content,
                'date' => current_time('mysql'),
                'read' => true
            ];
            $messages[] = $new_message;
            update_post_meta($lead_id, 'group', $messages);

            // Disparar a requisição HTTP
            $lead_phone = get_post_meta($lead_id, 'lead_phone', true);
            $zapster_api_key = 'Bearer ' . get_option('zapster_api_key');
            $instance_id = get_option('zapster_instance_id');
            if ($lead_phone && $instance_id) {
                $client = new Client();
                $response = $client->request('POST', 'https://new-api.zapsterapi.com/v1/wa/messages', [
                    'body' => json_encode([
                        'recipient' => $lead_phone,
                        'instance_id' => $instance_id,
                        'text' => $message_content
                    ]),

                    'headers' => [
                        'Authorization' => $zapster_api_key,
                        'accept' => 'application/json',
                        'content-type' => 'application/json',
                    ],
                ]);

                error_log('Zapster API response: ' . $response->getBody()); // Log para depuração
            } else {
                error_log('Missing lead_phone or instance_id for Zapster API request');
            }

            wp_send_json_success($new_message);
        } else {
            wp_send_json_error('Invalid lead ID or empty message');
        }
    }

    public static function check_unread_messages()
    {
        check_ajax_referer('general_nonce', 'security');

        $lead_ids = isset($_POST['leads']) ? json_decode(stripslashes($_POST['leads']), true) : [];

        if (!empty($lead_ids)) {
            $unread_counts = [];

            foreach ($lead_ids as $lead_id) {
                $messages = get_post_meta(intval($lead_id), 'group', true);
                $unread_count = 0;

                if ($messages) {
                    foreach ($messages as $message) {
                        if (!isset($message['read']) || !$message['read']) {
                            $unread_count++;
                        }
                    }
                }

                $unread_counts[$lead_id] = $unread_count;
            }

            wp_send_json_success($unread_counts);
        } else {
            wp_send_json_error('No lead IDs provided');
        }
    }
}

