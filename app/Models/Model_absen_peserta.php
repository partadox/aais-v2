<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_absen_peserta extends Model
{
    protected $table      = 'absen_peserta';
    protected $primaryKey = 'absen_peserta_id';
    protected $allowedFields = ['bckp_absen_peserta_id', 'bckp_absen_peserta_kelas','tm1', 'tm2' , 'tm3', 'tm4', 'tm5', 'tm6', 'tm7', 'tm8', 'tm9', 'tm10', 'tm11', 'tm12', 'tm13', 'tm14', 'tm15', 'tm16', 'note_ps_tm1', 'note_ps_tm2', 'note_ps_tm3', 'note_ps_tm4', 'note_ps_tm5', 'note_ps_tm6', 'note_ps_tm7', 'note_ps_tm8', 'note_ps_tm9', 'note_ps_tm10', 'note_ps_tm11', 'note_ps_tm12', 'note_ps_tm13', 'note_ps_tm14', 'note_ps_tm15', 'note_ps_tm16'];

}
