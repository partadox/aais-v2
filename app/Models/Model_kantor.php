<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kantor extends Model
{
    protected $table      = 'kantor_cabang';
    protected $primaryKey = 'kantor_id';
    protected $allowedFields = ['nama_kantor', 'kota_kantor', 'alamat_kantor', 'kontak_kantor'];

    //backend
    public function list()
    {
        return $this->table('kantor_cabang')
            //->orderBy('nama_program', 'ASC')
            ->get()->getResultArray();
    }

    //Dashboaed - Admin
    public function jml_kantor()
    {
        return $this->table('kantor_cabang')
        ->countAllResults();
    }

    // public function listjoin()
    // {
    //     return $this->table('kelas')
    //         ->join('guru', 'guru.guru_id = kelas.guru_id')
    //         ->orderBy('kelas_id', 'ASC')
    //         ->get()->getResultArray();
    // }
}
