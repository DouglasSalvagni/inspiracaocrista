<?php


class Landing_page extends Base_Page
{
    private $page_id;

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        $this->add_style('swiper-bundle', get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.css', [], false, 'all', 5);

        $this->add_script('layout',        get_template_directory_uri() . '/assets/js/layout.js', [], null, false, 0);
        $this->add_script('swiper',        get_template_directory_uri() . '/assets/libs/swiper/swiper-bundle.min.js', [], null, true, 90);
        $this->add_script('landing',       get_template_directory_uri() . '/assets/js/pages/landing.init.js', ['swiper'], null, true, 100);


        $this->page_id = get_queried_object()->ID;

        // var_dump(get_queried_object());
    }

    public function render()
    {
        $var = [
            'politica_content' => get_the_content($this->page_id)
        ];

        $this->render_view('pages/landing-page', $var);
    }
}
