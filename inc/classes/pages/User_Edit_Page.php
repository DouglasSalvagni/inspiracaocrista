<?php

class User_Edit_Page extends Base_Page
{
    private $user_id;
    private $user_data;
    private $roles;

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        //limpar session
        if(!isset($_GET['success'])) {
            Alert_Helper::clean_session();
        }

        // Define a privacidade da página (apenas para 'administrator' e 'diretoria')
        $this->set_page_privacy(['administrator', 'diretoria'], home_url('/'));

        // Obtém o user_id da query var
        $this->user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

        if (!$this->user_id) {
            wp_safe_redirect(home_url('/usuarios'));
            exit();
        }

        // Busca os dados do usuário
        $this->user_data = get_userdata($this->user_id);
        
        $this->roles = $this->get_allowed_roles();

        if (!$this->user_data) {
            wp_safe_redirect(home_url('/usuarios'));
            exit();
        }

        // Processa a submissão do formulário
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update_user'])) {
                $this->handle_form_submission();
            }
        }
    }

    private function handle_form_submission()
    {
        // Verifica o nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'update_user_' . $this->user_id)) {
            Alert_Helper::add_alert('Falha na verificação de segurança.', 'danger');
            return;
        }

        // Verifica as capacidades do usuário atual
        if (!current_user_can('edit_user', $this->user_id)) {
            Alert_Helper::add_alert('Você não tem permissão para editar este usuário.', 'danger');
            return;
        }

        // Obtém os dados do formulário
        $user_id = $this->user_id;
        $user_data = [
            'ID'         => $user_id,
            'first_name' => sanitize_text_field($_POST['first_name']),
            'last_name'  => sanitize_text_field($_POST['last_name']),
            'user_email' => sanitize_email($_POST['user_email']),
            'role'       => sanitize_text_field($_POST['role']),
        ];

        // Atualiza o meta 'team_id'
        if (isset($_POST['team_id'])) {
            update_user_meta($user_id, 'team_id', intval($_POST['team_id']));
        }

        // Processa a alteração de senha, se fornecida
        $user_pass = $_POST['user_pass'];
        $user_pass_confirm = $_POST['user_pass_confirm'];

        if (!empty($user_pass) || !empty($user_pass_confirm)) {
            // Verifica se as senhas correspondem
            if ($user_pass !== $user_pass_confirm) {
                Alert_Helper::add_alert('As senhas não correspondem.', 'danger');
                return;
            }

            // Validação da senha (opcional, ex.: tamanho mínimo)
            if (strlen($user_pass) < 6) {
                Alert_Helper::add_alert('A senha deve ter pelo menos 6 caracteres.', 'danger');
                return;
            }

            // Atualiza a senha
            $user_data['user_pass'] = $user_pass;
        }

        // Atualiza os dados do usuário
        $result = wp_update_user($user_data);

        if (is_wp_error($result)) {
            Alert_Helper::add_alert('Erro ao atualizar o usuário: ' . $result->get_error_message(), 'danger');
        } else {
            Alert_Helper::add_alert('Usuário atualizado com sucesso!', 'success');
            // Recarrega os dados do usuário
            $this->user_data = get_userdata($user_id);

            wp_safe_redirect(add_query_arg(['user_id' => $user_id,'success' => true], home_url('/editar-usuario')));
            exit;
        }
    }

    private function get_allowed_roles()
    {
        // Define os roles permitidos para seleção
        $allowed_roles = ['gerente_comercial', 'comercial']; // Ajuste conforme necessário
        if($this->user_has_role(['administrator'])) {
            $allowed_roles[] = 'diretoria';
        }

        global $wp_roles;
        $roles = [];

        foreach ($allowed_roles as $role) {
            if (isset($wp_roles->roles[$role])) {
                $roles[$role] = $wp_roles->roles[$role]['name'];
            }
        }

        return $roles;
    }


    private function get_all_teams()
    {
        $teams = [];

        $args = [
            'post_type'      => 'team',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $team_posts = get_posts($args);

        foreach ($team_posts as $team) {
            $teams[$team->ID] = $team->post_title;
        }

        return $teams;
    }


    public function render()
    {
        
        $user_info = User_Info::get_instance($this->user_id);

        $vars = [
            'page_instance' => $this,
            'user_data'     => $this->user_data,
            'teams'         => $this->get_all_teams(),
            'roles'         => $this->roles,
            'user_info'     => $user_info,
        ];

        $this->render_view('pages/user-edit', $vars);
    }
}
