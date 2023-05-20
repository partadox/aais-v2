<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_level extends Model
{
    protected $table      = 'peserta_level';
    protected $primaryKey = 'peserta_level_id';
    protected $allowedFields = ['nama_level', 'urutan_level', 'tampil_ondaftar'];

    //backend
    public function list()
    {
        return $this->table('peserta_level')
            ->orderBy('peserta_level_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_tampil_ondaftar()
    {
        return $this->table('peserta_level')
            ->where('tampil_ondaftar',1)
            ->orderBy('peserta_level_id', 'ASC')
            ->get()->getResultArray();
    }

}
