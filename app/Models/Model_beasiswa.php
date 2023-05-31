<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Model_beasiswa extends Model
{
    protected $table      = 'beasiswa';
    protected $primaryKey = 'beasiswa_id';
    protected $allowedFields = ['beasiswa_code', 'beasiswa_peserta', 'beasiswa_program', 'beasiswa_status', 'beasiswa_daftar', 'beasiswa_spp1', 'beasiswa_spp2', 'beasiswa_spp3', 'beasiswa_spp4', 'beasiswa_note', 'beasiswa_create', 'beasiswa_used'];

    protected $column_order = array(null, null, 'beasiswa_id', 'nis', 'beasiswa_code',  'nama_peserta', 'nama_program', 'beasiswa_status', 'beasiswa_daftar', 'beasiswa_spp1', 'beasiswa_spp2', 'beasiswa_spp3','beasiswa_spp4', 'beasiswa_create','beasiswa_used',null);
    protected $column_search = array('nis', 'nama_peserta');
    protected $order = array('beasiswa_id' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)
        ->select('*')
        ->join('peserta', 'peserta.peserta_id = beasiswa.beasiswa_peserta')
        ->join('program', 'program.program_id = beasiswa.beasiswa_program')
        ->orderBy('beasiswa_id', 'DESC');
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
        return $this->table('beasiswa')
            ->join('peserta', 'peserta.peserta_id = beasiswa.beasiswa_peserta')
            ->join('program', 'program.program_id = beasiswa.beasiswa_program')
            ->orderBy('beasiswa_id', 'DESC')
            ->get()->getResultArray();
    }

    public function find_code($beasiswa_code, $peserta_id, $program_id)
    {
        return $this->table('beasiswa')
            ->where('beasiswa_code', $beasiswa_code)
            ->where('beasiswa_peserta', $peserta_id)
            ->where('beasiswa_program', $program_id)
            ->where('beasiswa_status', '0')
            ->get()->getResultArray();
    }
}