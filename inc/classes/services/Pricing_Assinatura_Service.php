<?php
class Pricing_Assinatura_Service
{

    /**
     * Formata um valor monetário para exibição, com duas casas decimais e separadores padrões.
     * 
     * @param float $amount Valor a ser formatado.
     * @return string Valor monetário formatado como uma string.
     */
    public static function format_currency($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * Retorna o valor padrão da assinatura.
     * 
     * @return float Valor monetário da assinatura padrão, convertido para float.
     */
    public static function get_subscription_price()
    {
        return floatval(get_option('asaas_subscription_price'));
    }

    /**
     * Retorna o valor padrão da assinatura para Pessoa Jurídica.
     * 
     * @return float Valor monetário da assinatura padrão para Pessoa Jurídica, convertido para float.
     */
    public static function get_pj_subscription_price()
    {
        return floatval(get_option('asaas_subscription_pj_price'));
    }

    /**
     * Retorna a porcentagem de desconto aplicada por dependente.
     * 
     * @return int Porcentagem de desconto (0 a 100) aplicada para cada dependente.
     */
    public static function get_subscription_dependent_porcent_discount()
    {
        return (int)get_option('asaas_subscription_dependent_porcent_discount');
    }

    /**
     * Retorna a porcentagem de desconto para modalidade mensal para Pessoa Jurídica.
     * 
     * @return int Porcentagem de desconto (0 a 100) aplicada para Pessoa Jurídica.
     */
    public static function get_pj_max_subscription_monthly_porcent_discount()
    {
        return (int)get_option('asaas_pj_max_subscription_monthly_porcent_discount');
    }

    /**
     * Retorna a porcentagem de desconto aplicada ao total do plano anual.
     * 
     * @return int Porcentagem de desconto (0 a 100) aplicada ao valor total do plano anual.
     */
    public static function get_pf_subscription_annual_porcent_discount()
    {
        return (int)get_option('asaas_pf_subscription_annual_porcent_discount');
    }

    /**
     * Calcula o custo atual de uma assinatura com base no valor padrão da assinatura 
     * e no número de dependentes, aplicando o desconto correspondente a cada dependente.
     * 
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor total da assinatura formatado como uma string monetária.
     */
    public static function get_current_subscription_cost($number_of_dependentes)
    {
        $value_per_dependent = self::calculate_discounted_price_per_dependent();
        $subscription_price  = self::get_subscription_price();

        $total_cost = ($value_per_dependent * $number_of_dependentes) + $subscription_price;

        return self::format_currency($total_cost);
    }

    /**
     * Calcula o custo de uma assinatura com base em um valor customizado da assinatura 
     * e no número de dependentes, aplicando o desconto correspondente a cada dependente.
     * 
     * @param float $subscription_price Valor customizado (negociado) da assinatura.
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor total da assinatura formatado como uma string monetária.
     */
    public static function get_custom_subscription_cost($subscription_price, $number_of_dependentes)
    {
        $value_per_dependent = self::calculate_discounted_price_per_dependent();

        $total_cost = ($value_per_dependent * $number_of_dependentes) + $subscription_price;

        return self::format_currency($total_cost);
    }

    /**
     * Calcula o valor com desconto aplicado por dependente, baseado no valor da assinatura 
     * e na porcentagem de desconto definida para dependentes.
     * 
     * @return float Valor monetário por dependente após aplicação do desconto.
     */
    public static function calculate_discounted_price_per_dependent()
    {
        $subscription_price = self::get_subscription_price();
        $discount_percentage = self::get_subscription_dependent_porcent_discount();

        $discount_amount = ($subscription_price * $discount_percentage) / 100;

        return $subscription_price - $discount_amount;
    }

    /**
     * Calcula o valor total para Pessoa Jurídica (PJ), onde o valor é o número de dependentes
     * multiplicado pelo preço negociado por dependente.
     * 
     * @param float $negotiated_price Valor negociado por dependente.
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor total da assinatura formatado como uma string monetária.
     */
    public static function calculate_pj_subscription_cost($negotiated_price, $number_of_dependentes)
    {
        $total_cost = $negotiated_price * $number_of_dependentes;
        return self::format_currency($total_cost);
    }

    /**
     * Calcula o valor mensal para Pessoa Física (PF) com recorrência anual,
     * aplicando o desconto anual sobre o custo mensal.
     * 
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor mensal da assinatura anual formatado como uma string monetária.
     */
    public static function calculate_pf_annual_subscription_cost($number_of_dependentes)
    {
        $monthly_cost = self::get_current_subscription_cost($number_of_dependentes);
        $annual_discount = self::get_pf_subscription_annual_porcent_discount();

        $monthly_cost_with_discount = $monthly_cost - ($monthly_cost * $annual_discount / 100);

        return self::format_currency($monthly_cost_with_discount);
    }

    /**
     * Calcula o valor total anual para Pessoa Física (PF), baseado no custo mensal com desconto.
     * 
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor total da assinatura anual formatado como uma string monetária.
     */
    public static function calculate_pf_annual_total_cost($number_of_dependentes)
    {
        $monthly_cost_with_discount = self::calculate_pf_annual_subscription_cost($number_of_dependentes);
        $annual_total_cost = $monthly_cost_with_discount * 12;

        return self::format_currency($annual_total_cost);
    }

    /**
     * Calcula o valor total para Pessoa Física (PF) mensal.
     * 
     * @param int $number_of_dependentes Número de dependentes incluídos na assinatura.
     * @return string Valor total da assinatura mensal formatado como uma string monetária.
     */
    public static function calculate_pf_monthly_subscription_cost($number_of_dependentes)
    {
        return self::get_current_subscription_cost($number_of_dependentes);
    }
}
