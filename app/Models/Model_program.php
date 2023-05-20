<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_program extends Model
{
    protected $table      = 'program';
    protected $primaryKey = 'program_id';
    protected $allowedFields = ['nama_program', 'jenis_program', 'kategori_program', 'biaya_program', 'biaya_bulanan', 'biaya_modul', 'biaya_daftar', 'status_program'];

    //backend
    public function list()
    {
        return $this->table('program')
            //->orderBy('nama_program', 'ASC')
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
}
