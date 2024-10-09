<?php

/**
 * Template: Edit Dependentes
 * 
 * @param array $dependentes
 * @param int $assinante_id
 */

// Inicializar $dependentes como um array vazio se estiver nulo
$dependentes = $dependentes ?? [];

$assinante = new Subscriber_Data($assinante_id);
?>

<form method="post" action="" enctype="multipart/form-data">
    <div class="row gy-4">
        <?php wp_nonce_field('edit_dependentes', 'edit_dependentes_nonce'); ?>
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo esc_attr($assinante_id); ?>">
        <input type="hidden" name="update_dependentes" value="1">
        <input type="hidden" name="dependentes_to_delete" id="dependentes_to_delete" value="">

        <?php if ($assinante->is_type('PJ')) : ?>
            <div class="col-12">
                <div class="alert alert-warning alert-border-left alert-dismissible fade shadow show  mb-0" role="alert">
                    <p class="fs-11 mb-0"><i class="ri-alert-line me-2 align-middle fs-16"></i><strong>Atenção</strong> - Modificar o valor contratado de dependentes irá alterar o valor recorrente deste contrato.</p>
                </div>
            </div>

            <div class="col-8">

                <div class="input-group input-group-sm">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Dependentes contratados</span>
                    <input type="number" class="form-control" id="deal_pj_number_dependents" name="deal_pj_number_dependents" value="<?= $assinante->get_deal_pj_number_dependents() ?>" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
        <?php endif; ?>

        <div id="dependentes-container">
            <?php if (count($dependentes) < 1) : ?>
                <div class="alert alert-danger alert-border-left alert-dismissible fade shadow show " role="alert">
                    <i class="ri-user-unfollow-fill me-3 align-middle fs-16"></i><strong>Não há dependentes cadastrados</strong>
                </div>
            <?php else : ?>
                <?php foreach ($dependentes as $index => $dependente) : ?>
                    <div class="dependente-row row align-items-end mb-2" data-index="<?php echo $index; ?>">
                        <input type="hidden" name="dependentes[<?php echo $index; ?>][id]" value="<?php echo esc_attr($dependente['id']); ?>">
                        <div class="col-md-5">
                            <label for="dependentes[<?php echo $index; ?>][name]" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="dependentes[<?php echo $index; ?>][name]" name="dependentes[<?php echo $index; ?>][name]" value="<?php echo esc_attr($dependente['name']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="dependentes[<?php echo $index; ?>][cpf_cnpj]" class="form-label">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="dependentes[<?php echo $index; ?>][cpf_cnpj]" name="dependentes[<?php echo $index; ?>][cpf_cnpj]" value="<?php echo esc_attr($dependente['cpf_cnpj']); ?>">
                        </div>
                        <div class="col-md-3 d-flex gap-1">
                            <a href="<?php echo home_url('/assinantes/edit?assinante_id=' . $dependente['id']) ?>" class="btn btn-info w-100">
                                <i class="ri-pencil-line"></i>
                            </a>
                            <button type="button" class="btn btn-danger remove-dependente w-100 " data-id="<?php echo esc_attr($dependente['id']); ?>" data-name="<?php echo esc_attr($dependente['name']); ?>">
                                <i class="ri-delete-bin-5-fill"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($page_instance->user_has_role(['administrator', 'diretoria'])) : ?>
            <div class="col-12">
                <div class="alert alert-warning alert-border-left alert-dismissible fade shadow show " role="alert">
                    <i class="ri-alert-line me-2 align-middle fs-16"></i><strong class="fs-11">Atenção</strong>
                    <div class="form-check form-check-dark">
                        <input class="form-check-input" type="checkbox" id="not_update_subscription_value" name="not_update_subscription_value">
                        <label class="form-check-label fs-11 " for="not_update_subscription_value">
                            <strong>Não</strong> tualizar valor da assinatura.
                        </label>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-12">
            <label for="comissao_user_id" class="form-label">Comissão</label>
            <div class="w-100">
                <select data-choices name="comissao_user_id" id="comissao_user_id" class="form-select">
                    <?php
                    echo '<option value="">Sem comissão</option>';
                    foreach ($team_users as $user) {
                        $selected = isset($_GET['user_id']) && $_GET['user_id'] == $user->ID ? 'selected' : '';
                        echo '<option value="' . esc_attr($user->ID) . '" ' . $selected . '>' . esc_html($user->display_name) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div class="">
                    <button type="button" class="btn btn-primary" id="submit-form-button">Atualizar Dependentes</button>
                    <button type="button" id="add-dependente" class="btn btn-secondary">Adicionar Dependente <i class="ri-user-add-line"></i></button>
                </div>

                <?php if ($page_instance->user_has_role(['administrator', 'gerente_comercial', 'diretoria'])) : ?>
                    <input type="file" class="input-file js-input-file" id="file-csv-dependents-list" name="file-csv-dependents-list" />
                    <label for="file-csv-dependents-list" class="btn btn-success">
                        Upload CSV
                    </label>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Atualização com Deleção -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Deleção</h5>

                    <span class="badge badge-label bg-success">
                        <i class="mdi mdi-circle-medium"></i>
                        Novo valor: <span class="subscription-cost"></span>
                    </span>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning alert-border-left alert-dismissible fade shadow show" role="alert">
                        <i class="ri-alert-line me-3 align-middle fs-16"></i><strong>Atenção</strong>
                        - Esta ação é irreversível
                    </div>
                    Tem certeza que deseja deletar os seguintes dependentes?
                    <ul id="dependentesToDeleteList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Deletar e Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Atualização -->
    <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUpdateModalLabel">Confirmar Atualização</h5>

                    <span class="badge badge-label bg-success">
                        <i class="mdi mdi-circle-medium"></i>
                        Novo valor: <span class="subscription-cost"></span>
                    </span>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja atualizar os dependentes?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

</form>

<script>
    var dependentesToDelete = [];

    document.querySelectorAll('.remove-dependente').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            if (id) {
                dependentesToDelete.push({
                    id: id,
                    name: name
                });
                updateDependentesToDeleteField();
            }
            this.closest('.dependente-row').style.display = 'none';
        });
    });

    document.getElementById('add-dependente').addEventListener('click', function() {
        var container = document.getElementById('dependentes-container');
        var index = container.children.length;
        var row = document.createElement('div');
        row.classList.add('dependente-row', 'row', 'align-items-end', 'mb-2');
        row.setAttribute('data-index', index);

        row.innerHTML = `
            <input type="hidden" name="dependentes[${index}][id]">
            <div class="col-md-5">
                <label for="dependentes[${index}][name]" class="form-label">Nome</label>
                <input type="text" class="form-control" id="dependentes[${index}][name]" name="dependentes[${index}][name]">
            </div>
            <div class="col-md-4">
                <label for="dependentes[${index}][cpf_cnpj]" class="form-label">CPF/CNPJ</label>
                <input type="text" class="form-control" id="dependentes[${index}][cpf_cnpj]" name="dependentes[${index}][cpf_cnpj]">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger remove-dependente w-100" data-id="" data-name=""><i class="ri-delete-bin-5-fill"></i></button>
            </div>
        `;

        container.appendChild(row);

        row.querySelector('.remove-dependente').addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var name = this.getAttribute('data-name');
            if (id) {
                dependentesToDelete.push({
                    id: id,
                    name: name
                });
                updateDependentesToDeleteField();
            }
            this.closest('.dependente-row').style.display = 'none';
        });
    });

    document.getElementById('submit-form-button').addEventListener('click', function() {
        // Contar apenas os dependentes visíveis (não deletados)
        var numberOfDependents = Array.from(document.querySelectorAll('.dependente-row')).filter(function(row) {
            return row.style.display !== 'none';
        }).length;

        // Inicializa o objeto data para a requisição AJAX
        var ajaxData = {
            action: 'calculate_subscription_cost',
            assinante_id: <?php echo $assinante_id; ?>,
            number_of_dependents: numberOfDependents
        };

        // Verifica se o campo 'deal_pj_number_dependents' existe e tem um valor
        var dependentsInput = document.getElementById('deal_pj_number_dependents');
        if (dependentsInput && dependentsInput.value) {
            ajaxData.deal_pj_number_dependents = dependentsInput.value;
        }

        // Verifica se o campo 'not_update_subscription_value' existe e tem um valor
        var notUpdateValue = document.getElementById('not_update_subscription_value');
        if (notUpdateValue && notUpdateValue.checked) {
            ajaxData.not_update_subscription_value = true;
        }

        Preloader.enable();

        // Fazer a requisição AJAX para calcular o novo valor da assinatura
        jQuery.ajax({
            url: sysUrls.ajax_url,
            method: 'POST',
            data: ajaxData,
            success: function(response) {
                if (response.success) {
                    var newCost = parseFloat(response.data.new_cost).toFixed(2);

                    // Atualizar o texto do modal com o novo valor da assinatura
                    document.querySelector('#confirmUpdateModal .subscription-cost').textContent = 'R$ ' + newCost;
                    document.querySelector('#confirmDeleteModal .subscription-cost').textContent = 'R$ ' + newCost;

                    if (dependentesToDelete.length > 0) {
                        updateDependentesToDeleteList();
                        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {
                            keyboard: false
                        });
                        deleteModal.show();
                    } else {
                        var updateModal = new bootstrap.Modal(document.getElementById('confirmUpdateModal'), {
                            keyboard: false
                        });
                        updateModal.show();
                    }
                } else {
                    alert('Erro ao calcular o novo valor da assinatura: ' + response.data);
                }

                Preloader.disable();
            },
            error: function(xhr, status, error) {
                alert('Ocorreu um erro ao tentar calcular o novo valor da assinatura.');
                Preloader.disable();
            }
        });
    });


    function updateDependentesToDeleteList() {
        var list = document.getElementById('dependentesToDeleteList');
        list.innerHTML = '';
        dependentesToDelete.forEach(function(dependente) {
            var listItem = document.createElement('li');
            listItem.textContent = dependente.name;
            list.appendChild(listItem);
        });
    }

    function updateDependentesToDeleteField() {
        var ids = dependentesToDelete.map(function(dependente) {
            return dependente.id;
        }).join(',');
        document.getElementById('dependentes_to_delete').value = ids;
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        var form = document.querySelector('form');
        form.action = form.action + '?assinante_id=<?php echo $assinante_id; ?>';
        form.submit();
    });

    document.getElementById('confirmUpdateButton').addEventListener('click', function() {
        var form = document.querySelector('form');
        form.action = form.action + '?assinante_id=<?php echo $assinante_id; ?>';
        form.submit();
    });
</script>