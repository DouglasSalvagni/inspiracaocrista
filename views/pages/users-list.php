<!-- views/pages/users-list.php -->
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Usuários</h1>
        <a href="<?php echo esc_url(home_url('/criar-usuario')); ?>" class="btn btn-success">Criar Novo Usuário</a>
    </div>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="team_id" class="form-label">Time</label>
            <select name="team_id" id="team_id" class="form-select">
                <option value="">Todos os times</option>
                <?php foreach ($teams as $id => $name): ?>
                    <option value="<?php echo esc_attr($id); ?>" <?php selected($team_id, $id); ?>><?php echo esc_html($name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="search" class="form-label">Buscar por nome</label>
            <input type="text" name="search" id="search" class="form-control" value="<?php echo esc_attr($search_query); ?>" placeholder="Digite o nome do usuário">
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="<?php echo esc_url(remove_query_arg(['team_id', 'search', 'pagina'])); ?>" class="btn btn-secondary">Limpar Filtros</a>
        </div>
    </form>

    <table id="users-table" class="table table-striped table-bordered bg-white">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Time</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo esc_html($user->display_name); ?></td>
                        <td><?php echo esc_html($user->user_email); ?></td>
                        <td>
                            <?php
                            $user_team_id = get_user_meta($user->ID, 'team_id', true);
                            $team_name = 'N/A';
                            if ($user_team_id) {
                                $team_post = get_post($user_team_id);
                                if ($team_post && $team_post->post_type === 'team') {
                                    $team_name = $team_post->post_title;
                                }
                            }
                            echo esc_html($team_name);
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo esc_url(add_query_arg(['user_id' => $user->ID], home_url('/editar-usuario'))); ?>" class="btn btn-sm btn-primary">Editar</a>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="<?php echo esc_attr($user->ID); ?>" data-user-name="<?php echo esc_attr($user->display_name); ?>">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo esc_url(home_url('/usuarios')); ?>">
                    <?php wp_nonce_field('delete_user_action', 'delete_user_nonce'); ?>
                    <input type="hidden" name="user_id" id="delete-user-id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir o usuário <strong id="delete-user-name"></strong>?</p>
                        <p>Esta ação não pode ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="delete_user" class="btn btn-danger">Excluir Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    // Paginação personalizada
    $total_pages = ceil($total_users / $users_per_page);

    if ($total_pages > 1):
        $current_page = $pagina;
        $base_url = remove_query_arg('pagina');

        // Preserve existing query parameters
        $query_args = $_GET;
        unset($query_args['pagina']);
        $base_url = '?' . http_build_query($query_args);

        echo '<nav aria-label="Navegação de página">';
        echo '<ul class="pagination justify-content-center">';

        // Link para a página anterior
        if ($current_page > 1) {
            $prev_page = $current_page - 1;
            echo '<li class="page-item"><a class="page-link" href="' . esc_url(add_query_arg('pagina', $prev_page, $base_url)) . '">&laquo; Anterior</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">&laquo; Anterior</span></li>';
        }

        // Limitar o número de links de página exibidos
        $max_links = 5;
        $start = max(1, $current_page - intval($max_links / 2));
        $end = min($total_pages, $start + $max_links - 1);

        if ($start > 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $current_page) {
                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(add_query_arg('pagina', $i, $base_url)) . '">' . $i . '</a></li>';
            }
        }

        if ($end < $total_pages) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        // Link para a próxima página
        if ($current_page < $total_pages) {
            $next_page = $current_page + 1;
            echo '<li class="page-item"><a class="page-link" href="' . esc_url(add_query_arg('pagina', $next_page, $base_url)) . '">Próximo &raquo;</a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link">Próximo &raquo;</span></li>';
        }

        echo '</ul>';
        echo '</nav>';
    endif;
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteUserModal = document.getElementById('deleteUserModal');
        deleteUserModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var userName = button.getAttribute('data-user-name');
            var modalUserIdInput = deleteUserModal.querySelector('#delete-user-id');
            var modalUserName = deleteUserModal.querySelector('#delete-user-name');

            modalUserIdInput.value = userId;
            modalUserName.textContent = userName;
        });
    });
</script>