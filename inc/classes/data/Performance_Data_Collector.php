<?php

class Performance_Data_Collector
{
    private $user_id;
    private $user_team_id;
    private $scope; // 'global', 'team', or 'personal'

    public function __construct($user_id = NULL, $scope = 'personal')
    {
        $this->scope = $scope;

        if ($scope == 'global') {
            $this->user_id = null;
            $this->user_team_id = null;
        } else {
            if ($user_id && is_int($user_id)) {
                $this->user_id = $user_id;
            } else {
                $this->user_id = get_current_user_id();
            }
            $this->user_team_id = $this->get_user_team_id();
        }
    }

    public function get_user_team_id()
    {
        $team_id = get_user_meta($this->user_id, 'team_id', true);

        return $team_id ? intval($team_id) : null;
    }

    private function get_cache_key($key_base)
    {
        switch ($this->scope) {
            case 'global':
                return 'global_' . $key_base;
            case 'team':
                return 'team_' . $this->user_team_id . '_' . $key_base;
            case 'personal':
                return 'user_' . $this->user_id . '_' . $key_base;
        }
    }

    public function get_user_leads_count()
    {
        $cache_key = $this->get_cache_key('leads_count');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        // Build query
        $args = [
            'post_type' => 'leads',
            'posts_per_page' => -1
        ];

        if ($this->scope == 'team') {
            $args['meta_query'] = [
                [
                    'key' => 'assigned_team_id',
                    'value' => $this->user_team_id,
                    'compare' => '='
                ]
            ];
        } elseif ($this->scope == 'personal') {
            $args['meta_query'] = [
                [
                    'key' => 'lead_assigned_to',
                    'value' => $this->user_id,
                    'compare' => '='
                ]
            ];
        }

        $query = new WP_Query($args);
        $count = $query->found_posts;

        set_transient($cache_key, $count, HOUR_IN_SECONDS);

        return $count;
    }

    public function get_user_potential_sales()
    {
        $cache_key = $this->get_cache_key('potential_sales');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        // Build query
        $args = [
            'post_type' => 'leads',
            'posts_per_page' => -1
        ];

        if ($this->scope == 'team') {
            $args['meta_query'] = [
                [
                    'key' => 'assigned_team_id',
                    'value' => $this->user_team_id,
                    'compare' => '='
                ]
            ];
        } elseif ($this->scope == 'personal') {
            $args['meta_query'] = [
                [
                    'key' => 'lead_assigned_to',
                    'value' => $this->user_id,
                    'compare' => '='
                ]
            ];
        }

        $query = new WP_Query($args);
        $total_value = 0;

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $deal_value = get_post_meta(get_the_ID(), 'deal_value', true);
                $total_value += floatval($deal_value);
            }
            wp_reset_postdata();
        }

        set_transient($cache_key, $total_value, HOUR_IN_SECONDS);

        return $total_value;
    }

    public function get_cumulative_commission()
    {
        $cache_key = $this->get_cache_key('cumulative_commission');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        // Build where clause
        $where_clauses = ["sale_status = 'PAYMENT_CONFIRMED'"];

        if ($this->scope == 'team') {
            $where_clauses[] = "sale_team_id = {$this->user_team_id}";
        } elseif ($this->scope == 'personal') {
            $where_clauses[] = "sale_vendor_id = {$this->user_id}";
        }

        $where = implode(' AND ', $where_clauses);

        $query = new Base_Query('sales');
        $results = $query->get_results([
            'where' => $where
        ])->results;

        $total_commission = 0;
        foreach ($results as $result) {
            $total_commission += (float) $result->sale_amount;
        }

        set_transient($cache_key, $total_commission, HOUR_IN_SECONDS);

        return $total_commission;
    }

    public function get_monthly_paid_commission()
    {
        $cache_key = $this->get_cache_key('monthly_paid_commission');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        // Build where clause
        $current_month = date('Y-m');
        $where_clauses = ["sale_status = 'PAYMENT_RECEIVED'", "sale_received LIKE '{$current_month}%'"];

        if ($this->scope == 'team') {
            $where_clauses[] = "sale_team_id = {$this->user_team_id}";
        } elseif ($this->scope == 'personal') {
            $where_clauses[] = "sale_vendor_id = {$this->user_id}";
        }

        $where = implode(' AND ', $where_clauses);

        $query = new Base_Query('sales');
        $results = $query->get_results([
            'where' => $where
        ])->results;

        $total_commission = 0;
        foreach ($results as $result) {
            $total_commission += (float) $result->sale_amount;
        }

        set_transient($cache_key, $total_commission, HOUR_IN_SECONDS);

        return $total_commission;
    }

    public function get_monthly_sales_count()
    {
        $cache_key = $this->get_cache_key('monthly_sales_count');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        // Build where clause
        $current_month = date('Y-m');
        $where_clauses = ["sale_date LIKE '{$current_month}%'"];

        if ($this->scope == 'team') {
            $where_clauses[] = "sale_team_id = {$this->user_team_id}";
        } elseif ($this->scope == 'personal') {
            $where_clauses[] = "sale_vendor_id = {$this->user_id}";
        }

        $where = implode(' AND ', $where_clauses);

        $query = new Base_Query('sales');
        $results = $query->get_results([
            'where' => $where
        ])->results;

        $sales_count = count($results);

        set_transient($cache_key, $sales_count, HOUR_IN_SECONDS);

        return $sales_count;
    }

    public function get_user_leads()
    {
        $cache_key = $this->get_cache_key('priority_leads');
        $cached_leads = get_transient($cache_key);

        if ($cached_leads !== false) {
            return $cached_leads;
        }

        $args = [
            'post_type' => 'leads',
            'orderby' => 'modified',
            'order' => 'ASC', // Ordena do mais antigo ao mais recente
            'posts_per_page' => -1  // Retrieve all leads first
        ];

        if ($this->scope == 'team') {
            $args['meta_query'] = [
                [
                    'key' => 'assigned_team_id',
                    'value' => $this->user_team_id,
                    'compare' => '='
                ]
            ];
        } elseif ($this->scope == 'personal') {
            $args['meta_query'] = [
                [
                    'key' => 'lead_assigned_to',
                    'value' => $this->user_id,
                    'compare' => '='
                ]
            ];
        }

        $query = new WP_Query($args);
        $leads = $query->posts;

        $leads = array_slice($leads, 0, 7);  // Limit to the first 7 leads after sorting

        set_transient($cache_key, $leads, HOUR_IN_SECONDS);  // Cache for 1 hour

        return $leads;
    }

    public function get_daily_sales_data()
    {
        $cache_key = $this->get_cache_key('daily_sales_data');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        $daily_sales_data = [];
        $query = new Base_Query('sales');

        for ($i = 0; $i < 10; $i++) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $where_clauses = ["sale_date LIKE '{$date}%'"];

            if ($this->scope == 'team') {
                $where_clauses[] = "sale_team_id = {$this->user_team_id}";
            } elseif ($this->scope == 'personal') {
                $where_clauses[] = "sale_vendor_id = {$this->user_id}";
            }

            $where = implode(' AND ', $where_clauses);

            $results = $query->get_results([
                'where' => $where
            ])->results;

            $daily_sales_data[$date] = count($results);
        }

        $daily_sales_data = array_reverse($daily_sales_data);

        set_transient($cache_key, $daily_sales_data, HOUR_IN_SECONDS);
        return $daily_sales_data;
    }

    public function get_daily_leads_data()
    {
        $cache_key = $this->get_cache_key('daily_leads_data');
        $cached_value = get_transient($cache_key);

        if ($cached_value !== false) {
            return $cached_value;
        }

        $daily_leads_data = [];
        $query = new WP_Query();

        for ($i = 0; $i < 10; $i++) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $args = [
                'post_type' => 'leads',
                'date_query' => [
                    [
                        'after' => $date,
                        'before' => $date,
                        'inclusive' => true
                    ]
                ],
                'posts_per_page' => -1
            ];

            if ($this->scope == 'team') {
                $args['meta_query'] = [
                    [
                        'key' => 'assigned_team_id',
                        'value' => $this->user_team_id,
                        'compare' => '='
                    ]
                ];
            } elseif ($this->scope == 'personal') {
                $args['meta_query'] = [
                    [
                        'key' => 'lead_assigned_to',
                        'value' => $this->user_id,
                        'compare' => '='
                    ]
                ];
            }

            $query->query($args);
            $daily_leads_data[$date] = $query->found_posts;
        }

        $daily_leads_data = array_reverse($daily_leads_data);

        set_transient($cache_key, $daily_leads_data, HOUR_IN_SECONDS);
        return $daily_leads_data;
    }

    public function get_conversion_rate()
    {
        $cache_key = $this->get_cache_key('conversion_rate');
        $cached_value = get_transient($cache_key);

        // if ($cached_value !== false) {
        //     return $cached_value;
        // }

        // Current month
        $current_month = date('Y-m');

        // Get the number of leads assigned in the current month
        $leads_args = [
            'post_type' => 'leads',
            'date_query' => [
                [
                    'after' => $current_month . '-01',
                    'before' => date('Y-m-t'), // Last day of the current month
                    'inclusive' => true
                ]
            ],
            'posts_per_page' => -1
        ];

        if ($this->scope == 'team') {
            $leads_args['meta_query'] = [
                [
                    'key' => 'assigned_team_id',
                    'value' => $this->user_team_id,
                    'compare' => '='
                ]
            ];
        } elseif ($this->scope == 'personal') {
            $leads_args['meta_query'] = [
                [
                    'key' => 'lead_assigned_to',
                    'value' => $this->user_id,
                    'compare' => '='
                ]
            ];
        }

        $leads_query = new WP_Query($leads_args);
        $leads_count = $leads_query->found_posts;

        // Get the number of archived leads created in the current month
        global $wpdb;
        $archived_leads_count = 0;

        if ($this->scope == 'global') {
            $archived_leads_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->prefix}leads_archived WHERE DATE_FORMAT(created_at, '%%Y-%%m') = %s",
                    $current_month
                )
            );
        } elseif ($this->scope == 'team') {
            $archived_leads_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->prefix}leads_archived WHERE DATE_FORMAT(created_at, '%%Y-%%m') = %s AND assigned_team_id = %d",
                    $current_month,
                    $this->user_team_id
                )
            );
        } else { // 'personal'
            $archived_leads_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$wpdb->prefix}leads_archived WHERE DATE_FORMAT(created_at, '%%Y-%%m') = %s AND lead_assigned_to = %d",
                    $current_month,
                    $this->user_id
                )
            );
        }

        // Total leads count (active + archived)
        $total_leads_count = $leads_count + $archived_leads_count;

        // Get the number of sales in the current month
        $sales_query = new Base_Query('sales');

        $where_clauses = ["sale_status = 'PAYMENT_CONFIRMED'", "sale_date LIKE '{$current_month}%'"];

        if ($this->scope == 'team') {
            $where_clauses[] = "sale_team_id = {$this->user_team_id}";
        } elseif ($this->scope == 'personal') {
            $where_clauses[] = "sale_vendor_id = {$this->user_id}";
        }

        $where = implode(' AND ', $where_clauses);

        $sales_results = $sales_query->get_results([
            'where' => $where
        ])->results;

        $sales_count = count($sales_results);

        // Calculate conversion rate
        $conversion_rate = 0;
        if ($total_leads_count > 0) {
            $conversion_rate = ($sales_count / $total_leads_count) * 100;
            $conversion_rate = round($conversion_rate); // Round to the nearest integer
        }

        // Cache the result
        set_transient($cache_key, $conversion_rate, HOUR_IN_SECONDS);

        return $conversion_rate;
    }

    /**
     * Clean data cache related to user
     */
    public static function clear_personal_transients($user_id)
    {
        // Transients that need to be cleared
        $transients = [
            'user_' . $user_id . '_leads_count',
            'user_' . $user_id . '_potential_sales',
            'user_' . $user_id . '_cumulative_commission',
            'user_' . $user_id . '_monthly_paid_commission',
            'user_' . $user_id . '_monthly_sales_count',
            'user_' . $user_id . '_daily_sales_data',
            'user_' . $user_id . '_daily_leads_data',
            'user_' . $user_id . '_priority_leads',
            'user_' . $user_id . '_conversion_rate',
        ];

        // Deleting each transient
        foreach ($transients as $transient) {
            delete_transient($transient);
        }
    }

    /**
     * Clean data cache related to a team
     */
    public static function clear_team_transients($team_id)
    {
        // Transients that need to be cleared
        $transients = [
            'team_' . $team_id . '_leads_count',
            'team_' . $team_id . '_potential_sales',
            'team_' . $team_id . '_cumulative_commission',
            'team_' . $team_id . '_monthly_paid_commission',
            'team_' . $team_id . '_monthly_sales_count',
            'team_' . $team_id . '_daily_sales_data',
            'team_' . $team_id . '_daily_leads_data',
            'team_' . $team_id . '_priority_leads',
            'team_' . $team_id . '_conversion_rate',
        ];

        // Deleting each transient
        foreach ($transients as $transient) {
            delete_transient($transient);
        }
    }

    /**
     * Clean all personal data cache for all users
     */
    public static function clear_all_personal_transients()
    {
        global $wpdb;
        // Get all transient keys that match 'user_*'
        $transient_names = $wpdb->get_col(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_user_%' OR option_name LIKE '_transient_timeout_user_%'"
        );

        foreach ($transient_names as $option_name) {
            // Extract the transient key
            $transient_key = str_replace(['_transient_', '_transient_timeout_'], '', $option_name);
            delete_transient($transient_key);
        }
    }

    /**
     * Clean all team data cache for all teams
     */
    public static function clear_all_team_transients()
    {
        global $wpdb;
        // Get all transient keys that match 'team_*'
        $transient_names = $wpdb->get_col(
            "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_team_%' OR option_name LIKE '_transient_timeout_team_%'"
        );

        foreach ($transient_names as $option_name) {
            // Extract the transient key
            $transient_key = str_replace(['_transient_', '_transient_timeout_'], '', $option_name);
            delete_transient($transient_key);
        }
    }


    /**
     * Clean global data cache
     */
    public static function clear_global_transients()
    {
        // Global transients that need to be cleared
        $global_transients = [
            'global_leads_count',
            'global_potential_sales',
            'global_cumulative_commission',
            'global_monthly_paid_commission',
            'global_monthly_sales_count',
            'global_daily_sales_data',
            'global_daily_leads_data',
            'global_conversion_rate',
            'global_priority_leads',
        ];

        // Deleting each global transient
        foreach ($global_transients as $transient) {
            delete_transient($transient);
        }
    }
}
