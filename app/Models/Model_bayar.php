<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bayar extends Model
{
    protected $table      = 'program_bayar ';
    protected $primaryKey = 'bayar_id';
    protected $allowedFields = ['kelas_id', 'bayar_peserta_id', 'bayar_peserta_kelas_id','status_bayar',  'status_bayar_admin','status_konfirmasi', 'awal_bayar', 'awal_bayar_daftar', 'awal_bayar_infaq', 'awal_bayar_modul', 'awal_bayar_lainnya', 'awal_bayar_spp1', 'awal_bayar_spp2', 'awal_bayar_spp3', 'awal_bayar_spp4', 'nominal_bayar','bukti_bayar', 'keterangan_bayar', 'keterangan_bayar_admin','tgl_bayar', 'waktu_bayar', 'tgl_bayar_dl', 'waktu_bayar_dl','tgl_bayar_konfirmasi', 'waktu_bayar_konfirmasi', 'validator', 'metode', 'flip_bill_id', 'beasiswa_id'];

    
    //Custom Query
    public function belum_lunas($peserta_id)
    {
        return $this->table('program_bayar')
            ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
            ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
            ->join('program', 'program_kelas.program_id = program.program_id')
            ->where('status_bayar', 'Belum Lunas')
            ->where('bayar_peserta_id', $peserta_id)
            ->get()
            ->getResultArray();
    }

    public function cek_belum_lunas($peserta_id)
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->where('status_bayar', 'Belum Lunas')
        ->where('bayar_peserta_id', $peserta_id)
        ->countAllResults();
    }

    //Admin - Controller Pembayaran
    public function bayar_konfirmasi()
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi', 'Proses')
        ->get()
        ->getResultArray();
    }

    //Get jenis bayar
    public function get_jenis_bayar()
    {
        return $this->table('program_bayar')
        ->select('jenis_bayar')
        ->where('status_bayar', 'Belum Lunas')
        ->get()
        ->getResultArray();
    }

    public function get_kelas_id($bayar_id)
    {
        return $this->table('program_bayar')
            ->select('kelas_id')
            ->where('bayar_id', $bayar_id)
            ->get()
            ->getUnbufferedRow();
    }

    public function list()
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi !=', NULL)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    public function list_2nd($angkatan)
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi !=', NULL)
        ->where('angkatan_kelas', $angkatan)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    //Get list pembayran peserta - Panel Peserta
    public function list_pembayaran_peserta($peserta_id)
    {
        return $this->table('program_bayar')
        //->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        //->join('program', 'program_kelas.program_id = program.program_id')
        ->where('bayar_peserta_id', $peserta_id)
        ->where('status_konfirmasi !=', NULL)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

     //Get list rician pembayran peserta - Admin Panel 
     public function rincian_bayar_peserta($peserta_id)
     {
         return $this->table('program_bayar')
         ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
         ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
         ->join('program', 'program_kelas.program_id = program.program_id')
         ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
         ->where('bayar_peserta_id', $peserta_id)
         //->where('nama_kelas', $nama_kelas)
         ->orderBy('bayar_id', 'DESC')
         ->get()
         ->getResultArray();
     }

    //Dashboard - Admin
    public function jml_bayar_proses()
    {
        return $this->table('program_bayar')
        ->where('status_konfirmasi', 'Proses')
        ->countAllResults();
    }

    //Cek pembayaran peserta sudah expired, CRON JOB
    public function bayar_expired($tgl, $waktu)
    {
        return $this->table('program_bayar')
        ->select('bayar_id')
        //->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        //->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        //->join('program', 'program_kelas.program_id = program.program_id')
        ->where('tgl_bayar_dl', $tgl)
        ->where('waktu_bayar_dl <=', $waktu)
        ->where('status_konfirmasi', NULL)
        // ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }
}
