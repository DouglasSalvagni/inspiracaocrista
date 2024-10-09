<?php

class Lead_Endpoint_REST
{
    private static $secret_token = 'seu_token_secreto_aqui';

    public static function init()
    {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes()
    {
        register_rest_route('custom/v1', '/add-lead/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'add_lead_simplificado'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'lead_name' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o nome foi enviado
                    }
                ],
                'lead_phone' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o telefone foi enviado
                    }
                ],
                'cpf_cnpj' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o CPF/CNPJ foi enviado
                    }
                ],
                'token' => [
                    'required' => true, // O token deve ser enviado na requisição
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Validação básica de não estar vazio
                    }
                ],
            ]
        ]);
    }

    public static function permissions_check($request) {
        // Verifica se o token enviado na requisição corresponde ao token armazenado
        $received_token = $request->get_param('token');
        
        if ($received_token === self::$secret_token) {
            return true; // Token válido
        } else {
            return new WP_Error('invalid_token', 'Token inválido.', ['status' => 403]);
        }
    }

    public static function add_lead_simplificado($request)
    {
        // Converte os dados do request REST em formato de array
        $form_data = $request->get_params();

        // Chama o método Lead_Service::adicionar_lead_simplificado()
        $result = Lead_Service::adicionar_lead_simplificado($form_data, false);

        if ($result['success']) {
            return new WP_REST_Response(['message' => 'Lead criado com sucesso.', 'lead_id' => $result['lead_id']], 200);
        } else {
            return new WP_REST_Response(['message' => $result['message']], 400);
        }
    }
}

Lead_Endpoint_REST::init();
