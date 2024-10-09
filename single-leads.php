<?php

/**
 * Template name: Edit Lead
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$edit_lead = new Edit_lead(get_the_ID());

get_header('dashboard');

$edit_lead->render();

get_footer('dashboard');
