<?php
function my_custom_settings_page()
{
    add_menu_page(
        'Configurações Globais',
        'Configurações',
        'manage_options',
        'custom-settings',
        'my_custom_settings_page_html',
        'dashicons-admin-generic',
        1
    );
}
add_action('admin_menu', 'my_custom_settings_page');
function my_custom_settings_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('custom_options_group');
            do_settings_sections('custom-settings');
            submit_button('Salvar Configurações');
            ?>
        </form>
        <!-- Seção de Teste SMTP -->
        <hr>
        <h2>Teste SMTP</h2>
        <p>Clique no botão abaixo para enviar um e-mail de teste e verificar as configurações SMTP:</p>
        <button id="test-smtp" class="button">Testar SMTP</button>
    </div>
    <?php
}
function my_custom_settings_registration()
{
    add_settings_section(
        'custom_section',
        '',
        '',
        'custom-settings'
    );
    // Campo: Logotipo
    register_setting('custom_options_group', 'custom_logo', 'sanitize_text_field');
    add_settings_field(
        'custom_logo',
        'Logotipo',
        'custom_logo_callback',
        'custom-settings',
        'custom_section'
    );
    // Campo: Telefone
    register_setting('custom_options_group', 'custom_telefone', 'sanitize_text_field');
    add_settings_field(
        'custom_telefone',
        'Telefone',
        'custom_telefone_callback',
        'custom-settings',
        'custom_section'
    );
    // Campo: Whatsapp
    register_setting('custom_options_group', 'custom_whatsapp', 'sanitize_text_field');
    add_settings_field(
        'custom_whatsapp',
        'Whatsapp',
        'custom_whatsapp_callback',
        'custom-settings',
        'custom_section'
    );
    // Campo: Ativar Logo no canto inferior esquerdo
    register_setting('custom_options_group', 'activate_logo_checkbox', 'sanitize_text_field');
    add_settings_field(
        'activate_logo_checkbox',             // ID do campo
        'Botão do Whats',                        // Título do campo
        'activate_logo_callback',             // Callback
        'custom-settings',                    // Página
        'custom_section'                      // Seção
    );
    // Campo: Email
    register_setting('custom_options_group', 'custom_email', 'sanitize_text_field');
    add_settings_field(
        'custom_email',
        'Email',
        'custom_email_callback',
        'custom-settings',
        'custom_section'
    );
    // Campo: Endereço
    register_setting('custom_options_group', 'custom_endereco', 'sanitize_text_field');
    add_settings_field(
        'custom_endereco',
        'Endereço',
        'custom_endereco_callback',
        'custom-settings',
        'custom_section'
    );
    // Seção SMTP
    add_settings_section(
        'smtp_section',
        'Configurações SMTP',
        '',
        'custom-settings'
    );
    // Campo: SMTP Host
    register_setting('custom_options_group', 'smtp_host', 'sanitize_text_field');
    add_settings_field(
        'smtp_host',
        'SMTP Host',
        'smtp_host_callback',
        'custom-settings',
        'smtp_section'
    );
    // Campo: SMTP Port
    register_setting('custom_options_group', 'smtp_port', 'sanitize_text_field');
    add_settings_field(
        'smtp_port',
        'SMTP Port',
        'smtp_port_callback',
        'custom-settings',
        'smtp_section'
    );
    // Campo: SMTP Username
    register_setting('custom_options_group', 'smtp_username', 'sanitize_text_field');
    add_settings_field(
        'smtp_username',
        'SMTP Username',
        'smtp_username_callback',
        'custom-settings',
        'smtp_section'
    );
    // Campo: SMTP Password
    register_setting('custom_options_group', 'smtp_password', 'sanitize_text_field');
    add_settings_field(
        'smtp_password',
        'SMTP Password',
        'smtp_password_callback',
        'custom-settings',
        'smtp_section'
    );
    // Campo: SMTP Secure (TLS/SSL/None)
    register_setting('custom_options_group', 'smtp_secure', 'sanitize_text_field');
    add_settings_field(
        'smtp_secure',
        'SMTP Secure',
        'smtp_secure_callback',
        'custom-settings',
        'smtp_section'
    );
}
add_action('admin_init', 'my_custom_settings_registration');
function custom_logo_callback()
{
    $custom_logo = get_option('custom_logo');
    echo '<input type="hidden" name="custom_logo" id="custom_logo_url" value="' . esc_attr($custom_logo) . '">';
    echo '<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Escolher Imagem">';
    if ($custom_logo) {
        echo '<img id="custom_logo_preview" src="' . esc_attr($custom_logo) . '" style="max-width: 200px; display:block; margin-top:10px;" />';
    } else {
        echo '<img id="custom_logo_preview" style="max-width: 200px; display:none; margin-top:10px;" />';
    }
}
function custom_telefone_callback()
{
    $custom_telefone = get_option('custom_telefone');
    echo '<input type="text" name="custom_telefone" value="' . esc_attr($custom_telefone) . '" class="regular-text">';
}
function custom_whatsapp_callback()
{
    $custom_whatsapp = get_option('custom_whatsapp');
    echo '<input type="text" name="custom_whatsapp" value="' . esc_attr($custom_whatsapp) . '" class="regular-text">';
}
function activate_logo_callback()
{
    $checkbox_value = get_option('activate_logo_checkbox');
    echo '<input type="checkbox" name="activate_logo_checkbox" value="1"' . checked(1, $checkbox_value, false) . ' /> Ativar botão no canto inferior esquerdo';
}
function custom_email_callback()
{
    $custom_email = get_option('custom_email');
    echo '<input type="text" name="custom_email" value="' . esc_attr($custom_email) . '" class="regular-text">';
}
function custom_endereco_callback()
{
    $custom_endereco = get_option('custom_endereco');
    echo '<input type="text" name="custom_endereco" value="' . esc_attr($custom_endereco) . '" class="regular-text">';
}
// Callbacks
function smtp_host_callback()
{
    $smtp_host = get_option('smtp_host');
    echo '<input type="text" name="smtp_host" value="' . esc_attr($smtp_host) . '" class="regular-text">';
}
function smtp_port_callback()
{
    $smtp_port = get_option('smtp_port');
    echo '<input type="text" name="smtp_port" value="' . esc_attr($smtp_port) . '" class="regular-text">';
}
function smtp_username_callback()
{
    $smtp_username = get_option('smtp_username');
    echo '<input type="text" name="smtp_username" value="' . esc_attr($smtp_username) . '" class="regular-text">';
}
function smtp_password_callback()
{
    $smtp_password = get_option('smtp_password');
    echo '<input type="password" name="smtp_password" value="' . esc_attr($smtp_password) . '" class="regular-text">';
}
function smtp_secure_callback()
{
    $smtp_secure = get_option('smtp_secure');
    echo '<select name="smtp_secure">
            <option value="none" ' . selected($smtp_secure, 'none', false) . '>None</option>
            <option value="ssl" ' . selected($smtp_secure, 'ssl', false) . '>SSL</option>
            <option value="tls" ' . selected($smtp_secure, 'tls', false) . '>TLS</option>
          </select>';
}
// Logotipo
function custom_admin_js()
{
    $screen = get_current_screen();
    // Verifica se estamos na página 'custom-settings'
    if ($screen->base == 'toplevel_page_custom-settings') {
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                $("#upload-btn").click(function(e) {
                    e.preventDefault();
                    var image = wp.media({ 
                        title: "Upload Image",
                        multiple: false
                    }).open()
                    .on("select", function(e) {
                        var uploaded_image = image.state().get("selection").first();
                        var image_url = uploaded_image.toJSON().url;
                        $("#custom_logo_url").val(image_url);
                        $("#custom_logo_preview").attr("src", image_url).show();
                    });
                });
            });
        </script>';
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                $("#test-smtp").click(function(e) {
                    e.preventDefault();
                    $.post(ajaxurl, {action: "test_smtp"}, function(response) {
                        alert(response.data);
                    });
                });
            });
        </script>';
    }
}
add_action('admin_footer', 'custom_admin_js');
function load_wp_media_files() {
    // Verifica se estamos na página 'custom-settings'
    $screen = get_current_screen();
    if ($screen->base == 'toplevel_page_custom-settings') {
        // Enfileira o WordPress Media Uploader
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'load_wp_media_files');
// Logotipo
// Whatsapp Logo
add_action('wp_footer', 'render_whatsapp_balloon');
function render_whatsapp_balloon() {
    if (get_option('activate_logo_checkbox')) { ?>
        <div id="whatsapp-balloon" style="width: 60px;height:60px;position:fixed;bottom:30px;right: 30px;z-index: 9999;">
            <a href="https://wa.me/55<?php echo get_option('custom_whatsapp') ?>?text=Ol%C3%A1%2C+tudo+bem%3F" target="_blank">
                <img src="<?php echo get_media_src('wpp-icon.png'); ?>" alt="WhatsApp">
            </a>
        </div>
        <?php
    }
}
// Whatsapp Logo
