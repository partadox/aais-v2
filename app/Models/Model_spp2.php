<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_spp2 extends Model
{
    protected $table      = 'program_bayar_spp2 ';
    protected $primaryKey = 'spp2_id';
    protected $allowedFields = ['spp2_bayar_id', 'bayar_spp2', 'status_spp2'];
}
