<?php

class Notification_Renderer {
    private $user_id;

    public function __construct($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * Get the latest 20 notifications.
     * 
     * @return array List of notifications.
     */
    public function get_latest_notifications() {
        return Notification_Manager::get_user_notifications($this->user_id, 'all', 20);
    }

    /**
     * Count the unread notifications from the latest 20.
     * 
     * @return int The count of unread notifications.
     */
    public function count_unread_notifications() {
        $notifications = $this->get_latest_notifications();
        $unread_count = 0;

        foreach ($notifications as $notification) {
            if ($notification->status == 'unread') {
                $unread_count++;
            }
        }

        return $unread_count;
    }

    /**
     * Render the notifications.
     */
    public function render() {
        $notifications = $this->get_latest_notifications();
        $unread_count = $this->count_unread_notifications();

        // Pass variables to the view
        $vars = [
            'notifications' => $notifications,
            'unread_count' => $unread_count,
        ];

        // Render the view
        $this->render_view('components/notifications', $vars);
    }

    /**
     * Render a view.
     * 
     * @param string $view_name The name of the view file.
     * @param array $vars Variables to pass to the view.
     */
    private function render_view($view_name, $vars = []) {
        $view_path = get_template_directory() . '/views/' . $view_name . '.php';

        if (file_exists($view_path)) {
            extract($vars);
            include $view_path;
        } else {
            echo '<!-- View not found: ' . esc_html($view_path) . ' -->';
        }
    }
}

?>
