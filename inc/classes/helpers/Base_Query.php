<?php

class QueryResult
{
    public $results;
    public $pagination;

    public function __construct($results, $pagination = null)
    {
        $this->results = $results;
        $this->pagination = $pagination;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : null;
    }
}



/**
 * Class Base_Query
 *
 * Classe base para gerenciar consultas ao banco de dados.
 */
class Base_Query
{
    protected $table_name;
    protected $wpdb;
    public $pagination_results;

    /**
     * Base_Query constructor.
     *
     * @param string $table_name Nome da tabela no banco de dados.
     */
    public function __construct($table_name) {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . $table_name;
    }

    /**
     * Método para obter o nome completo da tabela.
     *
     * @return string Nome completo da tabela.
     */
    public function get_table_name() {
        return $this->table_name;
    }

    /**
     * Método para obter resultados da tabela.
     *
     * @param array $options Opções para personalizar a consulta (ordenar, paginar, etc.)
     * @return QueryResult Resultados da consulta.
     */
    public function get_results($options = [])
    {
        $defaults = [
            'order_by' => 'id',
            'order' => 'ASC',
            'limit' => 10,
            'offset' => 0,
            'where' => '',
            'paginate' => false,
        ];

        $args = wp_parse_args($options, $defaults);

        $valid_order_by = ['id', 'name', 'created_at', 'updated_at'];
        if (!in_array($args['order_by'], $valid_order_by)) {
            $args['order_by'] = 'id';
        }

        $sql = "SELECT * FROM {$this->table_name}";

        if (!empty($args['where'])) {
            $sql .= ' WHERE ' . $args['where'];
        }

        $sql .= " ORDER BY {$args['order_by']} {$args['order']}";

        if ($args['paginate'] && $args['limit'] !== null) {
            $sql .= $this->wpdb->prepare(" LIMIT %d OFFSET %d", $args['limit'], $args['offset']);
        }

        $results = $this->wpdb->get_results($sql, OBJECT);

        if ($args['paginate']) {
            $count_sql = "SELECT COUNT(*) FROM {$this->table_name}";
            if (!empty($args['where'])) {
                $count_sql .= ' WHERE ' . $args['where'];
            }
            $total_items = $this->wpdb->get_var($count_sql);
            $total_pages = $args['limit'] !== null ? ceil($total_items / $args['limit']) : 1;

            $this->pagination_results = new QueryResult($results, [
                'total_items' => $total_items,
                'total_pages' => $total_pages,
                'current_page' => ($args['offset'] / $args['limit']) + 1,
                'per_page' => $args['limit'],
            ]);

            return $this->pagination_results;
        } else {
            return new QueryResult($results);
        }
    }

    public function get_row($conditions = []) {
        $where = [];
        foreach ($conditions as $column => $value) {
            $where[] = $this->wpdb->prepare("{$column} = %s", $value);
        }
        $where_sql = implode(' AND ', $where);
        $sql = "SELECT * FROM {$this->table_name} WHERE {$where_sql} LIMIT 1";
        return $this->wpdb->get_row($sql);
    }

    /**
     * Método para gerar a interface de paginação.
     *
     * @param string $base_url URL base para os links de paginação.
     * @param array $classes Classes para estilização dos elementos de paginação.
     * @return string HTML da interface de paginação.
     */
    public function render_pagination($base_url, $classes = []) {
        if (empty($this->pagination_results) || empty($this->pagination_results->pagination)) {
            return '';
        }

        $pagination = $this->pagination_results->pagination;
        $current_page = $pagination['current_page'];
        $total_pages = $pagination['total_pages'];

        if ($total_pages <= 1) {
            return '';
        }

        $ul_class = isset($classes['ul']) ? $classes['ul'] : 'pagination';
        $li_class = isset($classes['li']) ? $classes['li'] : 'page-item';
        $a_class = isset($classes['a']) ? $classes['a'] : 'page-link';
        $prev_class = isset($classes['prev']) ? $classes['prev'] : 'prev';
        $next_class = isset($classes['next']) ? $classes['next'] : 'next';

        $html = "<ul class='{$ul_class}'>";

        // Link para a página anterior
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $html .= "<li class='{$li_class} {$prev_class}'><a class='{$a_class}' href='{$base_url}?pg={$prev_page}'>Anterior</a></li>";
        }

        // Links para as páginas
        $range = 2; // Quantidade de páginas ao redor da página atual
        $gap = 3; // Ponto de inserção do gap

        if ($current_page > $gap + $range + 1) {
            $html .= "<li class='{$li_class}'><a class='{$a_class}' href='{$base_url}?pg=1'>1</a></li>";
            $html .= "<li class='{$li_class}'><span class='{$a_class}'>...</span></li>";
        }

        for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            $html .= "<li class='{$li_class} {$active_class}'><a class='{$a_class}' href='{$base_url}?pg={$i}'>{$i}</a></li>";
        }

        if ($current_page < $total_pages - $gap - $range) {
            $html .= "<li class='{$li_class}'><span class='{$a_class}'>...</span></li>";
            $html .= "<li class='{$li_class}'><a class='{$a_class}' href='{$base_url}?pg={$total_pages}'>{$total_pages}</a></li>";
        }

        // Link para a próxima página
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            $html .= "<li class='{$li_class} {$next_class}'><a class='{$a_class}' href='{$base_url}?pg={$next_page}'>Próximo</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }

    public function render_ajax_pagination($base_url, $classes = []) {
        if (empty($this->pagination_results) || empty($this->pagination_results->pagination)) {
            return '';
        }

        $pagination = $this->pagination_results->pagination;
        $current_page = $pagination['current_page'];
        $total_pages = $pagination['total_pages'];

        if ($total_pages <= 1) {
            return '';
        }

        $ul_class = isset($classes['ul']) ? $classes['ul'] : 'pagination';
        $li_class = isset($classes['li']) ? $classes['li'] : 'page-item';
        $a_class = isset($classes['a']) ? $classes['a'] : 'page-link';
        $prev_class = isset($classes['prev']) ? $classes['prev'] : 'prev';
        $next_class = isset($classes['next']) ? $classes['next'] : 'next';

        $html = "<ul class='{$ul_class}'>";

        // Link para a página anterior
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            $html .= "<li class='{$li_class} {$prev_class}'><a class='{$a_class}' href='#' data-page='{$prev_page}'>Anterior</a></li>";
        }

        // Links para as páginas
        $range = 2; // Quantidade de páginas ao redor da página atual
        $gap = 3; // Ponto de inserção do gap

        if ($current_page > $gap + $range + 1) {
            $html .= "<li class='{$li_class}'><a class='{$a_class}' href='#' data-page='1'>1</a></li>";
            $html .= "<li class='{$li_class}'><span class='{$a_class}'>...</span></li>";
        }

        for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            $html .= "<li class='{$li_class} {$active_class}'><a class='{$a_class}' href='#' data-page='{$i}'>{$i}</a></li>";
        }

        if ($current_page < $total_pages - $gap - $range) {
            $html .= "<li class='{$li_class}'><span class='{$a_class}'>...</span></li>";
            $html .= "<li class='{$li_class}'><a class='{$a_class}' href='#' data-page='{$total_pages}'>{$total_pages}</a></li>";
        }

        // Link para a próxima página
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            $html .= "<li class='{$li_class} {$next_class}'><a class='{$a_class}' href='#' data-page='{$next_page}'>Próximo</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }

    /**
     * Método para adicionar um registro.
     *
     * @param array $data Dados do registro.
     * @return int|false ID do registro inserido ou false em caso de falha.
     */
    public function insert($data)
    {
        $this->wpdb->insert($this->table_name, $data);
        return $this->wpdb->insert_id;
    }

    /**
     * Método para atualizar um registro.
     *
     * @param array $data Dados atualizados.
     * @param array $where Condições para identificar o registro.
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function update($data, $where)
    {
        return $this->wpdb->update($this->table_name, $data, $where);
    }

    /**
     * Método para deletar um registro.
     *
     * @param array $where Condições para identificar o registro.
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function delete($where)
    {
        return $this->wpdb->delete($this->table_name, $where);
    }
}
