<?php
// Função para processar notificações do ASAAS
function process_asaas_webhook(WP_REST_Request $request)
{
    $body = $request->get_body();
    $event = json_decode($body);

    if ($event) {
        switch ($event->event) {
            case 'PAYMENT_CONFIRMED':
                handle_payment_confirmed($event);
                break;
            case 'PAYMENT_RECEIVED':
                handle_payment_received($event);
                break;
            case 'PAYMENT_FAILED':
                handle_payment_failed($event);
                break;
            case 'PAYMENT_OVERDUE':
                handle_subscription_overdue($event);
                break;
            // case 'SUBSCRIPTION_UPDATED':
            //     handle_subscription_updated($event);
            //     break;
            // case 'SUBSCRIPTION_CANCELED':
            //     handle_subscription_canceled($event);
            //     break;
            // case 'CUSTOMER_UPDATED':
            //     handle_customer_updated($event);
            //     break;
            // case 'CUSTOMER_DELETED':
            //     handle_customer_deleted($event);
            //     break;
        }
    }

    return new WP_REST_Response('Webhook processed', 200);
}
// Registrar o endpoint do webhook
add_action('rest_api_init', function () {
    register_rest_route(
        'asaas/v1',
        '/webhook',
        array(
            'methods' => 'POST',
            'callback' => 'process_asaas_webhook',
        )
    );
});

function handle_payment_confirmed($event)
{
    $subscriptionId = sanitize_text_field($event->payment->subscription);

    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes';

    // Verificar se o split já foi removido
    $split_removed = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT split_removed FROM $table_name WHERE asaas_subscription_id = %s LIMIT 1",
            $subscriptionId
        )
    );

    if (!$split_removed) {
        // Remover o split se ainda não foi removido
        $split_removed_success = remove_split_from_subscription($subscriptionId);

        if ($split_removed_success) {
            // Marcar o split como removido no banco de dados
            $wpdb->update(
                $table_name,
                array('split_removed' => 1),
                array('asaas_subscription_id' => $subscriptionId),
                array('%d'),
                array('%s')
            );
        }
    }

    // Atualizar status da assinatura para "Ativa" caso esteja "Suspensa"
    update_subscription_status($subscriptionId, 'ACTIVE');
    // Atualizar status da venda para "PAYMENT_CONFIRMED"
    update_sale_status($subscriptionId, $event->event, $event->payment->dateCreated);
}
/**
 * Handle payment received event.
 * 
 * @param object $event The event object containing payment information.
 */
function handle_payment_received($event)
{
    $subscriptionId = sanitize_text_field($event->payment->subscription);
    $dateReceived = sanitize_text_field($event->payment->dateCreated);
    $new_status = sanitize_text_field($event->event);

    // Conectar ao banco de dados e atualizar as colunas sale_status e sale_received
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales';

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $table_name 
            SET sale_status = %s, sale_received = %s
            WHERE sale_asaas_subscription_id = %s",
            $new_status,
            $dateReceived,
            $subscriptionId
        )
    );

    $table_assinantes = $wpdb->prefix . 'assinantes';
    // Verificar se o split já foi removido
    $split_removed = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT split_removed FROM $table_assinantes WHERE asaas_subscription_id = %s LIMIT 1",
            $subscriptionId
        )
    );
    if (!$split_removed && in_array($event->payment->billingType, ['BOLETO', 'PIX'])) {
        // Remover o split se ainda não foi removido
        $split_removed_success = remove_split_from_subscription($subscriptionId);

        if ($split_removed_success) {
            // Marcar o split como removido no banco de dados
            $wpdb->update(
                $table_assinantes,
                array('split_removed' => 1),
                array('asaas_subscription_id' => $subscriptionId),
                array('%d'),
                array('%s')
            );
        }
    }

    // Atualizar status da assinatura para "Ativa" caso esteja "Suspensa"
    update_subscription_status($subscriptionId, 'ACTIVE');

    if ($wpdb->last_error) {
        error_log('Erro ao atualizar as colunas sale_status e sale_received: ' . $wpdb->last_error);
    }
}
// Handler para falha na renovação
function handle_subscription_overdue($event)
{
    if (!isset($event->payment->subscription)) {
        return;
    }
    $subscription_id = sanitize_text_field($event->payment->subscription);

    // Conexão com o banco de dados do WordPress
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes';

    // Atualiza o status da assinatura para "Suspensa"
    $wpdb->update(
        $table_name,
        array('subscription_status' => 'SUSPENDED'),
        array('asaas_subscription_id' => $subscription_id),
        array('%s'),
        array('%s')
    );

    if ($wpdb->last_error) {
        error_log('Erro ao atualizar o status da assinatura: ' . $wpdb->last_error);
    }
}
// Handler para falha no pagamento
// Falta tratar erros na aprovação do pagamento da adesão
// Falta tratar erros na aprovação do pagamento da adesão
// Falta tratar erros na aprovação do pagamento da adesão
// Falta tratar erros na aprovação do pagamento da adesão
function handle_payment_failed($event)
{
    $payment_id = $event->payment->id;
    $status = 'falhou';
    $user_id = get_user_id_by_meta('asaas_payment_id', $payment_id);

    if ($user_id) {
        update_user_meta($user_id, 'asaas_payment_status', $status);
        // Enviar notificação ao usuário
        $user_email = get_the_author_meta('user_email', $user_id);
        wp_mail($user_email, 'Falha no pagamento', 'Houve uma falha no pagamento da sua assinatura.');
    }
}

// Funções auxiliares dos webhooks
// Funções auxiliares dos webhooks
function remove_split_from_subscription($subscriptionId)
{
    try {
        // Cliente Guzzle
        $client = new \GuzzleHttp\Client();

        // Editar a assinatura para definir o array 'split' como um objeto vazio
        $editResponse = $client->request('POST', "https://api.asaas.com/v3/subscriptions/{$subscriptionId}", [
            'body' => json_encode([
                'split' => [
                    [
                        'walletId' => 'fba72e7d-7113-4384-a7a8-96eb96f8fa05',
                        'percentualValue' => 3.0
                    ]
                ]
            ]),
            'headers' => [
                'accept' => 'application/json',
                'access_token' => get_option('asaas_api_key'),
                'content-type' => 'application/json',
            ],
        ]);

        $editResult = json_decode($editResponse->getBody(), true);

        if (isset($editResult['id'])) {
            // Sucesso
            error_log('Split removed successfully for subscription: ' . $subscriptionId);
            return true;
        } else {
            // Falha
            error_log('Failed to remove split for subscription: ' . $subscriptionId);
            return false;
        }
    } catch (Exception $e) {
        error_log('Error removing split: ' . $e->getMessage());
        return false;
    }
}

function update_subscription_status($subscriptionId, $new_status)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'assinantes';

    // Atualizar status da assinatura para "Ativa" onde o status atual é "Suspensa" ou "Pendente"
    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $table_name 
            SET subscription_status = %s 
            WHERE asaas_subscription_id = %s 
            AND (subscription_status = 'SUSPENDED' OR subscription_status = 'PENDING')",
            $new_status,
            $subscriptionId
        )
    );

    if ($wpdb->last_error) {
        error_log('Erro ao atualizar o status da assinatura: ' . $wpdb->last_error);
    }
}

/**
 * Update the sale status and sale confirmed in the 'sales' table based on the subscription ID.
 * 
 * @param string $subscriptionId The subscription ID.
 * @param string $new_status The new status to be set.
 * @param string $confirmed_date The date to set in the sale_confirmed column.
 */
function update_sale_status($subscriptionId, $new_status, $confirmed_date)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales';

    // Atualizar o status da venda e a data de confirmação se o status atual for diferente de "PAYMENT_RECEIVED"
    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $table_name 
            SET sale_status = %s, sale_confirmed = %s
            WHERE sale_asaas_subscription_id = %s 
            AND sale_status != 'PAYMENT_RECEIVED'",
            $new_status,
            $confirmed_date,
            $subscriptionId
        )
    );

    if ($wpdb->last_error) {
        error_log('Erro ao atualizar o status da venda: ' . $wpdb->last_error);
    }
}
