<?php

require_once(ABSPATH . 'vendor/autoload.php');

use GuzzleHttp\Client;

//DISPONIBILIZA ACTION AJAX
add_action('init', ['ASAAS_Checkout_Page', 'init_actions']);


/**
 * Class ASAAS_Checkout_Page
 * 
 * This class handles the checkout page logic.
 */
class ASAAS_Checkout_Page extends Base_Page
{
    private $lead_id;
    private $require_uuid;
    private $lead_data;
    private $entity;

    public function __construct($require_uuid = true)
    {
        parent::__construct();

        $this->require_uuid = $require_uuid;

        $this->load_base_style();
        $this->load_base_scripts();

        $this->add_script('jquery-mask', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true);
        $this->add_script('masks', get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true);
        $this->add_script('checkout-script', get_template_directory_uri() . '/assets/js/checkout.js', ['jquery'], null, true);

        if ($this->require_uuid) {
            // Recuperar o lead_id usando o UUID
            $uuid = get_query_var('checkout_uuid');
            $this->lead_id = $this->get_lead_id_from_uuid($uuid);
            if ($this->lead_id) {
                $this->lead_data = new Lead_Data($this->lead_id);
                $this->entity = $this->lead_data->get_type(); // Obtemos diretamente do Lead_Data se é PF ou PJ
            }
        } else {
            // Para usuários sem UUID, assumimos PF como padrão
            $this->entity = 'PF';
        }
    }

    /**
     * Initialize actions.
     */
    public static function init_actions()
    {
        add_action('wp_ajax_create_customer_and_subscription',        [__CLASS__, 'create_customer_and_subscription']);
        add_action('wp_ajax_nopriv_create_customer_and_subscription', [__CLASS__, 'create_customer_and_subscription']);
    }

    /**
     * Render the checkout page.
     */
    public function render()
    {
        // Definir fuso horário local
        date_default_timezone_set('America/Sao_Paulo');

        // Escolher o template de termos de acordo com a entidade
        $text_template = ($this->entity == 'PJ') ? 'accept_terms_PJ_text' : 'accept_terms_PF_text';


        // Verificar se o UUID é válido e renderizar a view adequada
        if ($this->require_uuid) {
            $uuid = get_query_var('checkout_uuid');

            $subscription_service = $this->lead_data ? new DNA_Assinatura_Service($this->lead_data) : new DNA_Assinatura_Service();

            if (self::is_valid_uuid($uuid) && $this->lead_data) {

                $args_contrato = [
                    'baseValue' => $subscription_service->get_base_price(),
                    'depValue' => $subscription_service->calculate_dependent_cost(),
                ];

                $vars = [
                    'lead_id'           => $this->lead_id,
                    'uuid'              => $uuid,
                    'lead_data'         => $this->lead_data,
                    'require_uuid'      => $this->require_uuid,
                    'accept_terms_text' => Template_Helper::get_view_content('text/' . $text_template, $args_contrato),
                    'entity'            => $this->entity,
                ];
                $this->render_view('pages/asaas-checkout', $vars);
            } else {
                echo "<p>Link de checkout expirado ou inválido.</p>";
            }
        } else {
            $vars = [
                'lead_id'           => false,
                'require_uuid'      => false,
                'accept_terms_text' => Template_Helper::get_view_content('text/' . $text_template),
                'entity'            => $this->entity,
            ];
            $this->render_view('pages/asaas-checkout', $vars);
        }
    }


    private static function is_valid_uuid($uuid)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'checkout_links';
        $lead_id = $wpdb->get_var($wpdb->prepare("SELECT lead_id FROM $table_name WHERE uuid = %s AND expires_at > NOW()", $uuid));
        return $lead_id !== null;
    }

    private static function validate_nonce()
    {
        if (!isset($_POST['checkout_nonce']) || !wp_verify_nonce($_POST['checkout_nonce'], 'checkout_nonce')) {
            wp_send_json_error('Invalid nonce');
            wp_die();
        }
    }

    /**
     * Handle the form submission and create customer and subscription.
     */
    public static function create_customer_and_subscription()
    {

        if (!isset($_POST['checkout_nonce']) || !wp_verify_nonce($_POST['checkout_nonce'], 'checkout_nonce')) {
            wp_send_json_error('Invalid nonce');
            wp_die();
        }


        // Verifica se parâmetros importantes estão presentes
        if (!isset($_POST['name']) || !isset($_POST['cpfCnpj'])) {
            wp_send_json_error('Missing required parameters');
            wp_die();
        }

        // Obter informações do lead e entidade
        $lead_id = isset($_POST['lead_id']) ? Encryption::decrypt(sanitize_text_field($_POST['lead_id']), true) : null;
        $lead = $lead_id ? new Lead_Data($lead_id) : null;
        $entity = $lead ? $lead->get_type() : 'PF';

        // Instanciar o serviço de assinatura e calcular o valor
        $subscription_service = $lead ? new DNA_Assinatura_Service($lead) : new DNA_Assinatura_Service();

        //se PF numero do form
        //se PJ número acordado
        

        if ($entity == 'PF') {
            $subscription_service->set_dependents_amount((int)$_POST['num_dependents']);
        }

        //verificar se há autorização para desconto personalizado para PJ
        if ($entity == 'PJ' && $lead->is_pj_admin_max_discount_authorized()) {
            $subscription_service->set_pj_max_discount($lead->get_deal_pj_admin_max_discount());
        }

        $cost      = $subscription_service->calculate_subscription_cost();
        $baseCost = $subscription_service->get_base_price();
        $depCost   = $subscription_service->calculate_dependent_cost();

        if ($entity == 'PJ') {
            $entity_type = 'CNPJ';
        } else {
            $entity_type = 'CPF';
        }

        $uuid = isset($_POST['uuid']) && $_POST['uuid']  != 'null' ? sanitize_text_field($_POST['uuid']) : null;
        $lead = isset($_POST['lead_id']) && $_POST['lead_id'] != 'null' ? new Lead_Data($_POST['lead_id'], true) : null;


        // Verificar se o UUID é válido se necessário
        if ($uuid && !self::is_valid_uuid($uuid)) {
            wp_send_json_error('Link expirado. ' . $lead);
            wp_die();
        }

        $formData = self::validate_and_sanitize_form_data($_POST);

        $formData['value'] = $cost;
        $formData['baseValue'] = $baseCost;
        $formData['depValue'] = $depCost;

        $dependents = json_decode(stripslashes($_POST['dependents']), true);

        if (Lead_Service::cpf_cnpj_exists($formData['cpfCnpj']) && !$uuid) {
            wp_send_json_error('Este CPF possui uma negociação em andamento. Por favor contato seu representante (11) 5500-0515.');
            wp_die();
        }

        if (Assinante_Service::cpf_cnpj_exists($formData['cpfCnpj'])) {
            wp_send_json_error('Este ' . $entity_type . ' já está cadastrado. ');
            wp_die();
        }

        if (!General_Helper::validar_cpf_cnpj($formData['cpfCnpj'])) {
            wp_send_json_error('O ' . $entity_type . ' do titular é inválido. ');
            wp_die();
        }

        foreach ($dependents as $dependent) {
            $dependent['cpf'] = preg_replace('/\D/', '', sanitize_text_field($dependent['cpf']));
            if (Assinante_Service::cpf_cnpj_exists($dependent['cpf'])) {
                wp_send_json_error('O CPF do dependente ' . $dependent['cpf'] . ' já está cadastrado.');
                wp_die();
            }

            if (!General_Helper::validar_cpf_cnpj($dependent['cpf'])) {
                wp_send_json_error('O CPF do dependente ' . $dependent['name'] . ' é inválido. ');
                wp_die();
            }
        }


        try {
            $asaas = new Asaas_API();
            $customerId     = self::asaas_get_or_create_customer($asaas, $formData);
            $subscriptionId = self::asaas_get_or_create_subscription($asaas, $customerId, $formData, $lead ? $lead : null);

            if (!$subscriptionId) {
                wp_send_json_error('Erro ao criar assinatura no ASAAS.');
                wp_die();
            }

            /** CRIAR SALE NO BANCO DE DADOS */
            $sale_id = Sales_Service::create_sale(date('Y-m-d H:i:s'), $formData['value'], $cost, 'ativa', $lead ? $lead->get_vendor_id() : null, $lead ? $lead->get_assigned_team_id() : null, $subscriptionId);

            if (is_wp_error($sale_id)) {
                wp_send_json_error('Erro ao criar venda: ' . $sale_id->get_error_message());
                wp_die();
            }

            $formData['sale_id'] = $sale_id;

            /** CRIAR ASSINATURA NO BANCO DE DADOS */
            $assinatura_id = Assinante_Service::create_assinante($formData, $customerId, $subscriptionId, $dependents, $lead ? $lead : null);


            if (is_wp_error($assinatura_id)) {
                wp_send_json_error('Erro ao criar assinatura: ' . $assinatura_id->get_error_message());
                wp_die();
            }


            //criar contrato pdf e enviar
            self::create_and_send_contract($formData, $lead);


            if ($lead) {
                // Deleta links do lead após pagamento
                self::delete_lead_checkout_links($lead->get_ID());

                // Arquivar e deletar o lead após o pagamento
                $lead->archive_lead();
                $lead->delete_lead();
            }

            // url de redirecionamento
            $redirect_url = home_url('/bem-vindo');

            // criptografia do id do sale
            $encrypted_asaas_subs_id = Encryption::encrypt($subscriptionId, true);
            $encrypted_assinante_id = Encryption::encrypt($assinatura_id, true);

            //adicionando query argument com id criptografado
            $redirect_url = add_query_arg(['ref' => $encrypted_asaas_subs_id, 'assinante' => $encrypted_assinante_id], $redirect_url);

            //resposta
            wp_send_json_success($redirect_url);
        } catch (Exception $e) {
            // Tente decodificar a resposta JSON
            $responseBody = $e->getResponse()->getBody()->getContents();
            $decodedResponse = json_decode($responseBody, true);

            // Verifique se a resposta contém o campo 'errors' e se é um array
            if (isset($decodedResponse['errors']) && is_array($decodedResponse['errors'])) {
                // Pegue a primeira mensagem de erro (se houver mais de uma)
                $errorDescription = $decodedResponse['errors'][0]['description'];

                // Substitua 'CPF/CNPJ' pela variável $entity_type, se existir
                if (strpos($errorDescription, 'CPF/CNPJ') !== false) {
                    $errorDescription = str_replace('CPF/CNPJ', $entity_type, $errorDescription);
                }

                // Envie a resposta JSON com a descrição do erro alterada
                wp_send_json_error($errorDescription);
            } else {
                // Se não for possível obter a descrição, envie a mensagem de erro original
                wp_send_json_error($e->getMessage());
            }
        }

        wp_die();
    }

    private static function create_and_send_contract($formData, $lead = null)
    {
        $address = esc_sql(sanitize_text_field($formData['address']));
        $addressNumber = esc_sql(sanitize_text_field($formData['addressNumber']));
        $complement = esc_sql(sanitize_text_field($formData['complement']));
        $province = esc_sql(sanitize_text_field($formData['province']));
        $city = esc_sql(sanitize_text_field($formData['city']));
        $uf = esc_sql(sanitize_text_field($formData['uf']));

        $endereco = $address . ', ' . $addressNumber;

        if (!empty($complement)) {
            $endereco .= ' - ' . $complement;
        }

        $endereco .= ', ' . $province . ', ' . $city . ' - ' . $uf;

        $nome = $_POST['name'];
        $cpf_cnpj = $formData['cpfCnpj'];
        $value = $formData['value'];
        $depValue = $formData['depValue'];
        $text_template = 'accept_terms_PF_text';

        if ($lead && $lead->is_type('PJ')) {
            $text_template = 'accept_terms_PJ_text';
        }

        $args_cotnrato = compact('nome', 'cpf_cnpj', 'endereco', 'value', 'depValue');

        $htmlContent = Template_Helper::get_view_content('text/' . $text_template, $args_cotnrato);
        $pdfGenerator = new Pdf_Generator();

        $file_name = 'contrato-' . General_Helper::remove_special_characters($cpf_cnpj);
        $pdfPath = $pdfGenerator->generatePDF($htmlContent, $file_name);

        $formData['file_name'] = $file_name;
        $formData['path'] = $pdfPath;

        $pdfGenerator->disparar_webhook_personalizado($formData);

        // Enviar o e-mail com o PDF
        if (isset($formData['email']) && filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $pdfGenerator->sendEmailWithPDF($formData['email'], 'Confirmação de Plano', 'Contrato de prestação de serviço.', $pdfPath);
        }
    }


    private static function delete_lead_checkout_links($lead_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'checkout_links';

        $wpdb->delete($table_name, ['lead_id' => $lead_id], ['%d']);
    }

    private static function get_lead_id_from_uuid($uuid)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'checkout_links';
        return $wpdb->get_var($wpdb->prepare("SELECT lead_id FROM $table_name WHERE uuid = %s", $uuid));
    }

    private static function validate_and_sanitize_form_data($data)
    {
        // Sanitiza e valida os dados do formulário
        $formData = [
            'name'           => esc_sql(sanitize_text_field($data['name'])),
            'email'          => esc_sql(sanitize_email($data['email'])),
            'phone'          => preg_replace('/\D/', '', esc_sql(sanitize_text_field($data['phone']))),
            'mobilePhone'    => preg_replace('/\D/', '', esc_sql(sanitize_text_field($data['phone']))),
            'cpfCnpj'        => preg_replace('/\D/', '', esc_sql(sanitize_text_field($data['cpfCnpj']))),
            'postalCode'     => preg_replace('/\D/', '', esc_sql(sanitize_text_field($data['postalCode']))),
            'address'        => esc_sql(sanitize_text_field($data['address'])),
            'addressNumber'  => esc_sql(sanitize_text_field($data['addressNumber'])),
            'complement'     => esc_sql(sanitize_text_field($data['complement'])),
            'province'       => esc_sql(sanitize_text_field($data['province'])),
            'city'           => esc_sql(sanitize_text_field($data['city'])),
            'uf'             => esc_sql(sanitize_text_field($data['uf'])),
            'num_dependents' => intval($data['num_dependents']),
            'holderName'     => esc_sql(sanitize_text_field($data['holderName'])),
            'number'         => preg_replace('/\D/', '', esc_sql(sanitize_text_field($data['number']))),
            'expiryMonth'    => esc_sql(sanitize_text_field($data['expiryMonth'])),
            'expiryYear'     => esc_sql(sanitize_text_field($data['expiryYear'])),
            'ccv'            => esc_sql(sanitize_text_field($data['ccv'])),
            'vendor_id'      => isset($_COOKIE['vendor_id']) ? intval($_COOKIE['vendor_id']) : 0,
        ];

        // Valida os dados
        // if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        //     wp_send_json_error('Invalid email address');
        //     wp_die();
        // }

        if (!preg_match('/^\d{11}$/', $formData['cpfCnpj']) && !preg_match('/^\d{14}$/', $formData['cpfCnpj'])) {
            wp_send_json_error('Invalid CPF/CNPJ');
            wp_die();
        }

        $formData['description'] = 'Assinatura com ' . $formData['num_dependents'] . ' dependentes';

        return $formData;
    }

    private static function asaas_get_or_create_customer($asaas, $formData)
    {
        $existingCustomerResult = $asaas->get_customer_by_cpf_cnpj($formData['cpfCnpj']);

        if (!empty($existingCustomerResult['data'])) {
            return $existingCustomerResult['data'][0]['id'];
        }

        $customerResult = $asaas->create_new_client($formData);

        if (isset($customerResult['errors'])) {
            $errors = array_map(function ($error) {
                return $error['description'];
            }, $customerResult['errors']);
            wp_send_json_error(implode(', ', $errors));
            wp_die();
        }

        return $customerResult['id'];
    }

    private static function asaas_get_or_create_subscription($asaas, $customerId, $formData, $lead = NULL)
    {

        //se já possui uma assinatura
        $existingSubs = $asaas->get_subscriptions(['customer' => $customerId]);

        if (isset($existingSubs['data']) && count($existingSubs['data']) > 0) {

            $subs_id = $existingSubs['data'][0]['id'];
            return $subs_id;
        }

        $customer = $asaas->get_customer_by_cpf_cnpj($formData['cpfCnpj']);
        if (empty($customer['data'])) {
            wp_send_json_error('Cliente não encontrado com o CPF/CNPJ fornecido.');
            wp_die();
        }

        $customer_data = $customer['data'][0];

        if ($customer_data['cpfCnpj'] !== $formData['cpfCnpj']) {
            $asaas->update_customer($customer_data['id'], ['cpfCnpj' => $formData['cpfCnpj']]);
        }

        // Determina o tipo de pagamento com base no valor de $pay_method
        $billingType = $_POST['pay_method'];

        //ciclo de cobrança
        $cycle = 'MONTHLY';

        //valor comissão
        $comissao = 100;
        $value    = $formData['value'];

        //data vencimento
        $next_due_date = date('Y-m-d');

        if ($lead && $lead->get_recurrence() == 'yearly') {
            $cycle = 'YEARLY';
            $comissao = 8.33;
        }

        // Verifica se o lead é do tipo PJ
        if ($lead && $lead->is_type('PJ')) {
            // Obtém o dia de vencimento escolhido pelo usuário
            $day_of_due_date = $lead->get_deal_due_date(); // Supondo que isso retorne apenas o dia

            if ($day_of_due_date) {
                // Verifica o mês e ano atuais
                $current_year = date('Y');
                $current_month = date('m');

                // Monta a data de vencimento usando o dia obtido
                $next_due_date = date('Y-m-d', strtotime("$current_year-$current_month-$day_of_due_date"));

                // Se o dia de vencimento já passou neste mês, ajusta para o próximo mês
                if (strtotime($next_due_date) < strtotime(date('Y-m-d'))) {
                    // Adiciona um mês à data
                    $next_due_date = date('Y-m-d', strtotime("+1 month", strtotime($next_due_date)));
                }
            }
        }

        // Prepara os dados comuns para a criação da assinatura
        $data = [
            'customer'    => $customerId,
            'billingType' => $billingType,
            'cycle'       => $cycle,
            'nextDueDate' => $next_due_date,
            'value'       => $value,
            'description' => $formData['description'],
        ];

        // Se o pagamento for por cartão, adicione os detalhes do cartão
        if ($billingType === 'CREDIT_CARD') {
            $data['creditCard'] = [
                'holderName'  => $formData['holderName'],
                'number'      => $formData['number'],
                'expiryMonth' => $formData['expiryMonth'],
                'expiryYear'  => $formData['expiryYear'],
                'ccv'         => $formData['ccv']
            ];
            $data['creditCardHolderInfo'] = [
                'name'          => $formData['name'],
                'email'         => $formData['email'] ?? '',
                'cpfCnpj'       => $formData['cpfCnpj'],
                'postalCode'    => $formData['postalCode'] ?? '',
                'addressNumber' => $formData['addressNumber'] ?? '',
                'phone'         => $formData['phone'],
            ];
        }

        $wizer_wallet_id = 'fba72e7d-7113-4384-a7a8-96eb96f8fa05';

        
        // if ($lead && $lead->get_vendor_id()) {
        if ($lead && $lead->get_vendor_id()) {
            $vendor_wallet_id = get_user_meta($lead->get_vendor_id(), 'wallet_id', true);

            if ($vendor_wallet_id) {
                if ($lead->get_recurrence() == 'yearly') {
                    // Se a recorrência for anual e há vendor_wallet_id
                    $data['split'] = [
                        [
                            'walletId'   => $vendor_wallet_id,
                            'percentualValue' => $comissao
                        ]
                    ];
                } else {
                    // Se há vendor_wallet_id, mas a recorrência não é anual
                    $data['split'] = [
                        [
                            'walletId'   => $vendor_wallet_id,
                            'percentualValue' => $comissao
                        ]
                    ];
                }
            } 
        } 


        // Cria a assinatura no Asaas
        $subscriptionResult = $asaas->create_subscription($data);

        // Verifica erros na resposta do Asaas
        if (isset($subscriptionResult['errors'])) {
            $errors = array_map(function ($error) {
                return $error['description'];
            }, $subscriptionResult['errors']);
            wp_send_json_error(implode(', ', $errors));
            wp_die();
        }

        return $subscriptionResult['id'];
    }
}
