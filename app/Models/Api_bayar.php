<?php

namespace App\Models;

use CodeIgniter\Model;

class Api_bayar extends Model
{
    protected $table      = 'program_bayar ';
    protected $primaryKey = 'bayar_id';
    protected $allowedFields = ['kelas_id', 'bayar_peserta_id', 'bayar_peserta_kelas_id','status_bayar',  'status_bayar_admin','status_konfirmasi', 'awal_bayar', 'awal_bayar_daftar', 'awal_bayar_infaq', 'awal_bayar_modul', 'awal_bayar_lainnya', 'awal_bayar_spp1', 'awal_bayar_spp2', 'awal_bayar_spp3', 'awal_bayar_spp4', 'nominal_bayar','bukti_bayar', 'keterangan_bayar', 'keterangan_bayar_admin','tgl_bayar', 'waktu_bayar', 'tgl_bayar_dl', 'waktu_bayar_dl','tgl_bayar_konfirmasi', 'waktu_bayar_konfirmasi', 'validator', 'metode', 'flip_bill_id', 'beasiswa_id'];
}
