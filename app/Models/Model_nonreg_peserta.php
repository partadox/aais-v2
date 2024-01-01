<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_peserta extends Model
{
    protected $table            = 'nonreg_peserta';
    protected $primaryKey       = 'np_id';
    protected $allowedFields    = ['np_nama', 'np_kelas', 'np_level'];

    public function peserta_onkelas($nk_id)
    {
        return $this->table('nonreg_peserta')
            ->where('np_kelas', $nk_id)
            ->orderBy('np_id', 'ASC')
            ->get()->getResultArray();
    }
}
