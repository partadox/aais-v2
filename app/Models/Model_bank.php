<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bank extends Model
{
    protected $table      = 'bank';
    protected $primaryKey = 'bank_id';
    protected $allowedFields = ['nama_bank', 'rekening_bank', 'atas_nama_bank'];

    //backend
    public function list()
    {
        return $this->table('bank')
            ->orderBy('bank_id', 'ASC')
            ->get()->getResultArray();
    }

}
