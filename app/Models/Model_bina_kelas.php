<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_bina_kelas extends Model
{
    protected $table      = 'bina_kelas';
    protected $primaryKey = 'bk_id';
    protected $allowedFields = ['bk_name', 'bk_angkatan', 'bk_hari', 'bk_waktu', 'bk_timezone', 'bk_level','bk_jenkel', 'bk_status', 'bk_created', 'bk_tm_methode','bk_tm_total', 'bk_absen_status', 'bk_absen_methode', 'bk_absen_koor', 'bk_absen_expired'];

    public function list($angkatan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('bina_peserta');

        $builder->selectCount('bs_kelas');
        $builder->where('bina_peserta.bs_kelas = bina_kelas.bk_id');
        $subQuery = $builder->getCompiledSelect();

        $mainQuery = $db->table('bina_kelas')
            ->select('bina_kelas.*, ('.$subQuery.') as peserta_bina_count')
            ->where('bk_angkatan', $angkatan)
            ->orderBy('bk_id', 'DESC');

        return $mainQuery->get()->getResultArray();
    }

    //Seluruh angkatan (unik value / Distinct)
    public function list_unik_angkatan()
    {
        return $this->table('bina_kelas')
            ->select('bk_angkatan')
            ->orderBy('bk_angkatan', 'DESC')
            ->distinct()
            ->get()->getResultArray();
    }
    
}