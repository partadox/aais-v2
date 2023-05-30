<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_pengajar extends Model
{
    protected $table      = 'nonreg_pengajar';
    protected $primaryKey = 'nj_id';
    protected $allowedFields = ['nj_pengajar', 'nj_kelas'];

    public function pengajar_onkelas($nk_id)
    {
        return $this->table('nonreg_pengajar')
            ->join('pengajar', 'pengajar.pengajar_id = nonreg_pengajar.nj_pengajar')
            ->where('nj_kelas', $nk_id)
            ->orderBy('nama_pengajar', 'ASC')
            ->get()->getResultArray();
    }
}