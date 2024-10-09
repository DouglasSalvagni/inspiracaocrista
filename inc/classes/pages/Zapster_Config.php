<?php
/**
 * Class Zapster_API_Config
 * 
 * This class handles the configuration page for Zapster API.
 */
class Zapster_API_Config extends Base_Page {
    
    public function __construct() {
        parent::__construct();
        add_action('admin_menu', [$this, 'add_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add the Zapster API configuration page to the admin menu.
     */
    public function add_menu_page() {
        add_menu_page(
            'Configuração de APIs',
            'Zapster API',
            'manage_options',
            'zapster-api',
            [$this, 'render_options_page']
        );
    }

    /**
     * Render the Zapster API configuration page.
     */
    public function render_options_page() {
        ?>
        <div class="wrap">
            <h1>Configuração da API do Zapster</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('zapster_api_options');
                do_settings_sections('zapster-api');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register the settings for Zapster API configuration.
     */
    public function register_settings() {
        register_setting('zapster_api_options', 'zapster_api_key');
        register_setting('zapster_api_options', 'zapster_instance_id');
        register_setting('zapster_api_options', 'zapster_webhook_01');
        register_setting('zapster_api_options', 'zapster_webhook_02');

        add_settings_section(
            'zapster_api_section',
            'Configurações da API do Zapster',
            [$this, 'render_section_description'],
            'zapster-api'
        );

        add_settings_field(
            'zapster_api_key',
            'Chave da API do Zapster',
            [$this, 'render_api_key_field'],
            'zapster-api',
            'zapster_api_section'
        );

        add_settings_field(
            'zapster_instance_id',
            'ID da Instância',
            [$this, 'render_instance_id_field'],
            'zapster-api',
            'zapster_api_section'
        );

        add_settings_field(
            'zapster_webhook_01',
            'Webhook 01',
            [$this, 'render_webhook_01_field'],
            'zapster-api',
            'zapster_api_section'
        );

        add_settings_field(
            'zapster_webhook_02',
            'Webhook 02',
            [$this, 'render_webhook_02_field'],
            'zapster-api',
            'zapster_api_section'
        );
    }

    /**
     * Render the description for the settings section.
     */
    public function render_section_description() {
        echo 'Insira sua chave da API do Zapster, o ID da instância e os webhooks abaixo:';
    }

    /**
     * Render the API key field.
     */
    public function render_api_key_field() {
        $api_key = get_option('zapster_api_key');
        echo '<input type="text" name="zapster_api_key" value="' . esc_attr($api_key) . '" />';
    }

    /**
     * Render the instance ID field.
     */
    public function render_instance_id_field() {
        $instance_id = get_option('zapster_instance_id');
        echo '<input type="text" name="zapster_instance_id" value="' . esc_attr($instance_id) . '" />';
    }

    /**
     * Render the Webhook 01 field.
     */
    public function render_webhook_01_field() {
        $webhook_01 = get_option('zapster_webhook_01');
        echo '<input type="text" name="zapster_webhook_01" value="' . esc_attr($webhook_01) . '" />';
    }

    /**
     * Render the Webhook 02 field.
     */
    public function render_webhook_02_field() {
        $webhook_02 = get_option('zapster_webhook_02');
        echo '<input type="text" name="zapster_webhook_02" value="' . esc_attr($webhook_02) . '" />';
    }
}

new Zapster_API_Config();
