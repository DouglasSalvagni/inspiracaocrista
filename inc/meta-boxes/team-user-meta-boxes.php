<?php
// Adiciona o campo de seleção de time na página de edição de perfil do usuário
function add_team_field_to_user_profile($user) {
    // Verifica se o usuário atual tem permissão para editar usuários
    if (!current_user_can('edit_users')) {
        return;
    }

    // Obtém o team_id atual do usuário
    $team_id = get_user_meta($user->ID, 'team_id', true);

    // Obtém todos os times (posts do tipo 'team')
    $args = array(
        'post_type' => 'team',
        'numberposts' => -1,
        'post_status' => 'publish',
    );
    $teams = get_posts($args);

    ?>
    <h3><?php _e('Informações do Time'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="team_id">Time</label></th>
            <td>
                <select name="team_id" id="team_id">
                    <option value=""><?php _e('Nenhum Time'); ?></option>
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?php echo esc_attr($team->ID); ?>" <?php selected($team_id, $team->ID); ?>>
                            <?php echo esc_html($team->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br/>
                <span class="description"><?php _e('Selecione o time ao qual este usuário pertence.'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_team_field_to_user_profile');
add_action('edit_user_profile', 'add_team_field_to_user_profile');

// Salva o team_id quando o perfil do usuário é atualizado
function save_team_field_from_user_profile($user_id) {
    // Verifica se o usuário atual tem permissão para editar este usuário
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Atualiza o metadado do usuário com o team_id selecionado
    if (isset($_POST['team_id'])) {
        $team_id = sanitize_text_field($_POST['team_id']);

        // Atualiza o team_id no metadado do usuário
        update_user_meta($user_id, 'team_id', $team_id);

        // Atualiza os leads atribuídos ao usuário
        update_leads_team_id_when_user_team_changes($user_id, $team_id);
    }
}
add_action('personal_options_update', 'save_team_field_from_user_profile');
add_action('edit_user_profile_update', 'save_team_field_from_user_profile');

function update_leads_team_id_when_user_team_changes($user_id, $team_id) {
    // Obter todos os leads atribuídos ao usuário
    $args = array(
        'post_type' => 'lead',
        'meta_key' => 'assigned_user_id',
        'meta_value' => $user_id,
        'posts_per_page' => -1,
    );
    $leads = get_posts($args);

    // Atualizar o assigned_team_id em cada lead
    foreach ($leads as $lead) {
        if ($team_id) {
            update_post_meta($lead->ID, 'assigned_team_id', $team_id);
        } else {
            delete_post_meta($lead->ID, 'assigned_team_id');
        }
    }
}

?>
