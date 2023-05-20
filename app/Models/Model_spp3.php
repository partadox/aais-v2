<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_spp3 extends Model
{
    protected $table      = 'program_bayar_spp3 ';
    protected $primaryKey = 'spp3_id';
    protected $allowedFields = ['spp3_bayar_id', 'bayar_spp3', 'status_spp3'];
}
