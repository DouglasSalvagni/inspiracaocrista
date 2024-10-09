<?php if ($has_access_to_statistics) : ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total de vidas <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account-heart-outline display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo esc_html($total_lives_count); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total de titulares <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account-group-outline display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo esc_html($total_titulares_count); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <!-- Número de Vendas do Mês -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total de dependentes <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account-multiple-outline display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="<?php echo esc_html($total_dependentes_count); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Recorrencia mensal -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Valor corrente mensal <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="las la-money-check-alt display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">R$ <span class="counter-value" data-target="<?php echo esc_html($total_subscription_monthly_value); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Recorrencia anual -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Valor corrente anual <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="las la-money-check-alt display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">R$ <span class="counter-value" data-target="<?php echo esc_html($total_subscription_yearly_value); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
<?php endif; ?>

<div class="row">
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card" id="assinantesList">
            <div class="card-header">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Buscar assinantes..." id="search-assinantes">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="assinante-status-filter" class="form-select">
                            <option value="">Todos</option>
                            <option value="ACTIVE">Ativas</option>
                            <option value="SUSPENDED">Suspensas</option>
                            <option value="PENDING">Pendente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-3">
                    <table class="table align-middle table-nowrap mb-0" id="assinantesTable">
                        <thead class="table-light">
                            <tr>
                                <th data-sort="name" scope="col">Nome</th>
                                <th data-sort="email" scope="col">Telefone</th>
                                <th data-sort="cpf_cnpj" scope="col">CPF/CNPJ</th>
                                <th data-sort="subscription_status" scope="col">Status</th>
                                <th data-sort="titular_status" scope="col">Titular/Dependente</th>
                                <th data-sort="members" scope="col">Membros</th>
                                <?php if ($page_instance->user_has_role(['gerente_comercial', 'diretoria', 'administrator'])) : ?>
                                    <th data-sort="" scope="col">Ação</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all" id="assinantes-list">
                            <!-- Assinantes serão carregados aqui via AJAX -->
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Desculpe! Nenhum resultado encontrado</h5>
                            <p class="text-muted mb-0">Não encontramos nenhum assinante para sua busca.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <div class="pagination-wrap hstack gap-2">
                        <ul class="pagination listjs-pagination mb-0" id="pagination">
                            <!-- Pagination will be generated here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-3">
        <div class="card" id="assinante-detail">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block">
                    <span class="avatar-title bg-dark-subtle text-dark rounded-circle fs-48">
                        <i class="las la-user-circle"></i>
                    </span>
                    <span class="contact-active position-absolute rounded-circle bg-success"><span class="visually-hidden"></span></span>
                </div>
                <h5 class="mt-4 mb-1" id="assinante-name">xxxxxxx xxxxxx</h5>
                <p class="text-muted" id="assinante-email">xxxxx@xxx.com</p>

                <ul class="list-inline mb-0">
                    <li class="list-inline-item avatar-xs">
                        <a id="assinante-phone-link" href="javascript:void(0);" class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                            <i class="ri-phone-line"></i>
                        </a>
                    </li>

                    <li class="list-inline-item avatar-xs">
                        <a id="assinante-email-link" href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                            <i class="ri-mail-line"></i>
                        </a>
                    </li>

                    <li class="list-inline-item avatar-xs">
                        <button id="assinante-edit-link" class="btn shadow-none avatar-title bg-success-subtle text-success fs-15 rounded js-dynamic-modal" data-bs-toggle="modal" data-bs-target="#modalFooter" data-content="edit_assinante_modal" data-params='{"assinante_id": 0}'>
                            <i class="mdi mdi-account-edit-outline"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h6 class="text-muted text-uppercase fw-semibold mb-3">Informações pessoais</h6>
                <div class="table-responsive table-card">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-medium" scope="row">CPF/CNPJ</td>
                                <td id="assinante-cpf_cnpj">xxx.xxx.xxx-xx</td>
                            </tr>
                            <tr>
                                <td class="fw-medium" scope="row">Telefone</td>
                                <td id="assinante-phone" class="phone-ddd-mask">(xx)-xxxx-xxxx</td>
                            </tr>
                            <tr>
                                <td class="fw-medium" scope="row">E-mail</td>
                                <td id="assinante-email-info">xxxxx@xxx.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>