<?php

class User_Leads extends Base_Page
{
    private int $user_id;
    private int $user_team_id;
    private string $type_entity;
    private bool $allow_pick_user = false;
    private bool $is_global = false;
    private $scope; // 'global', 'team', or 'personal'

    public function __construct($user_id = NULL, $type_entity = '', $scope = 'personal', $allow_pick_user = false)
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));
        
        $this->add_style('custom.css', get_template_directory_uri() . '/assets/css/custom.css', [], false, 'all', 40);

        $this->add_script('jquery-mask', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true);
        $this->add_script('masks', get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true);
        $this->add_script('custom-drag-drop', get_template_directory_uri() . '/assets/js/custom-drag-drop.js', ['jquery', 'jquery-ui-core'], null, true);

        global $user_info;

        if ($user_id && is_int($user_id)) {
            $user_info = User_Info::get_instance($user_id);
            $this->user_id = $user_info->get_user_id();
            $this->user_team_id = $user_info->get_team_id();
        } else {
            $this->user_id = $user_info->get_user_id();
            $this->user_team_id = $user_info->get_team_id();
        }

        $this->scope = $scope;

        if ($scope == 'global') {
            $this->is_global = true;
        }

        $this->type_entity = $type_entity;
        $this->allow_pick_user = $allow_pick_user;

        $this->handle_form_options();
    }

    private function handle_form_options()
    {
        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

        //verificar se usuário é do time


        $type_entity = isset($_GET['type_entity']) ? $_GET['type_entity'] : null;

        if ($user_id && $this->allow_pick_user) {
            $this->user_id = $user_id;
            $this->scope = 'personal';
        }

        if ($type_entity) {
            $this->type_entity = $type_entity;
        }
    }

    private function sort_leads_by_priority($leads)
    {
        $priority_order = array_flip(array_keys(Lead_Meta::get_priority_options()));

        usort($leads, function ($a, $b) use ($priority_order) {
            $priority_a = isset($priority_order[$a['priority']]) ? $priority_order[$a['priority']] : PHP_INT_MAX;
            $priority_b = isset($priority_order[$b['priority']]) ? $priority_order[$b['priority']] : PHP_INT_MAX;
            return $priority_b <=> $priority_a;
        });

        return $leads;
    }

    public function render()
    {
        $leads = $this->get_user_leads($this->user_id);
        $team_users = $this->get_team_users($this->user_id);

        // Agrupar os leads por status
        $grouped_leads = [];
        foreach ($leads as $lead) {
            $status = $lead['status'];
            if (!isset($grouped_leads[$status])) {
                $grouped_leads[$status] = [];
            }
            $grouped_leads[$status][] = $lead;
        }

        // Ordenar os leads por prioridade dentro de cada status
        foreach ($grouped_leads as $status => $leads) {
            $grouped_leads[$status] = $this->sort_leads_by_priority($leads);
        }

        // Passar variáveis para a view
        $vars = [
            'page_instance'   => $this,
            'leads'           => $leads,
            'team_users'      => $team_users,
            'grouped_leads'   => $grouped_leads,
            'status_options'  => Lead_Meta::get_status_options(),
            'status_classes'  => array_map([Lead_Meta::class, 'get_status_class'], array_keys(Lead_Meta::get_status_options())),
            'allow_pick_user' => $this->allow_pick_user,
        ];

        // Renderizar a view específica
        $this->render_view('pages/user-leads', $vars);
    }

    private function get_team_users()
    {
        $args = [
            'role__not_in' => ['administrator'],
        ];

        if ($this->scope !== 'global' && !$this->user_has_role(['administrator', 'diretoria'])) {
            $args['meta_query'] = [
                [
                    'key'     => 'team_id',
                    'value'   => $this->user_team_id,
                    'compare' => '='
                ]
            ];
        }

        return get_users($args);
    }


    private function get_user_leads()
    {
        $args = [
            'post_type'      => 'leads',
            'meta_query'     => [
                'relation' => 'AND',
            ],
            'posts_per_page' => -1
        ];

        if ($this->scope == 'personal') {
            // Obter o team_id do usuário atual
            $user_team_id = $this->get_user_team_id($this->user_id);

            // Construir a meta_query para filtrar por usuário ou time
            $user_or_team_query = [
                'relation' => 'AND',
                [
                    'key'     => 'lead_assigned_to',
                    'value'   => $this->user_id,
                    'compare' => '='
                ]
            ];

            if ($user_team_id) {
                $user_or_team_query[] = [
                    'key'     => 'assigned_team_id',
                    'value'   => $user_team_id,
                    'compare' => '='
                ];
            }

            $args['meta_query'][] = $user_or_team_query;
        }

        if ($this->scope == 'team') {

            // Obter o team_id do usuário atual
            $user_team_id = $this->get_user_team_id($this->user_id);

            $args['meta_query'][] = [
                'key'     => 'assigned_team_id',
                'value'   => $user_team_id,
                'compare' => '='
            ];
        }

        if ($this->type_entity) {
            $args['meta_query'][] = [
                'key'     => 'lead_type',
                'value'   => $this->type_entity,
                'compare' => '='
            ];
        }

        $query = new WP_Query($args);
        $leads = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $leads[] = [
                    'ID'                       => get_the_ID(),
                    'title'                    => get_the_title(),
                    'lead_status'              => get_post_meta(get_the_ID(), 'lead_status', true),
                    'lead_phone'               => get_post_meta(get_the_ID(), 'lead_phone', true),
                    'lead_phone_2'             => get_post_meta(get_the_ID(), 'lead_phone_2', true),
                    'deal_value'               => get_post_meta(get_the_ID(), 'deal_value', true),
                    'status'                   => get_post_meta(get_the_ID(), 'lead_status', true),
                    'lead_tags'                => get_post_meta(get_the_ID(), 'lead_tags', true),
                    'company'                  => get_post_meta(get_the_ID(), 'lead_company', true),
                    'next_action_description'  => get_post_meta(get_the_ID(), 'next_action_description', true),
                    'date'                     => get_the_date('Y-m-d H:i:s'),
                    'priority'                 => get_post_meta(get_the_ID(), 'lead_priority', true)
                ];
            }
            wp_reset_postdata();
        }

        return $leads;
    }
}
