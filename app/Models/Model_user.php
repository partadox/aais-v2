<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Model_user extends Model
{
    protected $table      = 'user ';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'nama', 'password', 'foto', 'level', 'active'];
    protected $column_order = array(null, null, 'user_id', 'nama', 'username', 'active',null);
    protected $column_search = array('nama', 'username');
    protected $order = array('user_id' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    //backend
    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)->select('*')->where('level', 4);
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


    public function list()
    {
        return $this->table('user')
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_peserta()
    {
        return $this->table('user')
            ->where('level', 4)
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_pengajar()
    {
        return $this->table('user')
            ->where('level', 5)
            ->orwhere('level', 6)
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_pengajar_nonaktif()
    {
        return $this->table('user')
            ->where('active', 0)
            ->where('level', 5)
            ->orwhere('level', 6)
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_peserta_pengajar()
    {
        //$where = "level=4 OR level=5";
        return $this->table('user')
            ->where('level',  4) 
            ->orwhere('level', 5)
            ->orwhere('level', 6)
            //->join('user_level', 'user_level.user_level_id = user.level')
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function list_admin()
    {
        //$where = "level=4 OR level=5";
        return $this->table('user')
            ->where('level', 1)
            ->orwhere('level',  2) 
            ->orwhere('level', 3)
            //->join('user_level', 'user_level.user_level_id = user.level')
            ->orderBy('user_id', 'DESC')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('user')
            ->like('active', '1')
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('user')
            ->where('active', 0)
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif_peserta()
    {
        return $this->table('user')
            ->where('active', 0)
            ->where('level', 4)
            ->orderBy('user_id', 'ASC')
            ->get()->getResultArray();
    }

    //Cek data duplikat - import file excel pada data akun user peserta
    public function cek_duplikat_import_akun_peserta($username)
    {
        return $this->table('user')
            ->where('username', $username)
            ->countAllResults();
    }

    //Cek akun user ada - import file excel pada data akun user peserta
    public function cek_user_ada($user_id)
    {
        return $this->table('user')
            ->where('user_id', $user_id)
            ->countAllResults();
    }

    //Cek data akun peserta ada atau tidak berdasarkan user_id
    public function cek_multiple_edit($user_id)
    {
        return $this->table('user')
            ->where('user_id', $user_id)
            ->countAllResults();
    }

    //Dashboard - Admin - Jumlah Akun Pengajar
    public function jml_akun_pengajar()
    {
        return $this->table('user')
        ->where('level', 5)
        ->orwhere('level', 6)
        ->countAllResults();
    }

    //Dashboard - Admin - Jumlah Akun Peserta
    public function jml_akun_peserta()
    {
        return $this->table('user')
        ->where('level', 4)
        ->orwhere('level',8)
        ->countAllResults();
    }

}
