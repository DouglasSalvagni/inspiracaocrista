<?php

/**
 * View for editing a lead.
 * 
 * @var array $lead_data Data of the lead to be edited.
 */
?>

<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <span
                            class="avatar-title <?php echo Lead_Meta::get_priority_class($lead_data['lead_priority']); ?> text-<?php echo Lead_Meta::get_priority_color($lead_data['lead_priority']); ?> rounded-circle fs-48">
                            <i class="las la-user-circle"></i>
                        </span>
                    </div>
                    <h5 class="fs-16 mb-1"><?php echo esc_attr($lead_data['lead_name']); ?></h5>
                    <p class="text-muted mb-0">Status:
                        <?php echo esc_html(Lead_Meta::get_status_label($lead_data['lead_status'])); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Objetivo</h5>
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar"
                        style="width: <?php echo esc_attr($progress_percentage); ?>%"
                        aria-valuenow="<?php echo esc_attr($progress_percentage); ?>" aria-valuemin="0"
                        aria-valuemax="100">
                        <div class="label"><?php echo esc_attr($progress_percentage); ?>%</div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($lead_data['messages'][0])): ?>

            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 450px;" class="px-3 mx-n3">
                        <?php foreach ($lead_data['messages'][0] as $message): ?>
                            <?php if (isset($message['sender'], $message['message'], $message['date'])): ?>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/users/user-dummy-img.jpg'); ?>"
                                            alt="" class="avatar-xs rounded-circle shadow" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fs-13"><?php echo esc_html($message['sender']); ?> <small
                                                class="text-muted"><?php echo esc_html($message['date']); ?></small></h5>
                                        <p class="text-muted"><?php echo esc_html($message['message']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Coluna formulário -->
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Informações do lead</h4>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <?= $form ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Coluna formulário -->
</div>