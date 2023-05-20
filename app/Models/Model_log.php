<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_log extends Model
{
    protected $table      = 'log_admin';
    protected $primaryKey = 'log_id';
    protected $allowedFields = ['username_log', 'aktivitas_log', 'status_log','tgl_log', 'waktu_log'];

    //backend
    public function list()
    {
        return $this->table('log_admin')
            ->orderBy('log_id', 'DESC')
            ->where('tgl_log BETWEEN CURDATE() - INTERVAL 60 DAY AND NOW()')
            ->get()->getResultArray();
    }

    public function hapus_log_14day()
    {
        return $this->table('log_admin')
            ->where('tgl_log < DATE_SUB(NOW(), INTERVAL 60 DAY)')
            ->delete();
    }

}
