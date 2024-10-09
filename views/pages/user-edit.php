<!-- views/pages/user-edit.php -->
<div class="container mt-4">
    <h1>Editar Usuário</h1>

    <?php
    // Exibe quaisquer alertas
    Alert_Helper::display_alerts();
    ?>

    <form method="POST" class="row g-3">
        <?php wp_nonce_field('update_user_' . $user_data->ID); ?>
        <div class="col-md-6">
            <label for="first_name" class="form-label">Nome</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo esc_attr($user_data->first_name); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="last_name" class="form-label">Sobrenome</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo esc_attr($user_data->last_name); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="user_email" class="form-label">E-mail</label>
            <input type="email" name="user_email" id="user_email" class="form-control" value="<?php echo esc_attr($user_data->user_email); ?>" required>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="role" class="form-label">Função (Role)</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Selecione uma função</option>
                        <?php foreach ($roles as $role_key => $role_name): ?>
                            <option value="<?php echo esc_attr($role_key); ?>" <?php selected($user_info->user_has_role([$role_key]) ? $role_key : '', $role_key); ?>><?php echo esc_html($role_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="team_id" class="form-label">Time</label>
                    <select name="team_id" id="team_id" class="form-select">
                        <option value="">Selecione um time</option>
                        <?php
                        $user_team_id = get_user_meta($user_data->ID, 'team_id', true);
                        foreach ($teams as $id => $name): ?>
                            <option value="<?php echo esc_attr($id); ?>" <?php selected($user_team_id, $id); ?>><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- Outros campos -->

        <div class="col-12">
            <div class="row">
                <!-- Adicione os campos de senha aqui -->
                <div class="col-md-6">
                    <label for="user_pass" class="form-label">Nova Senha</label>
                    <input type="password" name="user_pass" id="user_pass" class="form-control">
                </div>

                <div class="col-md-6">
                    <label for="user_pass_confirm" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" name="user_pass_confirm" id="user_pass_confirm" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="update_user" class="btn btn-primary">Atualizar Usuário</button>
            <a href="<?php echo esc_url(home_url('/usuarios')); ?>" class="btn btn-secondary">Voltar à lista</a>
        </div>
    </form>
</div>