<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_ujian_custom_config extends Model
{
    protected $table      = 'ujian_custom_config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['text1_status', 'text1_name', 'text2_status', 'text2_name', 'text3_status', 'text3_name', 'text4_status', 'text4_name', 'text5_status', 'text5_name', 'text6_status', 'text6_name', 'text7_status', 'text7_name', 'text8_status', 'text8_name', 'text9_status', 'text9_name', 'text10_status', 'text10_name', 'int1_status', 'int1_name', 'int2_status', 'int2_name', 'int3_status', 'int3_name', 'int4_status', 'int4_name', 'int5_status', 'int5_name', 'int6_status', 'int6_name', 'int7_status', 'int7_name', 'int8_status', 'int8_name', 'int9_status', 'int9_name', 'int10_status', 'int10_name'];
}