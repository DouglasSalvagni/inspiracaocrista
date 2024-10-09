<!-- ========== App Menu aqui ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?= site_url() ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo Media_Helper::get_asset_url('images/logo-dna-care-light.png') ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo Media_Helper::get_asset_url('images/logo-dna-care-light.png') ?>" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?= site_url() ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo Media_Helper::get_asset_url('images/logo-dna-care-light.png') ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo Media_Helper::get_asset_url('images/logo-dna-care-light.png') ?>" alt="" height="57">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <?php echo Menu_Helper::generate_menu_link('dashboard', 'bx bxs-dashboard'); ?>
                <?php echo Menu_Helper::generate_menu_link('leads', 'mdi mdi-account-group', false, false, ['administrator','diretoria', 'comercial']); ?>
                <?php echo Menu_Helper::generate_menu_link('gerente-leads', 'mdi mdi-account-lock-open-outline', 'Leads', false, ['administrator','diretoria', 'gerente_comercial']); ?>
                <?php echo Menu_Helper::generate_menu_link('assinantes', 'mdi mdi-account-search'); ?>
                <?php echo Menu_Helper::generate_menu_link('perfil', 'mdi mdi-account-circle', false, false); ?>
                <?php echo Menu_Helper::generate_menu_link('usuarios', 'mdi mdi-account-group-outline', 'Colaboradores', false, ['administrator','diretoria']); ?>
                <?php echo Menu_Helper::generate_menu_link('perfil', 'mdi mdi-cached', 'Limpar cache', home_url('/?limpar_cache=true'), ['administrator']); ?>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>