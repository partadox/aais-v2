<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bina_pengajar extends Model
{
    protected $table      = 'bina_pengajar';
    protected $primaryKey = 'bj_id';
    protected $allowedFields = ['bj_pengajar', 'bj_kelas'];

    public function pengajar_onkelas($bk_id)
    {
        return $this->table('bina_pengajar')
            ->join('pengajar', 'pengajar.pengajar_id = bina_pengajar.bj_pengajar')
            ->where('bj_kelas', $bk_id)
            ->orderBy('nama_pengajar', 'ASC')
            ->get()->getResultArray();
    }
}