<?php
/**
 * Template name: Sales Archive
 *
 * @package CRM
 * @since 1.0
 */

// Cria uma instância da classe Sales
$sales_page = new Sales_Archive();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$sales_page->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
?>
