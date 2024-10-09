<?php

// Disponibiliza ACTION AJAX
add_action('init', ['Assinantes_Archive', 'init_actions']);

/**
 * Class Assinantes_Archive
 *
 * Esta classe é responsável pela lógica da página de assinantes.
 */
class Assinantes_Archive extends Base_Page
{
    private $query;
    private $data_collector;
    private $has_access_to_statistics;

    public function __construct()
    {
        parent::__construct();
        $this->query = new Base_Query('assinantes');

        $this->load_base_style();
        $this->load_base_scripts();

        $this->set_page_privacy([], home_url('/login'));

        $this->add_script('jquery-mask',   get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true, 10);
        $this->add_script('masks',         get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true, 20);
        $this->add_script('ajax-script',   get_template_directory_uri() . '/assets/js/assinantes.js', ['jquery'], null, true, 30);
        $this->add_script('custom-script', get_template_directory_uri() . '/assets/js/custom.js', ['jquery'], null, true, 30);

        $this->data_collector = new Assinante_Data_Collector();

        if ($this->user_has_role(['diretoria', 'administrator'])) {
            $this->has_access_to_statistics = true;
        } else {
            $this->has_access_to_statistics = false;
        }
    }

    public function render()
    {
        $total_lives_count                = $this->data_collector->get_total_lives_count();
        $total_titulares_count            = $this->data_collector->get_total_titulares_count();
        $total_dependentes_count          = $this->data_collector->get_total_dependentes_count();
        $total_subscription_monthly_value = $this->data_collector->get_total_monthly_subscription_value();
        $total_subscription_yearly_value  = $this->data_collector->get_total_yearly_subscription_value();

        // Passa os dados para a view
        $vars = [
            'page_instance'                    => $this,
            'has_access_to_statistics'         => $this->has_access_to_statistics,
            'total_lives_count'                => $total_lives_count,
            'total_titulares_count'            => $total_titulares_count,
            'total_dependentes_count'          => $total_dependentes_count,
            'total_subscription_monthly_value' => $total_subscription_monthly_value,
            'total_subscription_yearly_value'  => $total_subscription_yearly_value
        ];

        $this->render_view('pages/assinantes-archive', $vars);
    }

    public function get_assinantes($search = '', $status = '', $page = 1, $special_user)
    {
        global $wpdb;

        $where_query = [];
        $table_name = $this->query->get_table_name();
        $dependent_ids = [];

        $condition = "(cpf_cnpj LIKE %s AND entity_type NOT LIKE 'PJ')";
        if ($special_user) {
            $condition = "(name LIKE %s OR cpf_cnpj LIKE %s)";
        }

        if (!empty($search)) {
            $search_like = '%' . $wpdb->esc_like($search) . '%';
            $search_conditions = $wpdb->prepare($condition, $search_like, $search_like);

            if ($special_user) {
                // Get the ID of the titular if the search term matches name or cpf_cnpj
                $titular_ids = $wpdb->get_col($wpdb->prepare(
                    "SELECT id FROM {$table_name} WHERE name LIKE %s OR cpf_cnpj LIKE %s",
                    $search_like,
                    $search_like
                ));

                if (!empty($titular_ids)) {
                    $titular_ids_placeholder = implode(',', array_fill(0, count($titular_ids), '%d'));
                    $dependent_conditions = $wpdb->prepare("related_to IN ($titular_ids_placeholder)", ...$titular_ids);
                    $search_conditions .= " OR {$dependent_conditions}";
                }
            }

            $where_query[] = $search_conditions;
        }

        if (!empty($status)) {
            $status_condition = $wpdb->prepare("subscription_status = %s", $status);
            $where_query[] = $status_condition;
        }

        $where = !empty($where_query) ? implode(' AND ', $where_query) : '';

        $args          =  [
            'where'    => $where,
            'order_by' => 'name',
            'order'    => 'ASC',
            'limit'    => 10,
            'offset'   => ($page - 1) * 10,
            'paginate' => true
        ];
        return $this->query->get_results($args);
    }


    public static function init_actions()
    {
        add_action('wp_ajax_load_assinantes', [__CLASS__, 'load_assinantes']);
        add_action('wp_ajax_nopriv_load_assinantes', [__CLASS__, 'load_assinantes']);
        add_action('wp_ajax_get_assinante_detail', [__CLASS__, 'get_assinante_detail']);
        add_action('wp_ajax_nopriv_get_assinante_detail', [__CLASS__, 'get_assinante_detail']);
    }

    public static function load_assinantes()
    {

        $current_user = wp_get_current_user();
        $user_roles = $current_user->roles;
        $special_user = !empty(array_intersect(['gerente_comercial', 'diretoria', 'administrator'], $user_roles));

        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';
        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
        $instance = new self();
        $result = $instance->get_assinantes($search, $status, $page, $special_user);

        //oculta listagem completa e retorna apenas se houver busca
        if (!$search && !$special_user) {
            wp_send_json_success(['html' => '', 'pagination' => '']);
        }

        ob_start();
        foreach ($result->results as $assinante) {
            $status_class = $assinante->subscription_status === 'ACTIVE' ? 'text-success' : 'text-danger';
            $titular_status = empty($assinante->related_to) ? 'Titular' : 'Dependente';
            $edit_url = home_url('/assinantes/editar/?assinante_id=' . Encryption::encrypt($assinante->id, true));
            $subscriber = new Subscriber_Data($assinante->id);
            $is_pf = $subscriber->is_type('PF');
            $some = $is_pf ? 1 : 0;
            $membros_qtd = $subscriber->get_number_dependents() + $some;

            echo "<tr class='assinante-item' data-id='{$assinante->id}'>
                    <td class='name'><a href='#' class='assinante-link' data-id='{$assinante->id}'>{$assinante->name}</a></td>
                    <td class='Telefone'>{$assinante->phone}</td>
                    <td class='cpf_cnpj'>{$assinante->cpf_cnpj}</td>
                    <td class='subscription_status {$status_class}'>{$assinante->subscription_status}</td>
                    <td class='titular_status'>{$titular_status}</td>
                    <td class='subscription_status'>{$membros_qtd}</td>";

            if ($special_user) {
                echo "<td class=''><a href='{$edit_url}' class='link-success fs-15'><i class='ri-edit-2-line'></i></a></td>";
            }

            echo "</tr>";
        }
        $html = ob_get_clean();

        $pagination = $instance->query->render_ajax_pagination('#', [
            'ul' => 'pagination',
            'li' => 'page-item',
            'a'  => 'page-link'
        ]);

        wp_send_json_success(['html' => $html, 'pagination' => $pagination]);
    }


    public static function get_assinante_detail()
    {
        $id = isset($_POST['id']) ? absint($_POST['id']) : 0;
        $query = new Base_Query('assinantes');
        $assinante = $query->get_row(['id' => $id]);

        if ($assinante) {
            wp_send_json_success([
                'name'     => $assinante->name,
                'email'    => $assinante->email,
                'cpf_cnpj' => $assinante->cpf_cnpj,
                'phone'    => $assinante->phone,
                'tags'     => explode(',', $assinante->tags)
            ]);
        } else {
            wp_send_json_error(['message' => 'Assinante not found']);
        }
    }
}
