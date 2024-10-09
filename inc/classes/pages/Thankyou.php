<?php

require_once(ABSPATH . 'vendor/autoload.php');

use GuzzleHttp\Client;

//DISPONIBILIZA ACTION AJAX
add_action('init', ['ASAAS_Checkout_Page', 'init_actions']);


/**
 * Class ASAAS_Checkout_Page
 * 
 * This class handles the checkout page logic.
 */
class Thankyou extends Base_Page
{

    public function __construct()
    {
        parent::__construct();

        $this->load_base_style();
        $this->load_base_scripts();

        // Add any specific scripts or styles for the checkout page
        $this->add_script('jquery-mask',     get_template_directory_uri() . '/assets/js/jquery.mask.min.js', ['jquery'], false, true);
        $this->add_script('masks',           get_template_directory_uri() . '/assets/js/masks.js', ['jquery'], false, true);
        $this->add_script('checkout-script', get_template_directory_uri() . '/assets/js/checkout.js', ['jquery'], null, true);
    }



    public function render()
    {

        $subscription_id = Encryption::decrypt($_GET['ref'], true);
        $assinante_id    = Encryption::decrypt($_GET['assinante'], true);

        $asaas_api = new Asaas_API();
        $payments = $asaas_api->get_subscription_payments($subscription_id);

        $assinante = new Subscriber_Data($assinante_id);

        $view = '';
        if($assinante->is_type('PJ')) {
            $view = 'thankyou-text-pj';
        } else {
            $view = 'thankyou-text-pf';
        }
        
        $btn_link = '';
        $btn_label = '';

        if(isset($payments['data'][0]) && $payments['data'][0]['billingType'] == 'BOLETO') {
            $btn_link = $payments['data'][0]['bankSlipUrl'];
            $btn_label = 'Baixar boleto';
        } elseif(isset($payments['data'][0]) && $payments['data'][0]['billingType'] == 'CREDIT_CARD') {
            $btn_link = $payments['data'][0]['transactionReceiptUrl'];
            $btn_label = 'Ver comprovante';
        } elseif(isset($payments['data'][0]) && $payments['data'][0]['billingType'] == 'PIX') {
            $btn_link = $payments['data'][0]['invoiceUrl'];
            $btn_label = 'Link pagamento pix';
        } elseif(isset($payments['data'][0]) && $payments['data'][0]['billingType'] == 'UNDEFINED') {
            $btn_link = $payments['data'][0]['invoiceUrl'];
            $btn_label = 'Link para pagamento';
        }


        $vars = [
            'btn_link'  => $btn_link,
            'btn_label' => $btn_label,
            'assinante_name' => $assinante->get_name()
        ];

        $conteudo = $this->render_part('text/' . $view, $vars);

        $vars = [
            'conteudo'  => $conteudo
        ];

        $this->render_view('pages/thankyou', $vars);
        
    }
}
