<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_absen_peserta extends Model
{
    protected $table      = 'absen_peserta';
    protected $primaryKey = 'absen_peserta_id';
    protected $allowedFields = ['bckp_absen_peserta_id', 'bckp_absen_peserta_kelas','tm1', 'tm2' , 'tm3', 'tm4', 'tm5', 'tm6', 'tm7', 'tm8', 'tm9', 'tm10', 'tm11', 'tm12', 'tm13', 'tm14', 'tm15', 'tm16'];

}
