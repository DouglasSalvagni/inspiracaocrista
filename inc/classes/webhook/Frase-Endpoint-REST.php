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
        // Endpoint para adicionar frase
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
                'token' => [
                    'required' => true, // O token deve ser enviado na requisição
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Validação básica de não estar vazio
                    }
                ],
            ]
        ]);

        // Endpoint para atualizar frase
        register_rest_route('custom/v1', '/update-frase/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'update_frase'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'id' => [
                    'required' => true,
                    'validate_callback' => function ($param, $request, $key) {
                        return !empty($param); // Valida se o nome foi enviado
                    }
                ],
                'imagem' => [
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

        // Endpoint para obter a próxima frase
        register_rest_route('custom/v1', '/get-next-frase/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'get_next_frase'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'assinante_id' => [
                    'required' => true,
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
                'token' => [
                    'required' => true,
                ]
            ]
        ]);

        // Endpoint para registrar frase lida
        register_rest_route('custom/v1', '/register-read-frase/', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'register_read_frase'],
            'permission_callback' => [__CLASS__, 'permissions_check'],
            'args' => [
                'assinante_id' => [
                    'required' => true,
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
                'frase_id' => [
                    'required' => true,
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ],
                'token' => [
                    'required' => true,
                ]
            ]
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

    public static function create_frase($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'frases';

        $data = [
            'texto'  => $request->get_param('texto'),
        ];

        $inserted = $wpdb->insert($table_name, $data);

        if ($inserted === false) {
            return new WP_REST_Response(['message' => $wpdb->last_error], 400);
        }

        $frase_id = $wpdb->insert_id;

        return new WP_REST_Response(['message' => 'Frase criada com sucesso.', 'frase_id' => $frase_id], 200);
    }

    public static function update_frase($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'frases';

        // Obter o ID da frase que será atualizada
        $frase_id = $request->get_param('id');

        // Dados para atualizar
        $data = [
            'imagem' => $request->get_param('imagem'),
        ];

        // Condição para o WHERE da query, que é o ID da frase
        $where = ['id' => $frase_id];

        // Executa a atualização
        $updated = $wpdb->update($table_name, $data, $where);

        // Verifica se houve algum erro
        if ($updated === false) {
            return new WP_REST_Response(['message' => $wpdb->last_error], 400);
        } elseif ($updated === 0) {
            // Se 0 linhas forem afetadas, significa que não houve mudança nos dados ou que o ID não existe
            return new WP_REST_Response(['message' => 'Nenhuma mudança foi feita ou ID não encontrado.'], 200);
        }

        return new WP_REST_Response(['message' => 'Frase atualizada com sucesso.', 'frase_id' => $frase_id], 200);
    }

    public static function get_next_frase($request)
    {
        global $wpdb;
        $assinante_id = $request->get_param('assinante_id');
        $frases_table = $wpdb->prefix . 'frases';
        $assinantes_frases_table = $wpdb->prefix . 'assinantes_frases';

        // Obter frases ainda não lidas pelo assinante
        $query = "
            SELECT f.id, f.texto, f.imagem 
            FROM $frases_table f
            LEFT JOIN $assinantes_frases_table af ON f.id = af.frase_id AND af.assinante_id = %d
            WHERE af.frase_id IS NULL
            ORDER BY f.created_at ASC
            LIMIT 1
        ";
        $frase = $wpdb->get_row($wpdb->prepare($query, $assinante_id));

        if (!$frase) {
            return new WP_REST_Response(['message' => 'Nenhuma nova frase disponível para este assinante.'], 404);
        }

        return new WP_REST_Response([
            'frase_id' => $frase->id,
            'texto' => $frase->texto,
            'imagem' => $frase->imagem
        ], 200);
    }

    public static function register_read_frase($request)
    {
        global $wpdb;
        $assinantes_frases_table = $wpdb->prefix . 'assinantes_frases';

        $assinante_id = $request->get_param('assinante_id');
        $frase_id = $request->get_param('frase_id');

        // Registrar a frase como lida pelo assinante
        $data = [
            'assinante_id' => $assinante_id,
            'frase_id' => $frase_id,
        ];
        $inserted = $wpdb->insert($assinantes_frases_table, $data);

        if ($inserted === false) {
            return new WP_REST_Response(['message' => $wpdb->last_error], 400);
        }

        return new WP_REST_Response(['message' => 'Frase marcada como lida com sucesso.'], 200);
    }
}

Frase_Endpoint_REST::init();
