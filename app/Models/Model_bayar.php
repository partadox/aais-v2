<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Model_bayar extends Model
{
    protected $table      = 'program_bayar ';
    protected $primaryKey = 'bayar_id';
    protected $allowedFields = ['kelas_id', 'bayar_peserta_id', 'bayar_peserta_kelas_id','status_bayar',  'status_bayar_admin','status_konfirmasi', 'awal_bayar', 'awal_bayar_daftar', 'awal_bayar_infaq', 'awal_bayar_modul', 'awal_bayar_lainnya', 'awal_bayar_spp1', 'awal_bayar_spp2', 'awal_bayar_spp3', 'awal_bayar_spp4', 'nominal_bayar','bukti_bayar', 'keterangan_bayar', 'keterangan_bayar_admin','tgl_bayar', 'waktu_bayar', 'tgl_bayar_dl', 'waktu_bayar_dl','tgl_bayar_konfirmasi', 'waktu_bayar_konfirmasi', 'validator', 'metode', 'flip_bill_id', 'beasiswa_id', 'bayar_tipe'];

    protected $column_order = array(null, 'bayar_id', null, null, null, null, null, null, null);
    protected $column_search = array('nis', 'nama_peserta');
    protected $order = array('bayar_id' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request, $angkatan = null,  $payment_filter = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table)
        ->select('*')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi !=', NULL)
        ->orderBy('bayar_id', 'DESC');
        if (!is_null($angkatan)) {
            $this->dt->where('program_kelas.angkatan_kelas', $angkatan);
        }
        if (!is_null($payment_filter)) {
            if ($payment_filter == 'flip') {
                $this->dt->where('program_bayar.metode', "flip");
            } elseif ($payment_filter == 'beasiswa') {
                $this->dt->where('program_bayar.metode', "beasiswa");
            } elseif ($payment_filter == 'tf') {
                $this->dt->where('program_bayar.metode', null);
            }
        }
    }
    private function _get_datatables_query($angkatan = null, $payment_filter = null)
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

        if(!is_null($angkatan)) {
            $this->dt->where('program_kelas.angkatan_kelas', $angkatan);
        }

        if (!is_null($payment_filter)) {
            if ($payment_filter == 'flip') {
                $this->dt->where('program_bayar.metode', "flip");
            } elseif ($payment_filter == 'beasiswa') {
                $this->dt->where('program_bayar.metode', "beasiswa");
            } elseif ($payment_filter == 'tf') {
                $this->dt->where('program_bayar.metode', null);
            }
        }

        if (isset($_POST['order'])) {
            $this->dt->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables($angkatan = null, $payment_filter = null)
    {
        $this->_get_datatables_query($angkatan, $payment_filter);
        if (isset($_POST['length' != -1]))
            $this->dt->limit($_POST['length'], $_POST['start']);
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($angkatan = null, $payment_filter = null)
    {
        $this->_get_datatables_query($angkatan, $payment_filter);
        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    
    //Custom Query
    public function belum_lunas($peserta_id)
    {
        return $this->table('program_bayar')
            ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
            ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
            ->join('program', 'program_kelas.program_id = program.program_id')
            ->where('status_bayar', 'Belum Lunas')
            ->where('bayar_peserta_id', $peserta_id)
            ->get()
            ->getResultArray();
    }

    public function cek_belum_lunas($peserta_id)
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->where('status_bayar', 'Belum Lunas')
        ->where('bayar_peserta_id', $peserta_id)
        ->countAllResults();
    }

    //Admin - Controller Pembayaran
    public function bayar_konfirmasi()
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi', 'Proses')
        ->where('metode', NULL)
        ->get()
        ->getResultArray();
    }

    //Get jenis bayar
    public function get_jenis_bayar()
    {
        return $this->table('program_bayar')
        ->select('jenis_bayar')
        ->where('status_bayar', 'Belum Lunas')
        ->get()
        ->getResultArray();
    }

    public function get_kelas_id($bayar_id)
    {
        return $this->table('program_bayar')
            ->select('kelas_id')
            ->where('bayar_id', $bayar_id)
            ->get()
            ->getUnbufferedRow();
    }

    public function list()
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta_level', 'peserta_level.peserta_level_id = program_kelas.peserta_level')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi !=', NULL)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    public function list_2nd($angkatan)
    {
        return $this->table('program_bayar')
        ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        ->join('program', 'program_kelas.program_id = program.program_id')
        ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
        ->where('status_konfirmasi !=', NULL)
        ->where('angkatan_kelas', $angkatan)
        ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    //Get list pembayran peserta - Panel Peserta
    public function list_pembayaran_peserta($peserta_id,$angkatan)
    {
        return $this->table('program_bayar')
            ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
            ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
            ->join('program', 'program_kelas.program_id = program.program_id')
            ->join('flip_bill', 'flip_bill.bill_id= program_bayar.flip_bill_id', 'left') // LEFT JOIN here
            ->where('angkatan_kelas',$angkatan)
            ->where('bayar_peserta_id', $peserta_id)
            ->where('status_konfirmasi !=', NULL)
            ->orderBy('bayar_id', 'DESC')
            ->get()
            ->getResultArray();
    }

     //Get list rician pembayran peserta - Admin Panel 
     public function rincian_bayar_peserta($peserta_id, $kelas_id)
     {
         return $this->table('program_bayar')
         ->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
         ->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
         ->join('program', 'program_kelas.program_id = program.program_id')
         ->join('pengajar', 'pengajar.pengajar_id = program_kelas.pengajar_id')
         ->where('bayar_peserta_id', $peserta_id)
         ->where('program_bayar.kelas_id', $kelas_id)
         ->orderBy('bayar_id', 'DESC')
         ->get()
         ->getResultArray();
     }

    //Dashboard - Admin
    public function jml_bayar_proses()
    {
        return $this->table('program_bayar')
        ->where('metode', NULL)
        ->where('status_konfirmasi', 'Proses')
        ->countAllResults();
    }

    //Cek pembayaran peserta sudah expired, CRON JOB
    public function bayar_expired($tgl, $waktu)
    {
        return $this->table('program_bayar')
        ->select('bayar_id')
        //->join('program_kelas', 'program_kelas.kelas_id = program_bayar.kelas_id')
        //->join('peserta', 'peserta.peserta_id = program_bayar.bayar_peserta_id')
        //->join('program', 'program_kelas.program_id = program.program_id')
        ->where('tgl_bayar_dl', $tgl)
        ->where('waktu_bayar_dl <=', $waktu)
        ->where('status_konfirmasi', NULL)
        // ->orderBy('bayar_id', 'DESC')
        ->get()
        ->getResultArray();
    }

    //Cek pembayaran peserta SPP
    public function cek_spp($peserta_id, $kelas_id)
    {
        return $this->table('program_bayar')
        ->select('bayar_id')
        ->where('bayar_peserta_id', $peserta_id)
        ->where('kelas_id', $kelas_id)
        ->where('status_konfirmasi', 'Proses')
        ->get()
        ->getResultArray();
    }
}
