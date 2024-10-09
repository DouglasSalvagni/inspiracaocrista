<?php

class Edit_assinante extends Base_Page
{
    private $assinante_id;
    private $assinante_data;
    private $dependentes;
    private $is_holder;

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy(['administrator', 'diretoria', 'gerente_comercial'], home_url('/assinantes'));


        $this->add_style('custom.css', get_template_directory_uri() . '/assets/css/custom.css', [], false, 'all', 40);
        $this->add_style('dataTables.bootstrap5', 'https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css', [], false, 'all', 40);
        $this->add_style('responsive.bootstrap', 'https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css', [], false, 'all', 40);
        $this->add_style('buttons.dataTables', 'https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css', [], false, 'all', 40);

        $this->add_script('jquery-mask', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true, 10);
        $this->add_script('masks', get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true, 20);
        $this->add_script('datatable', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', ['jquery'], false, true, 20);
        $this->add_script('dataTables.bootstrap5', 'https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js', ['jquery'], false, true, 20);
        $this->add_script('dataTables.responsive', 'https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js', ['jquery'], false, true, 20);
        $this->add_script('dataTables.buttons', 'https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js', ['jquery'], false, true, 20);
        $this->add_script('buttons.print', 'https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js', ['jquery'], false, true, 20);
        $this->add_script('buttons.html5', 'https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js', ['jquery'], false, true, 20);
        $this->add_script('vfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', ['jquery'], false, true, 20);
        $this->add_script('pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', ['jquery'], false, true, 20);
        $this->add_script('jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', ['jquery'], false, true, 20);
        $this->add_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', [], false, true, 70);

        // Obter o assinante_id da URL
        $this->assinante_id = isset($_GET['assinante_id']) ? Encryption::decrypt($_GET['assinante_id'], true) : 0;

        if (!$this->assinante_id) {
            wp_safe_redirect(home_url('/assinantes'));
            exit();
        }

        $assinante_service = new Assinante_Service($this->assinante_id);

        $this->assinante_data = $assinante_service->get_data();
        $this->is_holder = $assinante_service->is_holder();

        // Verificar se o assinante existe
        if (empty($this->assinante_data)) {
            wp_safe_redirect(home_url('/assinantes'));
            exit();
        }

        $this->dependentes = $assinante_service->get_dependentes();

        // Submissão do formulário tradicional
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_assinante'])) {
                $this->handle_form_submission();
            } elseif (isset($_POST['update_dependentes'])) {
                $this->handle_dependentes_form_submission();
            } elseif (isset($_POST['excluir_assinante'])) {
                $this->handle_excluir_assinante_form_submission();
            }
        }
    }

    public function handle_form_submission()
    {
        $assinante_service = new Assinante_Service($this->assinante_id);
        $result = $assinante_service->update_assinante($_POST, $this->user_has_role(['administrator']));

        if ($result['success']) {
            Alert_Helper::add_alert('Dados atualizados com sucesso!', 'success');
            wp_redirect(add_query_arg(['assinante_id' => $this->assinante_id], home_url($GLOBALS['wp']->request)));
            exit();
        } else {
            Alert_Helper::add_alert($result['message'], 'danger');
        }
    }

    public function handle_dependentes_form_submission()
    {
        $assinante_service = new Assinante_Service($this->assinante_id);
        $dependentes_to_delete = isset($_POST['dependentes_to_delete']) ? explode(',', sanitize_text_field($_POST['dependentes_to_delete'])) : [];
        $dependentes = isset($_POST['dependentes']) ? $_POST['dependentes'] : [];
        $result = $assinante_service->update_dependentes($dependentes, $dependentes_to_delete);

        if ($result['success']) {
            Alert_Helper::add_alert($result['message'], 'success');
            wp_redirect(add_query_arg(['assinante_id' => $this->assinante_id], home_url($GLOBALS['wp']->request)));
            exit();
        } else {
            Alert_Helper::add_alert($result['message'], 'danger');
        }
    }

    public function handle_excluir_assinante_form_submission()
    {
        // Instancia o serviço de assinante
        $assinante_service = new Assinante_Service($this->assinante_id);

        // Obtém os dados do assinante
        $assinante_data = $assinante_service->get_data();

        // Exclui a assinatura na API do Asaas
        $asaas = new Asaas_API();
        if ($assinante_service->get_asaas_subscription_id()) {
            try {
                $asaas->delete_subscription($assinante_service->get_asaas_subscription_id());
            } catch (Exception $e) {
                Alert_Helper::add_alert('Erro ao excluir a assinatura no Asaas: ' . $e->getMessage(), 'danger');
                return;
            }
        }

        // Arquiva os dados do assinante na tabela wp_assinantes_archived
        global $wpdb;
        $archived_table_name = $wpdb->prefix . 'assinantes_archived';

        // Arquivar o titular
        unset($assinante_data['id']);
        $assinante_data['archived_at'] = current_time('mysql');
        $wpdb->insert($archived_table_name, $assinante_data);

        // Verifica se o arquivamento do titular foi bem-sucedido
        if ($wpdb->insert_id) {
            // Arquivar e excluir os dependentes
            $dependentes = $assinante_service->get_dependentes();
            foreach ($dependentes as $dependente) {
                $dependent_id = $dependente['id'];
                unset($dependente['id']);
                $dependente['archived_at'] = current_time('mysql');
                $wpdb->insert($archived_table_name, $dependente);

                if ($wpdb->insert_id) {
                    // Deletar dependente da tabela original
                    $wpdb->delete($wpdb->prefix . 'assinantes', ['id' => $dependent_id]);
                } else {
                    Alert_Helper::add_alert('Erro ao arquivar o dependente: ' . $wpdb->last_error, 'danger');
                    wp_redirect(add_query_arg(['assinante_id' => Encryption::encrypt($this->assinante_id, true)], home_url($GLOBALS['wp']->request)));
                    exit();
                }
            }

            // Remove o assinante titular da tabela original
            $wpdb->delete($wpdb->prefix . 'assinantes', ['id' => $this->assinante_id]);

            Alert_Helper::add_alert('Assinante e dependentes excluídos e arquivados com sucesso.', 'success');
            $webhook = new Pdf_Generator();
            $webhook->disparar_webhook_geral($assinante_data, 'cancelamento');
        } else {
            Alert_Helper::add_alert('Erro ao arquivar o assinante. ' . $wpdb->last_error, 'danger');
            wp_redirect(add_query_arg(['assinante_id' => Encryption::encrypt($this->assinante_id, true)], home_url($GLOBALS['wp']->request)));
            exit();
        }

        // Redireciona para a lista de assinantes
        wp_safe_redirect(home_url('/assinantes'));
        exit();
    }

    private function get_team_users()
    {
        global $user_info;

        $args = [
            'role__not_in' => ['administrator'],
        ];

        if (!$user_info->user_has_role(['diretoria', 'administrator'])) {
            $args['meta_query'] = [
                [
                    'key' => 'team_id',
                    'value' => $user_info->get_team_id(),
                    'compare' => '='
                ]
            ];
        }

        return get_users($args);
    }


    public function render()
    {
        // Passar variáveis para a view
        $vars = [
            'page_instance' => $this,
            'assinante_data' => $this->assinante_data,
            'dependentes' => $this->dependentes,
            'assinante_id' => $this->assinante_id,
            'is_holder' => $this->is_holder,
            'form' => $this->render_form('edit-assinante', [
                'page_instance' => $this,
                'assinante_data' => $this->assinante_data,
                'assinante_id' => $this->assinante_id,
            ]),
            'form_dependentes' => $this->render_form('edit-dependentes', [
                'page_instance' => $this,
                'dependentes' => $this->dependentes,
                'assinante_id' => $this->assinante_id,
                'team_users' => $this->get_team_users(),
            ]),
            'form_excluir' => $this->render_form('excluir-assinante', [
                'page_instance' => $this,
                'assinante_id' => $this->assinante_id,
            ]),
        ];

        // Renderizar a view específica
        $this->render_view('pages/edit-assinante', $vars);
    }
}
