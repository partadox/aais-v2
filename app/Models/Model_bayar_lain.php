<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bayar_lain extends Model
{
    protected $table      = 'program_bayar_lainnya';
    protected $primaryKey = 'biaya_lainnya_id';
    protected $allowedFields = ['lainnya_bayar_id', 'bayar_lainnya', 'status_bayar_lainnya', 'data_peserta_id_lain'];

    public function list()
    {
        return $this->table('program_bayar_lainnya')
            ->join('peserta', 'peserta.peserta_id = program_bayar_lainnya.data_peserta_id_lain')
            ->join('program_bayar', 'program_bayar.bayar_id = program_bayar_lainnya.lainnya_bayar_id')
            ->orderBy('biaya_lainnya_id', 'DESC')
            ->get()->getResultArray();
    }
}
