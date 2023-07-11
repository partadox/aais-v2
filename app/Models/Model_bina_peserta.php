<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bina_peserta extends Model
{
    protected $table      = 'bina_peserta';
    protected $primaryKey = 'bs_id';
    protected $allowedFields = ['bs_peserta', 'bs_kelas', 'bs_status', 'bs_status_peserta'];

    public function peserta_onkelas($bk_id)
    {
        return $this->table('bina_peserta')
            ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
            ->where('bs_kelas', $bk_id)
            ->orderBy('nama_peserta', 'ASC')
            ->get()->getResultArray();
    }

    public function kelas_peserta($peserta_id, $angkatan)
    {
        return $this->table('bina_peserta')
        ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
        ->where('bs_peserta', $peserta_id)
        ->where('bk_angkatan', $angkatan)
        ->get()
        ->getResultArray();
    }

    public function peserta_kelas($bk_id)
    {
        return $this->table('bina_peserta')
        ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        ->where('bs_kelas', $bk_id)
        ->get()
        ->getResultArray();
    }
}