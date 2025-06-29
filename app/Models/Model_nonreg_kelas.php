<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_kelas extends Model
{
    protected $table            = 'nonreg_kelas';
    protected $primaryKey       = 'nk_id';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nk_id', 'nk_nama', 'nk_angkatan', 'nk_program', 'nk_tipe', 'nk_usaha', 'nk_level', 'nk_kuota', 'nk_tm_total', 'nk_tm_ambil', 'nk_hari', 'nk_waktu', 'nk_timezone', 'nk_pengajar', 'nk_pic_name', 'nk_pic_hp', 'nk_pic_otoritas', 'nk_lokasi', 'nk_absen_metode', 'nk_status', 'nk_status_daftar', 'nk_status_bayar', 'nk_keterangan', 'nk_created', 'nk_tahun', 'nk_tm_bayar'];

    public function list($tahun)
    {
        $db = \Config\Database::connect();

        // Subquery untuk menghitung peserta
        $builder = $db->table('nonreg_peserta');
        $builder->selectCount('np_kelas');
        $builder->where('nonreg_peserta.np_kelas = nonreg_kelas.nk_id');
        $subQuery = $builder->getCompiledSelect();

        // Main query dengan LEFT JOIN untuk multiple pengajar
        $mainQuery = $db->table('nonreg_kelas')
            ->select('nonreg_kelas.*, 
                 (' . $subQuery . ') as peserta_nonreg_count,
                 program.nama_program,
                 GROUP_CONCAT(DISTINCT pengajar.nama_pengajar ORDER BY pengajar.nama_pengajar SEPARATOR ", ") as nama_pengajar_list,
                 COUNT(DISTINCT nonreg_pengajar.npj_pengajar) as jumlah_pengajar,
                 GROUP_CONCAT(DISTINCT peserta_level.nama_level ORDER BY peserta_level.nama_level SEPARATOR ", ") as nama_level_list')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->join('nonreg_pengajar', 'nonreg_pengajar.npj_kelas = nonreg_kelas.nk_id', 'left')
            ->join('pengajar', 'pengajar.pengajar_id = nonreg_pengajar.npj_pengajar', 'left')
            ->join('nonreg_kelas_level', 'nonreg_kelas_level.nkl_nkid = nonreg_kelas.nk_id', 'left')
            ->join('peserta_level', 'peserta_level.peserta_level_id = nonreg_kelas_level.nkl_level', 'left')
            ->where('nk_tahun', $tahun)
            ->groupBy('nonreg_kelas.nk_id, nonreg_kelas.nk_nama, nonreg_kelas.nk_program, nonreg_kelas.nk_tahun, program.nama_program')
            ->orderBy('nonreg_kelas.nk_id', 'DESC');

        return $mainQuery->get()->getResultArray();
    }

    //Seluruh angkatan (unik value / Distinct)
    public function list_unik_angkatan()
    {
        return $this->table('nonreg_kelas')
            ->select('nk_angkatan')
            ->orderBy('nk_angkatan', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }

    //Seluruh tahun angkatan (unik value / Distinct)
    public function list_unik_tahun()
    {
        return $this->table('nonreg_kelas')
            ->select('nk_tahun')
            ->orderBy('nk_tahun', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }

    //List belum bayar daftar
    public function list_not_daftar()
    {
        return $this->table('nonreg_kelas')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->where('nk_status_daftar', 0)
            ->orderBy('nk_id', 'DESC')
            ->get()->getResultArray();
    }

    //List sudah bayar daftar (extend)
    public function list_extend()
    {
        return $this->table('nonreg_kelas')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->where('nk_status_daftar', 1)
            ->orderBy('nk_id', 'DESC')
            ->get()->getResultArray();
    }

    public function list_all_active()
    {
        return $this->table('nonreg_kelas')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->where('nk_status', 1)
            ->orderBy('nk_id', 'DESC')
            ->get()->getResultArray();
    }

    // public function find_kelas_nonreg($nk_id)
    // {
    //     return $this->table('nonreg_kelas')
    //         ->where('nk_id', $nk_id)
    //         ->orderBy('nk_id', 'DESC')
    //         ->get()->getRowArray();        
    // }
}
