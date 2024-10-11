<?php

class Base_Page
{
    protected $styles  = [];
    protected $scripts = [];
    protected $current_user;

    public function __construct()
    {
        $this->current_user = wp_get_current_user();

        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    // Método para carregar base style
    public function load_base_style()
    {
        // Adicionando os estilos com prioridade
        $this->add_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', [], false, 'all', 10);
        $this->add_style('icons', get_template_directory_uri() . '/assets/css/icons.min.css', [], false, 'all', 20);
        $this->add_style('app', get_template_directory_uri() . '/assets/css/app.min.css', [], false, 'all', 30);
        $this->add_style('custom', get_template_directory_uri() . '/assets/css/custom.css', [], false, 'all', 40);
    }

    // Método para carregar base scripts
    public function load_base_scripts()
    {
        // Adicionando os scripts com prioridade
        $this->add_script('bootstrap-bundle', get_template_directory_uri() . '/assets/libs/bootstrap/js/bootstrap.bundle.min.js', ['jquery'], false, true, 10);
        $this->add_script('simplebar', get_template_directory_uri() . '/assets/libs/simplebar/simplebar.min.js', [], false, true, 20);
        $this->add_script('waves', get_template_directory_uri() . '/assets/libs/node-waves/waves.min.js', [], false, true, 30);
        $this->add_script('feather', get_template_directory_uri() . '/assets/libs/feather-icons/feather.min.js', [], false, true, 40);
        $this->add_script('lord-icon', get_template_directory_uri() . '/assets/js/pages/plugins/lord-icon-2.1.0.js', [], false, true, 50);
        $this->add_script('choices', get_template_directory_uri() . '/assets/libs/choices.js/public/assets/scripts/choices.min.js', [], false, true, 49);
        $this->add_script('plugins', get_template_directory_uri() . '/assets/js/plugins.js', [], false, true, 60);
        $this->add_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', [], false, true, 70);
        $this->add_script('modal-handler-js', get_template_directory_uri() . '/assets/js/modal-handler.js', ['jquery'], false, true, 71);
        $this->add_script('app', get_template_directory_uri() . '/assets/js/app.js', [], false, true, 80);
    }

    // Método para adicionar CSS com prioridade
    public function add_style($handle, $src, $deps = [], $ver = false, $media = 'all', $priority = 10)
    {
        $this->styles[] = compact('handle', 'src', 'deps', 'ver', 'media', 'priority');
    }

    // Método para adicionar JavaScript com prioridade
    public function add_script($handle, $src, $deps = [], $ver = false, $in_footer = false, $priority = 10)
    {
        $this->scripts[] = compact('handle', 'src', 'deps', 'ver', 'in_footer', 'priority');
    }

    // Método que registra os assets no WordPress
    public function enqueue_assets()
    {
        usort($this->styles, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        usort($this->scripts, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        foreach ($this->styles as $style) {
            wp_enqueue_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media']);
        }

        foreach ($this->scripts as $script) {
            wp_enqueue_script($script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer']);
        }
    }

    // Método para renderizar uma view
    public function render_view($view_name, $vars = [])
    {
        $view_path = get_template_directory() . '/views/' . $view_name . '.php';

        if (file_exists($view_path)) {
            extract($vars);
            include($view_path);
        } else {
            echo '<!-- View not found: ' . esc_html($view_path) . ' -->';
        }
    }

    // Método para renderizar um formulário
    public function render_form($form_name, $vars = [])
    {
        $form_path = get_template_directory() . '/views/forms/' . $form_name . '.php';

        ob_start();
        if (file_exists($form_path)) {
            extract($vars);
            include($form_path);
        } else {
            echo '<!-- Form not found: ' . esc_html($form_path) . ' -->';
        }
        return ob_get_clean();
    }

    // Método para renderizar um formulário
    public function render_part($form_name, $vars = [])
    {
        $form_path = get_template_directory() . '/views/' . $form_name . '.php';

        ob_start();
        if (file_exists($form_path)) {
            extract($vars);
            include($form_path);
        } else {
            echo '<!-- part not found: ' . esc_html($form_path) . ' -->';
        }
        return ob_get_clean();
    }

    // Método para definir a privacidade da página
    public function set_page_privacy($roles = [], $redirect_url = null)
    {
        if (!is_user_logged_in()) {
            $this->redirect_user($redirect_url);
        } else {
            $user = wp_get_current_user();
            // Verifica se o usuário é um administrador
            if (in_array('administrator', $user->roles)) {
                return; // Se for administrador, permite o acesso
            }
            if (!empty($roles)) {
                if (!array_intersect($roles, $user->roles)) {
                    $this->redirect_user($redirect_url);
                }
            }
        }
    }

    public function get_current_user()
    {
        return $this->current_user;
    }

    protected function user_has_role($roles = [])
    {
        if (!is_user_logged_in()) {
            return false;
        }

        $user_roles = $this->current_user->roles;

        return !empty(array_intersect($roles, $user_roles));
    }

    public function get_user_team_id($user_id = null)
    {
        if (!$user_id) {
            $user_id = $this->current_user->ID;
        }

        $team_id = get_user_meta($user_id, 'team_id', true);

        return $team_id ? intval($team_id) : null;
    }


    // Método para invocar a privacidade da página
    public function apply_page_privacy($rules = [], $endpoint = '')
    {
        $this->set_page_privacy($rules, home_url($endpoint));
    }

    // Método auxiliar para redirecionar o usuário
    protected function redirect_user($redirect_url)
    {
        if (is_null($redirect_url)) {
            $redirect_url = wp_login_url($_SERVER['REQUEST_URI']);
        }
        wp_safe_redirect($redirect_url);
        exit;
    }
}
