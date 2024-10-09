<?php

class Pick_View extends Base_Page {

    public function __construct() {
        parent::__construct();
        
        $this->load_base_style();
        $this->load_base_scripts();
    }

    public function render($view) {
        // Renderizar a view específica
        $this->render_view($view);
    }
}