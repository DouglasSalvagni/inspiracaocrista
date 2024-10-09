<?php

/**
 * Template name: Gerente Leads
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

// Obtém o ID do usuário da URL, se disponível
// $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

global $user_info;

$scope = 'team';
if ($user_info->user_has_role(['administrator', 'diretoria'])) {
    $scope = 'global';
}

$user_leads = new User_Leads(null, '', $scope, true);

$user_leads->apply_page_privacy(['gerente_comercial','administrator', 'diretoria']);

get_header('dashboard');

$user_leads->render();

get_footer('dashboard');
