<?php

/**
 * Class Lead_Importer_Manager
 * 
 * Esta classe é responsável por gerenciar a importação de arquivos CSV e a transformação de dados
 * em posts do Custom Post Type 'leads'.
 */
class Lead_Importer_Manager
{

    private $csv_file;
    private $table_name = 'wp_leads_db';

    public function __construct()
    {
        // Registra a página no painel do WordPress
        add_action('admin_menu', [$this, 'register_import_page']);

        // Registra o hook para processamento do CSV
        add_action('admin_post_process_csv', [$this, 'process_csv_file']);

        // Registra o hook para transformar os dados da tabela em posts
        add_action('wp_loaded', [$this, 'transform_data_to_cpt']);

        // Shortcode para renderizar o formulário no front-end
        add_shortcode('lead_importer_form', [$this, 'render_transform_form']);
    }

    /**
     * Registra a página de importação no painel administrativo do WordPress.
     *
     * @return void
     */
    public function register_import_page()
    {
        add_menu_page(
            __('Importar Leads', 'textdomain'),
            __('Importar Leads', 'textdomain'),
            'manage_options',
            'import-leads',
            [$this, 'render_import_page']
        );
    }

    /**
     * Renderiza a página de importação.
     *
     * @return void
     */
    public function render_import_page()
    {
        ?>
        <div class="wrap">
            <h1><?php _e('Importar Leads via CSV', 'textdomain'); ?></h1>
            <form method="post" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php'); ?>">
                <input type="hidden" name="action" value="process_csv">

                <!-- Campo adicional para originURL -->
                <div class="mb-3">
                    <label for="originURL" class="form-label"><?php _e('URL de Origem', 'textdomain'); ?></label>
                    <input type="text" class="form-control" name="origin_url" id="originURL"
                        placeholder="<?php _e('Digite a URL de origem', 'textdomain'); ?>" required>
                </div>

                <input type="file" name="csv_file" accept=".csv" required>
                <?php submit_button(__('Importar', 'textdomain')); ?>
            </form>
        </div>
        <?php
    }


    /**
     * Processa o arquivo CSV carregado e insere os dados na tabela leads_db.
     *
     * @return void
     */
    public function process_csv_file() {
        if (!current_user_can('manage_options')) {
            wp_die(__('Você não tem permissão para acessar esta página.', 'textdomain'));
        }
    
        if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
            wp_die(__('Erro ao carregar o arquivo CSV.', 'textdomain'));
        }
    
        $this->csv_file = $_FILES['csv_file']['tmp_name'];
        
        // Captura o valor do campo origin_url
        $origin_url = isset($_POST['origin_url']) ? sanitize_text_field($_POST['origin_url']) : '';
    
        if (($handle = fopen($this->csv_file, 'r')) !== false) {
            global $wpdb;
            
            // Lê os cabeçalhos (primeira linha do CSV)
            $header = fgetcsv($handle, 1000, ',');
            
            // Processa cada linha do CSV
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Certifica-se de que a linha contém o número correto de colunas
                if (count($row) === 5) {
                    // Tratamento da data de nascimento no formato "dd.mm.aaaa hh.mm"
                    $date_time_parts = explode(' ', $row[1]); // Separa a data e o horário
                    $date_parts = explode('.', $date_time_parts[0]); // Separa os componentes da data pelo ponto
    
                    if (count($date_parts) === 3) {
                        $lead_date_birth = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]; // Converte para aaaa-mm-dd
                    } else {
                        $lead_date_birth = ''; // Se a data estiver mal formatada, deixa em branco
                    }
    
                    // Limpeza dos números de telefone
                    $lead_phone = preg_replace('/\D/', '', $row[3]); // Remove tudo que não for dígito
                    $lead_phone_2 = preg_replace('/\D/', '', $row[2]); // Remove tudo que não for dígito
    
                    // Inserção no banco de dados com o originURL
                    $wpdb->insert($this->table_name, [
                        'lead_name' => sanitize_text_field($row[0]),
                        'lead_date_birth' => $lead_date_birth,
                        'lead_phone_2' => $lead_phone_2,
                        'lead_phone' => $lead_phone,
                        'lead_email' => sanitize_email($row[4]),
                        'originURL' => $origin_url, // Adiciona a URL de origem
                    ]);
                }
            }
    
            fclose($handle);
            wp_redirect(admin_url('admin.php?page=import-leads&import=success'));
            exit;
        } else {
            wp_die(__('Não foi possível abrir o arquivo CSV.', 'textdomain'));
        }
    }
    

    /**
     * Transforma os dados da tabela leads_db em posts do CPT 'leads' e exclui os registros processados.
     *
     * @return void
     */
    public function transform_data_to_cpt()
    {
        if (isset($_POST['import']) && !empty($_POST['number_of_leads_1']) && !empty($_POST['assigned_user_1'])) {
            global $wpdb;

            $number_of_leads = intval($_POST['number_of_leads_1']);
            $assigned_user = intval($_POST['assigned_user_1']);

            $leads = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM {$this->table_name} LIMIT %d",
                $number_of_leads
            ));

            foreach ($leads as $lead) {
                $post_id = wp_insert_post([
                    'post_title' => sanitize_text_field($lead->lead_name),
                    'post_type' => 'leads',
                    'post_status' => 'publish',
                ]);

                if ($post_id) {
                    update_post_meta($post_id, 'lead_name', sanitize_text_field($lead->lead_name));
                    update_post_meta($post_id, 'lead_phone', sanitize_text_field($lead->lead_phone));
                    update_post_meta($post_id, 'lead_phone_2', sanitize_text_field($lead->lead_phone_2));
                    update_post_meta($post_id, 'lead_email', sanitize_email($lead->lead_email));
                    update_post_meta($post_id, 'lead_date_birth', sanitize_text_field($lead->lead_date_birth));
                    update_post_meta($post_id, 'lead_assigned_to', $assigned_user);
                    update_post_meta($post_id, 'lead_status', 'lead_discovered');

                    // Excluir o registro da tabela leads_db após a conversão bem-sucedida
                    $wpdb->delete($this->table_name, ['id' => $lead->id]);
                }
            }

            wp_redirect(add_query_arg('import', 'success', wp_get_referer()));
            exit;
        }
    }

    /**
     * Renderiza o formulário para transformação de leads em posts do CPT 'leads'.
     *
     * @return void
     */
    public function render_transform_form()
    {
        ob_start();
        ?>
        <form method="post" action="">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="numberOfLeads1" class="form-label">Número de Leads a Importar</label>
                        <input type="number" class="form-control" name="number_of_leads_1" id="numberOfLeads1" min="1"
                            placeholder="Digite o número de leads a importar" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="assignedUser1" class="form-label">Representante Responsável</label>
                        <select class="form-select" name="assigned_user_1" id="assignedUser1" required>
                            <option value="">Selecione um Representante</option>
                            <?php
                            $users = get_users(['role__in' => ['gerente_comercial', 'comercial']]);
                            foreach ($users as $user) {
                                echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="mb-3 w-100">
                        <button type="submit" name="import" class="btn btn-primary w-100 mb-2">Importar Leads</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }
}

if (class_exists('Lead_Importer_Manager')) {
    new Lead_Importer_Manager();
}
