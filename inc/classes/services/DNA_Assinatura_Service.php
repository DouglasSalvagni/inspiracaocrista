<?php

class DNA_Assinatura_Service
{

    private $cliente;
    private $is_pj;
    private $recurrence;
    private $dependents;
    private $base_price;
    private $discounts;
    private $pj_max_discount;

    /**
     * Construtor da classe DNA_Assinatura_Service
     *
     * @param Lead_Data|Subscriber_Data|null $cliente Objeto Lead_Data, Subscriber_Data
     * ou null para instâncias públicas.
     */
    public function __construct($cliente = null)
    {
        $this->cliente = $cliente;
        $this->is_pj = $cliente ? $cliente->is_type('PJ') : false;
        $this->recurrence = $cliente ? $cliente->get_recurrence() : 'monthly';
        $this->dependents = $cliente ? $cliente->get_number_dependents() : 0;
        $this->pj_max_discount = $this->get_sys_pj_max_discount();
        $this->discounts = $this->get_discounts();
        $this->base_price = $this->get_base_price();
    }

    /**
     * Seta manualmente o número de dependentes
     *
     * @param int $num_dependents número de dependentes.
     */
    public function set_dependents_amount(int $num_dependents)
    {
        $this->dependents = $num_dependents;
    }

    /**
     * Obter o preço base da assinatura
     *
     * @return float Preço base.
     */
    public function get_base_price()
    {
        if ($this->is_pj) {
            return floatval(get_option('asaas_subscription_pj_price', 29.90));
        } else {
            return floatval(get_option('asaas_subscription_price', 39.90));
        }
    }

    /**
     * Obter o preço base da assinatura
     *
     * @return float Preço base.
     */
    public function get_sys_pj_max_discount()
    {
        return floatval(get_option('asaas_pj_max_subscription_monthly_porcent_discount', 10));
    }

    /**
     * Setar a porcentagem máxima de desconto PJ
     *
     * @return float Preço base.
     */
    public function set_pj_max_discount( float $discount)
    {
        $this->pj_max_discount = $discount;

        //atualiza o desconto
        $this->discounts = $this->get_discounts();
    }

    /**
     * Obter a porcentagem máxima de desconto PJ
     *
     * @return float Preço base.
     */
    public function get_pj_max_discount()
    {
        return $this->pj_max_discount;
    }

    /**
     * Obter os descontos aplicáveis com base no tipo de lead e recorrência.
     *
     * @return array Array de descontos aplicáveis.
     */
    private function get_discounts()
    {
        if ($this->is_pj) {
            $user_defined_discount = floatval($this->cliente->get_deal_pj_discount());
            $max_discount = $this->pj_max_discount;

            // Assegura que o desconto definido pelo usuário não ultrapasse o máximo permitido
            $final_discount = min($user_defined_discount, $max_discount);

            return [
                'max_discount' => $max_discount,
                'deal_discount' => $final_discount,
            ];
        } else {
            return [
                'dependent_discount' => floatval(get_option('asaas_subscription_dependent_porcent_discount', 0)),
                'annual_discount' => $this->recurrence === 'yearly' ? floatval(get_option('asaas_pf_subscription_annual_porcent_discount', 0)) : 0,
            ];
        }
    }

    /**
     * Calcular o custo da assinatura baseado no tipo de lead.
     *
     * @return float Custo total da assinatura.
     */
    public function calculate_subscription_cost()
    {
        if ($this->is_pj) {
            return $this->calculate_pj_cost();
        } else {
            return $this->calculate_pf_cost();
        }
    }

    /**
     * Calcular o custo da assinatura para PJ.
     *
     * @return float Custo total para PJ.
     */
    private function calculate_pj_cost()
    {
        $total_cost = $this->base_price * $this->dependents;
        $deal_discount = $this->discounts['deal_discount'];
        $final_cost = $total_cost * (1 - ($deal_discount / 100));
        return $final_cost;
    }

    /**
     * Calcular o custo da assinatura para PF.
     *
     * @return float Custo total para PF.
     */
    private function calculate_pf_cost()
    {
        $dependent_cost = $this->base_price * (1 - ($this->discounts['dependent_discount'] / 100));
        $total_cost = $dependent_cost * $this->dependents + $this->base_price;

        if ($this->recurrence === 'yearly') {
            $total_cost *= 12;
            $total_cost *= (1 - ($this->discounts['annual_discount'] / 100));
        }

        return $total_cost;
    }

    /**
     * Calcular o custo para um dependente específico.
     *
     * @return float Custo do dependente.
     */
    public function calculate_dependent_cost()
    {
        if ($this->is_pj) {
            return $this->calculate_pj_dependent_cost();
        } else {
            return $this->calculate_pf_dependent_cost();
        }
    }

    /**
     * Calcular o custo por dependente para PJ.
     *
     * @return float Custo do dependente.
     */
    private function calculate_pj_dependent_cost()
    {
        return $this->base_price * (1 - ($this->discounts['deal_discount'] / 100));
    }

    /**
     * Calcular o custo por dependente para PF.
     *
     * @return float Custo do dependente.
     */
    private function calculate_pf_dependent_cost()
    {
        return $this->base_price * (1 - ($this->discounts['dependent_discount'] / 100));
    }

    /**
     * Obter informações detalhadas para exibir na interface.
     *
     * @return array Dados detalhados para interface.
     */
    public function get_detailed_info()
    {
        return [
            'base_price' => $this->base_price,
            'dependents' => $this->dependents,
            'total_cost' => $this->calculate_subscription_cost(),
            'recurrence' => $this->recurrence,
            'is_pj'      => $this->is_pj,
            'discounts'  => $this->discounts
        ];
    }
}
