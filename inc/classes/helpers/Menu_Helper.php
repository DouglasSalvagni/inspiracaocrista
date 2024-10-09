<?php

class Menu_Helper
{
    /**
     * Generate the HTML for a menu link.
     *
     * @param string $slug The slug of the page or post.
     * @param string $icon_class The class of the icon.
     * @param string $label The label for the menu item.
     * @param string|false $custom_url The custom URL for the menu item.
     * @param array $allowed_roles Array of allowed user roles.
     * @return string The HTML for the menu link or an empty string if the page/post is not found or the user does not have the required role.
     */
    public static function generate_menu_link($slug, $icon_class, $label = '', $custom_url = false, $allowed_roles = [])
    {
        // Check if the current user has one of the allowed roles
        if (!self::user_has_role($allowed_roles)) {
            return '';
        }

        // Get the post object by slug
        $post = get_page_by_path($slug);

        // Check if a custom URL is provided or if a post is found
        if ($custom_url) {
            $url = $custom_url;
        } elseif ($post) {
            $url = get_permalink($post);
        } else {
            // Return an empty string if no post is found and no custom URL is provided
            return '';
        }

        // Determine the title to use
        if ($label) {
            $title = $label;
        } elseif ($post) {
            $title = get_the_title($post->ID);
        } else {
            // Return an empty string if no title is available
            return '';
        }

        // Check if the current page is the same as the provided slug
        $is_active = (is_page($post->ID) || (is_single() && get_post_field('post_name', get_post()) === $slug)) ? 'active' : '';

        // Return the HTML for the menu link
        return '
        <li class="nav-item">
            <a class="nav-link menu-link ' . esc_attr($is_active) . '" href="' . esc_url($url) . '">
                <i class="' . esc_attr($icon_class) . '"></i> <span data-key="t-' . esc_attr($slug) . '">' . esc_html($title) . '</span>
            </a>
        </li>';
    }

    /**
     * Generate the HTML for a dropdown menu link.
     *
     * @param string $slug The slug of the page or post.
     * @param string $icon_class The class of the icon.
     * @param string $label The label for the menu item.
     * @param string|false $custom_url The custom URL for the menu item.
     * @param array $allowed_roles Array of allowed user roles.
     * @return string The HTML for the menu link or an empty string if the page/post is not found or the user does not have the required role.
     */
    public static function user_dropdown_menu_link($slug, $icon_class, $label = '', $custom_url = false, $allowed_roles = [])
    {
        // Check if the current user has one of the allowed roles
        if (!self::user_has_role($allowed_roles)) {
            return '';
        }

        // Get the post object by slug
        $post = get_page_by_path($slug);

        // Check if a custom URL is provided or if a post is found
        if ($custom_url) {
            $url = $custom_url;
        } elseif ($post) {
            $url = get_permalink($post);
        } else {
            // Return an empty string if no post is found and no custom URL is provided
            return '';
        }

        // Determine the title to use
        if ($label) {
            $title = $label;
        } elseif ($post) {
            $title = get_the_title($post->ID);
        } else {
            // Return an empty string if no title is available
            return '';
        }

        // Return the HTML for the menu link
        return '
            <a class="dropdown-item" href="' . esc_url($url) . '">
                <i class="' . esc_attr($icon_class) . ' text-muted fs-16 align-middle me-1"></i> <span class="align-middle">' . esc_html($title) . '</span>
            </a>';
    }

    /**
     * Generate the HTML for a simple link.
     *
     * @param string $slug The slug of the page or post.
     * @param string $class The class for the link.
     * @param string $icon_class The class of the icon.
     * @param string $label The label for the menu item.
     * @param string|false $custom_url The custom URL for the menu item.
     * @param array $allowed_roles Array of allowed user roles.
     * @return string The HTML for the menu link or an empty string if the page/post is not found or the user does not have the required role.
     */
    public static function get_simple_link($slug, $class = '', $icon_class = '', $label = '', $custom_url = false, $allowed_roles = [])
    {
        // Check if the current user has one of the allowed roles
        if (!self::user_has_role($allowed_roles)) {
            return '';
        }

        // Get the post object by slug
        $post = get_page_by_path($slug);

        // Check if a custom URL is provided or if a post is found
        if ($custom_url) {
            $url = $custom_url;
        } elseif ($post) {
            $url = get_permalink($post);
        } else {
            // Return an empty string if no post is found and no custom URL is provided
            return '';
        }

        // Determine the title to use
        if ($label) {
            $title = $label;
        } elseif ($post) {
            $title = get_the_title($post->ID);
        } else {
            // Return an empty string if no title is available
            return '';
        }

        $icon = '';
        if ($icon_class) {
            $icon = '<i class="' . esc_attr($icon_class) . ' "></i>';
        }

        // Return the HTML for the menu link
        return '
            <a class="' . esc_html($class) . '" href="' . esc_url($url) . '">
                ' . $icon . ' <span class="align-middle">' . esc_html($title) . '</span>
            </a>';
    }

    /**
     * Check if the current user has one of the allowed roles.
     *
     * @param array $allowed_roles Array of allowed user roles.
     * @return bool True if the user has one of the roles, false otherwise.
     */
    private static function user_has_role($allowed_roles)
    {
        if (empty($allowed_roles)) {
            return true; // No restriction if no roles are specified
        }

        $user = wp_get_current_user();
        if (!$user || empty($user->roles)) {
            return false;
        }

        foreach ($user->roles as $role) {
            if (in_array($role, $allowed_roles, true)) {
                return true;
            }
        }

        return false;
    }
}
