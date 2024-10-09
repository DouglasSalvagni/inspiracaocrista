<?php

class Lead_Meta
{
    private static $status_options = [
        'lead_discovered'  => ['label' => 'Lead descoberto', 'color'            => 'danger'],
        'contact_made'     => ['label' => 'Contato feito', 'color'              => 'success'],
        'needs_identified' => ['label' => 'Necessidades identificadas', 'color' => 'warning'],
        'meeting_arranged' => ['label' => 'Reunião marcada', 'color'            => 'info'],
        'offer_accepted'   => ['label' => 'Oferta aceita', 'color'              => 'secondary']
    ];

    private static $priority_options = [
        'low'    => ['label' => 'Baixa', 'color' => 'success'],
        'medium' => ['label' => 'Média', 'color' => 'warning'],
        'high'   => ['label' => 'Alta', 'color'  => 'danger']
    ];

    private static $source_options = [
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'whatsapp'  => 'Whatsapp',
        'other'     => 'Outros'
    ];

    private static $type_options = [
        'PF'  => 'Pessoa física',
        'PJ'  => 'Pessoa jurídica',
    ];

    // Método para obter a cor com base na slug do status
    public static function get_status_color($status_key)
    {
        return self::$status_options[$status_key]['color'] ?? '';
    }

    // Método para obter o label com base na slug do status
    public static function get_status_label($status_key)
    {
        return self::$status_options[$status_key]['label'] ?? '';
    }

    // Método para obter todas as opções de status
    public static function get_status_options()
    {
        return array_map(function ($option) {
            return $option['label'];
        }, self::$status_options);
    }

    // Método para obter a classe de cor do status
    public static function get_status_class($status_key)
    {
        $color = self::get_status_color($status_key);
        return $color ? "bg-{$color}-subtle" : '';
    }

    // Método para obter a cor com base na slug da prioridade
    public static function get_priority_color($priority_key)
    {
        return self::$priority_options[$priority_key]['color'] ?? '';
    }

    // Método para obter o label com base na slug da prioridade
    public static function get_priority_label($priority_key)
    {
        return self::$priority_options[$priority_key]['label'] ?? '';
    }

    // Método para obter todas as opções de prioridade
    public static function get_priority_options()
    {
        return array_map(function ($option) {
            return $option['label'];
        }, self::$priority_options);
    }

    // Método para obter a classe de cor da prioridade
    public static function get_priority_class($priority_key)
    {
        $color = self::get_priority_color($priority_key);
        return $color ? "bg-{$color}-subtle" : '';
    }

    // Método para obter todas as opções de origem
    public static function get_source_options()
    {
        return self::$source_options;
    }

    // Método para obter todas as opções de origem
    public static function get_type_options()
    {
        return self::$type_options;
    }
}
