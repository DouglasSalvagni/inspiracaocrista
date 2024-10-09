<?php

class Assinante_Data_Collector
{
    /**
     * Retorna o número total de vidas (assinantes e dependentes ativos).
     * 
     * @return int
     */
    public function get_total_lives_count()
    {
        $cached_value = get_transient('total_lives_count');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name"
            )
        );

        set_transient('total_lives_count', $count, HOUR_IN_SECONDS);

        return $count;
    }

    /**
     * Retorna o número total de titulares ativos.
     * 
     * @return int
     */
    public function get_total_titulares_count()
    {
        $cached_value = get_transient('total_titulares_count');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Contar todos os titulares onde o status é "ACTIVE" e o role_type é 'TITULAR'
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE subscription_status = %s AND role_type = %s",
                'ACTIVE',
                'TITULAR'
            )
        );

        set_transient('total_titulares_count', $count, HOUR_IN_SECONDS);

        return $count;
    }

    /**
     * Retorna o número total de dependentes ativos.
     * 
     * @return int
     */
    public function get_total_dependentes_count()
    {
        $cached_value = get_transient('total_dependentes_count');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Contar todos os dependentes onde o status é "ACTIVE" e o role_type é 'DEPENDENTE'
        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE subscription_status = %s AND role_type = %s",
                'ACTIVE',
                'DEPENDENTE'
            )
        );

        set_transient('total_dependentes_count', $count, HOUR_IN_SECONDS);

        return $count;
    }

    /**
     * Retorna o valor total das assinaturas de titulares ativos.
     * 
     * @return float
     */
    public function get_total_subscription_value()
    {
        $cached_value = get_transient('total_subscription_value');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Somar o valor das assinaturas (subscription_value) de todos os titulares ativos
        $total_value = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT SUM(subscription_value) FROM $table_name WHERE subscription_status = %s AND role_type = %s",
                'ACTIVE',
                'TITULAR'
            )
        );
        

        set_transient('total_subscription_value', $total_value, HOUR_IN_SECONDS);

        return $total_value;
    }

    /**
     * Retorna o valor total das assinaturas mensais de titulares ativos.
     * 
     * @return float
     */
    public function get_total_monthly_subscription_value()
    {
        $cached_value = get_transient('total_subscription_value');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Soma dos valores com o ciclo de faturamento mensal
        $total_value = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT SUM(subscription_value) FROM $table_name WHERE subscription_status = %s AND role_type = %s AND deal_billing_cycle = %s",
                'ACTIVE',
                'TITULAR',
                'monthly'
            )
        );

        set_transient('total_subscription_monthly_value', $total_value, HOUR_IN_SECONDS);

        return $total_value;
    }

    /**
     * Retorna o valor total das assinaturas mensais de titulares ativos.
     * 
     * @return float
     */
    public function get_total_yearly_subscription_value()
    {
        $cached_value = get_transient('total_subscription_value');

        if ($cached_value !== false) {
            return $cached_value;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Soma dos valores com o ciclo de faturamento anual, divididos por 12
        $total_value = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT SUM(subscription_value) FROM $table_name WHERE subscription_status = %s AND role_type = %s AND deal_billing_cycle = %s",
                'ACTIVE',
                'TITULAR',
                'yearly'
            )
        );


        set_transient('total_subscription_yearly_value', $total_value, HOUR_IN_SECONDS);

        return $total_value;
    }

    /**
     * Limpa o cache de todos os dados relacionados a assinantes.
     */
    public static function clear_assinante_cache()
    {
        delete_transient('total_lives_count');
        delete_transient('total_titulares_count');
        delete_transient('total_dependentes_count');
        delete_transient('total_subscription_value');
        delete_transient('total_subscription_monthly_value');
        delete_transient('total_subscription_yearly_value');
    }
}
