<?php

class Checkout_Controller {
    public function __construct() {
        add_action('wp_ajax_calculate_total_price', [$this, 'calculate_total_price']);
        add_action('wp_ajax_nopriv_calculate_total_price', [$this, 'calculate_total_price']);
    }

    public function calculate_total_price() {
        // Verifica se os dados necessários estão presentes
        if (!isset($_POST['entity']) || !isset($_POST['num_dependents'])) {
            wp_send_json_error('Missing required parameters.');
        }

        $lead_id = isset($_POST['lead_id']) ? $_POST['lead_id'] : null;
        $lead = $lead_id ? new Lead_Data($lead_id, true) : null;
        $entity = sanitize_text_field($_POST['entity']);
        $num_dependents = intval($_POST['num_dependents']);
        

        // Se existir o lead e estiver criptografado, decodifique e utilize na instância do serviço
        $subscription_service = $lead ? new DNA_Assinatura_Service($lead) : new DNA_Assinatura_Service();

        if ($entity != 'PJ') {
            /**
             * seta o número de dependentes conforme formulário
             * se for PJ mantem o número negociado
             **/
            $subscription_service->set_dependents_amount((int)$_POST['num_dependents']);
        }

        // Para PF, devemos considerar o número de dependentes adicionados pelo usuário via frontend
        if ($entity === 'PF') {
            $subscription_service = new DNA_Assinatura_Service($lead);

            $total_price = $subscription_service->calculate_subscription_cost();
            $dependent_cost = $subscription_service->calculate_dependent_cost();
            $total_price = $dependent_cost * $num_dependents + $subscription_service->get_detailed_info()['base_price'];
            
            // Se a recorrência for anual, aplique as regras específicas
            if ($subscription_service->get_detailed_info()['recurrence'] === 'yearly') {
                $total_price *= 12;
                $total_price *= (1 - ($subscription_service->get_detailed_info()['discounts']['annual_discount'] / 100));
            }

        } elseif($entity === 'PJ') {
            // Para PJ, use o cálculo já existente

            // verificar se há autorização para desconto personalizado
            if ($entity == 'PJ' && $lead->is_pj_admin_max_discount_authorized()) {
                $subscription_service->set_pj_max_discount($lead->get_deal_pj_admin_max_discount());
            }
            
            $total_price = $subscription_service->calculate_subscription_cost();
        } else {

            $total_price = $subscription_service->calculate_subscription_cost();
        }

        wp_send_json_success(['total_price' => $total_price]);
    }
}

new Checkout_Controller();

