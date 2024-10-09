<?php
if (isset($params['user_id'])) {
    $user_id = intval($params['user_id']);
    $team_id = intval($params['team_id']);

    $vars = [
        'user_id' => $user_id,
        'team_id' => $team_id,
    ];

    // limpa a sessions de alerta
    Alert_Helper::clean_session();

    Template_Helper::render_view('forms/add-lead-modal', $vars);
} else {
    echo '<p>Houve um erro.</p>';
}