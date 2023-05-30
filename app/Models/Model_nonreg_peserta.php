<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_peserta extends Model
{
    protected $table      = 'nonreg_peserta';
    protected $primaryKey = 'ns_id';
    protected $allowedFields = ['ns_peserta', 'ns_kelas', 'ns_status'];

    public function peserta_onkelas($nk_id)
    {
        return $this->table('nonreg_peserta')
            ->join('peserta', 'peserta.peserta_id = nonreg_peserta.ns_peserta')
            ->where('ns_kelas', $nk_id)
            ->orderBy('nama_peserta', 'ASC')
            ->get()->getResultArray();
    }
}