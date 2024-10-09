<?php

/**
 * Class Notification_Manager
 * 
 * This class handles the creation and management of notifications.
 */
class Notification_Manager
{
    /**
     * Adds a new notification to the database.
     * 
     * @param int $user_id The ID of the user to whom the notification is assigned.
     * @param string $name The name of the notification.
     * @param string $message The message of the notification.
     * @param string $type The type of the notification (e.g., 'lead', 'assinantes').
     * @param string $origin_type The type of the entity that originated the notification (e.g., 'post', 'lead').
     * @param int $origin_id The ID of the entity that originated the notification.
     * @return bool True on success, false on failure.
     */
    public static function add_notification($user_id, $name, $message, $type = '', $origin_type = '', $origin_id = 0)
    {
        // Verifica se o usuário existe
        if (!get_userdata($user_id)) {
            return false;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        $result = $wpdb->insert(
            $table_name,
            [
                'user_id' => $user_id,
                'name' => $name,
                'message' => $message,
                'type' => $type,
                'origin_type' => $origin_type,
                'origin_id' => $origin_id,
                'status' => 'unread',
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ]
        );

        return $result !== false;
    }

    /**
     * Gets notifications for a specific user.
     * 
     * @param int $user_id The ID of the user.
     * @param string $status The status of the notifications ('unread', 'read', or 'all').
     * @param int $limit The number of notifications to retrieve.
     * @param int $offset The offset for pagination.
     * @return array|object|null List of notifications or null on failure.
     */
    public static function get_user_notifications($user_id, $status = 'all', $limit = 20, $offset = 0)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        $query = "SELECT * FROM $table_name WHERE user_id = %d";

        if ($status != 'all') {
            $query .= $wpdb->prepare(" AND status = %s", $status);
        }

        $query .= $wpdb->prepare(" ORDER BY created_at DESC LIMIT %d OFFSET %d", $limit, $offset);

        return $wpdb->get_results($wpdb->prepare($query, $user_id));
    }

    /**
     * Marks a notification as read.
     * 
     * @param int $notification_id The ID of the notification.
     * @return bool True on success, false on failure.
     */
    public static function mark_as_read($notification_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        $result = $wpdb->update(
            $table_name,
            ['status' => 'read', 'updated_at' => current_time('mysql')],
            ['id' => $notification_id]
        );

        return $result !== false;
    }

    /**
     * Deletes a notification.
     * 
     * @param int $notification_id The ID of the notification.
     * @return bool True on success, false on failure.
     */
    public static function delete_notification($notification_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        $result = $wpdb->delete(
            $table_name,
            ['id' => $notification_id]
        );

        return $result !== false;
    }

    /**
     * Gets the count of unread notifications for a specific user.
     * 
     * @param int $user_id The ID of the user.
     * @return int The count of unread notifications.
     */
    public static function get_unread_count($user_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        return (int) $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND status = 'unread' LIMIT 20", $user_id)
        );
    }

    /**
     * Marks all notifications as read for a specific user.
     * 
     * @param int $user_id The ID of the user.
     * @return bool True on success, false on failure.
     */
    public static function mark_all_as_read($user_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';

        $result = $wpdb->update(
            $table_name,
            ['status' => 'read', 'updated_at' => current_time('mysql')],
            ['user_id' => $user_id, 'status' => 'unread']
        );

        return $result !== false;
    }

    /**
     * Archives old notifications after a certain period.
     */
    public static function archive_old_notifications()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';
        $archived_table_name = $wpdb->prefix . 'notifications_archived';

        $current_time = current_time('mysql');
        $threshold_time = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($current_time)));

        $old_notifications = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $table_name WHERE created_at < %s", $threshold_time)
        );

        foreach ($old_notifications as $notification) {
            $inserted = $wpdb->insert(
                $archived_table_name,
                [
                    'original_id' => $notification->id,
                    'user_id' => $notification->user_id,
                    'name' => $notification->name,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'origin_type' => $notification->origin_type,
                    'origin_id' => $notification->origin_id,
                    'status' => $notification->status,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at
                ]
            );

            if ($inserted) {
                $wpdb->delete($table_name, ['id' => $notification->id]);
            }
        }
    }

    /**
     * Handles the AJAX request to delete notifications.
     */
    public static function handle_delete_notifications()
    {
        // Verifica o nonce para segurança
        check_ajax_referer('delete_notification_nonce', 'nonce');

        // Verifica se o usuário está logado
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'Unauthorized']);
            wp_die();
        }

        // Recupera os IDs das notificações a serem deletadas
        $notification_ids = isset($_POST['notification_ids']) ? $_POST['notification_ids'] : [];

        if (empty($notification_ids)) {
            wp_send_json_error(['message' => 'Nenhuma notificação selecionada']);
            wp_die();
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'notifications';
        $archived_table_name = $wpdb->prefix . 'notifications_archived';

        // Arquiva e deleta as notificações
        foreach ($notification_ids as $id) {
            // Obter notificação original
            $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

            if ($notification) {
                // Inserir na tabela de arquivados
                $inserted = $wpdb->insert(
                    $archived_table_name,
                    [
                        'original_id' => $notification->id,
                        'user_id' => $notification->user_id,
                        'name' => $notification->name,
                        'message' => $notification->message,
                        'type' => $notification->type,
                        'origin_type' => $notification->origin_type,
                        'origin_id' => $notification->origin_id,
                        'status' => $notification->status,
                        'created_at' => $notification->created_at,
                        'updated_at' => $notification->updated_at
                    ]
                );

                // Deletar da tabela original se inserido na tabela de arquivados
                if ($inserted) {
                    $wpdb->delete($table_name, ['id' => $notification->id]);
                }
            }
        }

        wp_send_json_success(['message' => 'Notificações deletadas']);
        wp_die();
    }

    /**
     * Handles the AJAX request to mark a notification as read.
     */
    public static function handle_mark_as_read()
    {
        // Verifica o nonce para segurança
        check_ajax_referer('mark_as_read_nonce', 'nonce');

        // Verifica se o usuário está logado
        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'Unauthorized']);
            wp_die();
        }

        // Recupera o ID da notificação a ser marcada como lida
        $notification_id = isset($_POST['notification_id']) ? intval($_POST['notification_id']) : 0;

        if ($notification_id === 0) {
            wp_send_json_error(['message' => 'Invalid notification ID']);
            wp_die();
        }

        // Marca a notificação como lida
        $marked_as_read = self::mark_as_read($notification_id);

        if ($marked_as_read) {
            wp_send_json_success(['message' => 'Notification marked as read']);
        } else {
            wp_send_json_error(['message' => 'Failed to mark notification as read']);
        }

        wp_die();
    }
}
