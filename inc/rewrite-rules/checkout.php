<?php

function add_checkout_rewrite_rule() {
    add_rewrite_rule('^checkout/([^/]+)/?', 'index.php?pagename=checkout&checkout_uuid=$matches[1]', 'top');
    add_rewrite_tag('%checkout_uuid%', '([^&]+)');
}
add_action('init', 'add_checkout_rewrite_rule');

function add_checkout_query_vars($vars) {
    $vars[] = 'checkout_uuid';
    return $vars;
}
add_filter('query_vars', 'add_checkout_query_vars');


