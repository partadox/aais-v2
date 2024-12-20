<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_kelas extends Model
{
    protected $table            = 'nonreg_kelas';
    protected $primaryKey       = 'nk_id';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['nk_id', 'nk_nama', 'nk_angkatan', 'nk_program', 'nk_tipe', 'nk_usaha', 'nk_level', 'nk_kuota', 'nk_tm_total', 'nk_tm_ambil', 'nk_hari', 'nk_waktu', 'nk_timezone', 'nk_pengajar', 'nk_pic_name', 'nk_pic_hp', 'nk_pic_otoritas', 'nk_lokasi', 'nk_absen_metode', 'nk_status', 'nk_status_daftar', 'nk_status_bayar', 'nk_keterangan','nk_created'];

    public function list($angkatan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('nonreg_peserta');

        $builder->selectCount('np_kelas');
        $builder->where('nonreg_peserta.np_kelas = nonreg_kelas.nk_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('nonreg_kelas')
            ->select('nonreg_kelas.*, ('.$subQuery.') as peserta_nonreg_count,program.nama_program')
            // ->join('pengajar', 'pengajar.pengajar_id = nonreg_kelas.nk_pengajar')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->where('nk_angkatan', $angkatan)
            ->orderBy('nk_id', 'DESC');

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

    // public function find_kelas_nonreg($nk_id)
    // {
    //     return $this->table('nonreg_kelas')
    //         ->where('nk_id', $nk_id)
    //         ->orderBy('nk_id', 'DESC')
    //         ->get()->getRowArray();        
    // }
}
