<?php

class User_Profile_Edit extends Base_Page
{
    private $active_tab;

    public function __construct()
    {
        parent::__construct();
        
        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));

        $this->add_script('jquery-mask', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true);
        $this->add_script('masks', get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true);
        $this->add_script('choices', get_template_directory_uri() . '/assets/libs/choices.js/public/assets/scripts/choices.min.js', [], false, true);

        $this->active_tab = 'personalDetails'; // Aba padrão

        $this->handle_form_submission();
    }

    private function handle_form_submission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['edit_profile_nonce']) && wp_verify_nonce($_POST['edit_profile_nonce'], 'edit_profile')) {
                $current_user = wp_get_current_user();

                // Identifica qual formulário foi submetido
                if (isset($_POST['submit_profile_details'])) {
                    $this->update_profile_details($current_user);
                } elseif (isset($_POST['submit_profile_image'])) {
                    $this->handle_profile_image_upload($current_user->ID);
                } elseif (isset($_POST['delete_profile_image'])) {
                    $this->delete_profile_image($current_user->ID);
                }

                // Adiciona alerta de sucesso e redireciona após a atualização
                Alert_Helper::add_alert('Perfil atualizado com sucesso!', 'success');
                wp_redirect(add_query_arg(['updated' => 'true'], get_permalink()));
                exit;
            }

            if (isset($_POST['change_password_nonce']) && wp_verify_nonce($_POST['change_password_nonce'], 'change_password')) {
                $this->change_password();
            }
        }
    }

    private function update_profile_details($current_user)
    {
        // Atualiza os dados do usuário no banco de dados
        if (isset($_POST['first_name'])) {
            update_user_meta($current_user->ID, 'first_name', sanitize_text_field($_POST['first_name']));
        }
        if (isset($_POST['last_name'])) {
            update_user_meta($current_user->ID, 'last_name', sanitize_text_field($_POST['last_name']));
        }
        if (isset($_POST['phone_number'])) {
            update_user_meta($current_user->ID, 'phone_number', sanitize_text_field($_POST['phone_number']));
        }
        if (isset($_POST['wallet_id'])) {
            update_user_meta($current_user->ID, 'wallet_id', sanitize_text_field($_POST['wallet_id']));
        }
    }

    private function handle_profile_image_upload($user_id)
    {
        require_once(ABSPATH . 'wp-admin/includes/file.php');  // Incluir funções para upload de arquivos
        require_once(ABSPATH . 'wp-admin/includes/image.php');  // Incluir funções para manipulação de imagens
        require_once(ABSPATH . 'wp-admin/includes/media.php');  // Incluir funções para mídia

        if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) { // 2MB limit
            Alert_Helper::add_alert('A imagem deve ter no máximo 2MB.', 'danger');
            return;
        }

        $upload = wp_handle_upload($_FILES['profile_image'], ['test_form' => false]);

        if (isset($upload['error']) && $upload['error'] != 0) {
            Alert_Helper::add_alert('Houve um erro ao fazer o upload da imagem.', 'danger');
            return;
        }

        $filetype = wp_check_filetype($upload['file']);
        $allowed_types = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];

        if (!in_array($filetype['type'], $allowed_types)) {
            Alert_Helper::add_alert('Apenas arquivos JPG, JPEG, GIF e PNG são permitidos.', 'danger');
            return;
        }

        $attachment = [
            'guid' => $upload['url'],
            'post_mime_type' => $upload['type'],
            'post_title' => sanitize_file_name($upload['file']),
            'post_content' => '',
            'post_status' => 'inherit'
        ];

        $attach_id = wp_insert_attachment($attachment, $upload['file']);
        $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);

        update_user_meta($user_id, 'profile_image', $attach_id);
    }

    private function delete_profile_image($user_id)
    {
        $attachment_id = get_user_meta($user_id, 'profile_image', true);
        if ($attachment_id) {
            wp_delete_attachment($attachment_id, true);
            delete_user_meta($user_id, 'profile_image');
        }
    }

    private function change_password()
    {
        $current_user = wp_get_current_user();
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $this->active_tab = 'changePassword'; // Define a aba de mudança de senha como ativa

        if (wp_check_password($old_password, $current_user->user_pass, $current_user->ID)) {
            if ($new_password === $confirm_password) {
                $password_errors = $this->validate_password_strength($new_password);
                if (empty($password_errors)) {
                    wp_set_password($new_password, $current_user->ID);

                    // Mantém a sessão ativa após a mudança de senha
                    wp_set_current_user($current_user->ID, true);
                    wp_set_auth_cookie($current_user->ID, true);

                    Alert_Helper::add_alert('Senha alterada com sucesso!', 'success');
                    wp_redirect(add_query_arg(['password_updated' => 'true'], get_permalink()));
                    exit;
                } else {
                    // Handle password strength errors
                    foreach ($password_errors as $error) {
                        Alert_Helper::add_alert($error, 'danger');
                    }
                }
            } else {
                Alert_Helper::add_alert('As novas senhas não coincidem.', 'danger');
            }
        } else {
            Alert_Helper::add_alert('A senha atual está incorreta.', 'danger');
        }
    }

    private function validate_password_strength($password)
    {
        $errors = [];
        $min_length = 8;
        $has_uppercase = preg_match('/[A-Z]/', $password);
        $has_lowercase = preg_match('/[a-z]/', $password);
        $has_number = preg_match('/[0-9]/', $password);
        $has_special_char = preg_match('/[\W]/', $password); // Non-word characters

        if (strlen($password) < $min_length) {
            $errors[] = 'A senha deve ter pelo menos ' . $min_length . ' caracteres.';
        }
        if (!$has_uppercase) {
            $errors[] = 'A senha deve conter pelo menos uma letra maiúscula.';
        }
        if (!$has_lowercase) {
            $errors[] = 'A senha deve conter pelo menos uma letra minúscula.';
        }
        if (!$has_number) {
            $errors[] = 'A senha deve conter pelo menos um número.';
        }
        if (!$has_special_char) {
            $errors[] = 'A senha deve conter pelo menos um caractere especial.';
        }

        return $errors;
    }

    public function render()
    {
        $current_user = wp_get_current_user();
        $profile_image_id = get_user_meta($current_user->ID, 'profile_image', true);
        $avatar_url = $profile_image_id ? wp_get_attachment_url($profile_image_id) : get_avatar_url($current_user->ID);

        // Carrega os dados do usuário
        $user_data = [
            'first_name' => get_user_meta($current_user->ID, 'first_name', true),
            'last_name' => get_user_meta($current_user->ID, 'last_name', true),
            'phone_number' => get_user_meta($current_user->ID, 'phone_number', true),
            'email' => $current_user->user_email,
            'wallet_id' => get_user_meta($current_user->ID, 'wallet_id', true),
            'profile_image' => get_user_meta($current_user->ID, 'profile_image', true),
        ];

        // Passar variáveis para a view
        $vars = [
            'user_data' => $user_data,
            'active_tab' => $this->active_tab,
            'avatar_url' => $avatar_url,
            'profile_image_id' => $profile_image_id,
            'current_user' => $current_user,
        ];

        // Renderizar a view específica
        $this->render_view('pages/user-profile-edit', $vars);
    }
}

