<div class="row">
    <div class="col-lg-6">
        <form id="user-leads-form" method="GET">
            <label for="user_id" class="form-label">Filtro<?= $allow_pick_user ? 's' : '' ?></label>
            <div class="d-flex gap-2 mb-3">
                <?php if ($allow_pick_user): ?>
                    <div class="w-100">
                        <select data-choices name="user_id" id="user_id" class="form-select">
                            <?php
                            echo '<option value="">Todos</option>';
                            foreach ($team_users as $user) {
                                $selected = isset($_GET['user_id']) && $_GET['user_id'] == $user->ID ? 'selected' : '';
                                echo '<option value="' . esc_attr($user->ID) . '" ' . $selected . '>' . esc_html($user->display_name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="input-group align-items-start">
                    <select name="type_entity" id="type_entity" class="form-select">
                        <?php
                        $selected_pf = isset($_GET['type_entity']) && $_GET['type_entity'] == 'pf' ? 'selected' : '';
                        $selected_pj = isset($_GET['type_entity']) && $_GET['type_entity'] == 'pj' ? 'selected' : '';
                        echo '<option value="">Todos</option>';
                        echo '<option value="pf" ' . $selected_pf . '>Pessoa física</option>';
                        echo '<option value="pj" ' . $selected_pj . '>Pessoa jurídica</option>';
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    </div>

    <?php if ($page_instance->user_has_role(['administrator']) || $page_instance->get_current_user()->user_login  === 'danielsena') : ?>
        <div class="col-lg-3">
            <label for="user_id" class="form-label">Importar Banco Alfa</label>
            <button class="btn btn-success btn-md w-100 js-dynamic-modal" data-bs-toggle="modal" data-bs-target="#modalFooter"
                data-content="import_db_modal" data-params=''><i class="ri-folder-2-line align-bottom me-1"></i> Executar
                Importação</button>
        </div>
    <?php endif ?>

    <div class="col-lg-3">
        <label for="user_id" class="form-label">Adicionar Lead</label>

        <?php
        global $user_info;
        ?>
        <button class="btn btn-success btn-md w-100 js-dynamic-modal" data-bs-toggle="modal" data-bs-target="#modalFooter"
            data-content="add_lead_modal" data-params='{"user_id": <?= $page_instance->get_current_user()->id ?>, "team_id": <?= $user_info->get_team_id() ?>}'><i class="las la-user-circle me-1"></i>Add</button>
    </div>
</div>

<div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
    <?php foreach ($status_options as $status_key => $status_label): ?>
        <?php
        $status_leads = isset($grouped_leads[$status_key]) ? $grouped_leads[$status_key] : [];
        $total_value = array_sum(array_map(function ($lead) {
            return floatval($lead['deal_value']);
        }, $status_leads));
        ?>
        <div class="col col-leads">
            <div class="card">
                <a class="card-body <?php echo Lead_Meta::get_status_class($status_key); ?>" data-bs-toggle="collapse"
                    href="#<?php echo $status_key; ?>" role="button" aria-expanded="false"
                    aria-controls="<?php echo $status_key; ?>">
                    <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15"><?php echo $status_label; ?></h5>
                    <p class="text-muted mb-0">R$<?php echo number_format($total_value, 2, ',', '.'); ?> <span
                            class="fw-medium"><?php echo count($status_leads); ?> Leads</span></p>
                </a>
            </div>
            <div class="collapse show sortable pb-5" id="<?php echo $status_key; ?>" data-status="<?php echo $status_key; ?>">
                <?php foreach ($status_leads as $lead) :

                    $value = floatval($lead['deal_value']);
                    $value = number_format($value, 2, ',', '.')
                ?>
                    <div class="card mb-1 ribbon-box ribbon-fill ribbon-sm" data-lead-id=" <?php echo $lead['ID']; ?>">
                        <?php if (isset($lead['priority']) && $lead['priority'] == 'high') : ?>
                            <div class="ribbon ribbon-danger"><i class="mdi mdi-arrow-top-right"></i></div>
                        <?php endif ?>
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#lead<?php echo $lead['ID']; ?>" role="button" aria-expanded="false"
                                aria-controls="lead<?php echo $lead['ID']; ?>">
                                <div class="flex-shrink-0">
                                    <span
                                        class="avatar-title <?php echo Lead_Meta::get_priority_class($lead['priority']); ?> text-<?php echo Lead_Meta::get_priority_color($lead['priority']); ?> rounded-circle fs-36">
                                        <i class="las la-user-circle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1"><?php echo esc_html($lead['title']); ?></h6>
                                    <p class="text-muted mb-0">R$<?php echo $value; ?> -
                                        <?php echo date_i18n('d M, Y', strtotime($lead['date'])); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="collapse border-top border-top-dashed" id="lead<?php echo $lead['ID']; ?>">
                            <div class="card-body">
                                <small
                                    class="badge bg-danger-subtle text-danger"><?php echo human_time_diff(strtotime($lead['date']), current_time('timestamp')); ?>
                                    atrás</small>
                                <?php if (isset($lead['lead_phone'])): ?>
                                    <h6 class="fs-13 mb-1 mt-2">Celular</h6>
                                    <p class="text-muted fs-12 phone-ddd-mask"><?php echo esc_html($lead['lead_phone']); ?></p>
                                <?php endif ?>
                                <?php if (isset($lead['lead_phone_2'])): ?>
                                    <h6 class="fs-13 mb-1 mt-2">Telefone</h6>
                                    <p class="text-muted fs-12 phone-ddd-mask"><?php echo esc_html($lead['lead_phone_2']); ?></p>
                                <?php endif ?>
                                <?php if (isset($lead['next_action_description'])): ?>
                                    <h6 class="fs-13 mb-1 mt-2">Próxima Ação</h6>
                                    <p class="text-muted fs-12"><?php echo esc_html($lead['next_action_description']); ?></p>
                                <?php endif ?>
                                <?php if (isset($lead['lead_tags']) && is_string($lead['lead_tags'])): ?>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php
                                        $tags = explode(',', $lead['lead_tags']);
                                        foreach ($tags as $tag):
                                            $tag = trim($tag); // Remover espaços em branco ao redor
                                        ?>
                                            <span class="badge bg-info-subtle text-info"><?= htmlspecialchars($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif ?>

                                <button class="btn btn-danger btn-md w-100 mt-3 js-dynamic-modal" data-bs-toggle="modal" data-bs-target="#modalFooterMd" data-content="disqualify_lead_modal" data-params='{"lead_id": <?= $lead['ID'] ?>}'><i class="mdi mdi-trash-can-outline align-bottom me-1"></i> Desqualificar lead</button>
                            </div>
                            <div class="card-footer hstack gap-2">
                                <a href="<?php echo get_permalink($lead['ID']); ?>" class="btn btn-warning btn-md w-100"><i
                                        class="ri-folder-2-line align-bottom me-1"></i> Ver Lead</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .sortable .dragging {
        opacity: 0.5;
    }

    .sortable .card {
        cursor: move;
    }

    /* Estilo do clone */
    .dragged-clone {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1000;
        pointer-events: none;
        opacity: 0.8;
    }
</style>