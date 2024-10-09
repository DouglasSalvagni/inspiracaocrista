<?php

// Adiciona um intervalo personalizado de 30 segundos ao cron
// add_filter('cron_schedules', 'custom_cron_schedules');

// function custom_cron_schedules($schedules) {
//     $schedules['every_thirty_seconds'] = array(
//         'interval' => 30, // Intervalo em segundos
//         'display' => __('Every Thirty Seconds')
//     );
//     return $schedules;
// }

// Desagendar o cron job existente
// if (wp_next_scheduled('archive_old_notifications')) {
//     wp_clear_scheduled_hook('archive_old_notifications');
// }

// Agendar o cron job com a recorrência personalizada
if (!wp_next_scheduled('archive_old_notifications')) {
    wp_schedule_event(time(), 'daily', 'archive_old_notifications');
    error_log('Cron job scheduled: ' . current_time('mysql', 1));
}

add_action('archive_old_notifications', ['Notification_Manager', 'archive_old_notifications']);
?>
