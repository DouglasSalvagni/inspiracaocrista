<?php
/**
 * Template name: Criar Usuário
 *
 * @package CRM
 * @since 1.0
 */

// Cria uma instância da classe Usuario_Create_Page
$usuario_create_page = new Usuario_Create_Page();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$usuario_create_page->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
