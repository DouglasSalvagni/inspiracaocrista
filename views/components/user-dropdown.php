<div class="dropdown ms-sm-3 header-item topbar-user">
    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="d-flex align-items-center profile-user ">
            <img class="rounded-circle header-profile-user user-profile-image" src="<?php echo esc_url($avatar_url); ?>" alt="Header Avatar">
            <span class="text-start ms-xl-2">
                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $first_name ?></span>
                <!-- <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Founder</span> -->
            </span>
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        <h6 class="dropdown-header">Bem vindo!</h6>

        <?php if (current_user_can('administrator')) : ?>
            <?= Menu_Helper::user_dropdown_menu_link('', 'bx bxl-wordpress', 'Painel', esc_url(admin_url())) ?>
        <?php endif; ?>

        <?= Menu_Helper::user_dropdown_menu_link('perfil', 'mdi mdi-account-circle') ?>
        <?= Menu_Helper::user_dropdown_menu_link('meus-leads', 'mdi mdi-chart-timeline') ?>

        <div class="dropdown-divider"></div>

        <?php if (false) : ?>
            <!-- condição temporária para OCULTAR os items internos -->

            <a class="dropdown-item"><i class="ri-hand-coin-line text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Acumulado : <b>R$ <?php echo esc_html(number_format(floatval($cumulative_commission), 2, ',', '.')); ?></b></span></a>
            <a class="dropdown-item"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Pago : <b>R$ <?php echo esc_html(number_format(floatval($monthly_paid_commission), 2, ',', '.')); ?></b></span></a>
            
        <?php endif; ?>

        <?= Menu_Helper::user_dropdown_menu_link('logout', 'mdi mdi-logout', 'Sair') ?>
    </div>
</div>