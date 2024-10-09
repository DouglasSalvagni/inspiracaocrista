<?php

class Alert_Helper {
    
    public static function init_session() {
        if (!session_id()) {
            session_start();
        }
    }

    public static function add_alert($message, $type = 'success') {
        if (!isset($_SESSION['alerts'])) {
            $_SESSION['alerts'] = [];
        }
        $_SESSION['alerts'][] = ['message' => $message, 'type' => $type];
    }

    public static function display_alerts() {
        if (isset($_SESSION['alerts']) && !empty($_SESSION['alerts'])) {
            foreach ($_SESSION['alerts'] as $alert) {
                echo '<div class="alert alert-' . esc_attr($alert['type']) . ' alert-dismissible fade show" role="alert">';
                echo esc_html($alert['message']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            unset($_SESSION['alerts']); // Clear alerts after displaying
        }
    }

    public static function clean_session() {
        unset($_SESSION['alerts']);
    }
}

// Inicializar a sessão
add_action('init', function() {
    Alert_Helper::init_session();
});
