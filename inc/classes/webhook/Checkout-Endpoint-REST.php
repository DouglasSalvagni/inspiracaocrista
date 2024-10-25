<?php

class Checkout_Endpoint_REST
{
    private static $secret_token = '6tgY4zO2BGEzlKG17ku0u07qOqtt5gDDukHzHBKEC4OmoZMB6CdIVLUmsRrsu267';

    public static function init()
    {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes()
    {
        register_rest_route('custom/v1', '/generate-checkout-link/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'generate_checkout_link'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'lead_id' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return is_numeric($param);
                    }
                ],
                'token' => [
                    'required' => true, // O token deve ser enviado na requisição
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Validação básica de não estar vazio
                    }
                ],
            ],
        ]);
    }

    public static function permissions_check($request)
    {
        // Verifica se o token enviado na requisição corresponde ao token armazenado
        $received_token = $request->get_param('token');

        if ($received_token === self::$secret_token) {
            return true; // Token válido
        } else {
            return new WP_Error('invalid_token', 'Token inválido.', ['status' => 403]);
        }
    }

    public static function generate_checkout_link($request)
    {
        $lead_id = intval($request['lead_id']);

        // Gere o link de checkout
        $checkout_link = Checkout_Link_Manager::generate_checkout_link($lead_id);

        if ($checkout_link) {
            return new WP_REST_Response(['checkout_link' => $checkout_link], 200);
        } else {
            return new WP_REST_Response(['message' => 'Erro ao gerar o link de checkout.'], 500);
        }
    }
}

Checkout_Endpoint_REST::init();
