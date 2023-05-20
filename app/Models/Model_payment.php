<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_payment extends Model
{
    protected $table      = 'payment';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = ['payment_code', 'payment_name', 'payment_type', 'payment_status', 'payment_price', 'payment_tax', 'payment_bank', 'payment_rekening', 'payment_atasnama'];

    public function list()
    {
        return $this->table('payment')
            ->orderBy('payment_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_active()
    {
        return $this->table('payment')
            ->where('payment_status', 1)
            ->orderBy('payment_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_manual()
    {
        return $this->table('payment')
            ->where('payment_status', 1)
            ->where('payment_type', 'Manual')
            ->orderBy('payment_id', 'ASC')
            ->get()->getResultArray();
    }

}
