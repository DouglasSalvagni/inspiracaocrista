<?php


/**
 * Define a constant to enable or disable database migrations.
 *
 * This constant controls whether the custom database tables
 * should be automatically created or updated when the theme is activated.
 * 
 * Set to true to enable migrations, or false to disable them.
 * 
 * Usage:
 * If ENABLE_MIGRATIONS is set to true, the migrations will run automatically
 * during theme activation via the 'after_switch_theme' hook, creating or updating
 * custom tables as needed.
 *
 * Example:
 * define('ENABLE_MIGRATIONS', true);  // Enables automatic migrations
 *
 * @var bool ENABLE_MIGRATIONS Set to true to enable automatic database migrations, false to disable.
 */
define('ENABLE_MIGRATIONS', true);

function set_wp_timezone()
{
    $timezone = get_option('timezone_string');

    if ($timezone) {
        date_default_timezone_set($timezone);
    } else {
        // Se a configuração do fuso horário não estiver disponível, defina um fuso horário padrão.
        date_default_timezone_set('America/Sao_Paulo');
    }
}
add_action('init', 'set_wp_timezone');


// require get_template_directory() . '/inc/dev-testes.php';

//MIGRATIONS
if (defined('ENABLE_MIGRATIONS') && ENABLE_MIGRATIONS) {
    require get_template_directory() . '/inc/migration/create_sales_table.php';
    require get_template_directory() . '/inc/migration/create_notifications_table.php';
    require get_template_directory() . '/inc/migration/create_notifications_archived_table.php';
    require get_template_directory() . '/inc/migration/create_assinantes_table.php';
    require get_template_directory() . '/inc/migration/create_assinantes_meta_table.php';
    require get_template_directory() . '/inc/migration/create_assinantes_archived_table.php';
    require get_template_directory() . '/inc/migration/create_checkout_links_table.php';
    require get_template_directory() . '/inc/migration/create_leads_archived_table.php';
    require get_template_directory() . '/inc/migration/create_disqualified_leads_table.php';
    require get_template_directory() . '/inc/migration/create_frases_table.php';
    require get_template_directory() . '/inc/migration/create_assinantes_frases_table.php';
}

//LOAD CLASSES
require get_template_directory() . '/inc/classes/_loader.php';

//POSTTYPES LOADER
require get_template_directory() . '/inc/custom-post-type.php';

//ADD-ACTIONS
require get_template_directory() . '/inc/add-actions.php';

//METABOXES
require get_template_directory() . '/inc/meta-boxes.php';

//POSTMETA LOADER
require get_template_directory() . '/inc/register-post-meta.php';

//REWRITE RULES
require get_template_directory() . '/inc/rewrite-rules/checkout.php';

//SCHEDULES
require get_template_directory() . '/inc/schedules/archive_old_notifications.php';

//SMTP
require get_template_directory() . '/inc/config-smtp.php';

//UTEIS
require get_template_directory() . '/inc/utils/telefone.php';
require get_template_directory() . '/inc/utils/media.php';




//REFATORAR
add_filter('use_block_editor_for_post_type', 'disable_gutenberg_editor', 10, 2);
function disable_gutenberg_editor($use_block_editor, $post_type)
{
    return false;
}
add_filter('show_admin_bar', '__return_false');

function enqueue_javascript_variables()
{
    // wp_enqueue_script('notification-ajax', get_template_directory_uri() . '/assets/js/notification.js', ['jquery'], null, true);

    // Passando a URL AJAX e o nonce para o script
    wp_localize_script('jquery', 'sysUrls', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('delete_notification_nonce'),
        'mark_as_read_nonce' => wp_create_nonce('mark_as_read_nonce'),
        'general_nonce' => wp_create_nonce('general_nonce')
    ]);

    wp_localize_script('jquery', 'syOptions', [
        'subscription_price' => get_option('asaas_subscription_price', 100),
        'subscription_dependent_price' => Pricing_Assinatura_Service::calculate_discounted_price_per_dependent(),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_javascript_variables');

function register_notification_ajax_handler()
{
    add_action('wp_ajax_delete_notifications', ['Notification_Manager', 'handle_delete_notifications']);
    add_action('wp_ajax_mark_as_read', ['Notification_Manager', 'handle_mark_as_read']);
}
add_action('init', 'register_notification_ajax_handler');

// function update_lead_status()
// {
//     if (!isset($_POST['lead_id'], $_POST['new_status'])) {
//         wp_send_json_error('Invalid data.');
//     }

//     $lead_id = intval($_POST['lead_id']);
//     $new_status = sanitize_text_field($_POST['new_status']);

//     if (update_post_meta($lead_id, 'lead_status', $new_status)) {
//         wp_send_json_success();
//     } else {
//         wp_send_json_error('Failed to update lead status.');
//     }
// }
// add_action('wp_ajax_update_lead_status', 'update_lead_status');

function update_lead_status()
{
    if (!isset($_POST['lead_id'], $_POST['new_status'])) {
        wp_send_json_error('Invalid data.');
    }

    $lead_id = intval($_POST['lead_id']);
    $new_status = sanitize_text_field($_POST['new_status']);

    // Adicionando logs para depuração
    error_log('Updating lead ID: ' . $lead_id . ' to status: ' . $new_status);

    if (update_post_meta($lead_id, 'lead_status', $new_status)) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Failed to update lead status.');
    }
}
add_action('wp_ajax_update_lead_status', 'update_lead_status');




/**
 * 
 * Os scripts a seguir são responsáveis por proteger a rota de login do painel
 */
// function wiser_hide_wp_login() {
//     // Adiciona a nova regra de reescrita
//     add_rewrite_rule('^wiser/?$', 'wp-login.php', 'top');
// }
// add_action('init', 'wiser_hide_wp_login');

// function wiser_block_wp_login() {
//     global $pagenow;

//     if ($pagenow == 'wp-login.php' && !isset($_GET['action']) && !isset($_POST['log'])) {
//         wp_safe_redirect(home_url('/404'));
//         exit();
//     }
// }
// add_action('init', 'wiser_block_wp_login');

// function wiser_custom_login_url($login_url, $redirect, $force_reauth) {
//     $login_url = home_url('/wiser/');
//     if (!empty($redirect)) {
//         $login_url = add_query_arg('redirect_to', urlencode($redirect), $login_url);
//     }
//     return $login_url;
// }
// add_filter('login_url', 'wiser_custom_login_url', 10, 3);

// function wiser_custom_login_page() {
//     global $pagenow;

//     if ($pagenow == 'wp-login.php' && isset($_SERVER['REQUEST_URI']) && strpos($SERVER['REQUESTURI'], 'wiser') === false) {
//         wpsaferedirect(home_url('/404'));
//         exit();
//     }
// }
// add_action('login_init', 'wiser_custom_login_page');

// function wiser_flush_rewrite_rules() {
//     wiser_hide_wp_login();
//     flush_rewrite_rules();
// }
// register_activation_hook(__FILE__, 'wiser_flush_rewrite_rules');
// register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

function clean_custom_cache()
{
    if (isset($_GET['limpar_cache']) && $_GET['limpar_cache'] == 'true') {
        global $user_info;

        Assinante_Data_Collector::clear_assinante_cache();
        // Performance_Data_Collector::clear_personal_transients($user_info->get_user_id());
        // Performance_Data_Collector::clear_team_transients($user_info->get_team_id());
        Performance_Data_Collector::clear_all_personal_transients();
        Performance_Data_Collector::clear_all_team_transients();
        Performance_Data_Collector::clear_global_transients();

        // Redirecionar
        wp_safe_redirect(home_url(), 302, 'DNA');
        exit;
    }
}

add_action('init', 'clean_custom_cache');


add_filter('wp_die_handler', 'meu_wp_die_handler');

function meu_wp_die_handler()
{
    return 'minha_funcao_wp_die';
}

function minha_funcao_wp_die($message, $title = '', $args = array())
{
    // Verifica se o erro é no contexto de administração ou front-end
    if (is_admin()) {
        // Se for no admin, você pode optar por não personalizar
        _default_wp_die_handler($message, $title, $args);
    } else {
        // Personalize a saída para o front-end
        $pick_view = new Pick_View();

        get_header();

        $pick_view->render('pages/error');

        get_footer();
        die();
    }
}


function custom_login_styles()
{
    echo '<style>
        body.login {
            background-color: #f4f4f4;
        }
        .login h1 a {
            background-image: url("' . Media_Helper::get_asset_url('images/logo-dna-care-light.png') . '") !important;
            background-size: contain !important;
            background-position: center !important;
            width: 100% !important;
        }

        .login form {
            border-radius: 8px;
        }

        .language-switcher, .wp-login-log-in {display: none; }

        .wp-core-ui .button-primary {
            background: #4b38b3 !important;
            border-color: #4b38b3 !important;
        }
        
        p.submit .button {width: 100%}

        .login .message, .login .notice, .login .success {
            border-left: 4px solid #4b38b3 !important;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'custom_login_styles', 999);
