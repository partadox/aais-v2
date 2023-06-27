<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_pengumuman extends Model
{
    protected $table      = 'pengumuman';
    protected $primaryKey = 'pengumuman_id';
    protected $allowedFields = ['pengumuman_status', 'pengumuman_type', 'pengumuman_create', 'pengumuman_by', 'pengumuman_title', 'pengumuman_content'];

    public function list()
    {
        return $this->table('pengumuman')
            ->get()->getResultArray();
    }
    public function list_peserta()
    {
        return $this->table('pengumuman')
            ->where('pengumuman_type', 'PESERTA')
            ->where('pengumuman_status',1)
            ->get()->getResultArray();
    }

    public function list_pengajar()
    {
        return $this->table('cart')
            ->where('pengumuman_type', 'PENGAJAR')
            ->where('pengumuman_status',1)
            ->get()->getResultArray();
    }
}