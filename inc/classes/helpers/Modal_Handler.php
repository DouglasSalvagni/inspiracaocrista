<?php
/**
 * Class Modal_Handler
 *
 * This class handles AJAX requests to load modal content.
 */
class Modal_Handler {
    public function __construct() {
        add_action('wp_ajax_load_modal_content', [$this, 'load_modal_content']);
        add_action('wp_ajax_nopriv_load_modal_content', [$this, 'load_modal_content']);
    }

    /**
     * Load modal content based on the data-content attribute.
     */
    public function load_modal_content() {
        if (!isset($_POST['content_id'])) {
            wp_send_json_error('Content ID not provided.');
        }

        $content_id = sanitize_text_field($_POST['content_id']);
        $params = isset($_POST['params']) ? $_POST['params'] : [];
        $content_path = get_template_directory() . "/views/modals/{$content_id}.php";

        if (file_exists($content_path)) {
            ob_start();
            include $content_path;
            $content = ob_get_clean();
            wp_send_json_success($content);
        } else {
            wp_send_json_error('Content not found.');
        }
    }
}

new Modal_Handler();
