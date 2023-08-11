<?php

namespace App\Models;

use CodeIgniter\Model;

class Api_peserta_kelas extends Model
{
    protected $table      = 'peserta_kelas';
    protected $primaryKey = 'peserta_kelas_id';
    protected $allowedFields = ['peserta_kelas_id', 'data_peserta_id','data_kelas_id', 'data_absen', 'data_ujian', 'status_peserta_kelas', 'byr_daftar', 'byr_modul','byr_spp1','byr_spp2','byr_spp3', 'byr_spp4', 'spp_status', 'spp_terbayar', 'spp_piutang', 'dt_bayar_daftar', 'dt_bayar_spp2', 'dt_bayar_spp3', 'dt_bayar_spp4', 'dt_konfirmasi_daftar', 'dt_konfirmasi_spp2', 'dt_konfirmasi_spp3', 'dt_konfirmasi_spp4','expired_tgl_daftar','expired_waktu_daftar', 'status_aktif_peserta', 'beasiswa_daftar', 'beasiswa_spp1', 'beasiswa_spp2', 'beasiswa_spp3', 'beasiswa_spp4'];
}
