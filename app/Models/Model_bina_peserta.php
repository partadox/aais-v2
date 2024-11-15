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

    public function peserta_kelas_NEW($bk_id)
    {
        return $this->table('bina_peserta')
        ->select('bs_id,bs_status_peserta,nama_peserta,nis')
        ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        ->where('bs_kelas', $bk_id)
        ->orderBy('peserta.nama_peserta', 'ASC')
        ->get()
        ->getResultArray();
    }

    //rekap abensi pembinaan admin
    public function rekap_bina_absen($angkatan)
    {
        // $weeks = range(1, 15); // Array of weeks from 1 to 15
        // $selects = ['peserta.nama_peserta', 'bina_kelas.bk_name', 'bina_kelas.bk_angkatan', 'peserta.nis', 'bina_peserta.bs_status_peserta', 'bina_peserta.bs_status'];

        // // Adding columns for each week's attendance
        // foreach ($weeks as $week) {
        //     $weekColumn = "tm$week";
        //     $selects[] = "(SELECT MAX(bas_absen) FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week) as $weekColumn";
        // }

        // // Building the main query
        // return $this->table('bina_peserta')
        //             ->select(implode(', ', $selects))
        //             ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        //             ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
        //             ->where('bina_kelas.bk_angkatan', $angkatan)
        //             ->groupBy('bina_peserta.bs_id')
        //             ->orderBy('peserta.nama_peserta', 'ASC')
        //             ->get()
        //             ->getResultArray();

        return $this->table('bina_peserta')
            ->select('
                peserta.nama_peserta,
                bina_kelas.bk_name,
                bina_kelas.bk_angkatan,
                peserta.nis,
                bina_peserta.bs_status_peserta,
                bina_peserta.bs_status,
                MAX(CASE WHEN bas_tm = 1 THEN bas_absen END) as tm1,
                MAX(CASE WHEN bas_tm = 2 THEN bas_absen END) as tm2,
                MAX(CASE WHEN bas_tm = 3 THEN bas_absen END) as tm3,
                MAX(CASE WHEN bas_tm = 4 THEN bas_absen END) as tm4,
                MAX(CASE WHEN bas_tm = 5 THEN bas_absen END) as tm5,
                MAX(CASE WHEN bas_tm = 6 THEN bas_absen END) as tm6,
                MAX(CASE WHEN bas_tm = 7 THEN bas_absen END) as tm7,
                MAX(CASE WHEN bas_tm = 8 THEN bas_absen END) as tm8,
                MAX(CASE WHEN bas_tm = 9 THEN bas_absen END) as tm9,
                MAX(CASE WHEN bas_tm = 10 THEN bas_absen END) as tm10,
                MAX(CASE WHEN bas_tm = 11 THEN bas_absen END) as tm11,
                MAX(CASE WHEN bas_tm = 12 THEN bas_absen END) as tm12,
                MAX(CASE WHEN bas_tm = 13 THEN bas_absen END) as tm13,
                MAX(CASE WHEN bas_tm = 14 THEN bas_absen END) as tm14,
                MAX(CASE WHEN bas_tm = 15 THEN bas_absen END) as tm15
            ')
            ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
            ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
            ->join('bina_absen_peserta', 'bina_absen_peserta.bas_nsid = bina_peserta.bs_id', 'left')
            ->where('bina_kelas.bk_angkatan', $angkatan)
            ->groupBy([
                'bina_peserta.bs_id',
                'peserta.nama_peserta',
                'bina_kelas.bk_name',
                'bina_kelas.bk_angkatan',
                'peserta.nis',
                'bina_peserta.bs_status_peserta',
                'bina_peserta.bs_status'
            ])
            ->orderBy('peserta.nama_peserta', 'ASC')
            ->get()
            ->getResultArray();
    }

    //rekap abensi pembinaan export
    public function rekap_bina_absen_export($angkatan)
    {
        // $weeks = range(1, 15); // Array of weeks from 1 to 11
        // $selects = ['peserta.nis', 'peserta.nama_peserta', 'peserta.jenkel', 'bina_kelas.bk_name', 'bina_kelas.bk_angkatan', 'bina_kelas.bk_hari', 'bina_kelas.bk_waktu', 'bina_kelas.bk_timezone', 'bina_kelas.bk_tm_methode', 'bina_peserta.bs_status_peserta', 'bina_peserta.bs_status'];

        // // Adding columns for each week's attendance
        // foreach ($weeks as $week) {
        //     $weekColumn = "tm$week";
        //     $weekDateColumn = "tm{$week}_dt";
        //     // Subquery for attendance
        //     $selects[] = "(SELECT MAX(bas_absen) FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week) as $weekColumn";
        //     // Subquery for date
        //     $selects[] = "(SELECT bas_tm_dt FROM bina_absen_peserta WHERE bas_nsid = bina_peserta.bs_id AND bas_tm = $week LIMIT 1) as $weekDateColumn";
        // }

        // // Building the main query
        // return $this->table('bina_peserta')
        //             ->select(implode(', ', $selects))
        //             ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        //             ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
        //             ->where('bina_kelas.bk_angkatan', $angkatan)
        //             ->groupBy('bina_peserta.bs_id')
        //             ->orderBy('peserta.nama_peserta', 'ASC')
        //             ->get()
        //             ->getResultArray();

        return $this->table('bina_peserta')
        ->select('
            peserta.nis,
            peserta.nama_peserta,
            peserta.jenkel,
            bina_kelas.bk_name,
            bina_kelas.bk_angkatan,
            bina_kelas.bk_hari,
            bina_kelas.bk_waktu,
            bina_kelas.bk_timezone,
            bina_kelas.bk_tm_methode,
            bina_peserta.bs_status_peserta,
            bina_peserta.bs_status,
            MAX(CASE WHEN bas_tm = 1 THEN bas_absen END) as tm1,
            MAX(CASE WHEN bas_tm = 1 THEN bas_tm_dt END) as tm1_dt,
            MAX(CASE WHEN bas_tm = 2 THEN bas_absen END) as tm2,
            MAX(CASE WHEN bas_tm = 2 THEN bas_tm_dt END) as tm2_dt,
            MAX(CASE WHEN bas_tm = 3 THEN bas_absen END) as tm3,
            MAX(CASE WHEN bas_tm = 3 THEN bas_tm_dt END) as tm3_dt,
            MAX(CASE WHEN bas_tm = 4 THEN bas_absen END) as tm4,
            MAX(CASE WHEN bas_tm = 4 THEN bas_tm_dt END) as tm4_dt,
            MAX(CASE WHEN bas_tm = 5 THEN bas_absen END) as tm5,
            MAX(CASE WHEN bas_tm = 5 THEN bas_tm_dt END) as tm5_dt,
            MAX(CASE WHEN bas_tm = 6 THEN bas_absen END) as tm6,
            MAX(CASE WHEN bas_tm = 6 THEN bas_tm_dt END) as tm6_dt,
            MAX(CASE WHEN bas_tm = 7 THEN bas_absen END) as tm7,
            MAX(CASE WHEN bas_tm = 7 THEN bas_tm_dt END) as tm7_dt,
            MAX(CASE WHEN bas_tm = 8 THEN bas_absen END) as tm8,
            MAX(CASE WHEN bas_tm = 8 THEN bas_tm_dt END) as tm8_dt,
            MAX(CASE WHEN bas_tm = 9 THEN bas_absen END) as tm9,
            MAX(CASE WHEN bas_tm = 9 THEN bas_tm_dt END) as tm9_dt,
            MAX(CASE WHEN bas_tm = 10 THEN bas_absen END) as tm10,
            MAX(CASE WHEN bas_tm = 10 THEN bas_tm_dt END) as tm10_dt,
            MAX(CASE WHEN bas_tm = 11 THEN bas_absen END) as tm11,
            MAX(CASE WHEN bas_tm = 11 THEN bas_tm_dt END) as tm11_dt,
            MAX(CASE WHEN bas_tm = 12 THEN bas_absen END) as tm12,
            MAX(CASE WHEN bas_tm = 12 THEN bas_tm_dt END) as tm12_dt,
            MAX(CASE WHEN bas_tm = 13 THEN bas_absen END) as tm13,
            MAX(CASE WHEN bas_tm = 13 THEN bas_tm_dt END) as tm13_dt,
            MAX(CASE WHEN bas_tm = 14 THEN bas_absen END) as tm14,
            MAX(CASE WHEN bas_tm = 14 THEN bas_tm_dt END) as tm14_dt,
            MAX(CASE WHEN bas_tm = 15 THEN bas_absen END) as tm15,
            MAX(CASE WHEN bas_tm = 15 THEN bas_tm_dt END) as tm15_dt
        ')
        ->join('peserta', 'peserta.peserta_id = bina_peserta.bs_peserta')
        ->join('bina_kelas', 'bina_kelas.bk_id = bina_peserta.bs_kelas')
        ->join('bina_absen_peserta', 'bina_absen_peserta.bas_nsid = bina_peserta.bs_id', 'left')
        ->where('bina_kelas.bk_angkatan', $angkatan)
        ->groupBy([
            'peserta.nis',
            'peserta.nama_peserta',
            'peserta.jenkel',
            'bina_kelas.bk_name',
            'bina_kelas.bk_angkatan',
            'bina_kelas.bk_hari',
            'bina_kelas.bk_waktu',
            'bina_kelas.bk_timezone',
            'bina_kelas.bk_tm_methode',
            'bina_peserta.bs_status_peserta',
            'bina_peserta.bs_status'
        ])
        ->orderBy('peserta.nama_peserta', 'ASC')
        ->get()
        ->getResultArray();
        
    }
}