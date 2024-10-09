<form method="post" action="">
    <?php wp_nonce_field('excluir_assinante', 'excluir_assinante_nonce'); ?>
    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo esc_attr($assinante_id); ?>">
    <input type="hidden" name="excluir_assinante" value="1">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmExcluirModal">Excluir assinante</button>

    <!-- Modal de Confirmação de Atualização -->
    <div class="modal fade" id="confirmExcluirModal" tabindex="-1" aria-labelledby="confirmExcluirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmExcluirModalLabel">Confirmar Exclusão</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning alert-border-left alert-dismissible fade shadow show" role="alert">
                        <i class="ri-alert-line me-3 align-middle fs-16"></i><strong>Atenção</strong>
                        - Esta ação é irreversível
                    </div>
                    Tem certeza que deseja excluir este assinante?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</form>