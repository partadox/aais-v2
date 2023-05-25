<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_cart extends Model
{
    protected $table      = 'cart';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = ['cart_peserta', 'cart_kelas', 'cart_peserta_kelas','cart_timeout', 'cart_note', 'cart_status', 'cart_type'];

    public function cek_daftar($peserta_id)
    {
        return $this->table('cart')
            ->where('cart_peserta',$peserta_id)
            ->where('cart_timeout >',date('Y-m-d H:i:s'))
            ->where('cart_type', 'daftar')
            ->where('cart_status',NULL)
            ->get()->getResultArray();
    }
}