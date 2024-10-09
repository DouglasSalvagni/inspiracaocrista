<?php

function add_lead_metafields()
{
    // Informações Básicas
    register_post_meta('leads', 'lead_name', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_email', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_phone', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_cpf_cnpj', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_company', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_position', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_source', array('type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => 'other'));
    // Lead Status
    register_post_meta('leads', 'lead_status', array('type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => 'lead_discovered'));
    // Detalhes da Oportunidade
    register_post_meta('leads', 'deal_value', array('type' => 'number', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'deal_pj_discount', array('type' => 'number', 'single' => true, 'show_in_rest' => true, 'default' => 0));
    register_post_meta('leads', 'deal_recurrence', array('type' => 'number', 'single' => true, 'show_in_rest' => true, 'default' => 'monthly'));
    register_post_meta('leads', 'deal_stage', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'expected_close_date', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    // Informações de Contato e Interações
    register_post_meta('leads', 'last_contacted_date', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'contact_method', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'next_action_date', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'next_action_description', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    // Histórico de Atividades (Este campo pode usar uma estrutura complexa ou ACF)
    register_post_meta('leads', 'activity_log', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => array(
            'schema' => array(
                'type' => 'array',
                'items' => array(
                    'type' => 'object', // Supondo que cada item no log de atividades seja um objeto
                    'properties' => array(
                        'date' => array('type' => 'string'),
                        'activity' => array('type' => 'string')
                    )
                )
            )
        )
    ));
    // Notas e Comentários
    register_post_meta('leads', 'lead_notes', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    // Informações Adicionais
    register_post_meta('leads', 'lead_priority', array('type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => 'low'));
    register_post_meta('leads', 'lead_assigned_to', array('type' => 'string', 'single' => true, 'show_in_rest' => true));
    register_post_meta('leads', 'lead_tags', array(
        'type' => 'array',
        'single' => true,
        'show_in_rest' => array(
            'schema' => array(
                'type' => 'array',
                'items' => array(
                    'type' => 'string'
                )
            )
        )
    ));
    register_post_meta('leads', 'lead_type', array('type' => 'string', 'single' => true, 'show_in_rest' => true, 'default' => 'pf'));
}
add_action('init', 'add_lead_metafields');
?>
