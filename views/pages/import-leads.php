<form method="post" enctype="multipart/form-data">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Importar Leads - Arquivo CSV 1</h3>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="csvFileInput1" class="form-label">Selecione o arquivo CSV</label>
                <input type="file" class="form-control" name="csv_file_1" accept=".csv" id="csvFileInput1">
                <div id="file-name-1" class="mt-2">
                    <?php
                    $csv_file_1 = get_option('csv_file_1');
                    if ($csv_file_1) {
                        echo 'Arquivo atual: <a href="' . esc_url($csv_file_1) . '" target="_blank">' . basename($csv_file_1) . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="numberOfLeads1" class="form-label">Número de Leads a Importar</label>
                <input type="number" class="form-control" name="number_of_leads_1" id="numberOfLeads1" min="1" placeholder="Digite o número de leads a importar">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="assignedUser1" class="form-label">Representante Responsável</label>
                <select class="form-select" name="assigned_user_1" id="assignedUser1">
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
        <div class="col-md-3">
            <div class="mb-3">
                <label for="originURL1" class="form-label">Nome do Banco de Leads</label>
                <input type="text" class="form-control" name="origin_url_1" id="originURL1" placeholder="Digite o nome do banco de leads">
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="mb-3 w-100">
                <button type="submit" name="import_csv_1" class="btn btn-primary w-100 mb-2">Importar Leads</button>
                <button type="submit" name="delete_csv_1" class="btn btn-danger w-100">Excluir Arquivo</button>
            </div>
        </div>
    </div>
</form>

<form method="post" enctype="multipart/form-data">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Importar Leads - Arquivo CSV 2</h3>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="csvFileInput2" class="form-label">Selecione o arquivo CSV</label>
                <input type="file" class="form-control" name="csv_file_2" accept=".csv" id="csvFileInput2">
                <div id="file-name-2" class="mt-2">
                    <?php
                    $csv_file_2 = get_option('csv_file_2');
                    if ($csv_file_2) {
                        echo 'Arquivo atual: <a href="' . esc_url($csv_file_2) . '" target="_blank">' . basename($csv_file_2) . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="numberOfLeads2" class="form-label">Número de Leads a Importar</label>
                <input type="number" class="form-control" name="number_of_leads_2" id="numberOfLeads2" min="1" placeholder="Digite o número de leads a importar">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="assignedUser2" class="form-label">Representante Responsável</label>
                <select class="form-select" name="assigned_user_2" id="assignedUser2">
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
        <div class="col-md-3">
            <div class="mb-3">
                <label for="originURL2" class="form-label">Nome do Banco de Leads</label>
                <input type="text" class="form-control" name="origin_url_2" id="originURL2" placeholder="Digite o nome do banco de leads">
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="mb-3 w-100">
                <button type="submit" name="import_csv_2" class="btn btn-primary w-100 mb-2">Importar Leads</button>
                <button type="submit" name="delete_csv_2" class="btn btn-danger w-100">Excluir Arquivo</button>
            </div>
        </div>
    </div>
</form>

<form method="post" enctype="multipart/form-data">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Importar Leads - Arquivo CSV 3</h3>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="csvFileInput3" class="form-label">Selecione o arquivo CSV</label>
                <input type="file" class="form-control" name="csv_file_3" accept=".csv" id="csvFileInput3">
                <div id="file-name-3" class="mt-2">
                    <?php
                    $csv_file_3 = get_option('csv_file_3');
                    if ($csv_file_3) {
                        echo 'Arquivo atual: <a href="' . esc_url($csv_file_3) . '" target="_blank">' . basename($csv_file_3) . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="numberOfLeads3" class="form-label">Número de Leads a Importar</label>
                <input type="number" class="form-control" name="number_of_leads_3" id="numberOfLeads3" min="1" placeholder="Digite o número de leads a importar">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="assignedUser3" class="form-label">Representante Responsável</label>
                <select class="form-select" name="assigned_user_3" id="assignedUser3">
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
        <div class="col-md-3">
            <div class="mb-3">
                <label for="originURL3" class="form-label">Nome do Banco de Leads</label>
                <input type="text" class="form-control" name="origin_url_3" id="originURL3" placeholder="Digite o nome do banco de leads">
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="mb-3 w-100">
                <button type="submit" name="import_csv_3" class="btn btn-primary w-100 mb-2">Importar Leads</button>
                <button type="submit" name="delete_csv_3" class="btn btn-danger w-100">Excluir Arquivo</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('csvFileInput1').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name-1').innerText = 'Arquivo selecionado: ' + fileName;
    });

    document.getElementById('csvFileInput2').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name-2').innerText = 'Arquivo selecionado: ' + fileName;
    });

    document.getElementById('csvFileInput3').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-name-3').innerText = 'Arquivo selecionado: ' + fileName;
    });
</script>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $import_leads = new Import_Leads();

    if (isset($_POST['import_csv_1'])) {
        $import_leads->handle_file_upload('csv_file_1', 'csv_file_1');
        $origin_url_1 = isset($_POST['origin_url_1']) ? sanitize_text_field($_POST['origin_url_1']) : '';
        $import_leads->process_import('csv_file_1', $_POST['number_of_leads_1'], $_POST['assigned_user_1'], $origin_url_1);
    }

    if (isset($_POST['delete_csv_1'])) {
        $import_leads->delete_file('csv_file_1');
    }

    if (isset($_POST['import_csv_2'])) {
        $import_leads->handle_file_upload('csv_file_2', 'csv_file_2');
        $origin_url_2 = isset($_POST['origin_url_2']) ? sanitize_text_field($_POST['origin_url_2']) : '';
        $import_leads->process_import('csv_file_2', $_POST['number_of_leads_2'], $_POST['assigned_user_2'], $origin_url_2);
    }

    if (isset($_POST['delete_csv_2'])) {
        $import_leads->delete_file('csv_file_2');
    }

    if (isset($_POST['import_csv_3'])) {
        $import_leads->handle_file_upload('csv_file_3', 'csv_file_3');
        $origin_url_3 = isset($_POST['origin_url_3']) ? sanitize_text_field($_POST['origin_url_3']) : '';
        $import_leads->process_import('csv_file_3', $_POST['number_of_leads_3'], $_POST['assigned_user_3'], $origin_url_3);
    }

    if (isset($_POST['delete_csv_3'])) {
        $import_leads->delete_file('csv_file_3');
    }
}