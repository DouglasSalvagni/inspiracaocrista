<!DOCTYPE html>
<html <?php language_attributes(); ?> data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <title><?php wp_title('/', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>

<body id="html-body" <?php body_class(); ?>>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once get_template_directory() . '/views/base/header.php'; ?>
        <?php include_once get_template_directory() . '/views/base/navbar.php'; ?>

        <main class="main-content">
            <div class="page-content">
                <div id="content" class="container-fluid">
                    <?php do_action('debud-printer') ?>