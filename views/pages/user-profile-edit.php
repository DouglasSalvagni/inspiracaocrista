<div class="row">
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                        <img src="<?php echo esc_url($avatar_url); ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image shadow" alt="user-profile-image">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            <form id="upload-profile-image-form" method="post" enctype="multipart/form-data">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" name="profile_image" accept="image/*">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body shadow">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                                <?php wp_nonce_field('edit_profile', 'edit_profile_nonce'); ?>
                                <input type="hidden" name="submit_profile_image" value="1">
                            </form>
                        </div>
                    </div>
                    <?php if ($profile_image_id) : ?>
                        <form method="post">
                            <?php wp_nonce_field('edit_profile', 'edit_profile_nonce'); ?>
                            <input type="hidden" name="delete_profile_image" value="1">
                            <button type="submit" class="btn btn-danger mb-2">Deletar imagem</button>
                        </form>
                    <?php endif; ?>
                    <h5 class="fs-16 mb-1"><?php echo esc_html($current_user->display_name); ?></h5>
                    <p class="text-muted mb-0"><?php echo esc_html(get_user_meta($current_user->ID, 'designation', true)); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?php echo $active_tab === 'personalDetails' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="<?php echo $active_tab === 'personalDetails' ? 'true' : 'false'; ?>">
                            <i class="fas fa-home"></i> Detalhes Pessoais
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?php echo $active_tab === 'changePassword' ? 'active' : ''; ?>" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="<?php echo $active_tab === 'changePassword' ? 'true' : 'false'; ?>">
                            <i class="far fa-user"></i> Mudar Senha
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <?php Alert_Helper::display_alerts(); ?>
                <div class="tab-content">
                    <div class="tab-pane <?php echo $active_tab === 'personalDetails' ? 'active show' : ''; ?>" id="personalDetails" role="tabpanel">
                        <form method="post" action="">
                            <?php wp_nonce_field('edit_profile', 'edit_profile_nonce'); ?>
                            <input type="hidden" name="submit_profile_details" value="1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">Primeiro Nome</label>
                                        <input type="text" class="form-control" id="firstnameInput" name="first_name" value="<?php echo esc_attr($user_data['first_name']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lastnameInput" class="form-label">Último Nome</label>
                                        <input type="text" class="form-control" id="lastnameInput" name="last_name" value="<?php echo esc_attr($user_data['last_name']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Número de Telefone</label>
                                        <input type="text" class="form-control phone-ddd-mask" id="phonenumberInput" name="phone_number" value="<?php echo esc_attr($user_data['phone_number']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Endereço de Email</label>
                                        <input type="email" class="form-control" id="emailInput" value="<?php echo esc_attr($user_data['email']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="walletIdInput" class="form-label">ID da Carteira (Asaas)</label>
                                        <input type="text" class="form-control" id="walletIdInput" name="wallet_id" value="<?php echo esc_attr($user_data['wallet_id']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane <?php echo $active_tab === 'changePassword' ? 'active show' : ''; ?>" id="changePassword" role="tabpanel">
                        <form method="post" action="">
                            <?php wp_nonce_field('change_password', 'change_password_nonce'); ?>
                            <div class="row g-2">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="oldpasswordInput" class="form-label">Senha Antiga*</label>
                                        <input type="password" class="form-control" id="oldpasswordInput" name="old_password" placeholder="Digite a senha atual">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="newpasswordInput" class="form-label">Nova Senha*</label>
                                        <input type="password" class="form-control" id="newpasswordInput" name="new_password" placeholder="Digite a nova senha">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="confirmpasswordInput" class="form-label">Confirmar Nova Senha*</label>
                                        <input type="password" class="form-control" id="confirmpasswordInput" name="confirm_password" placeholder="Confirme a nova senha">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">Mudar Senha</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end tab-pane-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const profileImgInput = document.getElementById('profile-img-file-input');
    profileImgInput.addEventListener('change', function () {
        const form = document.getElementById('upload-profile-image-form');
        if (profileImgInput.files.length > 0) {
            form.submit();
        }
    });
});
</script>
