<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_spp4 extends Model
{
    protected $table      = 'program_bayar_spp4 ';
    protected $primaryKey = 'spp4_id';
    protected $allowedFields = ['spp4_bayar_id', 'bayar_spp4', 'status_spp4'];
}
