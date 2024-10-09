<?php

class Template_Helper
{
    // Método para renderizar um formulário
    public static function render_form($form_name, $vars = [])
    {
        $form_path = get_template_directory() . '/views/forms/' . $form_name . '.php';

        ob_start();
        if (file_exists($form_path)) {
            extract($vars);
            include($form_path);
        } else {
            echo '<!-- Form not found: ' . esc_html($form_path) . ' -->';
        }
        echo ob_get_clean();
    }

    // Método para renderizar um views
    public static function render_view($view, $vars = [])
    {
        $view = get_template_directory() . '/views/' . $view . '.php';

        ob_start();
        if (file_exists($view)) {
            extract($vars);
            include($view);
        } else {
            echo '<!-- Form not found: ' . esc_html($view) . ' -->';
        }
        echo ob_get_clean();
    }

    public static function get_view_content($view, $vars = [])
    {
        $view = get_template_directory() . '/views/' . $view . '.php';

        ob_start();
        if (file_exists($view)) {
            extract($vars);
            include($view);
        } else {
            echo '';
        }
        return ob_get_clean();
    }
}
