<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_wa_switch extends Model
{
    protected $table      = 'wa_switch';
    protected $primaryKey = 'code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['name', 'status', 'template'];

    //backend
    public function list()
    {
        return $this->table('wa_switch')
            ->orderBy('code', 'ASC')
            ->get()->getResultArray();
    }
}