<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_pengajar extends Model
{
    protected $table            = 'nonreg_pengajar';
    protected $primaryKey       = 'npj_id';
    protected $allowedFields    = ['npj_pengajar', 'npj_kelas'];

    public function list($npj_kelas)
    {
        return $this->table('nonreg_pengajar')
            ->where('npj_kelas', $npj_kelas)
            ->join('pengajar', 'pengajar.pengajar_id = nonreg_pengajar.npj_pengajar')
            ->get()->getResultArray();
    }

    public function list_pengajar($npj_pengajar)
    {
        return $this->table('nonreg_pengajar')
            ->select('npj_kelas')
            ->where('npj_pengajar', $npj_pengajar)
            ->get()->getResultArray();
    }
}
