<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_kelas extends Model
{
    protected $table      = 'nonreg_kelas';
    protected $primaryKey = 'nk_id';
    protected $allowedFields = ['nk_name', 'nk_angkatan', 'nk_hari', 'nk_waktu', 'nk_timezone', 'nk_level','nk_jenkel', 'nk_status', 'nk_created', 'nk_tm_methode','nk_tm_total', 'nk_absen_status', 'nk_absen_methode', 'nk_absen_koor'];

    public function list($angkatan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('nonreg_peserta');

        $builder->selectCount('ns_kelas');
        $builder->where('nonreg_peserta.ns_kelas = nonreg_kelas.nk_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('nonreg_kelas')
            ->select('nonreg_kelas.*, ('.$subQuery.') as peserta_nonreg_count')
            ->where('nk_angkatan', $angkatan)
            ->orderBy('nk_id', 'DESC');

        return $mainQuery->get()->getResultArray();
    }

    //Seluruh angkatan (unik value / Distinct)
    public function list_unik_angkatan()
    {
        return $this->table('nonreg_kelas')
            ->select('nk_angkatan')
            ->orderBy('nk_angkatan', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }
    
}