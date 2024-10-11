<?php
$add_dependent_class = 'd-none';
if ($entity == 'PJ') {
    $name_label = 'Nome da empresa';
    $entity_type = 'CNPJ';
    $entity_class = 'cnpj-mask';
    $add_dependent_class = 'd-none';
} else {
    $name_label = 'Nome completo';
    $entity_type = 'CPF';
    $entity_class = 'cpf-mask';
}


Template_Helper::render_view('parts/checkout-header');
?>

<div id="layout-wrapper">
    <div class="page-content mt-5">
        <div id="content" class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xxl-6">
                    <div class="card">
                        <form id="subscriptionForm">
                            <input type="hidden" id="entity" name="entity" value="<?php echo isset($lead_data) ? esc_attr($lead_data->get_type()) : ''; ?>">
                            <div class="card-body border-bottom border-bottom-dashed p-4">

                                <!-- Contêiner para as mensagens de alerta -->
                                <div id="messageContainer"></div>

                                <div class="row">
                                    <div class="col-12">
                                        <h2>Dados do Cliente</h2>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label"><?= $name_label ?>:</label>
                                                <input type="text" class="form-control bg-light border-0" id="name" name="name" value="<?php echo isset($lead_data) ? esc_attr($lead_data->get_name()) : ''; ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="cpfCnpj" class="form-label"><?= $entity_type ?>:</label>
                                                <input type="text" class="form-control bg-light border-0 <?= $entity_class ?>" id="cpfCnpj" name="cpfCnpj" value="<?php echo isset($lead_data) ? esc_attr($lead_data->get_cpf_cnpj()) : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">E-mail:</label>
                                                <input type="email" class="form-control bg-light border-0" id="email" name="email" value="<?php echo isset($lead_data) ? esc_attr($lead_data->get_email()) : ''; ?>">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="noEmail" name="noEmail">
                                                    <label class="form-check-label" for="noEmail">Não tem</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label">Celular (DDD):</label>
                                                <input type="text" class="form-control bg-light border-0 phone-ddd-mask" id="phone" name="phone" value="<?php echo isset($lead_data) ? esc_attr($lead_data->get_phone()) : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="postalCode" class="form-label">CEP:</label>
                                                <input type="text" class="form-control bg-light border-0 cep-mask" id="postalCode" name="postalCode">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="addressNumber" class="form-label">Número:</label>
                                                <input type="text" class="form-control bg-light border-0" id="addressNumber" name="addressNumber">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="address" class="form-label">Endereço:</label>
                                                <input type="text" class="form-control bg-light border-0" id="address" name="address" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="complement" class="form-label">Complemento:</label>
                                                <input type="text" class="form-control bg-light border-0" id="complement" name="complement">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="province" class="form-label">Bairro:</label>
                                                <input type="text" class="form-control bg-light border-0" id="province" name="province" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="city" class="form-label">Cidade:</label>
                                                <input type="text" class="form-control bg-light border-0" id="city" name="city" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="uf" class="form-label">UF:</label>
                                                <input type="text" class="form-control bg-light border-0" id="uf" name="uf" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 <?= $add_dependent_class ?>">
                                        <h2>Dependentes</h2>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <button type="button" class="btn btn-primary" id="add-dependent">Adicionar Dependente</button>
                                                <button type="button" class="btn btn-danger" id="remove-dependent" disabled>Remover Dependente</button>
                                            </div>
                                            <div>
                                                <span id="num-dependents-display">Número de Dependentes: <span id="num-dependents">0</span></span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="num_dependents" name="num_dependents" value="0">
                                        <div id="dependents-container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <h2>Dados da Assinatura</h2>
                                <h4>Preço Total: <span id="subscription-price"></span></h4>
                            </div>
                            <div class="card-body p-4 border-top border-top-dashed">

                                <!-- Accordions with Icons -->
                                <div class="accordion custom-accordionwithicon" id="accordionWithicon">

                                    <!-- PAGAMENTO CARTÃO -->
                                    <div class="accordion-item shadow">
                                        <h2 class="accordion-header" id="accordionwithiconExample2">
                                            <button class="accordion-button" type="button"
                                                for="cartao" data-bs-toggle="collapse" data-bs-target="#accor_cc" aria-expanded="true" aria-controls="accor_cc">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="radio" id="cartao" name="pay-method" checked value="CREDIT_CARD">
                                                    <label class="form-check-label" for="cartao">
                                                        Pagar com cartão
                                                    </label>
                                                </div>
                                                <i class="mdi mdi-credit-card ms-2"></i>
                                            </button>
                                        </h2>
                                        <div id="accor_cc" class="accordion-collapse collapse show" aria-labelledby="accordionwithiconExample2" data-bs-parent="#accordionWithicon">
                                            <div class="accordion-body">
                                                <h2 class="fs-5">Dados do Cartão de Crédito</h2>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="holderName" class="form-label">Nome do Titular:</label>
                                                        <input type="text" class="form-control bg-light border-0" id="holderName" name="holderName">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="number" class="form-label">Número do Cartão:</label>
                                                        <input type="text" class="form-control bg-light border-0 cc-mask" id="number" name="number" placeholder="XXXX XXXX XXXX XXXX">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="expiryMonth" class="form-label">Mês de Expiração:</label>
                                                        <input type="text" class="form-control bg-light border-0 mes-mask" id="expiryMonth" name="expiryMonth">
                                                    </div>
                                                    <div class="col-md-5 mb-3">
                                                        <label for="expiryYear" class="form-label">Ano de Expiração:</label>
                                                        <input type="text" class="form-control bg-light border-0 ano-mask" id="expiryYear" name="expiryYear">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label for="ccv" class="form-label">CCV:</label>
                                                        <input type="text" class="form-control bg-light border-0 cvv-mask" id="ccv" name="ccv">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PAGAMENTO BOLETO -->
                                    <?php if (
                                        $entity == 'PJ'
                                        || (isset($lead_data) && $lead_data->get_recurrence() == 'monthly'
                                            && $lead_data->is_boleto_authorized())
                                    ) : ?>
                                        <div class="accordion-item shadow">
                                            <h2 class="accordion-header" id="accordionwithiconExample3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_boleto" aria-expanded="false" aria-controls="accor_boleto">
                                                    <div class="form-check form-check d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="radio" id="boleto" name="pay-method" value="BOLETO">
                                                        <label class="form-check-label" for="boleto">
                                                            Pagamento com boleto
                                                        </label>
                                                    </div>
                                                    <i class="mdi mdi-barcode ms-2"></i>
                                                </button>
                                            </h2>
                                            <div id="accor_boleto" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample3" data-bs-parent="#accordionWithicon">
                                                <div class="accordion-body">
                                                    Pague com boleto.
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- PAGAMENTO PIX -->
                                    <?php if ($entity == 'PF' && isset($lead_data) && $lead_data->get_recurrence() == 'yearly') : ?>
                                        <div class="accordion-item shadow">
                                            <h2 class="accordion-header" id="accordionwithiconExample3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_pix" aria-expanded="false" aria-controls="accor_pix">
                                                    <div class="form-check form-check d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="radio" id="pix" name="pay-method" value="PIX">
                                                        <label class="form-check-label" for="pix">
                                                            Pagamento com pix
                                                        </label>
                                                    </div>
                                                    <i class="bx bx-qr-scan ms-2"></i>
                                                </button>
                                            </h2>
                                            <div id="accor_pix" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample3" data-bs-parent="#accordionWithicon">
                                                <div class="accordion-body">
                                                    Pague com pix.
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- PAGAMENTO DÉBITO -->
                                    <?php if ($entity == 'PF' && isset($lead_data) && $lead_data->get_recurrence() == 'yearly') : ?>
                                        <div class="accordion-item shadow">
                                            <h2 class="accordion-header" id="accordionwithiconExample3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_debito" aria-expanded="false" aria-controls="accor_debito">
                                                    <div class="form-check form-check d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="radio" id="debito" name="pay-method" value="UNDEFINED">
                                                        <label class="form-check-label" for="debito">
                                                            Pagamento com débito
                                                        </label>
                                                    </div>
                                                    <i class="bx bx-credit-card-alt ms-2"></i>
                                                </button>
                                            </h2>
                                            <div id="accor_debito" class="accordion-collapse collapse" aria-labelledby="accordionwithiconExample3" data-bs-parent="#accordionWithicon">
                                                <div class="accordion-body">
                                                    Pague com débito.
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="hstack gap-2 justify-content-end d-print-none">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAceitaTermos"><i class="bx bx-credit-card align-center fs-17 me-1"></i> Criar Assinatura</button>
                                </div>
                            </div>

                            <?php wp_nonce_field('checkout_nonce', 'checkout_nonce'); ?>
                            <?php if ($lead_id) : ?>
                                <input type="hidden" id="lead_id" name="lead_id" value="<?php echo esc_attr(Encryption::encrypt($lead_id, true)); ?>"> <!-- Campo oculto para lead_id -->
                            <?php endif; ?>
                            <?php if ($require_uuid) : ?>
                                <input type="hidden" id="uuid" name="uuid" value="<?php echo esc_attr($uuid); ?>"> <!-- Campo oculto para uuid -->
                            <?php endif; ?>

                            <div class="modal fade" id="modalAceitaTermos" tabindex="-1" aria-labelledby="modalAceitaTermosTitle" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAceitaTermosTitle">Termos de aceite</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body" id="accept-content">
                                            <?= $accept_terms_text ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-success"><i class="bx bx-credit-card align-center fs-17 me-1"></i> Aceitar e criar assinatura</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

Template_Helper::render_view('parts/checkout-footer');
