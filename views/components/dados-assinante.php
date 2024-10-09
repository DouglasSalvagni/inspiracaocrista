<?php
/**
 * Template: View Assinante
 * 
 * @param array $assinante_data
 * @param array $dependentes
 * @param int $assinante_id
 * @param bool $has_access
 */

?>

<div class="container">
    <div class="">
        <div class="card-header mb-4">
            <h5 class="card-title">Dados do Assinante</h5>
        </div>
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-4">
                    <strong>Nome:</strong> <?php echo esc_html($assinante_data['name']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Email:</strong> <?php echo esc_html($assinante_data['email']); ?>
                </div>
                <div class="col-md-4">
                    <strong>CPF/CNPJ:</strong> <?php echo esc_html($assinante_data['cpf_cnpj']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Telefone:</strong> <?php echo esc_html($assinante_data['phone']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Celular:</strong> <?php echo esc_html($assinante_data['mobile_phone']); ?>
                </div>
                <div class="col-md-4">
                    <strong>CEP:</strong> <?php echo esc_html($assinante_data['postal_code']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Endereço:</strong> <?php echo esc_html($assinante_data['address']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Número:</strong> <?php echo esc_html($assinante_data['address_number']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Complemento:</strong> <?php echo esc_html($assinante_data['complement']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Bairro:</strong> <?php echo esc_html($assinante_data['province']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Cidade:</strong> <?php echo esc_html($assinante_data['city']); ?>
                </div>
                <div class="col-md-4">
                    <strong>UF:</strong> <?php echo esc_html($assinante_data['uf']); ?>
                </div>
                <div class="col-md-4">
                    <strong>Data de Início:</strong> 
                    <?php echo date('d/m/Y', strtotime($assinante_data['subscription_start_date'])); ?>
                </div>
                <div class="col-md-4">
                    <strong>Última atualização:</strong> 
                    <?php echo date('d/m/Y', strtotime($assinante_data['updated_at'])); ?>
                </div>
                <?php if ($has_access) : ?>
                    <div class="col-12 mt-3">
                        <h6 class="fw-bold">Informações adm</h6>
                    </div>
                    <div class="col-md-4">
                        <strong>Status da Assinatura:</strong> <?php echo esc_html($assinante_data['subscription_status']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Asaas Customer ID:</strong> <?php echo esc_html($assinante_data['asaas_customer_id']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Asaas Subscription ID:</strong> <?php echo esc_html($assinante_data['asaas_subscription_id']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Vendor ID:</strong> <?php echo esc_html($assinante_data['vendor_id']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Related To:</strong> <?php echo esc_html($assinante_data['related_to']); ?>
                    </div>
                    <div class="col-md-4">
                        <strong>Split Removed:</strong> <?php echo $assinante_data['split_removed'] ? 'Sim' : 'Não'; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
