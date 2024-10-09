<?php

require_once(ABSPATH . 'vendor/autoload.php');

use GuzzleHttp\Client;

class Asaas_API
{
    private $access_token;
    private $url_atual;
    private $client;

    public function __construct()
    {
        $this->access_token = get_option('asaas_api_key');
        $environment = get_option('asaas_environment', 'sandbox');
        $this->url_atual = $environment === 'production' ? 'https://api.asaas.com/v3/' : 'https://sandbox.asaas.com/api/v3/';
        $this->client = new Client();
    }


    private function call_asaas_api($endpoint, $verb = 'GET', $params = null)
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $this->access_token,
                'User-Agent' => 'MinhaAplicacao/1.0' // Adicione aqui o nome da sua aplicação
            ],
        ];

        if (!is_null($params)) {
            $options['body'] = $params;
        }

        $response = $this->client->request($verb, $endpoint, $options);
        return json_decode($response->getBody(), true);
    }

    /**** CLIENTS ****/

    public function create_new_client($params)
    {
        $string_fields = json_encode($params);
        $endpoint = $this->url_atual . 'customers';
        return $this->call_asaas_api($endpoint, 'POST', $string_fields);
    }

    public function list_clients($query_params)
    {
        $query = http_build_query($query_params);
        $endpoint = $this->url_atual . 'customers?' . $query;
        return $this->call_asaas_api($endpoint);
    }

    public function delete_client_by_id($id_cliente)
    {
        $endpoint = $this->url_atual . 'customers/' . $id_cliente;
        return $this->call_asaas_api($endpoint, 'DELETE');
    }

    public function get_customer_by_cpf_cnpj($cpf_cnpj)
    {
        $query = http_build_query(['cpfCnpj' => $cpf_cnpj]);
        $endpoint = $this->url_atual . 'customers?' . $query;
        return $this->call_asaas_api($endpoint);
    }



    /**** PAYMENTS ****/

    public function create_payment($params)
    {
        $string_fields = json_encode($params);
        $endpoint = $this->url_atual . 'payments';
        return $this->call_asaas_api($endpoint, 'POST', $string_fields);
    }


    /**** SUBSCRIPTION ****/

    public function create_subscription($params)
    {
        $string_fields = json_encode($params);
        $endpoint = $this->url_atual . 'subscriptions';
        return $this->call_asaas_api($endpoint, 'POST', $string_fields);
    }

    public function update_subscription($id, $params)
    {
        $string_fields = json_encode($params);
        $endpoint = $this->url_atual . 'subscriptions/' . $id;
        return $this->call_asaas_api($endpoint, 'PUT', $string_fields);
    }


    public function get_subscriptions($query_params = [])
    {
        $query = http_build_query($query_params);
        $endpoint = $this->url_atual . 'subscriptions?' . $query;
        return $this->call_asaas_api($endpoint);
    }

    public function get_subscription_payments($subscription_id, $query_params = [])
    {
        $query = http_build_query($query_params);
        $endpoint = $this->url_atual . 'subscriptions/' . $subscription_id . '/payments?' . $query;
        return $this->call_asaas_api($endpoint);
    }

    public function delete_subscription($subscription_id)
    {
        $endpoint = $this->url_atual . 'subscriptions/' . $subscription_id;
        return $this->call_asaas_api($endpoint, 'DELETE');
    }
}

add_action('debud-printer', function () {
    // $teste = new Asaas_API;
    // $result = $teste->get_subscriptions(['customer' => 'cus_000006178545']);

    // if(count($result['data']) > 0) {
    //     echo '<pre>';
    //     var_dump($result['data'][0]['id']);
    //     echo '</pre>';
    // }

});
