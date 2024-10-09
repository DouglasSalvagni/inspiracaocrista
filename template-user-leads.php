<?php

/**
 * Template name: User Leads
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$user_leads = new User_Leads(NULL);

get_header('dashboard');

$user_leads->render();

get_footer('dashboard');
