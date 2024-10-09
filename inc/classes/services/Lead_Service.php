<?php

class Lead_Service extends Base_Service
{

    private $lead_id;
    private $lead_data;

    public function __construct($lead_id)
    {
        $this->lead_id = $lead_id;
        $this->load_lead_data();
    }

    private function load_lead_data()
    {
        // Carrega os dados do lead do banco de dados
        $this->lead_data = [
            'ID'                                    => $this->lead_id,
            'lead_name'                             => get_the_title($this->lead_id),
            'lead_nascimento'                       => get_post_meta($this->lead_id, 'lead_nascimento', true),
            'lead_email'                            => get_post_meta($this->lead_id, 'lead_email', true),
            'lead_phone'                            => get_post_meta($this->lead_id, 'lead_phone', true),
            'lead_cpf_cnpj'                         => get_post_meta($this->lead_id, 'lead_cpf_cnpj', true),
            'lead_company_representative'           => get_post_meta($this->lead_id, 'lead_company_representative', true),
            'lead_position'                         => get_post_meta($this->lead_id, 'lead_position', true),
            'lead_source'                           => get_post_meta($this->lead_id, 'lead_source', true),
            'lead_status'                           => get_post_meta($this->lead_id, 'lead_status', true),
            'lead_type'                             => get_post_meta($this->lead_id, 'lead_type', true),
            'deal_value'                            => get_post_meta($this->lead_id, 'deal_value', true),
            'deal_pj_discount'                      => get_post_meta($this->lead_id, 'deal_pj_discount', true),
            'deal_pj_admin_max_discount_authorized' => get_post_meta($this->lead_id, 'deal_pj_admin_max_discount_authorized', true),
            'deal_pj_admin_max_discount'            => get_post_meta($this->lead_id, 'deal_pj_admin_max_discount', true),
            'deal_boleto_authorized'                => get_post_meta($this->lead_id, 'deal_boleto_authorized', true),
            'deal_due_date'                         => get_post_meta($this->lead_id, 'deal_due_date', true),
            'deal_stage'                            => get_post_meta($this->lead_id, 'deal_stage', true),
            'deal_recurrence'                       => get_post_meta($this->lead_id, 'deal_recurrence', true),
            'deal_number_dependents'                => get_post_meta($this->lead_id, 'deal_number_dependents', true),
            'expected_close_date'                   => get_post_meta($this->lead_id, 'expected_close_date', true),
            'last_contacted_date'                   => get_post_meta($this->lead_id, 'last_contacted_date', true),
            'contact_method'                        => get_post_meta($this->lead_id, 'contact_method', true),
            'next_action_date'                      => get_post_meta($this->lead_id, 'next_action_date', true),
            'next_action_description'               => get_post_meta($this->lead_id, 'next_action_description', true),
            'lead_notes'                            => get_post_meta($this->lead_id, 'lead_notes', true),
            'lead_priority'                         => get_post_meta($this->lead_id, 'lead_priority', true),
            'lead_assigned_to'                      => get_post_meta($this->lead_id, 'lead_assigned_to', true),
            'lead_tags'                             => get_post_meta($this->lead_id, 'lead_tags', true),
            'messages'                              => get_post_meta($this->lead_id, 'group', false),
        ];
    }

    public function get_data()
    {
        return $this->lead_data;
    }

    public function update_lead($data)
    {

        if (!isset($data['edit_lead_nonce']) || !wp_verify_nonce($data['edit_lead_nonce'], 'edit_lead')) {
            return ['success' => false, 'message' => 'Falha na verificação de nonce.'];
        }
        
        $lead = new Lead_Data($this->lead_id);

        $current_user = wp_get_current_user();
        $is_admin = in_array('administrator', $current_user->roles);

        // Atualiza os dados do lead no banco de dados
        foreach ($this->lead_data as $meta_key => $meta_value) {
            if (isset($data[$meta_key]) && $meta_key == 'lead_name') {
                $post_data = [
                    'ID' => $this->lead_id,
                    'post_title' => sanitize_text_field($data[$meta_key]),
                ];

                wp_update_post($post_data);
                continue;
            }

            if (isset($data[$meta_key])) {
                update_post_meta($this->lead_id, $meta_key, sanitize_text_field($data[$meta_key]));
            }

            if ($meta_key == 'deal_pj_admin_max_discount_authorized') {
                update_post_meta($this->lead_id, $meta_key, sanitize_text_field($data[$meta_key]));
            }

            if ($meta_key == 'deal_boleto_authorized') {
                update_post_meta($this->lead_id, $meta_key, sanitize_text_field($data[$meta_key]));
            }
            

            if (isset($data[$meta_key]) && $meta_key == 'lead_status' && $data[$meta_key] == 'offer_accepted') {
                Notification_Manager::add_notification(
                    $current_user->ID,
                    'Parabéns! Seu lead aceitou sua oferta',
                    '',
                    'offer_accepted',
                    'post',
                    $this->lead_id
                );
            }
        }

        // Verifica se o campo lead_assigned_to pode ser atualizado
        if ($is_admin && isset($data['lead_assigned_to'])) {
            update_post_meta($this->lead_id, 'lead_assigned_to', sanitize_text_field($data['lead_assigned_to']));
        }

        // Garante que se lead_type for Pessoa Jutídica a recorrência é mensal
        if (isset($data['lead_type']) && $data['lead_type'] == 'PJ') {
            update_post_meta($this->lead_id, 'deal_recurrence', 'monthly');
        }

        
        if (isset($data['lead_cpf_cnpj'])) {
            $cpf_cnpj =  General_Helper::remove_special_characters($data['lead_cpf_cnpj']);
            update_post_meta($this->lead_id, 'lead_cpf_cnpj', $cpf_cnpj);
        }

        
        if (isset($data['lead_assigned_team_id'])) {
            update_post_meta($this->lead_id, 'assigned_team_id', $data['lead_assigned_team_id']);
        }
        
        $lead->update_deal_value();

        // Limpar cache da página de dados de performance (dashboard)
        global $user_info;

        Performance_Data_Collector::clear_personal_transients($user_info->get_user_id());
        Performance_Data_Collector::clear_team_transients($user_info->get_team_id());
        Performance_Data_Collector::clear_global_transients();

        return ['success' => true, 'message' => 'Dados atualizado com sucesso!'];
    }

    /**
     * Migrar lead para tabela de desqualificado.
     * 
     */
    public function disqualify_lead($reason)
    {
        global $wpdb;

        // Nome da tabela de leads desqualificados
        $table_name = $wpdb->prefix . 'disqualified_leads';

        // Inserir os dados do lead na tabela de leads desqualificados
        $inserted = $wpdb->insert(
            $table_name,
            [
                'name'      => $this->lead_data['lead_name'],
                'email'     => $this->lead_data['lead_email'],
                'cpf_cnpj'  => $this->lead_data['lead_cpf_cnpj'],
                'phone'     => $this->lead_data['lead_phone'],
                'vendor_id' => $this->lead_data['lead_assigned_to'],
                'reason'    => $reason,
                // Outros campos podem ser adicionados conforme a necessidade
            ],
            [
                '%s', // name
                '%s', // email
                '%s', // cpf_cnpj
                '%s', // phone
                '%d', // vendor_id
            ]
        );

        // Verifica se a inserção foi bem-sucedida
        if ($inserted === false) {
            return ['success' => false, 'message' => 'Erro ao desqualificar o lead.'];
        }

        // Deletar o lead da tabela original (posts) e seus metadados
        $deleted = wp_delete_post($this->lead_id, true);

        if ($deleted === false) {
            return ['success' => false, 'message' => 'Erro ao deletar o lead original.'];
        }

        return ['success' => true, 'message' => 'Lead desqualificado e deletado com sucesso.'];
    }

    public static function adicionar_lead_simplificado($form_data, $verificarnonce = true)
    {
        if($verificarnonce) {
            if (!isset($form_data['add_lead_simplificado']) || !wp_verify_nonce($form_data['add_lead_simplificado'], 'add_lead_simplificado')) {
                return ['success' => false, 'message' => 'Falha na verificação de nonce.'];
            }
        }

        // Verifica se o nome do lead está vazio
        if (!isset($form_data['lead_name']) || empty($form_data['lead_name'])) {
            return ['success' => false, 'message' => 'O nome do lead é obrigatório.'];
        }

        // Verifica se o nome do lead está vazio
        if (!isset($form_data['lead_phone']) || empty($form_data['lead_phone'])) {
            return ['success' => false, 'message' => 'O telefone é obrigatório.'];
        }

        // Verifica se o CPF/CNPJ está vazio
        if (!isset($form_data['cpf_cnpj']) || empty($form_data['cpf_cnpj'])) {
            return ['success' => false, 'message' => 'O CPF ou CNPJ é obrigatório.'];
        }

        $cpf_cnpj = General_Helper::remove_special_characters($form_data['cpf_cnpj']);

        // Verifica se o CPF/CNPJ já está cadastrado
        if (self::cpf_cnpj_exists($cpf_cnpj) || Assinante_Service::cpf_cnpj_exists($cpf_cnpj)) {
            return ['success' => false, 'message' => 'O CPF ou CNPJ já está cadastrado.'];
        }

        // Verifica se o CPF/CNPJ é válido
        if (!General_Helper::validar_cpf_cnpj($cpf_cnpj)) {
            return ['success' => false, 'message' => 'O CPF ou CNPJ é inválido.'];
        }

        // Verifica se o telefone já está cadastrado
        if (self::meta_value_exists('lead_phone', $form_data['lead_phone'])) {
            return ['success' => false, 'message' => 'O telefone já está cadastrado.'];
        }

        // Criação do post de tipo 'lead'
        $post_data = [
            'post_title'  => sanitize_text_field($form_data['lead_name']),
            'post_status' => 'publish',
            'post_type'   => 'leads',
        ];

        // Insere o post e captura o ID do novo lead
        $lead_id = wp_insert_post($post_data);

        $lead = new Lead_Data($lead_id);

        // Verifica se o post foi criado com sucesso
        if (is_wp_error($lead_id)) {
            return ['success' => false, 'message' => 'Erro ao criar o lead.'];
        }

        // Adiciona os metadados (lead_name e lead_cpf_cnpj)
        update_post_meta($lead_id, 'lead_name', sanitize_text_field($form_data['lead_name']));
        update_post_meta($lead_id, 'lead_phone', sanitize_text_field($form_data['lead_phone']));
        update_post_meta($lead_id, 'lead_cpf_cnpj', sanitize_text_field($cpf_cnpj));
        update_post_meta($lead_id, 'lead_status', 'lead_discovered');
        update_post_meta($lead_id, 'lead_type', 'PF');
        update_post_meta($lead_id, 'lead_assigned_to', $form_data['user_id']);
        update_post_meta($lead_id, 'assigned_team_id', $form_data['team_id']);
        
        $lead->update_deal_value();

        // Limpar cache da página de dados de performance (dashboard)
        global $user_info;

        Performance_Data_Collector::clear_personal_transients($user_info->get_user_id());
        Performance_Data_Collector::clear_team_transients($user_info->get_team_id());
        Performance_Data_Collector::clear_global_transients();

        // Retorna sucesso
        return ['success' => true, 'message' => 'Lead criado com sucesso.', 'lead_id' => $lead_id];
    }

    public static function cpf_cnpj_exists($cpfCnpj)
    {
        $cpfCnpj = preg_replace('/[^0-9]/', '', $cpfCnpj);

        $args = [
            'post_type'  => 'leads', // Tipo de post 'assinantes'
            'meta_query' => [
                [
                    'key'     => 'lead_cpf_cnpj',
                    'value'   => $cpfCnpj,
                    'compare' => ' = ',
                ],
            ],
            'posts_per_page' => 1,
            'fields'         => 'ids',
        ];

        $posts = get_posts($args);
        return !empty($posts);
    }

    
    public static function meta_value_exists($meta_key, $value)
    {
        $args = [
            'post_type'  => 'leads', 
            'meta_query' => [
                [
                    'key'     => $meta_key,
                    'value'   => $value,   
                    'compare' => ' = ',
                ],
            ],
            'posts_per_page' => 1,
            'fields'         => 'ids',
        ];

        $posts = get_posts($args);
        return !empty($posts);
    }
}
