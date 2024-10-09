<?php

class Checkout_Endpoint {
    public static function init() {
        add_action('wp_ajax_generate_checkout_link', [__CLASS__, 'generate_checkout_link']);
        add_action('wp_ajax_nopriv_generate_checkout_link', [__CLASS__, 'generate_checkout_link']);
    }

    public static function generate_checkout_link() {
        check_ajax_referer('generate_checkout_link_nonce', '_wpnonce');

        if (!isset($_POST['lead_id'])) {
            wp_send_json_error(['message' => 'Lead ID não fornecido.']);
        }

        $lead_id = intval($_POST['lead_id']);
        $checkout_link = Checkout_Link_Manager::generate_checkout_link($lead_id);

        if ($checkout_link) {
            wp_send_json_success(['checkout_link' => $checkout_link]);
        } else {
            wp_send_json_error(['message' => 'Erro ao gerar o link de checkout.']);
        }
    }
}

Checkout_Endpoint::init();

