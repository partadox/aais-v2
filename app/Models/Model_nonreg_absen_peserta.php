<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_absen_peserta extends Model
{
    protected $table      = 'nonreg_absen_peserta';
    protected $primaryKey = 'nas_id';
    protected $allowedFields = ['nas_nsid', 'nas_njid', 'nas_tm', 'nas_tm_dt', 'nas_status', 'nas_create', 'nas_by', 'nas_note'];
}