<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_log_user extends Model
{
    protected $table      = 'log_user';
    protected $primaryKey = 'log_id';
    protected $allowedFields = ['username_log', 'aktivitas_log', 'status_log','tgl_log', 'waktu_log'];

    //backend
    public function list()
    {
        return $this->table('log_user')
            ->orderBy('log_id', 'DESC')
            ->where('tgl_log >=', 'DATE_SUB(NOW(), INTERVAL 3 MONTH)', false)
            ->get()->getResultArray();
    }


    public function hapus_log_14day()
    {
        return $this->table('log_user')
            ->where('tgl_log < DATE_SUB(NOW(), INTERVAL 30 DAY)')
            ->delete();
    }

}
