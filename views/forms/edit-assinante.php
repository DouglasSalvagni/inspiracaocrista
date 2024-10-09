<?php

/**
 * Template: Edit Assinante
 * 
 * @param array $assinante_data
 * @param int $assinante_id
 * @param bool $has_access
 */
?>

<form method="post" action="">
    <div class="row gy-4">
        <?php wp_nonce_field('edit_assinante', 'edit_assinante_nonce'); ?>
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo esc_attr($assinante_id); ?>">
        <input type="hidden" name="update_assinante" value="1">

        <h5 class="fs-14 mb-3">Dados do Assinante</h5>

        <div class="col-md-6">
            <label for="lead_name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="lead_nome" name="lead_name" value="<?php echo esc_attr($assinante_data['name']); ?>">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo esc_attr($assinante_data['email']); ?>">
        </div>
        <div class="col-md-4">
            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="<?php echo esc_attr($assinante_data['cpf_cnpj']); ?>">
        </div>
        <div class="col-md-4">
            <label for="phone" class="form-label">Telefone</label>
            <input type="text" class="form-control phone-ddd-mask" id="phone" name="phone" value="<?php echo esc_attr($assinante_data['phone']); ?>">
        </div>
        <div class="col-md-4">
            <label for="mobile_phone" class="form-label">Celular</label>
            <input type="text" class="form-control phone-ddd-mask" id="mobile_phone" name="mobile_phone" value="<?php echo esc_attr($assinante_data['mobile_phone']); ?>">
        </div>
        <div class="col-md-4">
            <label for="postal_code" class="form-label">CEP</label>
            <input type="text" class="form-control cep-mask" id="postal_code" name="postal_code" value="<?php echo esc_attr($assinante_data['postal_code']); ?>">
        </div>
        <div class="col-md-4">
            <label for="address" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo esc_attr($assinante_data['address']); ?>">
        </div>
        <div class="col-md-4">
            <label for="address_number" class="form-label">Número</label>
            <input type="text" class="form-control" id="address_number" name="address_number" value="<?php echo esc_attr($assinante_data['address_number']); ?>">
        </div>
        <div class="col-md-4">
            <label for="complement" class="form-label">Complemento</label>
            <input type="text" class="form-control" id="complement" name="complement" value="<?php echo esc_attr($assinante_data['complement']); ?>">
        </div>
        <div class="col-md-4">
            <label for="province" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="province" name="province" value="<?php echo esc_attr($assinante_data['province']); ?>">
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo esc_attr($assinante_data['city']); ?>">
        </div>
        <div class="col-md-4">
            <label for="uf" class="form-label">UF</label>
            <input type="text" class="form-control" id="uf" name="uf" value="<?php echo esc_attr($assinante_data['uf']); ?>">
        </div>
        <div class="col-md-4">
            <label for="subscription_start_date" class="form-label">Data de Início</label>
            <input type="date" class="form-control" id="subscription_start_date" name="subscription_start_date" value="<?php echo esc_attr($assinante_data['subscription_start_date']); ?>">
        </div>
        <div class="col-md-4">
            <label for="subscription_start_date" class="form-label">Última atualização</label>
            <input type="datetime-local" class="form-control" id="subscription_start_date" name="subscription_start_date" value="<?php echo esc_attr($assinante_data['updated_at']); ?>" disabled>
        </div>

        <?php if ($page_instance->user_has_role(['administrator'])) : ?>
            <div class="border mt-3 border-dashed"></div>

            <h5 class="fs-14 mb-3">Informações adm</h5>

            <div class="col-md-4">
                <label for="subscription_status" class="form-label">Status da Assinatura</label>
                <?php
                $options_status_subscription = ['ACTIVE', 'SUSPENDED', 'PENDING'];
                ?>
                <select class="form-select" id="subscription_status" name="subscription_status">
                    <?php foreach ($options_status_subscription as $value) : ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected($assinante_data['subscription_status'], $value); ?>><?php echo esc_html($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="asaas_customer_id" class="form-label">Asaas Customer ID</label>
                <input type="text" class="form-control" id="asaas_customer_id" name="asaas_customer_id" value="<?php echo esc_attr($assinante_data['asaas_customer_id']); ?>">
            </div>
            <div class="col-md-4">
                <label for="asaas_subscription_id" class="form-label">Asaas Subscription ID</label>
                <input type="text" class="form-control" id="asaas_subscription_id" name="asaas_subscription_id" value="<?php echo esc_attr($assinante_data['asaas_subscription_id']); ?>">
            </div>
            <div class="col-md-4">
                <label for="vendor_id" class="form-label">Vendor ID</label>
                <input type="text" class="form-control" id="vendor_id" name="vendor_id" value="<?php echo esc_attr($assinante_data['vendor_id']); ?>">
            </div>
            <div class="col-md-4">
                <label for="related_to" class="form-label">Related To</label>
                <input type="text" class="form-control" id="related_to" name="related_to" value="<?php echo esc_attr($assinante_data['related_to']); ?>">
            </div>
            <div class="col-md-4">
                <label for="split_removed" class="form-label">Split Removed</label>
                <div class="form-check form-check-dark">
                    <input type="checkbox" class="form-check-input" id="split_removed" name="split_removed" <?php checked($assinante_data['split_removed'], 1); ?>>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Atualizar Assinante</button>
        </div>
    </div>
</form>