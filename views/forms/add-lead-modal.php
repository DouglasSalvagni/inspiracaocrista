<?php

/**
 * Template: Add Lead Modal Form
 * 
 * @param int $user_id
 * @param int $team_id
 */
?>

<form method="post" action="" id="add-lead-simplificado-form">
    <div class="row gy-4">
        <?php wp_nonce_field('add_lead_simplificado', 'add_lead_simplificado'); ?>
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="team_id" value="<?= $team_id ?>">

        <h5 class="fs-14 mb-3">Dados do Lead</h5>

        <div class="col-md-4">
            <label for="lead_name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="lead_nome" name="lead_name">
        </div>

        <div class="col-md-4">
            <label for="lead_phone" class="form-label">Telefone</label>
            <input type="text" class="form-control phone-ddd-mask" id="lead_phone" name="lead_phone">
        </div>

        <div class="col-md-4">
            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Adicionar Lead</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    (function($) {
        $('.phone-ddd-mask').mask('(00) 0000-00000');

        $('#cpf_cnpj').on('input', function() {
            var inputLength = $(this).val().replace(/\D/g, '').length;

            if (inputLength < 11) {
                // Aplica a máscara de CPF (11 dígitos)
                $(this).mask('000.000.000-000');
            } else {
                // Aplica a máscara de CNPJ (14 dígitos)
                $(this).mask('00.000.000/0000-00');
            }
        });

        $(document).ready(function() {
            $('#add-lead-simplificado-form').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: sysUrls.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'add_lead_simpificado',
                        form_data: formData
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Dados atualizados com sucesso!');
                            $('#modalFooter').modal('hide');
                            window.location.reload();
                        } else {
                            alert('Erro ao atualizar os dados: ' + response.data);
                        }
                    },
                    error: function() {
                        alert('Erro ao enviar o formulário.');
                    }
                });
            });
        });
    })(jQuery);
</script>