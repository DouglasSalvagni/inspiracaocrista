<?php
/**
 * Template name: Assinantes Edit
 *
 * @package CRM
 * @since 1.0
 */


// Cria uma instância da classe Assinantes
$edit_assinante = new Edit_assinante();

get_header('dashboard'); // Inclui o cabeçalho específico do dashboard

$edit_assinante->render(); // Renderiza a página

get_footer('dashboard'); // Inclui o rodapé específico do dashboard
