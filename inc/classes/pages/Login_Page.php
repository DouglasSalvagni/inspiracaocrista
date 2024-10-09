<?php

require_once 'Base_Page.php';

/**
 * Class Login_Page
 *
 * Esta classe é responsável por renderizar a página de login e processar o login do usuário.
 */
class Login_Page extends Base_Page {
    public function __construct() {
        parent::__construct();
        
        $this->load_base_style();
        $this->load_base_scripts();

        $this->add_script('password-addon', get_template_directory_uri() . '/assets/js/pages/password-addon.init.js', [], false, true);
        
        // Verifica se o usuário já está logado e redireciona
        if (is_user_logged_in()) {
            wp_safe_redirect(home_url());
            exit;
        }

        // Processa o login se a requisição for POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->process_login();
        }
        
    }

    /**
     * Renderiza a view do formulário de login.
     */
    public function render() {
        $this->render_view('pages/login');
    }

    /**
     * Processa o login do usuário.
     */
    private function process_login() {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            $this->render_view('pages/login', ['error' => 'Missing username or password.']);
            return;
        }

        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? true : false;

        $credentials = [
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        ];

        $user = wp_signon($credentials, false);

        if (is_wp_error($user)) {
            $this->render_view('pages/login', ['error' => $user->get_error_message(), 'username' => $username]);
        } else {
            wp_safe_redirect(home_url());
            exit;
        }
    }
}
