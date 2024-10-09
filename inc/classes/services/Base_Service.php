<?php

class Base_Service
{
    protected $current_user;

    public function __construct()
    {
        $this->current_user = wp_get_current_user();
    }


    public function get_current_user()
    {
        return $this->current_user;
    }

    protected function user_has_role($roles = [])
    {
        if (!is_user_logged_in()) {
            return false;
        }

        $user_roles = $this->current_user->roles;

        return !empty(array_intersect($roles, $user_roles));
    }
}
