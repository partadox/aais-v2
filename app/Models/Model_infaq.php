<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_infaq extends Model
{
    protected $table      = 'program_bayar_infaq';
    protected $primaryKey = 'infaq_id';
    protected $allowedFields = ['infaq_bayar_id',  'bayar_infaq', 'data_peserta_id_infaq'];

    public function list()
    {
        return $this->table('program_bayar_infaq')
            ->join('peserta', 'peserta.peserta_id = program_bayar_infaq.data_peserta_id_infaq')
            ->join('program_bayar', 'program_bayar.bayar_id = program_bayar_infaq.infaq_bayar_id')
            ->orderBy('infaq_id', 'DESC')
            ->get()->getResultArray();
    }
}
