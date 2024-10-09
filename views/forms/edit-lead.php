<?php Alert_Helper::display_alerts(); ?>
<form method="post" action="" id="edit-lead-form">
    <div class="row gy-4">
        <?php wp_nonce_field('edit_lead', 'edit_lead_nonce'); ?>

        <h5 class="fs-14 mb-3">Dados do lead</h5>
        <div class="col-12">
            <div class="row">
                <div class="col-md-2">
                    <label for="lead_type" class="form-label">Tipo de lead</label>
                    <select class="form-select" id="lead_type" name="lead_type">
                        <?php foreach (Lead_Meta::get_type_options() as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($lead_data['lead_type'], $value); ?>><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($lead->is_type('PJ')) : ?>
                    <div class="col-md-5">
                        <label for="lead_company_representative" class="form-label">Representante da empresa</label>
                        <input type="text" class="form-control" id="lead_company_representative" name="lead_company_representative" value="<?php echo esc_attr($lead_data['lead_company_representative']); ?>">
                    </div>

                    <div class="col-md-5">
                        <label for="lead_position" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="lead_position" name="lead_position" value="<?php echo esc_attr($lead_data['lead_position']); ?>">
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="col-md-4">
            <?php if ($lead->is_type('PJ')) : ?>
                <label for="lead_name" class="form-label">Nome da empresa</label>
            <?php else : ?>
                <label for="lead_name" class="form-label">Nome</label>
            <?php endif ?>
            <input type="text" class="form-control" id="lead_name" name="lead_name" value="<?php echo esc_attr($lead_data['lead_name']); ?>">
        </div>

        <?php if ($lead->is_type('PF')) : ?>
            <div class="col-md-4">
                <label for="lead_nascimento" class="form-label">Data Nascimento</label>
                <input type="date" class="form-control" id="lead_nascimento" name="lead_nascimento" value="<?php echo esc_attr($lead_data['lead_nascimento']); ?>">
            </div>
        <?php endif ?>
        
        <div class="col-md-4">
            <?php if ($lead->is_type('PJ')) : ?>
                <label for="lead_email" class="form-label">Email do financeiro</label>
            <?php endif ?>
            <?php if ($lead->is_type('PF')) : ?>
                <label for="lead_email" class="form-label">Email</label>
            <?php endif ?>
            <input type="email" class="form-control" id="lead_email" name="lead_email" value="<?php echo esc_attr($lead_data['lead_email']); ?>">
        </div>
        <div class="col-md-6">
            <?php if ($lead->is_type('PF')) : ?>
                <label for="lead_cpf_cnpj" class="form-label">CPF</label>
                <input type="text" class="form-control cpf-mask" id="lead_cpf_cnpj" name="lead_cpf_cnpj" value="<?php echo esc_attr($lead_data['lead_cpf_cnpj']); ?>">
            <?php endif ?>
            <?php if ($lead->is_type('PJ')) : ?>
                <label for="lead_cpf_cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control cnpj-mask" id="lead_cpf_cnpj" name="lead_cpf_cnpj" value="<?php echo esc_attr($lead_data['lead_cpf_cnpj']); ?>">
            <?php endif ?>
        </div>

        <div class="col-md-6">
            <label for="lead_phone" class="form-label">Telefone</label>
            <input type="text" class="form-control phone-ddd-mask" id="lead_phone" name="lead_phone" placeholder="(xx)xxxx-xxxx" value="<?php echo esc_attr($lead_data['lead_phone']); ?>">
        </div>


        <div class="border mt-3 border-dashed"></div>

        <h5 class="fs-14 mb-3">Informações da negociação</h5>

        <h6 class="fs-12">Modelo de negócio</h6>

        <!-- Início cálculos de valor -->

        <?php
        // Obter informações básicas do lead
        $deal_value_disabled = 'disabled';
        $lead_type = $lead->get_type();
        $number_of_dependents = $lead->get_number_dependents();
        $recurrence = $lead->get_recurrence();
        $vencimento_fatura = $lead->get_deal_due_date();

        // Instanciar o serviço de assinatura DNA_Assinatura_Service
        $subscription_service = new DNA_Assinatura_Service($lead);

        $pj_max_discount = $subscription_service->get_sys_pj_max_discount();

        if ($lead->is_pj_admin_max_discount_authorized()) {
            $subscription_service->set_pj_max_discount($lead->get_deal_pj_admin_max_discount());
            $pj_max_discount = $lead->get_deal_pj_admin_max_discount();
        }


        // Calcular o valor do titular e dos dependentes
        $total_cost = $subscription_service->calculate_subscription_cost();
        $dependent_cost = $subscription_service->calculate_dependent_cost();
        $base_price = $subscription_service->get_detailed_info()['base_price'];

        // Exibir valores calculados
        ?>
        <div class="col-md-4">
            <?php if ($lead->is_type('PF')) : ?>
                <label for="deal_value" class="form-label">Valor titular</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="text" class="form-control preco-mask" id="deal_value" value="<?php echo esc_attr(number_format($base_price, 2, ',', '.')); ?>" disabled>
                </div>
            <?php elseif ($lead->is_type('PJ')) : ?>
                <label for="deal_value" class="form-label">Valor por dependente</label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="text" class="form-control preco-mask" id="deal_value" value="<?php echo esc_attr(number_format($dependent_cost, 2, ',', '.')); ?>" disabled>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-2">
            <label for="deal_number_dependents" class="form-label">N dependentes</label>
            <div class="input-group">
                <input type="text" class="form-control mil-mask" id="deal_number_dependents" name="deal_number_dependents" value="<?php echo esc_attr($number_of_dependents); ?>">
                <span class="input-group-text"><i class="ri-team-fill align-bottom me-1"></i></span>
            </div>
        </div>

        <div class="col-md-2">
            <label for="deal_recurrence" class="form-label">Recorrência de cobrança</label>
            <select class="form-select" id="deal_recurrence" name="deal_recurrence">
                <option value="monthly" <?php selected($recurrence, 'monthly'); ?>>Mensal</option>

                <?php if ($lead->is_type('PF')) : ?>
                    <option value="yearly" <?php selected($recurrence, 'yearly'); ?>>Anual</option>
                <?php endif; ?>
            </select>
        </div>

        <?php if ($lead->is_type('PJ')) : ?>
            <div class="col-md-2">
                <label for="deal_pj_discount" class="form-label">Desconto (%)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="deal_pj_discount" name="deal_pj_discount" value="<?= $lead->get_deal_pj_discount() ?>" max="<?= $pj_max_discount ?>" step="0.01">
                    <span class="input-group-text">%</span>
                </div>
                <small class="form-text text-muted">Máximo permitido: <?= $pj_max_discount ?>%</small>
            </div>

            <div class="col-md-2">
                <label for="expected_close_date" class="form-label">Dia vencimento</label>
                <div class="input-group">
                    <input type="number" id="deal_due_date" name="deal_due_date" min="1" max="31" placeholder="15" class="form-control" id="expected_close_date" name="expected_close_date" value="<?php echo esc_attr($vencimento_fatura); ?>">
                    <span class="input-group-text"><i class="ri-calendar-check-line align-bottom me-1"></i></span>
                </div>
            </div>
        <?php endif; ?>

        <p class="text-muted">Valor estimado do negócio: <span class="badge badge-label bg-success fs-15">R$ <?= number_format($total_cost, 2, ',', '.'); ?></span></p>


        <!-- fim cálculos de valor -->

        <?php if ($lead->is_type('PJ') && $page_instance->user_has_role(['diretoria', 'administrator'])) : ?>
            <div class="col-md-3">
                <input class="form-check-input" type="checkbox" id="deal_pj_admin_max_discount_authorized" name="deal_pj_admin_max_discount_authorized" <?= $lead->is_pj_admin_max_discount_authorized() ? 'checked' : '' ?>>
                <label class="form-check-label" for="deal_pj_admin_max_discount_authorized">
                    Máximo desconto personalizado
                </label>

                <div class="input-group">
                    <input type="number" class="form-control" id="deal_pj_admin_max_discount" name="deal_pj_admin_max_discount" value="<?= $lead->get_deal_pj_admin_max_discount() ?>" max="30" step="0.01">
                    <span class="input-group-text">%</span>
                </div>
                <small class="form-text text-muted">Máximo permitido: 30%</small>
            </div>
        <?php endif; ?>

        <?php if ($lead->is_type('PF') && $lead->get_recurrence() == 'monthly') : ?>
            <div class="col-12">
                <input class="form-check-input" type="checkbox" id="deal_boleto_authorized" name="deal_boleto_authorized" <?= $lead->is_boleto_authorized() ? 'checked' : '' ?>>
                <label class="form-check-label" for="deal_boleto_authorized">
                    Autorizar Boleto Bancário
                </label>
            </div>
        <?php endif; ?>


        <h6 class="fs-12">Andamento</h6>

        <div class="col-md-4">
            <label for="lead_status" class="form-label">Status</label>
            <select class="form-select" id="lead_status" name="lead_status">
                <?php foreach (Lead_Meta::get_status_options() as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($lead_data['lead_status'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="lead_priority" class="form-label">Prioridade</label>
            <select class="form-select" id="lead_priority" name="lead_priority">
                <?php foreach (Lead_Meta::get_priority_options() as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($lead_data['lead_priority'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="lead_source" class="form-label">Origem</label>
            <select class="form-select" id="lead_source" name="lead_source">
                <?php foreach (Lead_Meta::get_source_options() as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($lead_data['lead_source'], $value); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="deal_stage" class="form-label">Estágio do Negócio</label>
            <input type="text" class="form-control" id="deal_stage" name="deal_stage" value="<?php echo esc_attr($lead_data['deal_stage']); ?>">
        </div>

        <div class="col-md-4">
            <label for="expected_close_date" class="form-label">Data Esperada de Fechamento</label>
            <input type="date" class="form-control" id="expected_close_date" name="expected_close_date" value="<?php echo esc_attr($lead_data['expected_close_date']); ?>">
        </div>

        <div class="col-md-4">
            <label for="last_contacted_date" class="form-label">Data do Último Contato</label>
            <input type="date" class="form-control" id="last_contacted_date" name="last_contacted_date" value="<?php echo esc_attr($lead_data['last_contacted_date']); ?>">
        </div>

        <div class="col-md-4">
            <label for="contact_method" class="form-label">Método de Contato</label>
            <input type="text" class="form-control" id="contact_method" name="contact_method" value="<?php echo esc_attr($lead_data['contact_method']); ?>">
        </div>

        <div class="col-md-4">
            <label for="next_action_date" class="form-label">Data da Próxima Ação</label>
            <input type="date" class="form-control" id="next_action_date" name="next_action_date" value="<?php echo esc_attr($lead_data['next_action_date']); ?>">
        </div>

        <div class="col-md-4">
            <label for="lead_tags" class="form-label">Tags</label>
            <input type="text" class="form-control " data-choices data-choices-limit="Required Limit" data-choices-removeItem id="lead_tags" name="lead_tags" value="<?php echo esc_html($lead_data['lead_tags']); ?>">
        </div>

        <div class="col-md-12">
            <label for="next_action_description" class="form-label">Descrição da Próxima Ação</label>
            <textarea class="form-control" id="next_action_description" name="next_action_description"><?php echo esc_textarea($lead_data['next_action_description']); ?></textarea>
        </div>

        <?php if ($page_instance->user_has_role(['administrator', 'diretoria', 'gerente_comercial'])) : ?>
            <div class="border mt-3 border-dashed"></div>
            <h5 class="fs-14 mb-3">Informações complementares</h5>

            <?php
            $current_user = wp_get_current_user();
            $is_admin = in_array('administrator', $current_user->roles);
            $assigned_user = get_user_by('id', $lead_data['lead_assigned_to']);
            ?>

            <div class="col-md-4">
                <label for="lead_assigned_to" class="form-label">Atribuído a</label>
                <select id="lead_assigned_to" data-choices data-choices-sorting-false name="lead_assigned_to" class="form-select" style="width: 100%;">
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($team_users as $user) : ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($lead_data['lead_assigned_to'], $user->ID); ?>>
                            <?php echo esc_html($user->display_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($page_instance->user_has_role(['administrator', 'diretoria'])) : ?>

                <?php
                $args = array(
                    'post_type' => 'team',
                    'numberposts' => -1,
                    'post_status' => 'publish',
                );
                $teams = get_posts($args);
                ?>

                <div class="col-md-4">
                    <label for="lead_assigned_team_id" class="form-label">Time</label>
                    <select id="lead_assigned_team_id" data-choices data-choices-sorting-false name="lead_assigned_team_id" class="form-select" style="width: 100%;">
                        <option value="">Selecione um time</option>
                        <?php foreach ($teams as $team) : ?>
                            <option value="<?php echo esc_attr($team->ID); ?>" <?php selected($lead->get_assigned_team_id(), $team->ID); ?>>
                                <?php echo esc_html($team->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="col-md-12">
                <label for="lead_notes" class="form-label">Notas</label>
                <textarea class="form-control" id="lead_notes" name="lead_notes"><?php echo esc_textarea($lead_data['lead_notes']); ?></textarea>
            </div>
        <?php endif; ?>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Atualizar Lead</button>

            <button type="button" class="btn btn-danger btn-md  js-dynamic-modal" data-bs-toggle="modal" data-bs-target="#modalFooterMd" data-content="disqualify_lead_modal" data-params='{"lead_id": "<?= $lead_data['ID'] ?>", "redirect_url": "<?= home_url('/leads') ?>"}'><i class="mdi mdi-trash-can-outline align-bottom me-1"></i> Desqualificar lead</button>

            <?php if ($lead_data['lead_status'] == 'offer_accepted') : ?>
                <button type="button" class="btn btn-success" id="generate-checkout-link">Gerar Link de Checkout</button>
            <?php endif ?>
        </div>

        <div class="col-12">
            <span class="input-group-text d-none" id="output-checkout-link"></span>
        </div>
    </div>
</form>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#generate-checkout-link').on('click', function() {
            Preloader.enable();

            var lead_id = <?php echo $lead_data['ID']; ?>;
            var outputCheckoutLink = $('#output-checkout-link');

            $.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'generate_checkout_link',
                    lead_id: lead_id,
                    _wpnonce: '<?php echo wp_create_nonce('generate_checkout_link_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        var checkoutLink = response.data.checkout_link;

                        // Mostrar o campo de saída e preencher com o link gerado
                        outputCheckoutLink.removeClass('d-none');
                        outputCheckoutLink.html(checkoutLink);

                        // Copiar o link para a área de transferência
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(checkoutLink).then(function() {
                                alert('Link de checkout copiado para a área de transferência!');
                            }, function() {
                                alert('Falha ao copiar o link para a área de transferência.');
                            });
                        } else {
                            alert('O navegador não suporta a funcionalidade de copiar para a área de transferência.');
                        }
                    } else {
                        alert('Erro ao gerar o link de checkout: ' + response.data.message);
                    }
                    // Desativar o Preloader ao final, independentemente de sucesso ou erro
                    Preloader.disable();
                },
                error: function() {
                    alert('Ocorreu um erro inesperado ao gerar o link de checkout.');
                    Preloader.disable();
                }
            });
        });
    });
</script>