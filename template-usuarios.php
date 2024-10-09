<?php
/**
 * Template name: Lista de Usuários
 *
 * @package CRM
 * @since 1.0
 */

// Cria uma instância da classe Usuarios_Page
$usuarios_page = new Usuarios_Page();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$usuarios_page->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
