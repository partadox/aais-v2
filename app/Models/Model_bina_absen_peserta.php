<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bina_absen_peserta extends Model
{
    protected $table      = 'bina_absen_peserta';
    protected $primaryKey = 'bas_id';
    protected $allowedFields = ['bas_nsid', 'bas_njid', 'bas_bkid', 'bas_tm', 'bas_tm_dt', 'bas_absen','bas_create', 'bas_by', 'bas_note'];

    public function absen_peserta($bs_id)
    {
        return $this->table('bina_absen_peserta')
        ->where('bas_nsid', $bs_id)
        ->orderBy('bas_tm', 'ASC')
        ->get()
        ->getResultArray();
    }

    public function tm_kelas($bk_id)
    {
        return $this->table('bina_absen_peserta')
            ->select('bas_tm')
            ->where('bas_bkid', $bk_id)
            ->distinct()
            ->get()->getResultArray();
    }

    public function absensi_peserta_tm($bk_id, $tm)
    {
        return $this->table('bina_peserta')
        ->join('bina_peserta', 'bina_peserta.bs_id = bina_absen_peserta.bas_nsid')
        ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        ->where('bas_bkid', $bk_id)
        ->where('bas_tm', $tm)
        ->orderBy('peserta.nama_peserta', 'ASC')
        ->get()
        ->getResultArray();
    }
}