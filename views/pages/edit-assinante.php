<?php


Alert_Helper::display_alerts();

$assinante = new Subscriber_Data($assinante_id);

$recorrência = $assinante->get_recurrence() == 'yearly' ? 'Pacote anual' : 'Plano mensal';
$tipo = $assinante->is_type('PJ') == 'Pessoa Jurídica' ? 'Pessoa Jurídica' : 'Pessoa Física';
$tipo_icon = $assinante->is_type('PJ') == 'Pessoa Jurídica' ? 'mdi-office-building-outline' : 'mdi-account-heart-outline';
$role = $assinante->get_role_type() == 'TITULAR' ? 'Titular' : 'Dependente';
$role_icon = $assinante->get_role_type() == 'TITULAR' ? 'mdi-account-multiple-outline' : 'mdi-account-multiple-plus-outline';

?>
<div class="row">
    <!-- Coluna formulário -->
    <div class="col-xxl-7">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Informações do Assinante <?= $assinante->get_deal_pj_number_dependents() ?></h4>

                <?php if ($is_holder) : ?>
                    <?= $form_excluir ?>
                <?php else: ?>
                    <a href="<?= Assinante_Service::get_titular_link_by_dependente($assinante_id);; ?>" class="btn btn-info">Ver titular</a>
                <?php endif ?>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <div class="row mb-4">
                        <div class="col flex">
                            <?php if ($role) : ?>
                                <span class="badge bg-primary-subtle text-primary  fs-12">
                                    <i class="mdi <?= $role_icon ?> me-1"></i><?= $role ?>
                                </span>
                            <?php endif ?>
                            <?php if ($tipo) : ?>
                                <span class="badge bg-secondary-subtle text-secondary fs-12">
                                    <i class="mdi <?= $tipo_icon ?> me-1"></i><?= $tipo ?>
                                </span>
                            <?php endif ?>
                            <?php if ($recorrência) : ?>
                                <span class="badge bg-success-subtle text-success  fs-12">
                                    <i class="mdi mdi-cached me-1"></i><?= $recorrência ?>
                                </span>
                            <?php endif ?>
                        </div>
                    </div>
                    <?= $form ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Coluna formulário -->
    <?php if ($is_holder) : ?>
        <div class="col-xxl-5">

            <div class="card ribbon-box right">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Cobranças</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($assinante_data['subscription_value'])) : ?>
                        <div class="ribbon ribbon-success round-shape"><?= $recorrência ?>: R$ <span class=""><?php echo esc_attr($assinante_data['subscription_value']); ?></span></div>
                    <?php endif; ?>

                    <div id="lista-cobrancas" class="live-preview">
                        <table id="cobrancas-datatable" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th>Data de Vencimento</th>
                                    <th>Valor</th>
                                    <th>Tipo de Cobrança</th>
                                    <th>Status</th>
                                    <th>Data de Criação</th>
                                    <th>Link da Fatura</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- O conteúdo será carregado via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Dependentes</h4>

                    <?php if ($assinante->is_type('PJ')) : ?>

                        <span class="fs-12">N.º dependentes contratados <span class="badge rounded-pill bg-danger"><?= $assinante->get_deal_pj_number_dependents() ?></span></span>

                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <?= $form_dependentes ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endif ?>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadSubscriptionPayments();

        function loadSubscriptionPayments() {
            jQuery.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'load_subscription_payments',
                    assinante_id: <?php echo $assinante_id; ?>
                },
                success: function(response) {
                    if (response.success) {
                        initializeDataTable(response.data);
                    } else {
                        document.getElementById('lista-cobrancas').innerHTML = '<p class="text-danger">Erro ao carregar cobranças: ' + response.data + '</p>';
                    }
                },
                error: function(xhr, status, error) {
                    document.getElementById('lista-cobrancas').innerHTML = '<p class="text-danger">Erro ao carregar cobranças.</p>';
                }
            });
        }

        function initializeDataTable(payments) {
            jQuery('#cobrancas-datatable').DataTable({
                data: payments,
                columns: [{
                        data: 'dueDate',
                        render: function(data, type, row) {
                            const date = new Date(data);
                            // Ajuste para considerar o fuso horário
                            const adjustedDate = new Date(date.getTime() + date.getTimezoneOffset() * 60000);
                            return adjustedDate.toLocaleDateString('pt-BR');
                        }
                    },
                    {
                        data: 'value',
                        render: function(data, type, row) {
                            return 'R$ ' + parseFloat(data).toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'billingType'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'dateCreated',
                        render: function(data, type, row) {
                            const date = new Date(data);
                            // Ajuste para considerar o fuso horário
                            const adjustedDate = new Date(date.getTime() + date.getTimezoneOffset() * 60000);
                            return adjustedDate.toLocaleDateString('pt-BR');
                        }
                    },
                    {
                        data: 'invoiceUrl',
                        render: function(data, type, row) {
                            return `<a href="${data}" target="_blank">Ver Fatura</a>`;
                        }
                    }
                ],
                responsive: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    "decimal": ",",
                    "thousands": ".",
                    "sEmptyTable": "Nenhum dado disponível na tabela",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sSearch": "Pesquisar",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "_": "Selecionado %d linhas",
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha"
                        }
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "copyTitle": "Cópia bem sucedida",
                        "copySuccess": {
                            "1": "Uma linha copiada",
                            "_": "%d linhas copiadas"
                        }
                    }
                }
            });
        }
    });
</script>