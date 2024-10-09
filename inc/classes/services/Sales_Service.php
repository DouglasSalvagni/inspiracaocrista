<?php

class Sales_Service
{
    /**
     * Create sale record.
     * 
     * @param string $sale_date
     * @param string $sale_amount
     * @param string $sale_status
     * @param string $sale_vendor_id
     * @param string $sale_asaas_subscription_id
     * @return int|WP_Error ID da venda criada em caso de sucesso, ou WP_Error em caso de falha
     */
    public static function create_sale($sale_date, $sale_amount, $deal_amount, $sale_status, $sale_vendor_id = NULL, $sale_team_id = NULL, $sale_asaas_subscription_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sales';

        $sale_data = [
            'sale_date'                  => $sale_date,
            'sale_amount'                => $sale_amount,
            'deal_amount'                => $deal_amount,
            'sale_status'                => $sale_status,
            'sale_vendor_id'             => $sale_vendor_id,
            'sale_team_id'               => $sale_team_id,
            'sale_asaas_subscription_id' => $sale_asaas_subscription_id,
        ];

        $inserted = $wpdb->insert($table_name, $sale_data);

        if ($inserted === false) {
            return new WP_Error('db_insert_error', 'Erro ao inserir dados na tabela sales: ' . $wpdb->last_error);
        }

        return $wpdb->insert_id;
    }
}
