<?php

class User_Dropdown
{
    private $user_id;
    private $data_collector;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->data_collector = new Performance_Data_Collector($user_id);
    }

    /**
     * Render the notifications.
     */
    public function render()
    {

        $profile_image_id = get_user_meta($this->user_id, 'profile_image', true);
        $avatar_url = $profile_image_id ? wp_get_attachment_url($profile_image_id) : get_avatar_url($this->user_id);
        $first_name = get_user_meta($this->user_id, 'first_name', true);

        // Pass variables to the view
        $vars = [
            'avatar_url' => $avatar_url,
            'first_name' => $first_name,
            'cumulative_commission' => $this->data_collector->get_cumulative_commission(),
            'monthly_paid_commission' => $this->data_collector->get_monthly_paid_commission()
        ];

        // Render the view
        $this->render_view('components/user-dropdown', $vars);
    }

    private function get_cumulative_commission()
    {
        $cached_value = get_transient('cumulative_commission_' . $this->user_id);
        if ($cached_value !== false) {
            //return $cached_value;
        }

        // Consulta para obter a soma das comissões acumuladas
        $query = new Base_Query('sales');
        $results = $query->get_results([
            'where' => "sale_status = 'PAYMENT_CONFIRMED' AND sale_vendor_id = {$this->user_id}"
        ])->results;

        $total_commission = 0;
        foreach ($results as $result) {
            $total_commission += (float) $result->sale_amount;
        }

        set_transient('cumulative_commission_' . $this->user_id, $total_commission, HOUR_IN_SECONDS);
        return $total_commission;
    }


    private function get_monthly_paid_commission()
    {
        $cached_value = get_transient('monthly_paid_commission_' . $this->user_id);
        if ($cached_value !== false) {
            // //return $cached_value;
        }

        // Consulta para obter a soma das comissões pagas no mês atual
        $current_month = date('Y-m');
        $query = new Base_Query('sales');
        $results = $query->get_results([
            'where' => "sale_status = 'PAYMENT_RECEIVED' AND sale_received LIKE '{$current_month}%' AND sale_vendor_id = {$this->user_id}"
        ])->results;

        $total_commission = 0;
        foreach ($results as $result) {
            $total_commission += (float) $result->sale_amount;
        }

        set_transient('monthly_paid_commission_' . $this->user_id, $total_commission, HOUR_IN_SECONDS);
        return $total_commission;
    }

    /**
     * Render a view.
     * 
     * @param string $view_name The name of the view file.
     * @param array $vars Variables to pass to the view.
     */
    private function render_view($view_name, $vars = [])
    {
        $view_path = get_template_directory() . '/views/' . $view_name . '.php';

        if (file_exists($view_path)) {
            extract($vars);
            include $view_path;
        } else {
            echo '<!-- View not found: ' . esc_html($view_path) . ' -->';
        }
    }
}
