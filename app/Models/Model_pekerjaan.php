<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_pekerjaan extends Model
{
    protected $table      = 'peserta_pekerjaan';
    protected $primaryKey = 'id_pekerjaan';
    protected $allowedFields = ['nama'];

    public function list()
    {
        return $this->table('peserta_pekerjaan')
            ->orderBy('id_pekerjaan', 'ASC')
            ->get()->getResultArray();
    }
}
