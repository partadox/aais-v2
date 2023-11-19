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
        ->orderBy('peserta.nama_peserta', 'ASC')
        ->get()
        ->getResultArray();
    }

    //rekap abensi pembinaan admin
    public function rekap_bina_absen($angkatan)
    {
        $weeks = range(1, 11); // Array of weeks from 1 to 11
        $selects = ['peserta.nama_peserta', 'bina_kelas.bk_name', 'bina_kelas.bk_angkatan', 'peserta.nis', 'bina_peserta.bs_status_peserta', 'bina_peserta.bs_status'];

        // Adding columns for each week's attendance
        foreach ($weeks as $week) {
            $weekColumn = "tm$week";
            $selects[] = "(SELECT MAX(bas_absen) FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week) as $weekColumn";
        }

        // Building the main query
        return $this->table('bina_peserta')
                    ->select(implode(', ', $selects))
                    ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
                    ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
                    ->where('bina_kelas.bk_angkatan', $angkatan)
                    ->groupBy('bina_peserta.bs_id')
                    ->orderBy('peserta.nama_peserta', 'ASC')
                    ->get()
                    ->getResultArray();
    }

    //rekap abensi pembinaan export
    public function rekap_bina_absen_export($angkatan)
    {
        $weeks = range(1, 11); // Array of weeks from 1 to 11
        $selects = ['peserta.nis', 'peserta.nama_peserta', 'peserta.jenkel', 'bina_kelas.bk_name', 'bina_kelas.bk_angkatan', 'bina_kelas.bk_hari', 'bina_kelas.bk_waktu', 'bina_kelas.bk_timezone', 'bina_kelas.bk_tm_methode', 'bina_peserta.bs_status_peserta', 'bina_peserta.bs_status'];

        // Adding columns for each week's attendance
        foreach ($weeks as $week) {
            $weekColumn = "tm$week";
            $weekDateColumn = "tm{$week}_dt";
            // Subquery for attendance
            $selects[] = "(SELECT MAX(bas_absen) FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week) as $weekColumn";
            // Subquery for date
            $selects[] = "(SELECT bas_tm_dt FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week LIMIT 1) as $weekDateColumn";
        }

        // Building the main query
        return $this->table('bina_peserta')
                    ->select(implode(', ', $selects))
                    ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
                    ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
                    ->where('bina_kelas.bk_angkatan', $angkatan)
                    ->groupBy('bina_peserta.bs_id')
                    ->orderBy('peserta.nama_peserta', 'ASC')
                    ->get()
                    ->getResultArray();
    }

    
}