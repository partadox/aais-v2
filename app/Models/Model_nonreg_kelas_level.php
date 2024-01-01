<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_kelas_level extends Model
{
    protected $table            = 'nonreg_kelas_level';
    protected $primaryKey       = 'nkl_id';
    protected $allowedFields    = ['nkl_nkid', 'nkl_level'];

    public function list($nk_id)
    {
        return $this->table('nonreg_kelas_level')
            ->join('peserta_level', 'peserta_level.peserta_level_id = nonreg_kelas_level.nkl_level')
            ->where('nkl_nkid', $nk_id)
            ->orderBy('nkl_level', 'ASC')
            ->get()->getResultArray();
    }
}
