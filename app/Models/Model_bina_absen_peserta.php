<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bina_absen_peserta extends Model
{
    protected $table      = 'bina_absen_peserta';
    protected $primaryKey = 'bas_id';
    protected $allowedFields = ['bas_nsid', 'bas_njid', 'bas_tm', 'bas_tm_dt', 'bas_status', 'bas_absen','bas_create', 'bas_by', 'bas_note'];
}