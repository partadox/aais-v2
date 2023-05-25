<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bill extends Model
{
    protected $table      = 'flip_bill';
    protected $primaryKey = 'bill_id';
    protected $allowedFields = ['bill_code','bill_link', 'bill_amount', 'bill_va', 'bill_bank', 'bill_unique_code', 'bill_expired'];
}