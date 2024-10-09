<?php

/**
 * Class User_Role_Manager
 * 
 * This class handles the creation and management of user roles and capabilities in WordPress.
 */
class User_Role_Manager
{
    private $default_roles = [
        'comercial' => [
            'display_name' => 'Comercial',
            'slug' => 'comercial',
            'capabilities' => [
                'read' => true,
                'edit_posts' => false, // No access to edit posts
                'delete_posts' => false, // No access to delete posts
                'upload_files' => false // No access to upload files
            ]
        ],
        'gerente_comercial' => [
            'display_name' => 'Gerente comercial',
            'slug' => 'gerente_comercial',
            'capabilities' => [
                'read' => true,
                'edit_posts' => false, // No access to edit posts
                'delete_posts' => false, // No access to delete posts
                'upload_files' => false // No access to upload files
            ]
        ],
        'diretoria' => [
            'display_name' => 'Diretoria',
            'slug' => 'diretoria',
            'capabilities' => [
                'read' => true,
                'edit_posts' => false, // No access to edit posts
                'delete_posts' => false, // No access to delete posts
                'upload_files' => false // No access to upload files
            ]
        ]
    ];

    /**
     * Constructor to initialize user roles.
     * 
     * @param array $roles An array of roles with capabilities.
     */
    public function __construct($roles = [])
    {

        add_action('admin_init', [$this, 'restrict_non_admin_access']);

        // Merge provided roles with default roles
        $roles = array_merge($this->default_roles, $roles);

        // Add or update roles based on provided roles array
        foreach ($roles as $role_data) {
            $this->add_or_update_role($role_data['slug'], $role_data['display_name'], $role_data['capabilities']);
        }

        // Remove roles that are not in the default roles
        $this->remove_extra_roles();
    }

    /**
     * Add or update a role with specified capabilities.
     * 
     * @param string $role_slug The slug of the role.
     * @param string $display_name The display name of the role.
     * @param array $capabilities The capabilities for the role.
     * @return void
     */
    public function add_or_update_role($role_slug, $display_name, $capabilities = [])
    {
        if (!empty($role_slug) && !empty($display_name)) {
            // Check if the role already exists
            if (null !== get_role($role_slug)) {
                // Role exists, update capabilities
                $this->update_role_capabilities($role_slug, $capabilities);
            } else {
                // Role doesn't exist, add it
                add_role($role_slug, $display_name, $capabilities);
            }
        }
    }

    /**
     * Update capabilities for an existing role.
     * 
     * @param string $role_slug The slug of the role.
     * @param array $capabilities The capabilities to set.
     * @return void
     */
    private function update_role_capabilities($role_slug, $capabilities = [])
    {
        $role = get_role($role_slug);
        if ($role) {
            // Remove all current capabilities
            foreach ($role->capabilities as $cap => $grant) {
                $role->remove_cap($cap);
            }
            // Add new capabilities
            foreach ($capabilities as $cap => $grant) {
                $role->add_cap($cap, $grant);
            }
        }
    }

    /**
     * Remove an existing role.
     * 
     * @param string $role_slug The slug of the role to remove.
     * @return void
     */
    public function remove_role($role_slug)
    {
        remove_role($role_slug);
    }

    /**
     * Remove roles that are not defined in the default roles.
     * 
     * @return void
     */
    private function remove_extra_roles()
    {
        global $wp_roles;
        $existing_roles = $wp_roles->roles;

        $default_role_slugs = array_column($this->default_roles, 'slug');
        $wp_default_roles = ['administrator', 'editor', 'author', 'contributor', 'subscriber'];

        foreach ($existing_roles as $role_slug => $role_data) {
            if (!in_array($role_slug, $default_role_slugs) && !in_array($role_slug, $wp_default_roles)) {
                $this->remove_role($role_slug);
            }
        }
    }

    /**
     * Restore default roles and their capabilities.
     * 
     * @return void
     */
    public function restore_default_roles()
    {
        // Remove all roles that are not in the default roles
        $this->remove_extra_roles();

        // Restore default roles
        foreach ($this->default_roles as $role_data) {
            // Remove the existing role if it exists
            $this->remove_role($role_data['slug']);
            // Add the role with default capabilities
            $this->add_or_update_role($role_data['slug'], $role_data['display_name'], $role_data['capabilities']);
        }
    }

    /**
     * Redireciona usuários não administradores para a página inicial do site.
     */
    public function restrict_non_admin_access()
    {
        // Verifica se o usuário está tentando acessar uma página administrativa
        if (is_admin()) {
            // Obtém informações sobre o usuário atual
            $current_user = wp_get_current_user();

            // Verifica se o usuário não é administrador
            if (!in_array('administrator', $current_user->roles)) {
                // Verifica se a requisição não é uma requisição AJAX
                if (!defined('DOING_AJAX') || !DOING_AJAX) {
                    // Redireciona o usuário para a página inicial do site
                    wp_redirect(home_url());
                    exit;
                }
            }
        }
    }
}

// Exemplo de uso
$config_roles = new User_Role_Manager();

if (isset($_GET['refresh_roles']) && $_GET['refresh_roles'] == 'on') {
    $config_roles->restore_default_roles();
}
