<?php

class General_Helper {
    /**
     * Valida CPF
     *
     * @param string $cpf
     * @return bool
     */
    public static function validar_cpf($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * Valida CNPJ
     *
     * @param string $cnpj
     * @return bool
     */
    public static function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $weight = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $weight[$c + 1 - ($t - 12)];
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validar CPF/CNPJ.
     * 
     * @param string $cpfCnpj
     * @return bool
     */
    public static function validar_cpf_cnpj($cpfCnpj)
    {
        // Remove qualquer caractere não numérico
        $cpfCnpj = preg_replace('/\D/', '', $cpfCnpj);

        if (strlen($cpfCnpj) == 11) {
            return General_Helper::validar_cpf($cpfCnpj);
        } elseif (strlen($cpfCnpj) == 14) {
            return General_Helper::validar_cnpj($cpfCnpj);
        }

        return false;
    }

    /**
     * Remove caracteres especiais de um campo.
     *
     * @param string $field
     * @return string
     */
    public static function remove_special_characters($field) {
        $field = sanitize_text_field($field);
        return preg_replace('/[^0-9]/', '', $field);
    }
}