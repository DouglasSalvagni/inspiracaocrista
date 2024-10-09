<?php

class Lead_Controller
{
    public function __construct()
    {

        //editar lead
        add_action('wp_ajax_submit_edit_lead', [$this, 'submit_edit_lead']);

        add_action('wp_ajax_add_lead_simpificado', [$this, 'add_lead_simpificado']);

        //desqualificar lead
        add_action('wp_ajax_submit_disqualify_lead', [$this, 'submit_disqualify_lead']);
    }

    public function submit_edit_lead()
    {
        if (!isset($_POST['lead_id'])) {
            wp_send_json_error('Lead ID not provided.');
        }

        $lead_id = intval($_POST['lead_id']);
        $form_data = [];
        parse_str($_POST['form_data'], $form_data);

        // Instantiate the service and process the form
        $lead_service = new Lead_Service($lead_id);
        $result = $lead_service->update_lead($form_data);

        if ($result['success']) {
            wp_send_json_success('Lead updated successfully.');
        } else {
            wp_send_json_error($result['message']);
        }
    }

    public function submit_disqualify_lead()
    {
        if (!isset($_POST['lead_id'])) {
            wp_send_json_error('Lead ID not provided.');
        }

        $lead_id = intval($_POST['lead_id']);

        // Instantiate the service and process the form
        $lead_service = new Lead_Service($lead_id);
        $result = $lead_service->disqualify_lead($_POST['reason']);

        if ($result['success']) {
            wp_send_json_success('Lead updated successfully.');
        } else {
            wp_send_json_error($result['message']);
        }
    }

    public function add_lead_simpificado()
    {

        // Converte os dados do formulário
        $form_data = [];
        parse_str($_POST['form_data'], $form_data);

        // Instantiate the service and process the form
        $result = Lead_Service::adicionar_lead_simplificado($form_data);

        if ($result['success']) {
            wp_send_json_success('Lead updated successfully.');
        } else {
            wp_send_json_error($result['message']);
        }
    }
}

new Lead_Controller();
