<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_tipe extends Model
{
    protected $table      = 'nonreg_tipe';
    protected $primaryKey = 'nrt_name';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['nrt_code'];
}