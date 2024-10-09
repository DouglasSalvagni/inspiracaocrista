<?php

/**
 * Template name: Index
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$example_page = new Index();

get_header('dashboard');

$example_page->render();

get_footer('dashboard');
