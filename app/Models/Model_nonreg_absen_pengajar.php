<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_nonreg_absen_pengajar extends Model
{
    protected $table            = 'nonreg_absen_pengajar';
    protected $primaryKey       = 'napj_id';
    protected $allowedFields = [
        'napj_pengajar',
        'napj1',
        'napj2',
        'napj3',
        'napj4',
        'napj5',
        'napj6',
        'napj7',
        'napj8',
        'napj9',
        'napj10',
        'napj11',
        'napj12',
        'napj13',
        'napj14',
        'napj15',
        'napj16',
        'napj17',
        'napj18',
        'napj19',
        'napj20',
        'napj21',
        'napj22',
        'napj23',
        'napj24',
        'napj25',
        'napj26',
        'napj27',
        'napj28',
        'napj29',
        'napj30',
        'napj31',
        'napj32',
        'napj33',
        'napj34',
        'napj35',
        'napj36',
        'napj37',
        'napj38',
        'napj39',
        'napj40',
        'napj41',
        'napj42',
        'napj43',
        'napj44',
        'napj45',
        'napj46',
        'napj47',
        'napj48',
        'napj49',
        'napj50'
    ];

    public function list_rekap($tahun)
    {
        return $this->table('nonreg_absen_pengajar')
            ->select('nonreg_absen_pengajar.*, pengajar.nama_pengajar, pengajar.kategori_pengajar, nonreg_kelas.*, program.biaya_bulanan')
            ->where('nk_tahun', $tahun)
            ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
            ->join('nonreg_kelas', 'nonreg_kelas.nk_id = nonreg_pengajar.npj_kelas')
            ->join('pengajar', 'pengajar.pengajar_id = nonreg_pengajar.npj_pengajar')
            ->join('program', 'program.program_id = nonreg_kelas.nk_program')
            ->get()->getResultArray();
    }
}
