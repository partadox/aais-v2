<?php

namespace App\Models;

use CodeIgniter\Model;

class Api_peserta extends Model
{
    protected $table      = 'peserta';
    protected $primaryKey = 'peserta_id';
    protected $allowedFields = ['user_id', 'asal_cabang_peserta','level_peserta','nama_peserta', 'status_peserta', 'nik', 'tmp_lahir', 'tgl_lahir', 'jenkel', 'pendidikan', 'jurusan', 'status_kerja','pekerjaan', 'domisili_peserta', 'alamat', 'hp', 'email', 'nis', 'angkatan', 'tgl_gabung', 'peserta_note'];
}
