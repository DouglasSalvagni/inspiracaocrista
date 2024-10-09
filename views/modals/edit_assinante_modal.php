<?php
if (isset($params['assinante_id'])) {
    $assinante_id = intval($params['assinante_id']);
    $assinante_service = new Assinante_Service($assinante_id);
    $assinante_data = $assinante_service->get_data();
    $dependentes = $assinante_service->get_dependentes();

    $vars = [
        'assinante_data' => $assinante_data,
        'dependentes'    => $dependentes,
        'assinante_id'   => $assinante_id,
    ];

    // limpa a sessions de alerta
    Alert_Helper::clean_session();

    Template_Helper::render_view('components/dados-assinante', $vars);
} else {
    echo '<p>Assinante ID not provided.</p>';
}
?>
