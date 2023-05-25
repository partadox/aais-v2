<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Model_peserta extends Model
{
    protected $table      = 'peserta';
    protected $primaryKey = 'peserta_id';
    protected $allowedFields = ['user_id', 'asal_cabang_peserta','level_peserta','nama_peserta', 'status_peserta', 'nik', 'tmp_lahir', 'tgl_lahir', 'jenkel', 'pendidikan', 'jurusan', 'status_kerja','pekerjaan', 'domisili_peserta', 'alamat', 'hp', 'email', 'nis', 'angkatan', 'tgl_gabung', 'peserta_note'];


    protected $column_order = array(null, null, 'peserta_id', 'nis', 'nama_peserta', 'nik', 'asal_cabang_peserta', 'jenkel', 'hp', 'level_peserta', 'angkatan','tgl_lahir', 'status_peserta', 'user_id',null);
    protected $column_search = array('nis', 'nama_peserta');
    protected $order = array('nis' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    //backend
    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)
        ->select('*')
        ->join('peserta_level', 'peserta_level.peserta_level_id = peserta.level_peserta')
        ->join('user', 'user.user_id = peserta.user_id')
        ->join('kantor_cabang', 'kantor_cabang.kantor_id = peserta.asal_cabang_peserta')
        ->orderBy('peserta_id', 'DESC');
    }
    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if (isset($_POST['search']['value'])) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $_POST['search']('value'));
                } else {
                    $this->dt->orLike($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->dt->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_POST['length' != -1]))
            $this->dt->limit($_POST['length'], $_POST['start']);
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    // Get List All Data Peserta for view of datatable
    public function list()
    {
        return $this->table('peserta')
            ->join('peserta_level', 'peserta_level.peserta_level_id = peserta.level_peserta')
            ->join('user', 'user.user_id = peserta.user_id')
            ->join('kantor_cabang', 'kantor_cabang.kantor_id = peserta.asal_cabang_peserta')
            ->orderBy('peserta_id', 'DESC')
            ->get()->getResultArray();
    }

    public function get_peserta($user_id)
    {
        return $this->table('peserta')
            ->where('user_id', $user_id)
            ->get()
            ->getRowArray();
    }

    public function get_peserta_id($user_id)
    {
        return $this->table('peserta')
            ->select('peserta_id')
            ->where('user_id', $user_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Untuk filter level - Daftar Program Peserta
    public function get_peserta_level($user_id)
    {
        return $this->table('peserta')
            ->select('level_peserta')
            ->where('user_id', $user_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Untuk filter jenis kelamin - Daftar Program Peserta
    public function get_peserta_jenkel($user_id)
    {
        return $this->table('peserta')
            ->select('jenkel')
            ->where('user_id', $user_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Untuk filter status kerja - Daftar Program Peserta
    public function get_peserta_status_kerja($user_id)
    {
        return $this->table('peserta')
            ->select('status_kerja')
            ->where('user_id', $user_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Untuk filter domisili - Daftar Program Peserta
    public function get_peserta_domisili($user_id)
    {
        return $this->table('peserta')
            ->select('domisili_peserta')
            ->where('user_id', $user_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Hapus Akun Peserta saat Data Peserta Dihapus - Get User id
    public function get_user_id($peserta_id)
    {
        return $this->table('peserta')
            ->select('user_id')
            ->where('peserta_id', $peserta_id)
            ->get()
            ->getUnbufferedRow();
    }

    //Dashboard - Admin
    public function jml_peserta()
    {
        return $this->table('peserta')
        ->countAllResults();
    }

    //Cek data duplikat - import file excel pada data peserta
    public function cek_duplikat_import($nis)
    {
        return $this->table('peserta')
            ->where('nis', $nis)
            ->countAllResults();
    }

    //Cek data duplikat user id- import file excel pada data peserta
    public function cek_duplikat_user($user_id)
    {
        return $this->table('peserta')
            ->where('user_id', $user_id)
            ->countAllResults();
    }

    //Cek data peserta ada atau tidak berdasarkan peserta_id
    public function cek_multiple_edit($peserta_id)
    {
        return $this->table('peserta')
            ->where('peserta_id', $peserta_id)
            ->countAllResults();
    }

    //Cek data apa id peserta ada - import beasiswa
    public function cek_peserta_id($peserta_id)
    {
        return $this->table('peserta')
            ->where('peserta_id', $peserta_id)
            ->countAllResults();
    }
}
