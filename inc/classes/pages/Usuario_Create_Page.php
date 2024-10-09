<?php

class Usuario_Create_Page extends Base_Page
{
    private $teams;
    private $roles;

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        //limpar session
        Alert_Helper::clean_session();

        // Define a privacidade da página (apenas para 'administrator' e 'diretoria')
        $this->set_page_privacy(['administrator', 'diretoria'], home_url('/'));

        // Carrega estilos e scripts adicionais se necessário
        $this->add_style('custom.css', get_template_directory_uri() . '/assets/css/custom.css', [], false, 'all', 40);

        // Carrega times e roles
        $this->teams = $this->get_all_teams();
        $this->roles = $this->get_allowed_roles();

        // Processa a submissão do formulário
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['create_user'])) {
                $this->handle_form_submission();
            }
        }
    }

    private function handle_form_submission()
    {
        // Verifica o nonce
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'create_user')) {
            Alert_Helper::add_alert('Falha na verificação de segurança.', 'danger');
            return;
        }

        // Obtém os dados do formulário
        $user_data = [
            'user_login'   => sanitize_user($_POST['user_login'], true),
            'first_name'   => sanitize_text_field($_POST['first_name']),
            'last_name'    => sanitize_text_field($_POST['last_name']),
            'user_email'   => sanitize_email($_POST['user_email']),
            'user_pass'    => $_POST['user_pass'], // Será sanitizado abaixo
            'role'         => sanitize_text_field($_POST['role']),
        ];

        $user_pass_confirm = $_POST['user_pass_confirm'];

        // Validações
        if (empty($user_data['user_login']) || empty($user_data['user_email']) || empty($user_data['user_pass'])) {
            Alert_Helper::add_alert('Por favor, preencha todos os campos obrigatórios.', 'danger');
            return;
        }

        if ($user_data['user_pass'] !== $user_pass_confirm) {
            Alert_Helper::add_alert('As senhas não correspondem.', 'danger');
            return;
        }

        // Valida o email
        if (!is_email($user_data['user_email'])) {
            Alert_Helper::add_alert('E-mail inválido.', 'danger');
            return;
        }

        // Verifica se o nome de usuário já existe
        if (username_exists($user_data['user_login'])) {
            Alert_Helper::add_alert('Nome de usuário já existe.', 'danger');
            return;
        }

        // Verifica se o email já está registrado
        if (email_exists($user_data['user_email'])) {
            Alert_Helper::add_alert('E-mail já está registrado.', 'danger');
            return;
        }

        // Sanitiza a senha (você pode implementar uma política de senhas fortes aqui)
        $user_data['user_pass'] = sanitize_text_field($user_data['user_pass']);

        // Cria o usuário
        $user_id = wp_insert_user($user_data);

        if (is_wp_error($user_id)) {
            Alert_Helper::add_alert('Erro ao criar o usuário: ' . $user_id->get_error_message(), 'danger');
            return;
        }

        // Associa o usuário ao time se selecionado
        if (isset($_POST['team_id']) && !empty($_POST['team_id'])) {
            update_user_meta($user_id, 'team_id', intval($_POST['team_id']));
        }

        Alert_Helper::add_alert('Usuário criado com sucesso!', 'success');
        // Redireciona para a lista de usuários ou outra página de sua escolha
        wp_safe_redirect(home_url('/usuarios'));
        exit;
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

    public function render()
    {
        $vars = [
            'page_instance' => $this,
            'teams'         => $this->teams,
            'roles'         => $this->roles,
        ];

        $this->render_view('pages/user-create', $vars);
    }
}
