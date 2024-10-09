<?php

class Edit_lead extends Base_Page
{
    private $lead_id;
    private $lead_data;

    public function __construct($lead_id)
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));

        $this->add_script('jquery-mask', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true, 10);
        $this->add_script('masks', get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true, 20);

        $this->lead_id = $lead_id;

        $lead_service = new Lead_Service($lead_id);
        $this->lead_data = $lead_service->get_data();

        // Submissão do formulário tradicional
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handle_form_submission();
        }
    }

    private function calculate_progress_percentage()
    {
        $status_order = array_keys(Lead_Meta::get_status_options());
        $current_status_index = array_search($this->lead_data['lead_status'], $status_order);
        if ($current_status_index === false) {
            return 0;
        }
        $total_stages = count($status_order);
        $progress_percentage = (($current_status_index + 1) / $total_stages) * 100;
        return round($progress_percentage);
    }

    public function handle_form_submission()
    {
        $lead_service = new Lead_Service($this->lead_id);
        $result = $lead_service->update_lead($_POST);

        if ($result['success']) {
            Alert_Helper::add_alert($result['message'], 'success');
            wp_redirect(add_query_arg(['updated' => 'true'], get_permalink($this->lead_id)));
            exit;
        } else {
            Alert_Helper::add_alert($result['message'], 'danger');
        }
    }

    public function render()
    {
        $current_user = wp_get_current_user();
        $assigned_user_id = $this->lead_data['lead_assigned_to'];
        global $user_info;

        if(!$user_info->get_wallet_id()) {
            Alert_Helper::add_alert('Sua wallet ID não foi identificada. Se o lead realizar o pagamento você não receberá a comissão. ' . $user_info->get_wallet_id(), 'danger');
        }

        // Verificar se o usuário atual é o usuário vinculado ao lead ou se é administrador
        if ($this->user_has_role(['administrator', 'diretoria', 'gerente_comercial']) || $current_user->ID == $assigned_user_id) {
            $progress_percentage = $this->calculate_progress_percentage();

            // Passar variáveis para a view
            $vars = [
                'user_info' => $user_info,
                'lead_data' => $this->lead_data,
                'status_options' => Lead_Meta::get_status_options(),
                'priority_options' => Lead_Meta::get_priority_options(),
                'source_options' => Lead_Meta::get_source_options(),
                'progress_percentage' => $progress_percentage,
                'form' => $this->render_form('edit-lead', [
                    'page_instance' => $this,
                    'lead_data'     => $this->lead_data,
                    'team_users'    => $this->get_team_users(),
                    'lead'          => new Lead_Data($this->lead_id),
                ]),
            ];

            // Renderizar a view específica
            $this->render_view('pages/edit-lead', $vars);
        } else {
            echo (__('Você não tem permissão para acessar esta página.'));
        }

        Alert_Helper::clean_session();
    }

    private function get_team_users()
    {
        global $user_info;

        $args = [
            'role__not_in' => [],
        ];

        if (!$this->user_has_role(['administrator', 'diretoria'])) {
            $args['meta_query'] = [
                [
                    'key'     => 'team_id',
                    'value'   => $user_info->get_team_id(),
                    'compare' => '='
                ]
            ];
        }

        return get_users($args);
    }

    public function render_only_form()
    {
        $current_user = wp_get_current_user();
        $is_admin = in_array('administrator', $current_user->roles);
        $assigned_user_id = $this->lead_data['lead_assigned_to'];

        // Verificar se o usuário atual é o usuário vinculado ao lead ou se é administrador
        if ($is_admin || $current_user->ID == $assigned_user_id) {

            // Passar variáveis para a view
            $vars = [
                'lead_data' => $this->lead_data,
                'status_options' => Lead_Meta::get_status_options(),
                'priority_options' => Lead_Meta::get_priority_options(),
                'source_options' => Lead_Meta::get_source_options(),
            ];

            echo $this->render_form('edit-lead', $vars);
        } else {
            echo (__('Você não tem permissão para acessar esta página.'));
        }
    }
}
