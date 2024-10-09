<?php

/**
 * Template name: Import DB
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$Import_Leads = new Import_Leads();

get_header('dashboard');

$Import_Leads->render();

get_footer('dashboard');
