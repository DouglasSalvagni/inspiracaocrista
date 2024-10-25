<?php

class Frase_Endpoint_REST
{
    private static $secret_token = '6tgY4zO2BGEzlKG17ku0u07qOqtt5gDDukHzHBKEC4OmoZMB6CdIVLUmsRrsu267';

    public static function init()
    {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes()
    {
        register_rest_route('custom/v1', '/add-frase/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'create_frase'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'texto' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o nome foi enviado
                    }
                ],
                'texto' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o nome foi enviado
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

    public static function create_frase($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'frases';

        $data = [
            'texto'  => $request->get_param('texto'),
            'imagem' => $request->get_param('imagem'),
        ];

        $inserted = $wpdb->insert($table_name, $data);

        if ($inserted === false) {
            return new WP_REST_Response(['message' => $wpdb->last_error], 400);
        }

        $frase_id = $wpdb->insert_id;

        return new WP_REST_Response(['message' => 'Frase criada com sucesso.', 'frase_id' => $frase_id], 200);
    }
}

Frase_Endpoint_REST::init();
