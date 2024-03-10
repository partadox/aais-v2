<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_wa extends Model
{
    protected $table      = 'wa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['session', 'status', 'datetime'];

    //backend
    public function list()
    {
        return $this->table('wa')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }
}