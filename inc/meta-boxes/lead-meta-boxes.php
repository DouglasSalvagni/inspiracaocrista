<?php
function lead_meta_box_add()
{
    add_meta_box('lead_user_meta', 'Atribuir Lead a Usuário', 'lead_user_meta_box_callback', 'leads', 'side', 'high');
    add_meta_box('lead_extra_meta', 'Informações Adicionais do Lead', 'lead_extra_meta_box_callback', 'leads', 'normal', 'high');
}
add_action('add_meta_boxes', 'lead_meta_box_add');

function lead_user_meta_box_callback($post)
{
    wp_nonce_field('lead_user_meta_box', 'lead_user_meta_box_nonce');
    $assigned_user = get_post_meta($post->ID, 'lead_assigned_to', true);
    $originURL = get_post_meta($post->ID, 'originURL', true);

    $users = get_users(['role__in' => ['administrator', 'comercial', 'gerente_comercial']]);
    ?>
    <label for="lead_assigned_to">Atribuído a:</label>
    <select id="lead_assigned_to" name="lead_assigned_to" style="width: 100%;">
        <option value="">Selecione um usuário</option>
        <?php foreach ($users as $user): ?>
            <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($assigned_user, $user->ID); ?>>
                <?php echo esc_html($user->display_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="originURL">URL de Origem:</label>
    <input type="text" id="originURL" name="originURL" value="<?php echo esc_attr($originURL); ?>" />
    <?php
}

function lead_extra_meta_box_callback($post)
{
    wp_nonce_field('lead_extra_meta_box', 'lead_extra_meta_box_nonce');
    $fields = [
        'lead_name' => 'Nome',
        'lead_phone' => 'Celular',
        'lead_phone_2' => 'Telefone',
        'lead_email' => 'Email',
        'lead_cpf_cnpj' => 'CPF',
        'lead_date_birth' => 'Data de Nascimento',
        'lead_company' => 'Empresa',
        'lead_position' => 'Cargo',
        'lead_source' => 'Origem',
        'lead_status' => 'Status',
        'deal_value' => 'Valor da Oportunidade',
        'deal_stage' => 'Fase da Oportunidade',
        'expected_close_date' => 'Data de Fechamento Esperada',
        'last_contacted_date' => 'Último Contato',
        'contact_method' => 'Método de Contato',
        'next_action_date' => 'Próxima Ação',
        'next_action_description' => 'Descrição da Próxima Ação',
        'lead_notes' => 'Notas',
        'lead_priority' => 'Prioridade',
        'lead_type' => 'Tipo'
    ];

    foreach ($fields as $field_key => $field_label) {
        $field_value = get_post_meta($post->ID, $field_key, true);
        ?>
        <label for="<?php echo $field_key; ?>"><?php echo $field_label; ?>:</label>
        <input type="text" id="<?php echo $field_key; ?>" name="<?php echo $field_key; ?>"
            value="<?php echo esc_attr($field_value); ?>" style="width: 100%;" />
        <br><br>
        <?php
    }
}

function save_lead_user_meta_box($post_id)
{
    if (!isset($_POST['lead_user_meta_box_nonce']) || !wp_verify_nonce($_POST['lead_user_meta_box_nonce'], 'lead_user_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['lead_assigned_to'])) {
        update_post_meta($post_id, 'lead_assigned_to', sanitize_text_field($_POST['lead_assigned_to']));
    }

    if (isset($_POST['originURL'])) {
        update_post_meta($post_id, 'originURL', sanitize_text_field($_POST['originURL']));
    }
}

function save_lead_extra_meta_box($post_id)
{
    if (!isset($_POST['lead_extra_meta_box_nonce']) || !wp_verify_nonce($_POST['lead_extra_meta_box_nonce'], 'lead_extra_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'lead_name',
        'lead_phone',
        'lead_phone_2',
        'lead_email',
        'lead_cpf_cnpj',
        'lead_date_birth',
        'lead_company',
        'lead_position',
        'lead_source',
        'lead_status',
        'deal_value',
        'deal_stage',
        'expected_close_date',
        'last_contacted_date',
        'contact_method',
        'next_action_date',
        'next_action_description',
        'lead_notes',
        'lead_priority',
        'lead_type'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_lead_user_meta_box');
add_action('save_post', 'save_lead_extra_meta_box');


function enqueue_admin_scripts($hook)
{
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ('leads' === get_post_type()) {
            wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], null, true);
            wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
            wp_enqueue_script('lead-admin', get_template_directory_uri() . '/assets/js/admin.js', ['jquery', 'select2'], null, true);
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');


add_filter('rwmb_meta_boxes', 'register_conversas_meta_boxes');
function register_conversas_meta_boxes($meta_boxes)
{
    $meta_boxes[] = array(
        'id' => 'conversas_metabox',
        'title' => __('Detalhes da Conversa', 'textdomain'),
        'post_types' => array('leads'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            [
                'type' => 'single_image',
                'name' => 'Lead Foto',
                'id' => 'lead_image',
            ],
            array(
                'name' => __('Thread', 'textdomain'),
                'id' => 'thread',
                'type' => 'text',
            ),
            array(
                'type' => 'group',
                'id' => 'group',
                'name' => __('Group', 'textdomain'),
                'fields' => array(
                    array(
                        'name' => __('Sender', 'textdomain'),
                        'id' => 'sender',
                        'type' => 'text',
                    ),
                    array(
                        'name' => __('Message', 'textdomain'),
                        'id' => 'message',
                        'type' => 'text',
                    ),
                    [
                        'name' => 'Data/Hora',
                        'id' => 'date',
                        'type' => 'datetime',
                        'js_options' => [
                            'stepMinute' => 1,
                            'showTimepicker' => true,
                            'controlType' => 'select',
                            'showButtonPanel' => false,
                            'oneLine' => true,
                        ],
                        'inline' => false,
                        'timestamp' => false,
                    ],
                    [
                        'name' => 'Checkbox',
                        'id' => 'read',
                        'type' => 'checkbox',
                        'std' => 1, // 0 or 1
                    ],
                ),
                'clone' => true, // Permitir clonar o grupo
                'sort_clone' => true, // Permitir ordenar os clones
            ),
        ),
    );
    return $meta_boxes;
}
?>