<?php
/**
 * Template name: Assinantes Archive
 *
 * @package CRM
 * @since 1.0
 */


// Cria uma instância da classe Assinantes
$assinantes_page = new Assinantes_Archive();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$assinantes_page->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
