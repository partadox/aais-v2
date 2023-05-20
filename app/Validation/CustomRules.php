<?php namespace App\Validation;

use CodeIgniter\Database\Exceptions\DatabaseException;

class CustomRules {

    public function is_unique_except($str, string $field, array $data) {
        list($table, $field, $except_field, $except_value) = explode('.', $field);
        $db = \Config\Database::connect();
    
        $row = $db->table($table)
            ->where($field, $str)
            ->where($except_field.' !=', $except_value)
            ->limit(1)
            ->get()
            ->getRow();
    
        return $row === null;
    }

}