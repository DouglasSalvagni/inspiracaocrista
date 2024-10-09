<?php

/**
 * Class Lead_Data
 *
 * This class provides methods to retrieve lead metadata.
 */
class Lead_Data
{
    private $lead_id;

    /**
     * Lead_Data constructor.
     *
     * @param int|string $lead_id The ID of the lead. Can be an integer or an encrypted string.
     */
    public function __construct($lead_id, $is_encripted = false)
    {
        if ($is_encripted) {
            $lead_id = Encryption::decrypt($lead_id, true);
        }
        $this->lead_id = intval($lead_id);
    }

    /**
     * Get lead ID.
     *
     * @return int lead ID.
     */
    public function get_ID()
    {
        return $this->lead_id;
    }

    /**
     * Get a specific meta value by key.
     *
     * @param string $meta_key The meta key.
     * @return mixed The meta value.
     */
    public function get_meta($meta_key)
    {
        return get_post_meta($this->lead_id, $meta_key, true);
    }

    /**
     * Get lead name.
     *
     * @return string
     */
    public function get_name()
    {
        return get_the_title($this->lead_id);
    }

    /**
     * Get lead email.
     *
     * @return string
     */
    public function get_email()
    {
        return $this->get_meta('lead_email');
    }

    /**
     * Get assigned team.
     *
     * @return string
     */
    public function get_assigned_team_id()
    {
        return (int)$this->get_meta('assigned_team_id');
    }

    /**
     * Get birth date.
     *
     * @return string
     */
    public function get_birth_date()
    {
        return $this->get_meta('lead_nascimento');
    }

    /**
     * Get lead phone.
     *
     * @return string
     */
    public function get_phone()
    {
        return $this->get_meta('lead_phone');
    }

    /**
     * Get lead CPF.
     *
     * @return string
     */
    public function get_cpf_cnpj()
    {
        return $this->get_meta('lead_cpf_cnpj');
    }

    /**
     * Get lead company.
     *
     * @return string
     */
    public function get_company()
    {
        return $this->get_meta('lead_company');
    }

    /**
     * Get lead company.
     *
     * @return string
     */
    public function get_company_representative()
    {
        return $this->get_meta('lead_company_representative');
    }

    /**
     * Get lead company.
     *
     * @return string
     */
    public function get_company_representative_position()
    {
        return $this->get_meta('lead_position');
    }

    /**
     * Get lead position.
     *
     * @return string
     */
    public function get_position()
    {
        return $this->get_meta('lead_position');
    }

    /**
     * Get lead source.
     *
     * @return string
     */
    public function get_source()
    {
        return $this->get_meta('lead_source');
    }

    /**
     * Get lead status.
     *
     * @return string
     */
    public function get_status()
    {
        return $this->get_meta('lead_status');
    }

    /**
     * Get lead deal PJ discount.
     *
     * @return string
     */
    public function get_deal_pj_discount()
    {
        return $this->get_meta('deal_pj_discount');
    }

    /**
     * Get lead deal PJ discount.
     *
     * @return string
     */
    public function is_pj_admin_max_discount_authorized()
    {
        return $this->get_meta('deal_pj_admin_max_discount_authorized') == 'on';
    }

    /**
     * Get lead deal PJ discount.
     *
     * @return string
     */
    public function is_boleto_authorized()
    {
        return $this->get_meta('deal_boleto_authorized') == 'on';
    }

    /**
     * Get lead deal PJ discount.
     *
     * @return string
     */
    public function get_deal_pj_admin_max_discount()
    {
        return floatval($this->get_meta('deal_pj_admin_max_discount'));
    }

    /**
     * Get due date.
     *
     * @return string
     */
    public function get_deal_due_date()
    {
        return $this->get_meta('deal_due_date');
    }

    /**
     * Get lead number dependents.
     *
     * @return int
     */
    public function get_number_dependents()
    {
        return (int)$this->get_meta('deal_number_dependents') ?? 0;
    }

    /**
     * Get negotiation value.
     *
     * @return float
     */
    public function get_deal_value()
    {
        return (int)$this->get_meta('deal_value') ?? 0;
    }

    /**
     * Calculate negotiation value.
     *
     * @return float
     */
    public function calc_deal_value()
    {
        // Instanciar o serviço de assinatura DNA_Assinatura_Service
        $subscription_service = new DNA_Assinatura_Service($this);

        if ($this->is_pj_admin_max_discount_authorized()) {
            $subscription_service->set_pj_max_discount($this->get_deal_pj_admin_max_discount());
        }

        // Calcular o valor do titular e dos dependentes
        $total_cost = $subscription_service->calculate_subscription_cost();

        // Converter para float e retornar
        return floatval($total_cost);
    }

    /**
     * Update negotiation value.
     *
     * @return float
     */
    public function update_deal_value()
    {
        update_post_meta($this->get_ID(), 'deal_value', $this->calc_deal_value());
    }


    /**
     * Get deal stage.
     *
     * @return string
     */
    public function get_deal_stage()
    {
        return $this->get_meta('deal_stage');
    }

    /**
     * Get expected close date.
     *
     * @return string
     */
    public function get_expected_close_date()
    {
        return $this->get_meta('expected_close_date');
    }

    /**
     * Get last contacted date.
     *
     * @return string
     */
    public function get_last_contacted_date()
    {
        return $this->get_meta('last_contacted_date');
    }

    /**
     * Get contact method.
     *
     * @return string
     */
    public function get_contact_method()
    {
        return $this->get_meta('contact_method');
    }

    /**
     * Get next action date.
     *
     * @return string
     */
    public function get_next_action_date()
    {
        return $this->get_meta('next_action_date');
    }

    /**
     * Get next action description.
     *
     * @return string
     */
    public function get_next_action_description()
    {
        return $this->get_meta('next_action_description');
    }

    /**
     * Get activity log.
     *
     * @return array
     */
    public function get_activity_log()
    {
        return $this->get_meta('activity_log');
    }

    /**
     * Get lead notes.
     *
     * @return string
     */
    public function get_notes()
    {
        return $this->get_meta('lead_notes');
    }

    /**
     * Get lead priority.
     *
     * @return string
     */
    public function get_priority()
    {
        return $this->get_meta('lead_priority');
    }

    /**
     * Get lead assigned to.
     *
     * @return string
     */
    public function get_vendor_id()
    {
        return $this->get_meta('lead_assigned_to');
    }

    /**
     * Get lead tags.
     *
     * @return array
     */
    public function get_tags()
    {
        return $this->get_meta('lead_tags');
    }

    /**
     * Get lead recurrence. valores possíveis monthly|annual
     *
     * @return array
     */
    public function get_recurrence()
    {
        return $this->get_meta('deal_recurrence');
    }

    /**
     * Get lead type (PJ ou PF).
     *
     * @return string
     */
    public function get_type()
    {
        return $this->get_meta('lead_type');
    }

    /**
     * Check if recurrence is monthly
     *
     * @return bool|null
     */
    public function is_recurrence_monthly()
    {
        $recurrence = $this->get_recurrence();

        if ($recurrence === 'monthly') {
            return true;
        } else {
            return null;
        }
    }

    /**
     * Check if recurrence is annual
     *
     * @return bool|null
     */
    public function is_recurrence_annual()
    {
        $recurrence = $this->get_recurrence();

        if ($recurrence === 'yearly') {
            return true;
        } else {
            return null;
        }
    }

    /**
     * Check if is type PF|PJ
     *
     * @return bool|null
     */
    public function is_type($type)
    {
        $lead_type = $this->get_type();

        if (strtoupper($lead_type) === strtoupper($type)) {
            return true;
        } else {
            return null;
        }
    }


    public function archive_lead()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'leads_archived';

        $lead_data = array(
            'original_id'             => $this->lead_id,
            'lead_name'               => get_the_title($this->lead_id),
            'lead_email'              => get_post_meta($this->lead_id, 'lead_email', true),
            'lead_phone'              => get_post_meta($this->lead_id, 'lead_phone', true),
            'lead_cpf_cnpj'           => get_post_meta($this->lead_id, 'lead_cpf_cnpj', true),
            'lead_company'            => get_post_meta($this->lead_id, 'lead_company', true),
            'lead_position'           => get_post_meta($this->lead_id, 'lead_position', true),
            'lead_source'             => get_post_meta($this->lead_id, 'lead_source', true),
            'lead_status'             => get_post_meta($this->lead_id, 'lead_status', true),
            'deal_value'              => get_post_meta($this->lead_id, 'deal_value', true),
            'deal_stage'              => get_post_meta($this->lead_id, 'deal_stage', true),
            'expected_close_date'     => get_post_meta($this->lead_id, 'expected_close_date', true),
            'last_contacted_date'     => get_post_meta($this->lead_id, 'last_contacted_date', true),
            'contact_method'          => get_post_meta($this->lead_id, 'contact_method', true),
            'next_action_date'        => get_post_meta($this->lead_id, 'next_action_date', true),
            'next_action_description' => get_post_meta($this->lead_id, 'next_action_description', true),
            'activity_log'            => maybe_serialize(get_post_meta($this->lead_id, 'activity_log', true)),
            'lead_notes'              => get_post_meta($this->lead_id, 'lead_notes', true),
            'lead_priority'           => get_post_meta($this->lead_id, 'lead_priority', true),
            'lead_assigned_to'        => get_post_meta($this->lead_id, 'lead_assigned_to', true),
            'assigned_team_id'        => get_post_meta($this->lead_id, 'assigned_team_id', true),
            'lead_tags'               => maybe_serialize(get_post_meta($this->lead_id, 'lead_tags', true)),
            'lead_type'               => get_post_meta($this->lead_id, 'lead_type', true),
            'created_at'              => get_the_date('Y-m-d H: i: s', $this->lead_id),
            'updated_at'              => get_the_modified_date('Y-m-d H:i:s', $this->lead_id)
        );

        $wpdb->insert($table_name, $lead_data);

        if ($wpdb->last_error) {
            error_log('Erro ao arquivar lead: ' . $wpdb->last_error);
        }
    }


    public function delete_lead()
    {
        wp_delete_post($this->lead_id, true);
    }
}
