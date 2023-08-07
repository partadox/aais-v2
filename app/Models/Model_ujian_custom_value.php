<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_ujian_custom_value extends Model
{
    protected $table      = 'ujian_custom_value';
    protected $primaryKey = 'ucv_id';
    protected $allowedFields = ['ucv_ujian_id', 'ucv_peserta_id', 'ucv_kelas_id', 'ucv_text1', 'ucv_text2', 'ucv_text3', 'ucv_text4', 'ucv_text5', 'ucv_text6', 'ucv_text7', 'ucv_text8', 'ucv_text9', 'ucv_text10', 'ucv_int1', 'ucv_int2', 'ucv_int3', 'ucv_int4', 'ucv_int5', 'ucv_int6', 'ucv_int7', 'ucv_int8', 'ucv_int9', 'ucv_int10'];
}