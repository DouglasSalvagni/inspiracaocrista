<?php
/**
 * Template name: Logout
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

// Função para deslogar o usuário e redirecioná-lo para a página de login
function logout_and_redirect() {
    // Redireciona para a página de login após o logout
    $redirect_url = home_url('/login');

    // Executa o logout do usuário
    wp_logout();

    // Redireciona de forma segura para a URL especificada
    wp_safe_redirect($redirect_url);
    exit;
}

// Executa a função de logout e redirecionamento
logout_and_redirect();
?>
