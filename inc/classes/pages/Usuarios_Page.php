<?php

class Usuarios_Page extends Base_Page
{
    private $team_id;
    private $search_query;
    private $users;
    private $pagina;
    private $users_per_page = 10; // Ajuste este número conforme necessário
    private $total_users;

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

        // Obtém os filtros dos parâmetros GET
        $this->team_id = isset($_GET['team_id']) ? intval($_GET['team_id']) : null;
        $this->search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

        // Obtém o número da página atual
        $this->pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

        // Busca os usuários com base nos filtros e paginação
        $this->users = $this->get_filtered_users();

        // Obtém o total de usuários para paginação
        $this->total_users = $this->get_total_users_count();

        // Processa a submissão do formulário de exclusão
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_user'])) {
                $this->handle_delete_user();
            }
        }
    }

    private function handle_delete_user()
    {
        // Verifica o nonce
        if (!isset($_POST['delete_user_nonce']) || !wp_verify_nonce($_POST['delete_user_nonce'], 'delete_user_action')) {
            Alert_Helper::add_alert('Falha na verificação de segurança.', 'danger');
            return;
        }

        // Verifica as capacidades do usuário atual
        if (!current_user_can('delete_users')) {
            Alert_Helper::add_alert('Você não tem permissão para excluir usuários.', 'danger');
            return;
        }

        $user_id = intval($_POST['user_id']);

        // Não permitir a exclusão de administradores
        $user_to_delete = get_userdata($user_id);
        if (in_array('administrator', $user_to_delete->roles)) {
            Alert_Helper::add_alert('Você não pode excluir um administrador.', 'danger');
            return;
        }

        // Previne que o usuário atual se exclua
        if ($user_id === get_current_user_id()) {
            Alert_Helper::add_alert('Você não pode excluir seu próprio usuário.', 'danger');
            return;
        }

        // Exclui o usuário
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        $result = wp_delete_user($user_id);

        if ($result) {
            Alert_Helper::add_alert('Usuário excluído com sucesso.', 'success');
            // Redireciona para a página de lista de usuários para evitar reenvio do formulário
            wp_safe_redirect(home_url('/usuarios'));
            exit;
        } else {
            Alert_Helper::add_alert('Erro ao excluir o usuário.', 'danger');
        }
    }


    private function get_filtered_users()
    {
        $args = [
            'role__not_in' => ['administrator'],
            'meta_query'   => [],
            'number'       => $this->users_per_page,
            'offset'       => ($this->pagina - 1) * $this->users_per_page,
        ];

        if ($this->team_id) {
            $args['meta_query'][] = [
                'key'     => 'team_id',
                'value'   => $this->team_id,
                'compare' => '='
            ];
        }

        if ($this->search_query) {
            $args['search'] = '*' . esc_attr($this->search_query) . '*';
            $args['search_columns'] = ['user_login', 'user_nicename', 'display_name'];
        }

        return get_users($args);
    }

    private function get_total_users_count()
    {
        $args = [
            'role__not_in' => ['administrator'],
            'meta_query'   => [],
            'fields'       => 'ID',
            'number'       => -1,
        ];

        if ($this->team_id) {
            $args['meta_query'][] = [
                'key'     => 'team_id',
                'value'   => $this->team_id,
                'compare' => '='
            ];
        }

        if ($this->search_query) {
            $args['search'] = '*' . esc_attr($this->search_query) . '*';
            $args['search_columns'] = ['user_login', 'user_nicename', 'display_name'];
        }

        $user_query = new WP_User_Query($args);
        return $user_query->get_total();
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
        $vars = [
            'page_instance'  => $this,
            'users'          => $this->users,
            'teams'          => $this->get_all_teams(),
            'team_id'        => $this->team_id,
            'search_query'   => $this->search_query,
            'pagina'         => $this->pagina,
            'users_per_page' => $this->users_per_page,
            'total_users'    => $this->total_users,
        ];

        $this->render_view('pages/users-list', $vars);
    }
}
