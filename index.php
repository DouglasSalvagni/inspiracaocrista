<?php

/**
 *
 * @author Wiser
 * @package CRM
 * @since 1.0
 */

$pick_view = new Pick_View();

get_header();

$pick_view->render('pages/maintenance');

get_footer();