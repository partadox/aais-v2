<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_kelas extends Model
{
    protected $table      = 'program_kelas';
    protected $primaryKey = 'kelas_id';
    protected $allowedFields = ['program_id', 'peserta_level','pengajar_id', 'data_absen_pengajar', 'nama_kelas', 'angkatan_kelas', 'hari_kelas', 'waktu_kelas', 'zona_waktu_kelas', 'jenkel', 'status_kerja', 'kouta', 'sisa_kouta', 'jumlah_peserta', 'metode_kelas','status_kelas', 'metode_absen', 'tm_absen',  'config_absen','expired_absen', 'show_ujian'];

    /*--- NEW MODEL ---*/
    public function list_2nd($angkatan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('peserta_kelas');

        $builder->selectCount('data_kelas_id');
        $builder->where('peserta_kelas.data_kelas_id = program_kelas.kelas_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('program_kelas')
            ->select('program_kelas.*, program.*, pengajar.*, peserta_level.*, ('.$subQuery.') as peserta_kelas_count')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('kelas_id', 'DESC');

        return $mainQuery->get()->getResultArray();
    }

    public function list_ondaftar($filter_domisili, $peserta_domisili , $peserta_level, $peserta_jenkel, $peserta_status_kerja, $angkatan, $peserta_id)
     {
        $db      = \Config\Database::connect();

        // Subquery 1: Count peserta_kelas with the same kelas_id
        $builder = $db->table('peserta_kelas');
        $builder->selectCount('data_kelas_id');
        $builder->where('peserta_kelas.data_kelas_id = program_kelas.kelas_id');
        $subQuery = $builder->getCompiledSelect();

        // Subquery 2: Check if peserta has already taken the class
        $builder2 = $db->table('peserta_kelas');
        $builder2->select('IF(COUNT(*) > 0, 1, 0)', false); // Use 'false' to disable field escaping
        $builder2->where('peserta_kelas.data_kelas_id = program_kelas.kelas_id')
                ->where('peserta_kelas.data_peserta_id', $peserta_id);
        $subQuery2 = $builder2->getCompiledSelect();

        $mainQuery = $db->table('program_kelas')
            ->select('program_kelas.*, program.*, pengajar.*, peserta_level.*, ('.$subQuery.') as peserta_kelas_count, ('.$subQuery2.') as peserta_status')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->where('status_kelas','aktif')
            ->where('peserta_level',$peserta_level)
            ->where('jenkel',$peserta_jenkel)
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('kelas_id', 'ASC');
        
        if($filter_domisili == 'AKTIF' && $peserta_domisili == 'BALIKPAPAN') {
            $mainQuery = $mainQuery->where('metode_kelas', 'OFFLINE');
        } elseif ($filter_domisili == 'AKTIF' && $peserta_domisili == 'LUAR BALIKPAPAN'){
            $mainQuery = $mainQuery->where('metode_kelas', 'ONLINE');
        }

        if ($peserta_status_kerja == 0) {
            $mainQuery = $mainQuery->where('status_kerja', $peserta_status_kerja);
        }

        return $mainQuery->get()->getResultArray();
    }

    public function fdt_kelas($kelas_id)
    {
        $db      = \Config\Database::connect();

        // Subquery 1: Count peserta_kelas with the same kelas_id
        $builder = $db->table('peserta_kelas');
        $builder->selectCount('data_kelas_id');
        $builder->where('peserta_kelas.data_kelas_id = program_kelas.kelas_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('program_kelas')
                    ->select('program_kelas.*, program.*, pengajar.*, peserta_level.*, ('.$subQuery.') as peserta_kelas_count')
                    ->where('kelas_id', $kelas_id)
                    ->join('program', 'program.program_id = program_kelas.program_id')
                    ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
                    ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level');
        return $mainQuery->get()->getRowArray();
    }
    /*--- END NEW MODEL ---*/

    //Daftar kelas untuk peserta -> TIDAK Bekerja -> Domisili Luar
    public function aktif($peserta_level, $peserta_jenkel, $peserta_status_kerja, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('status_kerja', $peserta_status_kerja)
            ->where('angkatan_kelas', $angkatan)
            ->where('metode_kelas', 'ONLINE')
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas untuk peserta -> TIDAK Bekerja 
    public function aktif_nodomisili($peserta_level, $peserta_jenkel, $peserta_status_kerja, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('status_kerja', $peserta_status_kerja)
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas untuk peserta -> TIDAK Bekerja -> Domisili Balikpapan
    public function aktif_balikpapan($peserta_level, $peserta_jenkel, $peserta_status_kerja, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('status_kerja', $peserta_status_kerja)
            ->where('angkatan_kelas', $angkatan)
            ->where('metode_kelas', 'OFFLINE')
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas untuk peserta -> Bekerja -> Domisili Luar
    public function aktif_pekerja($peserta_level, $peserta_jenkel, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('angkatan_kelas', $angkatan)
            ->where('metode_kelas', 'ONLINE')
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas untuk peserta -> Bekerja 
    public function aktif_pekerja_nodomisili($peserta_level, $peserta_jenkel, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas untuk peserta -> Bekerja -> Domisili Balikpapan
    public function aktif_pekerja_balikpapan($peserta_level, $peserta_jenkel, $angkatan )
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->where('status_kelas', 'aktif')
            ->where('peserta_level', $peserta_level)
            ->where('jenkel', $peserta_jenkel)
            ->where('angkatan_kelas', $angkatan)
            ->where('metode_kelas', 'OFFLINE')
            ->orderBy('kelas_id', 'ASC')
            ->get()->getResultArray();
    }

    //Daftar kelas utk peserta yang sudah memilih kelas
    public function aktif_kelas_terdaftar($cek3_arr)
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->wherein('kelas_id', $cek3_arr)
            ->get()->getResultArray();
    }

    // Get Sisa Kouta
    public function get_sisa_kouta($kelas_id)
    {
        return $this->table('program_kelas')
            ->select('sisa_kouta')
            ->where('kelas_id', $kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Program ID
    public function get_program_id($kelas_id)
    {
        return $this->table('program_kelas')
            ->select('program_id')
            ->where('kelas_id', $kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Jumlah Peserta
    public function get_jumlah_peserta($kelas_id)
    {
        return $this->table('program_kelas')
            ->select('jumlah_peserta')
            ->where('kelas_id', $kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Sisa Kouta Kelas Asal - Fitur Pindah Kelas
    public function get_sisa_kouta_asal($asal_kelas_id)
    {
        return $this->table('program_kelas')
            ->select('sisa_kouta')
            ->where('kelas_id', $asal_kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Sisa Kouta Kelas Tujuan - Fitur Pindah Kelas
    public function get_sisa_kouta_tujuan($tujuan_kelas_id)
    {
        return $this->table('program_kelas')
            ->select('sisa_kouta')
            ->where('kelas_id', $tujuan_kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Jumlah Peserta Kelas Asal - Fitur Pindah Kelas
    public function get_jumlah_peserta_asal($asal_kelas_id)
    {
        return $this->table('program_kelas')
            ->select('jumlah_peserta')
            ->where('kelas_id', $asal_kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Jumlah Peserta Kelas Tujuan - Fitur Pindah Kelas
    public function get_jumlah_peserta_tujuan($tujuan_kelas_id)
    {
        return $this->table('program_kelas')
            ->select('jumlah_peserta')
            ->where('kelas_id', $tujuan_kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get Data Kelas
    public function list()
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->orderBy('kelas_id', 'DESC')
            ->get()->getResultArray();
    }

    //  public function list_2nd($angkatan)
    //  {
    //      return $this->table('program_kelas')
    //          ->join('program', 'program.program_id = program_kelas.program_id')
    //          ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
    //          ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
    //          ->where('angkatan_kelas', $angkatan)
    //          ->orderBy('kelas_id', 'DESC')
    //          ->get()->getResultArray();
    //  }

     

    public function list_ada_kouta()
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->where('sisa_kouta !=', 0)
            ->orderBy('kelas_id', 'DESC')
            ->get()->getResultArray();
    }

    public function list_sesuai_angkatan_perkuliahan($angkatan)
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('kelas_id', 'DESC')
            ->get()->getResultArray();
    }

    public function list_detail_kelas($kelas_id)
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->join('absen_pengajar', 'absen_pengajar.absen_pengajar_id = program_kelas.data_absen_pengajar')
            ->where('kelas_id', $kelas_id)
            ->get()->getResultArray();
    }

    public function detail_kelas_bayar($kelas_id)
    {
        return $this->table('program_kelas')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->where('kelas_id', $kelas_id)
            ->get()->getRowArray();
    }

    //Group_concat hitung table jumlah fk dari pk tabel lain
    //  public function list_kelas_dan_jml_peserta()
    //  {
    //     return $this->table('program_kelas')
    //     ->join('program', 'program.program_id = program_kelas.program_id')
    //     ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
    //     ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
    //     ->join('peserta_kelas', 'data_kelas_id = program_kelas.kelas_id', 'left')
    //     ->count('data_kelas_id')
    //     ->orderBy('kelas_id', 'DESC')
    //     ->get()->getResultArray();
    //  }

    //Dashboard - Admin
    public function jml_kelas()
    {
        return $this->table('program_kelas')
        ->countAllResults();
    }

    //Panel Pengajar - Menu Kelas & Absen
    // public function kelas_pengajar($pengajar_id, $angkatan)
    // {
    //     return $this->table('program_kelas')
    //         ->join('program', 'program.program_id = program_kelas.program_id')
    //         ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
    //         ->where('pengajar_id', $pengajar_id)
    //         ->where('angkatan_kelas', $angkatan)
    //         ->where('status_kelas', 'aktif')
    //         ->get()->getResultArray();
    // }

    public function kelas_pengajar($pengajar_id, $angkatan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('peserta_kelas');

        $builder->selectCount('data_kelas_id');
        $builder->where('peserta_kelas.data_kelas_id = program_kelas.kelas_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('program_kelas')
            ->select('program_kelas.*, program.*, peserta_level.*, ('.$subQuery.') as peserta_kelas_count')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->where('pengajar_id', $pengajar_id)
            ->where('angkatan_kelas', $angkatan)
            ->where('status_kelas', 'aktif')
            ->orderBy('kelas_id', 'DESC');

        return $mainQuery->get()->getResultArray();
    }

    //Pengajar Panel - Absensi Peserta
    // public function pengajar_onkelas_absen($kelas_id)
    // {
    //     return $this->table('program_kelas')
    //         ->join('absen_pengajar', 'absen_pengajar.absen_pengajar_id = program_kelas.data_absen_pengajar')
    //         ->where('kelas_id', $kelas_id)
    //         ->get()->getResultArray();
    // }

    public function get_data_absen_pengajar_id($kelas_id)
    {
        return $this->table('program_kelas')
            ->select('data_absen_pengajar')
            ->where('kelas_id', $kelas_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Seluruh angkatan (unik value / Distinct)
    public function list_unik_angkatan()
    {
        return $this->table('program_kelas')
            ->select('angkatan_kelas')
            ->orderBy('angkatan_kelas', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }

    //Rekap data absen pengajar - Admin panel
    public function admin_rekap_absen_pengajar($angkatan)
    {
        return $this->table('program_kelas')
            //->join('peserta', 'peserta.peserta_id = peserta_kelas.data_peserta_id')
            //->join('program_kelas', 'program_kelas.kelas_id = peserta_kelas.data_kelas_id')
            ->join('program', 'program.program_id = program_kelas.program_id')
            ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
            ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
            ->join('kantor_cabang', 'kantor_cabang.kantor_id = pengajar.asal_kantor')
            ->join('absen_pengajar', 'absen_pengajar.absen_pengajar_id = program_kelas.data_absen_pengajar')
            //->where('spp_status !=', 'BELUM BAYAR PENDAFTARAN')
            ->where('angkatan_kelas', $angkatan)
            ->orderBy('nama_pengajar', 'ASC')
            ->get()->getResultArray();
    }
}
