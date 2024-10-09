<?php
/**
 * Template name: Editar Usuário
 *
 * @package CRM
 * @since 1.0
 */

// Cria uma instância da classe User_Edit_Page
$user_edit_page = new User_Edit_Page();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$user_edit_page->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
