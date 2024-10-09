<div class="row gy-4">
    <div class="col-12">
        <label for="motivo" class="form-label">Motivo</label>
        <textarea class="form-control" name="motivo" id="motivo"></textarea>
        <div id="motivo-error" class="text-danger" style="display: none;">O motivo deve ter pelo menos 20 caracteres.</div>
    </div>

    <div class="col-12">
        <button id="disqualify-lead-btn" class="btn btn-primary">Desqualificar Lead</button>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            // Evento de clique para o botão de desqualificação
            $('#disqualify-lead-btn').on('click', function(event) {
                event.preventDefault();

                // Captura o valor do textarea com o id 'motivo'
                const reason = $('#motivo').val();

                // Validação do motivo
                if (reason.length < 20) {
                    $('#motivo-error').show(); // Mostra a mensagem de erro
                    $('#motivo').addClass('is-invalid'); // Adiciona classe de erro visual
                    return; // Interrompe o envio se a validação falhar
                }

                // Remove qualquer mensagem de erro se a validação passar
                $('#motivo-error').hide();
                $('#motivo').removeClass('is-invalid');

                // Captura o lead_id e a URL de redirecionamento (se existir)
                const leadId = "<?php echo trim($params['lead_id']); ?>";
                const redirectUrl = "<?php echo isset($params['redirect_url']) ? esc_url($params['redirect_url']) : ''; ?>";

                $.ajax({
                    url: sysUrls.ajax_url,
                    method: 'POST',
                    data: {
                        action: 'submit_disqualify_lead',
                        lead_id: leadId,
                        reason: reason
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Lead desqualificado com sucesso!');

                            // Fecha o modal
                            $('#modalFooterMd').modal('hide');

                            // Se a URL de redirecionamento estiver definida, redireciona
                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                            } else {
                                // Caso contrário, remove o card correspondente
                                const cardElement = $('.card').filter(function() {
                                    return $(this).attr('data-lead-id') && $(this).attr('data-lead-id').trim() === leadId;
                                });

                                if (cardElement.length > 0) {
                                    // Adiciona a classe de chacoalhar
                                    cardElement.addClass('shake');

                                    // Após a animação de chacoalhar, faz a explosão
                                    setTimeout(function() {
                                        cardElement.addClass('explode');

                                        // Após a explosão, remove o elemento do DOM
                                        setTimeout(function() {
                                            cardElement.remove();
                                        }, 300); // Tempo para a explosão
                                    }, 1000); // Tempo para a animação de chacoalhar
                                } else {
                                    console.error('Elemento não encontrado ou não pôde ser removido.');
                                }
                            }
                        } else {
                            alert('Erro ao desqualificar o lead: ' + response.data);
                        }
                    },
                    error: function() {
                        alert('Erro ao enviar a requisição.');
                    }
                });
            });

            // Remove a classe de erro e a mensagem quando o usuário começa a digitar
            $('#motivo').on('input', function() {
                if ($(this).val().length >= 20) {
                    $('#motivo-error').hide();
                    $(this).removeClass('is-invalid');
                }
            });
        });
    })(jQuery);
</script>


<style>
    @keyframes shake {
        0% {
            transform: translate(1px, 1px) rotate(0deg);
        }

        10% {
            transform: translate(-1px, -2px) rotate(-1deg);
        }

        20% {
            transform: translate(-3px, 0px) rotate(1deg);
        }

        30% {
            transform: translate(3px, 2px) rotate(0deg);
        }

        40% {
            transform: translate(1px, -1px) rotate(1deg);
        }

        50% {
            transform: translate(-1px, 2px) rotate(-1deg);
        }

        60% {
            transform: translate(-3px, 1px) rotate(0deg);
        }

        70% {
            transform: translate(3px, 1px) rotate(-1deg);
        }

        80% {
            transform: translate(-1px, -1px) rotate(1deg);
        }

        90% {
            transform: translate(1px, 2px) rotate(0deg);
        }

        100% {
            transform: translate(1px, -2px) rotate(-1deg);
        }
    }

    .shake {
        animation: shake 0.5s;
        animation-iteration-count: 2;
    }

    @keyframes explode {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .explode {
        animation: explode 0.3s forwards;
    }
</style>