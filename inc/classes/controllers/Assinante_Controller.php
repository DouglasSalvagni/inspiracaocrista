<?php

class Assinante_Controller
{
    public function __construct()
    {
        // editar assinante
        add_action('wp_ajax_submit_edit_assinante', [$this, 'submit_edit_assinante']);

        // Adicione o handler para o cálculo do novo custo da assinatura
        add_action('wp_ajax_calculate_subscription_cost', [$this, 'calculate_subscription_cost']);

        // Adicionar handler para carregar cobranças
        add_action('wp_ajax_load_subscription_payments', [$this, 'load_subscription_payments']);
    }

    public function submit_edit_assinante()
    {
        if (!isset($_POST['assinante_id'])) {
            wp_send_json_error('Assinante ID not provided.');
        }

        $assinante_id = intval($_POST['assinante_id']);
        $form_data = [];
        parse_str($_POST['form_data'], $form_data);

        // Instantiate the service and process the form
        $assinante_service = new Assinante_Service($assinante_id);
        $result = $assinante_service->update_assinante($form_data);

        if ($result['success']) {
            wp_send_json_success('Assinante updated successfully.');
        } else {
            wp_send_json_error($result['message']);
        }
    }

    public function calculate_subscription_cost()
    {
        if (!isset($_POST['assinante_id']) || !isset($_POST['number_of_dependents'])) {
            wp_send_json_error('Assinante ID or number of dependents not provided.');
        }

        $assinante_id = intval($_POST['assinante_id']);

        ///////// NOVA IMPLEMENTAÇÃO //////////////

        $assinante = new Subscriber_Data($assinante_id);
        $subscription_service = new DNA_Assinatura_Service($assinante);

        
        if (isset($_POST['not_update_subscription_value']) && $_POST['not_update_subscription_value'] == 'true') {
            $number_of_dependents = $assinante->get_number_dependents();
        } else {
            $number_of_dependents = intval($_POST['number_of_dependents']);
        }

        if ($assinante->is_type('PJ')) {

            //manter desconto pj de negociação
            if ($assinante->get_deal_pj_discount()) {
                $subscription_service->set_pj_max_discount($assinante->get_deal_pj_discount());
            }

            if (isset($_POST['deal_pj_number_dependents'])) {
                $number_of_dependents = (int)$_POST['deal_pj_number_dependents'];
            } else {
                $number_of_dependents = $assinante->get_deal_pj_number_dependents();
            }

            //mantem o número de dependentes negociados
            $subscription_service->set_dependents_amount($number_of_dependents);
        } else {
            $subscription_service->set_dependents_amount($number_of_dependents);
        }

        $total_cost = $subscription_service->calculate_subscription_cost();

        //////// FIM NOVA IMPLEMENTAÇÃO //////////////


        if ($total_cost !== false) {
            wp_send_json_success(['new_cost' => $total_cost]);
        } else {
            wp_send_json_error('Failed to calculate the new subscription cost.');
        }
    }

    public function load_subscription_payments()
    {
        if (!isset($_POST['assinante_id'])) {
            wp_send_json_error('Assinante ID não fornecido.');
        }

        $assinante_id = intval($_POST['assinante_id']);

        // Instanciar o serviço Assinante_Service
        $assinante_service = new Assinante_Service($assinante_id);
        $subscription_id = $assinante_service->get_asaas_subscription_id();

        if (!$subscription_id) {
            wp_send_json_error('Assinante não possui uma assinatura válida.');
        }

        $asaas_api = new Asaas_API();
        $payments = $asaas_api->get_subscription_payments($subscription_id);

        if (isset($payments['data'])) {
            wp_send_json_success($payments['data']);
        } else {
            wp_send_json_error('Erro ao carregar cobranças.');
        }
    }
}

new Assinante_Controller();
