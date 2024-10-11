<?php

class Pick_View extends Base_Page {

    private $queried_object;

    public function __construct() {
        parent::__construct();
        
        $this->load_base_style();
        $this->load_base_scripts();

        $this->queried_object = get_queried_object();
    }

    public function render($view) {

        $vars = [
            'queried_object' => $this->queried_object
        ];
        
        $this->render_view($view, $vars);
    }
}