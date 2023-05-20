<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_ujian extends Model
{
    protected $table      = 'ujian';
    protected $primaryKey = 'ujian_id';
    protected $allowedFields = ['bckp_ujian_peserta', 'bckp_ujian_kelas', 'tgl_ujian', 'waktu_ujian', 'nilai_ujian', 'nilai_akhir', 'next_level', 'ujian_note'];

    //Cek data duplikat - import file excel pada data admin rekap ujian peserta
    public function cek_ujian($id_ujian)
    {
        return $this->table('ujian')
            ->where('ujian_id', $id_ujian)
            ->countAllResults();
    }

}
