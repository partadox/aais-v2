<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_sertifikat extends Model
{
    protected $table      = 'sertifikat';
    protected $primaryKey = 'sertifikat_id';
    protected $allowedFields = ['sertifikat_peserta_id', 'sertifikat_program','nomor_sertifikat', 'periode_cetak','jenis_sertifikat', 'nominal_bayar_cetak', 'status', 'bukti_bayar_cetak', 'dt_ajuan', 'dt_konfirmasi','keterangan_cetak', 'sertifikat_tgl', 'sertifikat_file', 'angkatan_sertifikat', 'sertifikat_kelas', 'unshow'];

    public function list($periode)
    {
        return $this->table('sertifikat')
            ->select('sertifikat.sertifikat_id, sertifikat.nomor_sertifikat, peserta.nis, peserta.nama_peserta, peserta.jenkel, program.nama_program, sertifikat.sertifikat_tgl, sertifikat.status, sertifikat.nominal_bayar_cetak, sertifikat.bukti_bayar_cetak, sertifikat.keterangan_cetak, sertifikat.sertifikat_kelas, program_kelas.nama_kelas,sertifikat.sertifikat_file, sertifikat.unshow')
            ->join('peserta', 'peserta.peserta_id = sertifikat.sertifikat_peserta_id')
            ->join('program', 'program.program_id = sertifikat.sertifikat_program')
            ->join('program_kelas', 'program_kelas.kelas_id = sertifikat.sertifikat_kelas')
            ->where('periode_cetak', $periode)
            ->orderBy('sertifikat_id', 'DESC')
            ->get()->getResultArray();
    }

    public function list_peserta($peserta_id)
    {
        return $this->table('sertifikat')
            ->select('program_bayar.bayar_id, program_bayar.tgl_bayar, program_bayar.waktu_bayar, program_bayar.tgl_bayar_konfirmasi,  program_bayar.waktu_bayar_konfirmasi,  program_bayar.status_bayar, program_bayar.nominal_bayar, program_bayar.bukti_bayar, program_bayar.status_bayar_admin, program_bayar.keterangan_bayar, program_bayar.keterangan_bayar_admin, program_bayar.status_konfirmasi, program_bayar.awal_bayar_spp1, program_bayar.awal_bayar_infaq, program.nama_program, sertifikat.nomor_sertifikat, sertifikat.sertifikat_tgl, sertifikat.sertifikat_file, sertifikat.status as sertifikat_status, sertifikat.sertifikat_id, sertifikat.sertifikat_kelas, program_kelas.nama_kelas, sertifikat.unshow')
            //->join('peserta_kelas', 'peserta_kelas.data_peserta_id = sertifikat.sertifikat_peserta_id')
            //->join('peserta', 'peserta.peserta_id = sertifikat.sertifikat_peserta_id')
            ->join('program_kelas', 'program_kelas.kelas_id = sertifikat.sertifikat_kelas')
            ->join('program', 'program.program_id = sertifikat.sertifikat_program')
            ->join('program_bayar', 'program_bayar.bayar_id = sertifikat.bukti_bayar_cetak')
            //->join('peserta_level', 'peserta_level.peserta_level_id = peserta.level_peserta')
            ->where('sertifikat_peserta_id', $peserta_id)
            ->orderBy('sertifikat_id', 'DESC')
            ->get()->getResultArray();
    }

    //Seluruh periode cetak (unik value / Distinct)
    public function list_unik_periode()
    {
        return $this->table('sertifikat')
            ->select('periode_cetak')
            ->orderBy('periode_cetak', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }

    //Cek data duplikat - import file excel pada data rekap sertifikat
    public function cek_nomor_sertifikat_duplikat($nomor_sertifikat)
    {
        return $this->table('sertifikat')
            ->where('nomor_sertifikat', $nomor_sertifikat)
            ->countAllResults();
    }

    //Admin - Controller Pembayaran
    public function bayar_konfirmasi_sertifikat()
    {
        return $this->table('sertifikat')
        ->select('peserta.nis, peserta.nama_peserta, program_bayar.bayar_id,  program_bayar.tgl_bayar, program_bayar.waktu_bayar, program_bayar.tgl_bayar_konfirmasi,  program_bayar.waktu_bayar_konfirmasi,  program_bayar.status_bayar, program_bayar.nominal_bayar, program_bayar.awal_bayar_spp1, program_bayar.awal_bayar_infaq, program_bayar.bukti_bayar, program_bayar.status_bayar_admin, program_bayar.keterangan_bayar, program_bayar.keterangan_bayar_admin, program_bayar.status_konfirmasi, program.nama_program, program_kelas.nama_kelas, sertifikat.sertifikat_kelas, sertifikat.sertifikat_id')
        ->join('program_bayar', 'program_bayar.bayar_id = sertifikat.bukti_bayar_cetak')
        ->join('program_kelas', 'program_kelas.kelas_id = sertifikat.sertifikat_kelas')
        ->join('peserta', 'peserta.peserta_id = sertifikat.sertifikat_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi', 'Proses')
        ->where('bayar_tipe', 'sertifikat')
        ->where('metode', NULL)
        ->get()
        ->getResultArray();
    }

    public function bayar_sertifikat()
    {
        return $this->table('sertifikat')
        ->select('peserta.nis, peserta.nama_peserta, program_bayar.bayar_id,  program_bayar.tgl_bayar, program_bayar.waktu_bayar, program_bayar.tgl_bayar_konfirmasi,  program_bayar.waktu_bayar_konfirmasi,  program_bayar.status_bayar, program_bayar.nominal_bayar, program_bayar.awal_bayar_spp1, program_bayar.awal_bayar_infaq, program_bayar.bukti_bayar, program_bayar.status_bayar_admin, program_bayar.keterangan_bayar, program_bayar.keterangan_bayar_admin, program_bayar.status_konfirmasi, program.nama_program, program_kelas.nama_kelas, sertifikat.sertifikat_kelas, sertifikat.sertifikat_id')
        ->join('program_bayar', 'program_bayar.bayar_id = sertifikat.bukti_bayar_cetak')
        ->join('program_kelas', 'program_kelas.kelas_id = sertifikat.sertifikat_kelas')
        ->join('peserta', 'peserta.peserta_id = sertifikat.sertifikat_peserta_id')
        ->join('program', 'sertifikat.sertifikat_program = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        // ->where('status_konfirmasi', 'Proses')
        ->where('bayar_tipe', 'sertifikat')
        ->where('metode', NULL)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    public function sertifikat_sudah_peserta($peserta_id)
    {
        return $this->table('sertifikat')
            ->select('sertifikat.sertifikat_kelas')
            ->where('sertifikat_peserta_id', $peserta_id)
            ->where('sertifikat_kelas !=', '1')
            ->orderBy('sertifikat_id', 'DESC')
            ->get()->getResultArray();
    }

}