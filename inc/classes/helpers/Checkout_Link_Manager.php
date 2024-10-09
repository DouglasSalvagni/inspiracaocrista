<?php

class Checkout_Link_Manager
{
    /**
     * Gera um link de checkout temporário.
     * 
     * @param int $lead_id
     * @return string
     */
    public static function generate_checkout_link($lead_id)
    {
        // Gerar UUID único
        $uuid = wp_generate_uuid4();

        // Calcular data de expiração (1 dia)
        date_default_timezone_set('America/Sao_Paulo');
        $expiration = date('Y-m-d H:i:s', strtotime('+1 day'));

        // Inserir no banco de dados
        global $wpdb;
        $table_name = $wpdb->prefix . 'checkout_links';
        $wpdb->insert($table_name, [
            'lead_id' => $lead_id,
            'uuid' => $uuid,
            'expires_at' => $expiration
        ]);

        // Retornar o link gerado
        $checkout_link = add_query_arg('checkout_uuid', $uuid, get_permalink(get_page_by_path('checkout')));
        return $checkout_link;
    }
}


