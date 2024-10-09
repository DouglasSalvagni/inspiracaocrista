<?php

function distribute_lead($post_id)
{
    $users = get_commercial_users();
    if (empty($users)) {
        return false; // No commercial users found
    }

    // Get the last assigned user ID from options table
    $last_assigned_user_id = get_option('last_assigned_commercial_user_id', 0);

    // Find the index of the next user to assign the lead to
    $next_user_index = 0;
    foreach ($users as $index => $user) {
        if ($user->ID == $last_assigned_user_id) {
            $next_user_index = ($index + 1) % count($users);
            break;
        }
    }

    $next_user = $users[$next_user_index];

    // Update the post meta with the assigned user ID
    update_post_meta($post_id, 'lead_assigned_to', $next_user->ID);

    // Update the last assigned user ID in the options table
    update_option('last_assigned_commercial_user_id', $next_user->ID);

    return $next_user; // Return the user object instead of just the ID
}

function get_commercial_users()
{
    $users = get_users(
        array(
            'role' => 'comercial',
            'orderby' => 'ID',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'team_id',
                    'value' => 748,
                    'compare' => '='
                )
            )
        )
    );
    return $users;
}
