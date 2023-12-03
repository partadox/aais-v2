<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_usaha extends Model
{
    protected $table      = 'nonreg_usaha';
    protected $primaryKey = 'nu_usaha';
    protected $useAutoIncrement = false;
    protected $allowedFields = [];
}