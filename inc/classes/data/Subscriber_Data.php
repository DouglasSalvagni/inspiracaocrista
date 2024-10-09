<?php

/**
 * Class Subscriber_Data
 *
 * This class provides methods to retrieve subscriber data.
 */
class Subscriber_Data
{
    private $subscriber_id;

    /**
     * Subscriber_Data constructor.
     *
     * @param int $subscriber_id The ID of the subscriber.
     */
    public function __construct($subscriber_id)
    {
        $this->subscriber_id = intval($subscriber_id);
    }

    /**
     * Get subscriber ID.
     *
     * @return int Subscriber ID.
     */
    public function get_ID()
    {
        return $this->subscriber_id;
    }

    /**
     * Get a specific subscriber data by column name.
     *
     * @param string $column The column name.
     * @return mixed The column value.
     */
    public function get_data($column)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        return $wpdb->get_var($wpdb->prepare("SELECT $column FROM $table_name WHERE id = %d", $this->subscriber_id));
    }

    /**
     * Get a specific meta data for the subscriber by meta key.
     *
     * @param string $meta_key The meta key.
     * @return mixed The meta value.
     */
    public function get_meta($meta_key)
    {
        global $wpdb;
        $meta_table = $wpdb->prefix . 'assinantes_meta';
        return $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $meta_table WHERE assinante_id = %d AND meta_key = %s", $this->subscriber_id, $meta_key));
    }

    /**
     * Get subscriber name.
     *
     * @return string
     */
    public function get_name()
    {
        return $this->get_data('name');
    }

    /**
     * Get subscriber email.
     *
     * @return string
     */
    public function get_email()
    {
        return $this->get_data('email');
    }

    /**
     * Get subscriber phone.
     *
     * @return string
     */
    public function get_phone()
    {
        return $this->get_data('phone');
    }

    /**
     * Get subscriber mobile phone.
     *
     * @return string
     */
    public function get_mobile_phone()
    {
        return $this->get_data('mobile_phone');
    }

    /**
     * Get subscriber CPF or CNPJ.
     *
     * @return string
     */
    public function get_cpf_cnpj()
    {
        return $this->get_data('cpf_cnpj');
    }

    /**
     * Get subscriber company.
     *
     * @return string
     */
    public function get_company()
    {
        return $this->get_data('address'); // Assuming company details are stored in address fields
    }

    /**
     * Get subscriber postal code.
     *
     * @return string
     */
    public function get_postal_code()
    {
        return $this->get_data('postal_code');
    }

    /**
     * Get subscriber address.
     *
     * @return string
     */
    public function get_address()
    {
        return $this->get_data('address');
    }

    /**
     * Get subscriber address number.
     *
     * @return string
     */
    public function get_address_number()
    {
        return $this->get_data('address_number');
    }

    /**
     * Get subscriber complement.
     *
     * @return string
     */
    public function get_complement()
    {
        return $this->get_data('complement');
    }

    /**
     * Get subscriber province.
     *
     * @return string
     */
    public function get_province()
    {
        return $this->get_data('province');
    }

    /**
     * Get subscriber city.
     *
     * @return string
     */
    public function get_city()
    {
        return $this->get_data('city');
    }

    /**
     * Get subscriber UF.
     *
     * @return string
     */
    public function get_uf()
    {
        return $this->get_data('uf');
    }

    /**
     * Get subscriber entity type.
     *
     * @return string
     */
    public function get_type()
    {
        return $this->get_data('entity_type');
    }

    /**
     * Check if is type PF|PJ
     *
     * @return bool|null
     */
    public function is_type($type)
    {
        $subscriber_type = $this->get_type();

        if (strtoupper($subscriber_type) === strtoupper($type)) {
            return true;
        } else {
            return null;
        }
    }

    /**
     * Get subscriber subscription status.
     *
     * @return string
     */
    public function get_status()
    {
        return $this->get_data('subscription_status');
    }

    /**
     * Get subscription start date.
     *
     * @return string
     */
    public function get_subscription_start_date()
    {
        return $this->get_data('subscription_start_date');
    }

    /**
     * Get Asaas customer ID.
     *
     * @return string
     */
    public function get_asaas_customer_id()
    {
        return $this->get_data('asaas_customer_id');
    }

    /**
     * Get Asaas subscription ID.
     *
     * @return string
     */
    public function get_asaas_subscription_id()
    {
        return $this->get_data('asaas_subscription_id');
    }

    /**
     * Get subscription value.
     *
     * @return float
     */
    public function get_subscription_value()
    {
        return floatval($this->get_data('subscription_value'));
    }

    /**
     * Get deal price.
     *
     * @return float
     */
    public function get_base_price()
    {
        return floatval($this->get_data('base_price'));
    }

    /**
     * Get deal billing cycle.
     *
     * @return string
     */
    public function get_recurrence()
    {
        return $this->get_data('deal_billing_cycle');
    }

    /**
     * Get PJ discount.
     *
     * @return float
     */
    public function get_deal_pj_discount()
    {
        return floatval($this->get_data('deal_pj_discount'));
    }

    /**
     * Get the vendor ID assigned to this subscriber.
     *
     * @return int|null
     */
    public function get_vendor_id()
    {
        return $this->get_data('vendor_id');
    }

    /**
     * Get the vendor ID assigned to this subscriber.
     *
     * @return int|null
     */
    public function get_titular_id()
    {
        if (!$this->is_role_type('TITULAR')) {
            return $this->get_related_to();
        } else {
            return null;
        }
    }

    /**
     * Get related ID.
     *
     * @return int|null
     */
    public function get_related_to()
    {
        return $this->get_data('related_to');
    }

    /**
     * Check if split removed.
     *
     * @return bool
     */
    public function is_split_removed()
    {
        return boolval($this->get_data('split_removed'));
    }

    /**
     * Set split_removed to 0 (split not removed).
     *
     * @return bool True on success, false on failure.
     */
    public function reset_split_removed()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $result = $wpdb->update(
            $table_name,
            array('split_removed' => 0),
            array('id' => $this->subscriber_id),
            array('%d'),
            array('%d')
        );

        if ($result === false) {
            return false;
        }

        return true;
    }


    /**
     * Get the number of dependents.
     *
     * @return int
     */
    public function get_number_dependents()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';

        $is_titular = $this->is_role_type('TITULAR');

        if ($is_titular) {
            return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE related_to = %d", $this->subscriber_id));
        }

        return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE related_to = %d", $this->get_titular_id()));
    }

    /**
     * Get the deal number of dependents.
     *
     * @return int
     */
    public function get_deal_pj_number_dependents()
    {
        return $this->get_data('deal_pj_number_dependents');
    }

    /**
     * Set the number of dependents for the subscriber's deal.
     *
     * @param int $number The number of dependents to set.
     * @return bool True on success, false on failure.
     */
    public function set_deal_pj_number_dependents($number)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        $number = intval($number);

        $result = $wpdb->update(
            $table_name,
            array('deal_pj_number_dependents' => $number),
            array('id' => $this->subscriber_id),
            array('%d'),
            array('%d')
        );

        if ($result === false) {
            return false;
        }

        return true;
    }


    /**
     * Get the subscriber's role type (TITULAR or DEPENDENTE).
     *
     * @return string
     */
    public function get_role_type()
    {
        return $this->get_data('role_type');
    }

    /**
     * Check if the subscriber's role type machts (TITULAR or DEPENDENTE).
     *
     * @return string
     */
    public function is_role_type($type)
    {
        return strtoupper($this->get_role_type()) == strtoupper($type);
    }

    /**
     * Get related sale ID.
     *
     * @return int|null
     */
    public function get_sale_id()
    {
        return $this->get_data('sale_id');
    }

    /**
     * Get created at date.
     *
     * @return string
     */
    public function get_created_at()
    {
        return $this->get_data('created_at');
    }

    /**
     * Get updated at date.
     *
     * @return string
     */
    public function get_updated_at()
    {
        return $this->get_data('updated_at');
    }

    /**
     * Delete subscriber record from the database.
     *
     * @return void
     */
    public function delete_subscriber()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'assinantes';
        $wpdb->delete($table_name, array('id' => $this->subscriber_id), array('%d'));

        if ($wpdb->last_error) {
            error_log('Erro ao deletar assinante: ' . $wpdb->last_error);
        }
    }
}
