<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_absen_peserta extends Model
{
    protected $table            = 'nonreg_absen_peserta';
    protected $primaryKey       = 'naps_id';
    protected $allowedFields = ['naps_peserta', 'naps1', 'naps2', 
    'naps3', 'naps4', 'naps5', 'naps6', 'naps7', 'naps8', 'naps9', 'naps10',
    'naps11', 'naps12', 'naps13', 'naps14', 'naps15', 'naps16', 'naps17', 'naps18', 'naps19', 'naps20',
    'naps21', 'naps22', 'naps23', 'naps24', 'naps25', 'naps26', 'naps27', 'naps28', 'naps29', 'naps30',
    'naps31', 'naps32', 'naps33', 'naps34', 'naps35', 'naps36', 'naps37', 'naps38', 'naps39', 'naps40',
    'naps41', 'naps42', 'naps43', 'naps44', 'naps45', 'naps46', 'naps47', 'naps48', 'naps49', 'naps50'];

    public function peserta_onkelas($nk_id)
    {
        return $this->table('nonreg_absen_peserta')
            ->join('nonreg_peserta', 'nonreg_peserta.np_id = nonreg_absen_peserta.naps_peserta')
            ->where('np_kelas', $nk_id)
            ->orderBy('np_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_rekap($tahun)
    {
        return $this->table('nonreg_absen_peserta')
            ->select('nonreg_absen_peserta.*, nonreg_peserta.np_nama, nonreg_kelas.nk_nama, nonreg_kelas.nk_angkatan, nonreg_kelas.nk_pic_name, nonreg_kelas.nk_tahun')
            ->where('nk_tahun', $tahun)
            ->join('nonreg_peserta', 'nonreg_peserta.np_id = nonreg_absen_peserta.naps_peserta')
            ->join('nonreg_kelas', 'nonreg_kelas.nk_id = nonreg_peserta.np_kelas')
            ->get()->getResultArray();
    }
}
