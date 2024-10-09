<?php

/**
 * Template name: Checkout
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$edit_lead = new ASAAS_Checkout_Page(true);

get_header();

$edit_lead->render();

get_footer();
