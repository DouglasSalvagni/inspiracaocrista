<?php

/**
 * Class ASAAS_Config
 * 
 * This class handles the configuration page for ASAAS API.
 */
class ASAAS_Config extends Base_Page
{

    public function __construct()
    {
        parent::__construct();
        add_action('admin_menu', [$this, 'add_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add the ASAAS API configuration page to the admin menu.
     */
    public function add_menu_page()
    {
        add_menu_page(
            'Configuração da API do ASAAS',
            'ASAAS API',
            'manage_options',
            'asaas-api',
            [$this, 'render_options_page']
        );
    }

    /**
     * Render the ASAAS API configuration page.
     */
    public function render_options_page()
    {
?>
        <div class="wrap">
            <h1>Configuração da API do ASAAS</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('asaas_api_options');
                do_settings_sections('asaas-api');
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Register the settings for ASAAS API configuration.
     */
    public function register_settings()
    {
        register_setting('asaas_api_options', 'asaas_api_key');
        register_setting('asaas_api_options', 'asaas_subscription_price');
        register_setting('asaas_api_options', 'asaas_subscription_pj_price');
        register_setting('asaas_api_options', 'asaas_subscription_dependent_porcent_discount');
        register_setting('asaas_api_options', 'asaas_pf_subscription_annual_porcent_discount');
        register_setting('asaas_api_options', 'asaas_pj_max_subscription_monthly_porcent_discount');
        register_setting('asaas_api_options', 'asaas_commission_type');
        register_setting('asaas_api_options', 'asaas_commission_value');
        register_setting('asaas_api_options', 'asaas_environment');


        add_settings_section(
            'asaas_api_section',
            'Configurações da API do ASAAS',
            [$this, 'render_section_description'],
            'asaas-api'
        );

        add_settings_field(
            'asaas_api_key',
            'Chave da API do ASAAS',
            [$this, 'render_api_key_field'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_field(
            'asaas_subscription_price',
            'Preço da Assinatura',
            [$this, 'render_subscription_price_field'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_field(
            'asaas_subscription_pj_price',
            'Preço da Assinatura para Pessoa Jurídica',
            [$this, 'render_subscription_pj_price_field'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_field(
            'asaas_subscription_dependent_porcent_discount',
            'Desconto para o dependente (%)',
            [$this, 'render_subscription_dependent_porcent_discount'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_field(
            'asaas_pf_subscription_annual_porcent_discount',
            'Desconto anual para Pessoa Física (%)',
            [$this, 'render_pf_subscription_annual_porcent_discount'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_field(
            'asaas_pj_max_subscription_monthly_porcent_discount',
            'Máximo desconto mensal para Pessoa Jurídica (%)',
            [$this, 'render_pj_max_subscription_monthly_porcent_discount'],
            'asaas-api',
            'asaas_api_section'
        );

        add_settings_section(
            'asaas_commission_section',
            'Configurar comissionamento',
            [$this, 'render_commission_section_description'],
            'asaas-api'
        );

        add_settings_field(
            'asaas_commission_type',
            'Tipo de Comissão',
            [$this, 'render_commission_type_field'],
            'asaas-api',
            'asaas_commission_section'
        );

        add_settings_field(
            'asaas_commission_value',
            'Valor da Comissão',
            [$this, 'render_commission_value_field'],
            'asaas-api',
            'asaas_commission_section'
        );

        add_settings_field(
            'asaas_environment',
            'ASAAS Environment',
            [$this, 'render_environment_field'],
            'asaas-api',
            'asaas_api_section'
        );
    }

    /**
     * Render the description for the settings section.
     */
    public function render_section_description()
    {
        echo 'Insira sua chave da API do ASAAS e o preço das assinaturas abaixo:';
    }

    /**
     * Render the API key field.
     */
    public function render_api_key_field()
    {
        $api_key = get_option('asaas_api_key');
        echo '<input type="text" name="asaas_api_key" value="' . esc_attr($api_key) . '" />';
    }

    /**
     * Render the subscription price field.
     */
    public function render_subscription_price_field()
    {
        $price = get_option('asaas_subscription_price');
        echo '<input type="number" name="asaas_subscription_price" value="' . esc_attr($price) . '" step="0.01" />';
    }

    /**
     * Render the subscription price field.
     */
    public function render_subscription_pj_price_field()
    {
        $price = get_option('asaas_subscription_pj_price');
        echo '<input type="number" name="asaas_subscription_pj_price" value="' . esc_attr($price) . '" step="0.01" />';
    }

    /**
     * Render the subscription dependent porcent discont.
     */
    public function render_subscription_dependent_porcent_discount()
    {
        $porcent = get_option('asaas_subscription_dependent_porcent_discount');
        echo '<input type="number" name="asaas_subscription_dependent_porcent_discount" value="' . esc_attr($porcent) . '" step="0.01" />';
    }

    /**
     * Render the subscription dependent porcent discont.
     */
    public function render_pf_subscription_annual_porcent_discount()
    {
        $porcent = get_option('asaas_pf_subscription_annual_porcent_discount');
        echo '<input type="number" name="asaas_pf_subscription_annual_porcent_discount" value="' . esc_attr($porcent) . '" step="0.01" />';
    }

    /**
     * Render the subscription dependent porcent discont.
     */
    public function render_pj_max_subscription_monthly_porcent_discount()
    {
        $porcent = get_option('asaas_pj_max_subscription_monthly_porcent_discount');
        echo '<input type="number" name="asaas_pj_max_subscription_monthly_porcent_discount" value="' . esc_attr($porcent) . '" step="0.01" />';
    }

    /**
     * Render the description for the commission section.
     */
    public function render_commission_section_description()
    {
        echo 'Configure o tipo de comissão e o valor da comissão abaixo:';
    }

    /**
     * Render the commission type field.
     */
    public function render_commission_type_field()
    {
        $commission_type = get_option('asaas_commission_type');
    ?>
        <select name="asaas_commission_type">
            <option value="fixedValue" <?php selected($commission_type, 'fixedValue'); ?>>Valor Fixo</option>
            <option value="percentualValue" <?php selected($commission_type, 'percentualValue'); ?>>Porcentagem</option>
        </select>
    <?php
    }

    /**
     * Render the commission value field.
     */
    public function render_commission_value_field()
    {
        $commission_value = get_option('asaas_commission_value');
        echo '<input type="number" name="asaas_commission_value" value="' . esc_attr($commission_value) . '" step="0.01" />';
    }

    public function render_environment_field()
    {
        $environment = get_option('asaas_environment', 'sandbox'); // 'sandbox' como padrão
    ?>
        <select name="asaas_environment">
            <option value="production" <?php selected($environment, 'production'); ?>>Produção</option>
            <option value="sandbox" <?php selected($environment, 'sandbox'); ?>>Teste</option>
        </select>
<?php
    }
}

new ASAAS_Config();
