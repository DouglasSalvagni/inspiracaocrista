<?php
class Assinante_Service extends Base_Service
{

    private $assinante_id;
    private $assinante_data;

    public function __construct($assinante_id)
    {
        parent::__construct();

        $this->assinante_id = $assinante_id;
        $this->load_assinante_data();
    }

    private function load_assinante_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        $this->assinante_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $this->assinante_id), ARRAY_A);
    }

    public function get_data()
    {
        return $this->assinante_data;
    }

    public function get_dependentes()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        return $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE related_to = %d", $this->assinante_id), ARRAY_A);
    }

    /**
     * Obtém o valor de deal_amount associado ao assinante.
     * 
     * @return float|null Retorna o valor de deal_amount ou null se não existir.
     */
    public function get_deal_amount()
    {
        global $wpdb;
        $sales_table_name = $wpdb->prefix . 'sales';

        // Verifica se o assinante tem um sale_id associado
        if (!empty($this->assinante_data['sale_id'])) {
            $deal_amount = $wpdb->get_var($wpdb->prepare(
                "SELECT deal_amount FROM $sales_table_name WHERE id = %d",
                $this->assinante_data['sale_id']
            ));

            return $deal_amount !== null ? floatval($deal_amount) : null;
        }

        return null;
    }


    /**
     * Retorna o número total de assinantes.
     * 
     * @return int
     */
    public function get_number_of_dependentes()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        return (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE related_to = %d", $this->assinante_id));
    }

    /**
     * Obtém o Asaas Subscription ID do assinante da instância.
     * 
     * @return string|false Retorna o Asaas Subscription ID se existir, ou false se não existir.
     */
    public function get_asaas_subscription_id()
    {
        // Verifica se existe um asaas_subscription_id para o assinante
        if (!empty($this->assinante_data['asaas_subscription_id'])) {
            return $this->assinante_data['asaas_subscription_id'];
        } else {
            return false;
        }
    }


    public function is_holder()
    {
        // Um assinante é considerado titular se a coluna related_to for NULL ou 0
        return empty($this->assinante_data['related_to']);
    }

    public function update_assinante($data, $has_access)
    {
        if (!isset($data['edit_assinante_nonce']) || !wp_verify_nonce($data['edit_assinante_nonce'], 'edit_assinante')) {
            return ['success' => false, 'message' => 'Falha na verificação de nonce.'];
        }

        if (!General_Helper::validar_cpf_cnpj($data['cpf_cnpj'])) {
            return ['success' => false, 'message' => 'CPF/CNPJ ' . esc_html($data['cpf_cnpj']) . ' inválido.'];
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $assinante_data = [
            'name'                    => sanitize_text_field($data['lead_name']),
            'email'                   => sanitize_email($data['email']),
            'cpf_cnpj'                => General_Helper::remove_special_characters($data['cpf_cnpj']),
            'phone'                   => General_Helper::remove_special_characters($data['phone']),
            'mobile_phone'            => General_Helper::remove_special_characters($data['mobile_phone']),
            'postal_code'             => General_Helper::remove_special_characters($data['postal_code']),
            'address'                 => sanitize_text_field($data['address']),
            'address_number'          => sanitize_text_field($data['address_number']),
            'complement'              => sanitize_text_field($data['complement']),
            'province'                => sanitize_text_field($data['province']),
            'city'                    => sanitize_text_field($data['city']),
            'uf'                      => sanitize_text_field($data['uf']),
            'subscription_start_date' => sanitize_text_field($data['subscription_start_date']),
            'updated_at'              => current_time('mysql'),
        ];

        if ($has_access) {
            $assinante_data['subscription_status']   = sanitize_text_field($data['subscription_status']);
            $assinante_data['asaas_customer_id']     = sanitize_text_field($data['asaas_customer_id']);
            $assinante_data['asaas_subscription_id'] = sanitize_text_field($data['asaas_subscription_id']);
            $assinante_data['vendor_id']             = intval($data['vendor_id']);
            $assinante_data['related_to']            = intval($data['related_to']);
            $assinante_data['split_removed']         = intval($data['split_removed']);
        }

        $where = ['id' => $this->assinante_id];

        $updated = $wpdb->update($table_name, $assinante_data, $where);

        //Limpar cache
        Assinante_Data_Collector::clear_assinante_cache();

        if ($updated !== false) {
            return ['success' => true, 'message' => 'Assinante atualizado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Falha ao atualizar assinante.'];
        }
    }


    public function update_dependentes($dependentes, $dependentes_to_delete)
    {

        if (!isset($_POST['edit_dependentes_nonce']) || !wp_verify_nonce($_POST['edit_dependentes_nonce'], 'edit_dependentes')) {
            return ['success' => false, 'message' => 'Falha na verificação de nonce.'];
        }

        $assinante = new Subscriber_Data($this->assinante_id);
        $deal_num_dependents_before_edit = $assinante->get_deal_pj_number_dependents();

        if ($assinante->is_type('PJ') && isset($_POST['deal_pj_number_dependents'])) {
            $new_deal_pj_number_dependents = (int)$_POST['deal_pj_number_dependents'];
            if (is_array($dependentes) && $new_deal_pj_number_dependents < count($dependentes)) {
                return ['success' => false, 'message' => 'Novo limite de dependentes não pode ser menor que o número atual de dependentes cadastrados ou a serem cadastrados'];
            } else {
                $assinante->set_deal_pj_number_dependents($new_deal_pj_number_dependents);
            }
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $number_of_dependentes_before_edit = $this->get_number_of_dependentes();

        // Deletar dependentes marcados para exclusão
        if (!empty($dependentes_to_delete)) {
            foreach ($dependentes_to_delete as $id) {
                $wpdb->delete($table_name, ['id' => intval($id), 'related_to' => $this->assinante_id]);
            }
        }

        if ($assinante->is_type('PJ') && count($dependentes) > $assinante->get_deal_pj_number_dependents()) {
            return ['success' => false, 'message' => 'Número de dependentes acima do contratado'];
        }

        // Verificar se o arquivo CSV foi enviado
        if (isset($_FILES['file-csv-dependents-list']) && $_FILES['file-csv-dependents-list']['error'] === UPLOAD_ERR_OK) {
            $csv_file = $_FILES['file-csv-dependents-list']['tmp_name'];


            // Processar o arquivo CSV
            $csv_data = $this->process_csv($csv_file);

            if (is_wp_error($csv_data)) {
                return ['success' => false, 'message' => $csv_data->get_error_message()];
            }

            // Adicionar os dependentes do CSV ao array de dependentes
            $dependentes = array_merge($dependentes, $csv_data);
        }

        // Atualizar ou inserir novos dependentes
        foreach ($dependentes as $dependente) {

            if (!empty($dependente['id'])) {
                // Update existing dependent
                if (!General_Helper::validar_cpf_cnpj($dependente['cpf_cnpj'])) {
                    return ['success' => false, 'message' => 'CPF/CNPJ ' . esc_html($dependente['cpf_cnpj']) . ' inválido.'];
                }

                $dependente_data = [
                    'name'                => sanitize_text_field($dependente['name']),
                    'cpf_cnpj'            => General_Helper::remove_special_characters($dependente['cpf_cnpj']),
                    'updated_at'          => current_time('mysql'),
                    'subscription_status' => $this->assinante_data['subscription_status'],
                ];
                $where = ['id' => intval($dependente['id'])];

                $wpdb->update($table_name, $dependente_data, $where);
            } else {


                //impede inserção de novos dependentes
                if ($assinante->get_recurrence() == 'yearly') {
                    return ['success' => false, 'message' => 'O plano anual não permite novos dependentes.'];
                }

                // Insert new dependent
                if (!empty($dependente['name']) && !empty($dependente['cpf_cnpj'])) {


                    if (self::cpf_cnpj_exists($dependente['cpf_cnpj'])) {
                        return ['success' => false, 'message' => 'CPF/CNPJ ' . esc_html($dependente['cpf_cnpj']) . ' já existe.'];
                    }

                    if (!General_Helper::validar_cpf_cnpj($dependente['cpf_cnpj'])) {
                        return ['success' => false, 'message' => 'CPF/CNPJ ' . esc_html($dependente['cpf_cnpj']) . ' inválido.'];
                    }


                    $teste = $wpdb->insert($table_name, [
                        'name'                => sanitize_text_field($dependente['name']),
                        'cpf_cnpj'            => General_Helper::remove_special_characters(($dependente['cpf_cnpj'])),
                        'related_to'          => $this->assinante_id,
                        'subscription_status' => $this->assinante_data['subscription_status'],
                        'created_at'          => current_time('mysql'),
                        'updated_at'          => current_time('mysql'),
                        'role_type'           => 'DEPENDENTE'
                    ]);
                }
            }
        }

        $number_of_dependentes  = $this->get_number_of_dependentes();
        $subscription_service = new DNA_Assinatura_Service($assinante);


        if ($assinante->is_type('PJ')) {

            //manter desconto pj de negociação
            if ($assinante->get_deal_pj_discount()) {
                $subscription_service->set_pj_max_discount($assinante->get_deal_pj_discount());
            }

            $subscription_service->set_dependents_amount($assinante->get_deal_pj_number_dependents());
        }

        $total_cost = $subscription_service->calculate_subscription_cost();


        if (!isset($_POST['not_update_subscription_value']) && $this->user_has_role(['diretoria', 'administrator'])) {

            /****** ATUALIZAR NO ASAAS ******/

            $comission = 0;
            if ($assinante->is_type('PJ') && $assinante->get_deal_pj_number_dependents() > $deal_num_dependents_before_edit) {
                $difference = $assinante->get_deal_pj_number_dependents() - $deal_num_dependents_before_edit;
                $comission = $difference * $subscription_service->calculate_dependent_cost();
            } elseif ($assinante->get_recurrence() == 'monthly' && $number_of_dependentes > $number_of_dependentes_before_edit) {
                $difference = $number_of_dependentes - $number_of_dependentes_before_edit;
                $comission = $difference * $subscription_service->calculate_dependent_cost();
            }

            try {
                $asaas = new Asaas_API();
                $number_of_dependentes = $this->get_number_of_dependentes();

                $params = array(
                    "value"                 => $total_cost,
                    "description"           => "Assinatura com {$number_of_dependentes} dependentes",
                    "updatePendingPayments" => true
                );

                if (isset($_POST['comissao_user_id']) && $comission > 0) {
                    $vendor_wallet_id = get_user_meta($_POST['comissao_user_id'], 'wallet_id', true);
                    if ($vendor_wallet_id) {
                        $params['split'] = [
                            [
                                'walletId'   => $vendor_wallet_id,
                                'fixedValue' => $comission
                            ]
                        ];
                    }
                }

                $response = $asaas->update_subscription($this->get_asaas_subscription_id(), $params);

                $this->update_subscription_value($total_cost);

                //ativa bandeira de que split precisa ser removido quando pagamento for realizado
                $assinante->reset_split_removed();

                //Limpar cache
                Assinante_Data_Collector::clear_assinante_cache();

                return ['success' => true, 'message' => 'Dependentes e valor de assinatura atualizados com sucesso.'];
            } catch (Exception $e) {

                return ['success' => false, 'message' => 'Houve um erro. ' . $e];
            }
        }

        //Limpar cache
        Assinante_Data_Collector::clear_assinante_cache();

        return ['success' => true, 'message' => 'Dependentes atualizados com sucesso.'];
    }

    private function process_csv($csv_file)
{
    $csv_data = [];

    // Abrir o arquivo CSV
    if (($handle = fopen($csv_file, 'r')) !== false) {
        // Ler a primeira linha para detectar o delimitador
        $first_line = fgets($handle, 1000);
        fclose($handle);

        // Detectar o delimitador (usando vírgula ou ponto e vírgula)
        $delimiter = (strpos($first_line, ';') !== false) ? ';' : ',';

        // Reabrir o arquivo CSV para processamento completo
        if (($handle = fopen($csv_file, 'r')) !== false) {
            // Ler cada linha do CSV
            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Assumindo que o CSV tem duas colunas: nome e CPF/CNPJ
                $name = sanitize_text_field($data[0]);
                $cpf_cnpj = General_Helper::remove_special_characters($data[1]);

                // Adicionar dependente à lista de dados
                $csv_data[] = [
                    'name'     => $name,
                    'cpf_cnpj' => $cpf_cnpj,
                ];
            }
            fclose($handle);
        } else {
            return new WP_Error('file_error', 'Não foi possível abrir o arquivo CSV.');
        }
    } else {
        return new WP_Error('file_error', 'Não foi possível abrir o arquivo CSV.');
    }

    return $csv_data;
}



    /**
     * Atualiza o subscription value no banco de dados
     * 
     * @return bool
     */
    public function update_subscription_value($new_value)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $updated = $wpdb->update(
            $table_name,
            ['subscription_value' => floatval($new_value)], // Sanitiza o valor para garantir que é float
            ['id' => $this->assinante_id],
            ['%f'], // Define o tipo de dados como float
            ['%d']
        );

        if ($updated !== false) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * 
     ************ MÉTODOS ESTÁTICOS ****************
     *
     */


    // public static function get_current_subscription_cost($number_of_dependentes)
    // {
    //     $value_per_dependent = self::calculate_discounted_price_per_dependent();
    //     $subscription_price  = get_option('asaas_subscription_price');

    //     $total_cost = ($value_per_dependent * $number_of_dependentes) + $subscription_price;

    //     // Retorna o valor formatado com duas casas decimais
    //     return number_format($total_cost, 2, '.', '');
    // }

    // public static function get_custom_subscription_cost($subscription_price, $number_of_dependentes)
    // {
    //     $value_per_dependent = self::calculate_discounted_price_per_dependent();

    //     $total_cost = ($value_per_dependent * $number_of_dependentes) + $subscription_price;

    //     // Retorna o valor formatado com duas casas decimais
    //     return number_format($total_cost, 2, '.', '');
    // }



    // public static function calculate_discounted_price_per_dependent()
    // {
    //     // Get the subscription price
    //     $subscription_price = get_option('asaas_subscription_price');

    //     // Get the discount percentage for dependents
    //     $discount_percentage = get_option('asaas_subscription_dependent_porcent_discount');

    //     // Calculate the discount amount
    //     $discount_amount = ($subscription_price * $discount_percentage) / 100;

    //     // Calculate the final price with the discount applied
    //     $discounted_price = $subscription_price - $discount_amount;

    //     return $discounted_price;
    // }

    public static function get_titular_link_by_dependente($dependente_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        // Obter o ID do titular (related_to) com base no ID do dependente
        $titular_id = $wpdb->get_var($wpdb->prepare(
            "SELECT related_to FROM $table_name WHERE id = %d",
            $dependente_id
        ));

        // Verificar se o ID do titular foi encontrado
        if ($titular_id) {
            // Construir o link para editar o titular
            $url = add_query_arg(['assinante_id' => Encryption::encrypt($titular_id, true)], home_url('/assinantes/editar/'));
            return $url;
        } else {
            return null; // Retorna null se o dependente não estiver associado a um titular
        }
    }


    /**
     * Verificar se CPF/CNPJ existe.
     * 
     * @param string $cpfCnpj
     * @return bool
     */
    public static function cpf_cnpj_exists($cpfCnpj)
    {
        $cpfCnpj = preg_replace('/\D/', '', $cpfCnpj);

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE cpf_cnpj = %s", $cpfCnpj)) > 0;
    }


    /**
     * Cria um assinante.
     * 
     * @param array $formData
     * @param string $customerId
     * @param string $subscriptionId
     * @param array $dependents
     * @param object|null $lead
     * @return int|WP_Error ID do assinante criado em caso de sucesso, ou WP_Error em caso de falha
     */
    public static function create_assinante($formData, $customerId, $subscriptionId, $dependents = [], $lead = null)
    {
        // return new WP_Error('db_insert_error', 'Erro ao inserir dados na tabela assinantes: ' . $subscriptionId);

        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        $meta_table_name = $wpdb->prefix . 'assinantes_meta'; 
        $base_price = floatval(get_option('asaas_subscription_price', 39.90));

        if ($lead) {
            $dan_assinatura_service = new DNA_Assinatura_Service($lead);
            $base_price = $dan_assinatura_service->get_base_price();


            $deal_pj_discount = 0;
            $deal_pj_number_dependents = 0;

            if ($lead->is_type('PJ')) {
                $deal_pj_discount = $lead->get_deal_pj_discount();
                $deal_pj_number_dependents = $lead->get_number_dependents();
            }
        }

        $cpf_cnpj = General_Helper::remove_special_characters($formData['cpfCnpj']);

        $titular_data = [
            'name'                      => $formData['name'],
            'email'                     => $formData['email'],
            'birth_date'                => $lead ? $lead->get_birth_date() : null,
            'cpf_cnpj'                  => $cpf_cnpj,
            'phone'                     => $formData['phone'],
            'mobile_phone'              => $formData['mobilePhone'],
            'postal_code'               => $formData['postalCode'],
            'address'                   => $formData['address'],
            'address_number'            => $formData['addressNumber'],
            'complement'                => $formData['complement'],
            'province'                  => $formData['province'],
            'city'                      => $formData['city'],
            'uf'                        => $formData['uf'],
            'entity_type'               => $lead ? $lead->get_type()  : 'PF',
            'subscription_status'       => 'PENDING',
            'subscription_start_date'   => date('Y-m-d'),
            'asaas_customer_id'         => $customerId,
            'asaas_subscription_id'     => $subscriptionId,
            'base_price'                => $base_price,
            'deal_billing_cycle'        => $lead ? $lead->get_recurrence() : 'monthly',
            'deal_pj_discount'          => $deal_pj_discount,
            'deal_pj_number_dependents' => $deal_pj_number_dependents,
            'vendor_id'                 => $lead ? $lead->get_vendor_id()  : null,
            'related_to'                => null,
            'sale_id'                   => $formData['sale_id'],
            'role_type'                 => 'TITULAR'
        ];


        $inserted = $wpdb->insert($table_name, $titular_data);

        if ($inserted === false) {
            return new WP_Error('db_insert_error', 'Erro ao inserir dados na tabela assinantes: ' . $wpdb->last_error);
        }

        $titular_id = $wpdb->insert_id;

        if ($inserted) {

            $meta_data = [];

            if( $lead && $lead->get_company_representative() ) {
                $meta_data['company_representative'] =  $lead->get_company_representative();
            }

            if( $lead && $lead->get_company_representative() ) {
                $meta_data['company_representative_position'] =  $lead->get_company_representative_position();
            }

            foreach ($meta_data as $meta_key => $meta_value) {
                $wpdb->insert(
                    $meta_table_name,
                    [
                        'assinante_id' => $titular_id,
                        'meta_key'     => $meta_key,
                        'meta_value'   => $meta_value
                    ]
                );
            }
        }

        if ($dependents) {
            foreach ($dependents as $dependent) {
                $dependent_cpf  = esc_sql(sanitize_text_field($dependent['cpf']));
                $dependent_cpf  = preg_replace('/\D/', '', $dependent_cpf);
                $dependent_name = esc_sql(sanitize_text_field($dependent['name']));

                $dependente_data = [
                    'name'                    => $dependent_name,
                    'email'                   => '',
                    'cpf_cnpj'                => $dependent_cpf,
                    'phone'                   => '',
                    'mobile_phone'            => '',
                    'postal_code'             => $formData['postalCode'],
                    'address'                 => $formData['address'],
                    'address_number'          => $formData['addressNumber'],
                    'complement'              => $formData['complement'],
                    'province'                => $formData['province'],
                    'city'                    => $formData['city'],
                    'uf'                      => $formData['uf'],
                    'subscription_status'     => 'PENDING',
                    'subscription_start_date' => date('Y-m-d'),
                    'asaas_customer_id'       => $customerId,
                    'asaas_subscription_id'   => $subscriptionId,
                    'vendor_id'               => $lead ? $lead->get_vendor_id() : null,
                    'related_to'              => $titular_id,
                    'sale_id'                 => $formData['sale_id'],
                    'role_type'               => 'DEPENDENTE'
                ];

                $wpdb->insert($table_name, $dependente_data);

                if ($wpdb->last_error) {
                    return new WP_Error('db_insert_error', 'Erro ao inserir dados do dependente na tabela assinantes: ' . $wpdb->last_error);
                }
            }
        }

        $instancia = new self($titular_id);

        $instancia->update_subscription_value($formData['value']);

        Assinante_Data_Collector::clear_assinante_cache();

        return $titular_id;
    }
}
