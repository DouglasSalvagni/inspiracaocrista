<?php
if (isset($params['lead_id'])) {
    $lead_id = intval($params['lead_id']);
    $edit_lead = new Edit_lead($lead_id);

    // limpa a sessions de alerta
    Alert_Helper::clean_session();

    //renderiza o formulário
    $edit_lead->render_only_form();
} else {
    echo '<p>Lead ID not provided.</p>';
}
?>
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('#edit-lead-form').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url: sysUrls.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'submit_edit_lead',
                        lead_id: <?php echo $lead_id; ?>,
                        form_data: formData
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Dados atualizados com sucesso!');
                            $('#modalFooter').modal('hide');
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