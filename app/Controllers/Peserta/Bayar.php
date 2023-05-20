<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Bayar extends BaseController
{
    public function index()
    {
        $user           = $this->userauth();
        $user_id        = $user['user_id'];
        $peserta        = $this->peserta->get_peserta($user_id);
        $peserta_id     = $peserta['peserta_id'];

        $cek                = $this->cart->cek_daftar($peserta_id);
        
        if (count($cek) != 0) {
            $expired_waktu      = $cek[0]['cart_timeout'];
            $kelas_id           = $cek[0]['cart_kelas'];
            $kelas              = $this->kelas->fdt_kelas($kelas_id);
            $peserta_kelas_id   = $cek[0]['cart_peserta_kelas'];
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            $cart_id            = $cek[0]['cart_id'];

            $biaya_daftar       = $kelas['biaya_daftar'];
            $biaya_bulanan      = $kelas['biaya_bulanan'];
            $biaya_modul        = $kelas['biaya_modul'];
        } else {
            $expired_waktu      = NULL;
            $kelas              = NULL;
            $kelas_id           = NULL;
            $peserta_kelas      = NULL;
            $peserta_kelas_id   = NULL;
            $cart_id            = NULL;

            $biaya_daftar       = 0;
            $biaya_bulanan      = 0;
            $biaya_modul        = 0;
        }

        $data = [
            'title'             => 'Bayar Daftar Program',
            'user'              => $user,
            'peserta'           => $peserta,
            'peserta_id'        => $peserta_id,
            'peserta_kelas'     => $peserta_kelas,
            'peserta_kelas_id'  => $peserta_kelas_id,
            'kelas'             => $kelas,
            'kelas_id'          => $kelas_id,
            'biaya_daftar'      => $biaya_daftar,
            'biaya_bulanan'     => $biaya_bulanan,
            'biaya_modul'       => $biaya_modul,
            'cek'               => count($cek),
            'cart_id'           => $cart_id,
            'payment'           => $this->payment->list_active(),
            'payment_manual'    => $this->payment->list_manual(),
            'expired_waktu'     => $expired_waktu,
        ];
        return view('panel_peserta/bayar/daftar', $data);
    }

    public function save_manual()
    {
         // Get the POST data
        $note               = $this->request->getPost('note');
        $cart               = $this->request->getPost('cart');
        $total              = $this->request->getPost('total');
        $peserta_id         = $this->request->getPost('peserta_id');
        $peserta_kelas_id   = $this->request->getPost('peserta_kelas_id');
        $kelas_id           = $this->request->getPost('kelas_id');
        $cart_id            = $this->request->getPost('cart_id');
        $expired_waktu      = $this->request->getPost('expired_waktu');
        $expired_waktu      = \DateTime::createFromFormat('Y-m-d H:i:s', $expired_waktu);

        $now                = new \DateTime();

        // Check if a file was received
        if (!$this->request->getFiles('image')) {
            return $this->response->setJSON(['error' => 'Harap Upload Bukti Transfer.']);
        }

        // Get the file
        $image = $this->request->getFile('image');

        // Check if file is uploaded
        if (!$image->isValid()) {
            return $this->response->setJSON(
                ['error' => 'Bukti transfer harus dalam format gambar (jpg/png)']);
        }

        if ($expired_waktu < $now) {
            return $this->response->setJSON(
                ['error' => 'Anda telah melampui batas waktu transfer, silahkan pilih kelas terlebih dahulu.']);
        }

        // Move the uploaded file somewhere
        // $newName = $image->getRandomName();
        // $image->move('public/img/transfer', $newName);
        $cart = json_decode($cart, true);

        // Define mapping from ids to column names
        $idColumnMap = [
            // 1 => 'dt_bayar_spp1',
            2 => 'dt_bayar_spp2',
            3 => 'dt_bayar_spp3',
            4 => 'dt_bayar_spp4',
            5 => 'dt_bayar_daftar',
            // Add more mappings if needed...
        ];

        // Initialize data to update
        $dataUpdatePK = [];

        // Loop over each item in the cart
        foreach ($cart as $item) {
            // Get id and price from item
            $id = $item['id'];
            // $price = $item['price'];

            // If there is a mapping for this id, add the price to the data to update
            if (isset($idColumnMap[$id])) {
                $dataUpdatePK[$idColumnMap[$id]] = date('Y-m-d H:i:s');
            }
        }

        // Update data in database
        $this->peserta_kelas->update($peserta_kelas_id,$dataUpdatePK);
        
        return $this->response->setJSON(['success' => 'Your operation was successful.']);
    }
}