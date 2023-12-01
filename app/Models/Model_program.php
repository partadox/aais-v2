<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_program extends Model
{
    protected $table      = 'program';
    protected $primaryKey = 'program_id';
    protected $allowedFields = ['nama_program', 'jenis_program', 'kategori_program', 'biaya_program', 'biaya_bulanan', 'biaya_modul', 'biaya_daftar', 'status_program', 'ujian_custom_status', 'ujian_custom_id', 'ujian_show'];

    //backend
    public function list()
    {
        return $this->table('program')
            //->orderBy('nama_program', 'ASC')
            // ->where('kategori_program', 'REGULER')
            ->get()->getResultArray();
    }

    public function list_reguler()
    {
        return $this->table('program')
            //->orderBy('nama_program', 'ASC')
            ->where('kategori_program !=', 'NON-REGULER')
            ->get()->getResultArray();
    }

    public function list_non_reguler()
    {
        return $this->table('program')
            //->orderBy('nama_program', 'ASC')
            ->where('kategori_program', 'NON-REGULER')
            ->get()->getResultArray();
    }

    public function list_aktif()
    {
        return $this->table('program')
            ->orderBy('nama_program', 'ASC')
            ->where('status_program', 'aktif')
            ->get()->getResultArray();
    }

    //Dashboaed - Admin
    public function jml_program()
    {
        return $this->table('program')
        ->countAllResults();
    }

    // Get Biaya Program
    public function get_biaya_program($program_id)
    {
        return $this->table('program')
            ->select('biaya_program')
            ->where('program_id', $program_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get SPP Bulanan
    public function get_biaya_bulanan($program_id)
    {
        return $this->table('program')
            ->select('biaya_bulanan')
            ->where('program_id', $program_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get SPP Daftar
    public function get_biaya_daftar($program_id)
    {
        return $this->table('program')
            ->select('biaya_daftar')
            ->where('program_id', $program_id)
            ->get()
            ->getUnbufferedRow();
    }

    // Get SPP Bulanan
    public function get_biaya_modul($program_id)
    {
        return $this->table('program')
            ->select('biaya_modul')
            ->where('program_id', $program_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Cek data apa id program ada - import beasiswa
    public function cek_program_id($program_id)
    {
        return $this->table('program')
            ->where('program_id', $program_id)
            ->countAllResults();
    }

    //Get Ujian Custom
    public function list_ujian_custom()
    {
        return $this->table('program')
            ->orderBy('nama_program', 'ASC')
            ->where('ujian_custom_status', '1')
            ->get()->getResultArray();
    }
}
