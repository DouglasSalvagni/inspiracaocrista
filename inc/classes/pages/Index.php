<?php

use function PHPSTORM_META\type;

class Index extends Base_Page
{
    private $current_user_id;
    private $data_collector;

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));

        $this->add_script('apexcharts',        get_template_directory_uri() . '/assets/libs/apexcharts/apexcharts.min.js', [], null, true, 120);
        $this->add_script('apexcharts-column', get_template_directory_uri() . '/assets/js/pages/apexcharts-column.init.js', [], null, true, 120);

        $this->current_user_id = get_current_user_id();

        if ($this->user_has_role(['diretoria', 'administrator'])) {
            $this->data_collector = new Performance_Data_Collector($this->current_user_id, 'global');
        } elseif($this->user_has_role(['gerente_comercial'])) {
            $this->data_collector = new Performance_Data_Collector($this->current_user_id, 'team');
        } else {
            $this->data_collector = new Performance_Data_Collector($this->current_user_id);
        }
    }

    public function render()
    {
        // Obtém os dados necessários para a dashboard
        $leads_count           = $this->data_collector->get_user_leads_count();
        $potential_sales       = $this->data_collector->get_user_potential_sales();
        $cumulative_commission = $this->data_collector->get_cumulative_commission();
        $monthly_sales_count   = $this->data_collector->get_monthly_sales_count();
        $daily_sales_data      = $this->data_collector->get_daily_sales_data();
        $daily_leads_data      = $this->data_collector->get_daily_leads_data();
        $user_leads            = $this->data_collector->get_user_leads();
        $conversion_rate       = $this->data_collector->get_conversion_rate();


        // Passa os dados para a view
        $vars = [
            'leads_count'           => $leads_count,
            'potential_sales'       => $potential_sales,
            'cumulative_commission' => $cumulative_commission,
            'monthly_sales_count'   => $monthly_sales_count,
            'daily_sales_data'      => $daily_sales_data,
            'daily_leads_data'      => $daily_leads_data,
            'user_leads'            => $user_leads,
            'conversion_rate'       => $conversion_rate,
        ];

        // Renderizar a view específica
        $this->render_view('pages/index', $vars);
    }
}
