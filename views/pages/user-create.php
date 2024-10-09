<!-- views/pages/user-create.php -->
<div class="container mt-4">
    <h1>Criar Novo Usuário</h1>

    <?php
    // Exibe quaisquer alertas
    Alert_Helper::display_alerts();
    ?>

    <form method="POST" class="row g-3">
        <?php wp_nonce_field('create_user'); ?>

        <div class="col-md-6">
            <label for="user_login" class="form-label">Nome de Usuário (Login)</label>
            <input type="text" name="user_login" id="user_login" class="form-control" value="<?php echo isset($_POST['user_login']) ? esc_attr($_POST['user_login']) : ''; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="user_email" class="form-label">E-mail</label>
            <input type="email" name="user_email" id="user_email" class="form-control" value="<?php echo isset($_POST['user_email']) ? esc_attr($_POST['user_email']) : ''; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="first_name" class="form-label">Nome</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>">
        </div>

        <div class="col-md-6">
            <label for="last_name" class="form-label">Sobrenome</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>">
        </div>

        <div class="col-md-6">
            <label for="user_pass" class="form-label">Senha</label>
            <input type="password" name="user_pass" id="user_pass" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="user_pass_confirm" class="form-label">Confirmar Senha</label>
            <input type="password" name="user_pass_confirm" id="user_pass_confirm" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="role" class="form-label">Função (Role)</label>
            <select name="role" id="role" class="form-select" required>
                <option value="">Selecione uma função</option>
                <?php foreach ($roles as $role_key => $role_name): ?>
                    <option value="<?php echo esc_attr($role_key); ?>" <?php selected(isset($_POST['role']) ? $_POST['role'] : '', $role_key); ?>><?php echo esc_html($role_name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="team_id" class="form-label">Time</label>
            <select name="team_id" id="team_id" class="form-select">
                <option value="">Selecione um time</option>
                <?php foreach ($teams as $id => $name): ?>
                    <option value="<?php echo esc_attr($id); ?>" <?php selected(isset($_POST['team_id']) ? $_POST['team_id'] : '', $id); ?>><?php echo esc_html($name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" name="create_user" class="btn btn-primary">Criar Usuário</button>
            <a href="<?php echo esc_url(home_url('/usuarios')); ?>" class="btn btn-secondary">Voltar à lista</a>
        </div>
    </form>
</div>
