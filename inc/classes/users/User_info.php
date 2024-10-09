<?php
class User_Info {
    private static $instances = [];
    private $user_id;
    private $user;

    // Construtor privado para impedir instância direta
    private function __construct($user_id = null) {
        if ($user_id) {
            $this->user_id = $user_id;
            $this->user = get_userdata($user_id);
        } else {
            $this->user = wp_get_current_user();
            $this->user_id = $this->user->ID;
        }
    }

    // Método para obter a instância única da classe para um usuário específico
    public static function get_instance($user_id = null) {
        if ($user_id === null) {
            $user_id = get_current_user_id();
        }

        if (!isset(self::$instances[$user_id])) {
            self::$instances[$user_id] = new self($user_id);
        }

        return self::$instances[$user_id];
    }

    // Método para obter o ID do usuário
    public function get_user_id() {
        return (int)$this->user_id;
    }

    // Método para obter o ID do time do usuário
    public function get_team_id() {
        return (int)get_user_meta($this->user_id, 'team_id', true);
    }

    // Método para obter o ID do time do usuário
    public function get_wallet_id() {
        return get_user_meta($this->user_id, 'wallet_id', true);
    }

    // Método para obter metadados do usuário
    public function get_user_meta($key) {
        return get_user_meta($this->user_id, $key, true);
    }

    // Método para verificar se o usuário possui certos papéis (roles)
    public function user_has_role($roles = []) {
        if (!$this->user) {
            return false;
        }

        $user_roles = $this->user->roles;

        return !empty(array_intersect($roles, $user_roles));
    }
}

// Uso da classe

// Instância singleton para o usuário atual
$current_user_info = User_Info::get_instance();

// Tornar a instância do usuário atual global (opcional)
$GLOBALS['user_info'] = $current_user_info;
