<?php

/**
 * Template name: Leads Chat
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$Leads_Chat = new Leads_Chat();

get_header('dashboard');

$Leads_Chat->render();

get_footer('dashboard');
