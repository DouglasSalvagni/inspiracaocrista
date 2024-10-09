<?php

/**
 * View for rendering notifications.
 * 
 * @var array $notifications List of notifications.
 * @var int $unread_count Count of unread notifications.
 */
?>

<div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
        <i class='bx bx-bell fs-22'></i>
        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger js-unread-number"><?php echo esc_html($unread_count); ?><span class="visually-hidden">unread messages</span></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

        <div class="dropdown-head bg-primary bg-pattern rounded-top">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notificações </h6>
                    </div>
                    <div class="col-auto dropdown-tabs">
                        <span class="badge bg-light-subtle text-body fs-13"> <span class="js-unread-number"><?php echo esc_html($unread_count); ?></span> Novas</span>
                    </div>
                </div>
            </div>

            <div class="px-2 pt-2">
                <!-- <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist"> -->
                <!-- <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                            All (4)
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                            Messages
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                            Alerts
                        </a>
                    </li>
                </ul> -->
            </div>

        </div>


        <div data-simplebar style="max-height: 300px;" class="pe-2">
            <div class="tab-content position-relative" id="notificationItemsTabContent">
                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                    <?php foreach ($notifications as $index => $notification) : ?>
                        <div data-not-id="<?php echo esc_html($notification->id); ?>" class="text-reset notification-item d-block dropdown-item position-relative <?php echo $notification->status == 'unread' ? 'unread' : 'read'; ?>">
                            <div class="d-flex">
                                <div class="avatar-xs me-3 flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="#!" class="stretched-link">
                                        <h6 class="mt-0 mb-2 lh-base"><?php echo esc_html($notification->name); ?></h6>
                                    </a>
                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                        <span><i class="mdi mdi-clock-outline"></i> <?php echo esc_html($notification->created_at); ?></span>
                                    </p>
                                </div>
                                <div class="px-2 fs-15">
                                    <div class="form-check notification-check">
                                        <input class="form-check-input" type="checkbox" value="" id="notification-check<?php echo esc_attr($index); ?>">
                                        <label class="form-check-label" for="notification-check<?php echo esc_attr($index); ?>"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab"></div>
    
                <!-- precisa para não gerar erro no tema -->
                <div class="notification-actions z-1" id="notification-actions">
                    <div class="d-flex text-muted justify-content-center">
                        Selecionados <div id="select-content" class="text-body fw-semibold px-1">0</div>
                         <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>