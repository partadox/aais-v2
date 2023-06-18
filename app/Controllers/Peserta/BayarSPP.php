<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class BayarSPP extends BaseController
{

    public function index()
    {
        $user           = $this->userauth();
        $user_id        = $user['user_id'];
        $peserta        = $this->peserta->get_peserta($user_id);
        $peserta_id     = $peserta['peserta_id'];

        //Kelas id
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('kelas', $params)) {
            $kelas_id           = $params['kelas'];
            if (ctype_digit($kelas_id)) {
                $kelas_id           = $params['kelas'];
            }else {
                return redirect()->to('/peserta-kelas');
            }
        } else {
            return redirect()->to('/peserta-kelas');
        }

        $time                   = \CodeIgniter\I18n\Time::now('Asia/Makassar');
        $cek                    = $this->cart->cek_spp($peserta_id, $kelas_id);
        $get_peserta_kelas_id   = $this->peserta_kelas->get_peserta_kelas_id($peserta_id, $kelas_id);
        $peserta_kelas_id       = $get_peserta_kelas_id->peserta_kelas_id;

        $peserta_kelas          = $this->peserta_kelas->find($peserta_kelas_id);
        $kelas                  = $this->kelas->detail_kelas_bayar($kelas_id);
        
        // if (count($cek) == 0) {
        //     // $expired_waktu      = $cek[0]['cart_timeout'];
            
        //     // $peserta_kelas_id   = $cek[0]['cart_peserta_kelas'];
        //     // $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
        //     // $cart_id            = $cek[0]['cart_id'];

        //     $biaya_daftar       = $kelas['biaya_daftar'];
        //     $biaya_bulanan      = $kelas['biaya_bulanan'];
        //     $biaya_modul        = $kelas['biaya_modul'];
        // } else {
        //     $expired_waktu      = NULL;
        //     $kelas              = NULL;
        //     $kelas_id           = NULL;
        //     $peserta_kelas      = NULL;
        //     $peserta_kelas_id   = NULL;
        //     $cart_id            = NULL;

        //     $biaya_daftar       = 0;
        //     $biaya_bulanan      = 0;
        //     $biaya_modul        = 0;
        // }
        // var_dump($peserta_kelas);

        $data = [
            'title'             => 'Bayar SPP Kelas',
            'user'              => $user,
            'peserta'           => $peserta,
            'peserta_id'        => $peserta_id,
            'peserta_kelas'     => $peserta_kelas,
            'peserta_kelas_id'  => $peserta_kelas_id,
            'kelas'             => $kelas,
            'kelas_id'          => $kelas_id,
            // 'biaya_daftar'      => $biaya_daftar,
            // 'biaya_bulanan'     => $biaya_bulanan,
            // 'biaya_modul'       => $biaya_modul,
            'cek'               => count($cek),
            // 'cart_id'           => $cart_id,
            'payment'           => $this->payment->list_active(),
            'payment_manual'    => $this->payment->list_manual(),
            'jsFriendlyTime'    => $time->format('Y/m/d H:i:s'),
            // 'expired_waktu'     => $expired_waktu,
        ];
        return view('panel_peserta/bayar_spp/index', $data);
    }

    /*--- BACKEND ---*/

    public function maintenance_status()
    {
        $ch         = curl_init();
        $key        = $this->konfigurasi->flip_key();
        $secret_key = $key->flip_key;

        curl_setopt($ch, CURLOPT_URL, "https://bigflip.id/api/v2/general/maintenance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded"
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");

        $json = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($json);
        $maintenance_status = $data->maintenance;
        return $maintenance_status;
    }

    public function bank_status($bank)
    {
        $ch = curl_init();
        $key        = $this->konfigurasi->flip_key();
        $secret_key = $key->flip_key;

        curl_setopt($ch, CURLOPT_URL, "https://bigflip.id/api/v2/general/banks?code=".$bank);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded"
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");

        $json = curl_exec($ch);
        curl_close($ch);       
        $data = json_decode($json);
        $bank_status = $data[0]->status;
        return $bank_status;
    }

    public function generate_link($peserta_kelas_id, $cart_id, $bayar_id, $total, $expired_waktu, $peserta_nama, $peserta_email, $sender_bank, $account_type)
    {
        $ch         = curl_init();
        $key        = $this->konfigurasi->flip_key();
        $secret_key = $key->flip_key;

        curl_setopt($ch, CURLOPT_URL, "https://bigflip.id/big_sandbox_api/v2/pwf/bill");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        $payloads = [
            "title"                     => $peserta_kelas_id.'-'.$cart_id.'-'.$bayar_id.'-'.time(),
            "amount"                    => $total,
            "type"                      => "SINGLE",
            "expired_date"              => $expired_waktu->format('Y-m-d H:i'),
            "is_address_required"       => 0,
            "is_phone_number_required"  => 0,
            "step"                      => 3,
            "sender_name"               => $peserta_nama,
            "sender_email"              => $peserta_email,
            "sender_bank"               => $sender_bank,
            "sender_bank_type"          => $account_type,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded"
        ));

        curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function generate_flip()
    {
        $cart               = $this->request->getPost('cart');
        $total              = $this->request->getPost('total');
        $peserta_id         = $this->request->getPost('peserta_id');
        $peserta_kelas_id   = $this->request->getPost('peserta_kelas_id');
        $kelas_id           = $this->request->getPost('kelas_id');
        $cart_id            = $this->request->getPost('cart_id');
        $expired_waktu1      = $this->request->getPost('expired_waktu');
        $expired_waktu      = \DateTime::createFromFormat('Y-m-d H:i:s', $expired_waktu1);

        $peserta            = $this->peserta->find($peserta_id);
        $peserta_nama       = $peserta['nama_peserta'];
        $peserta_email      = $peserta['email'];
        $data_kelas         = $this->kelas->find($kelas_id);

        $cart               = json_decode($cart, true);

        foreach ($cart as $item) {
            // Get id and price from item
            $id     = $item['id'];
            $name   = $item['name'];

            // If there is a mapping for this id, add the price to the data to update
            if ($id >= 22 && $id <=34) {
                if (strpos($name, 'FLIP_') === 0) {
                    $account_type = "bank_account";
                    $part = explode("_", $name);
                    $sender_bank = strtolower($part[1]);
                } else {
                    $account_type = "virtual_account";
                    $sender_bank  = strtolower($name);
                }
                
            }
        }

        $maintenance_status = $this->maintenance_status();
        // $bank_status        = $this->bank_status($sender_bank);

        if ($maintenance_status == true) {
            return $this->response->setJSON(['error' => 'Metode pembayaran dengan payment gateway sedang maintenance, gunakan pembayaran via transfer manual.']);
        }

        // if ($bank_status != 'OPERATIONAL') {
        //     return $this->response->setJSON(['error' => 'Metode pembayaran dengan bank yang anda pilih sedang gangguan, gunakan pembayaran via VA bank lain atau transfer manual.']);
        // }

        $data_bayar = [
            'kelas_id'                  => $kelas_id,
            'bayar_peserta_id'          => $peserta_id,
            'bayar_peserta_kelas_id'    => $peserta_kelas_id,
            'metode'                    => 'flip',
            'status_konfirmasi'         => 'Proses',
            'awal_bayar'                => $total,
            'nominal_bayar'             => $total,
            'bukti_bayar'               => 'default.png',
            'tgl_bayar'                 => date("Y-m-d"),
            'waktu_bayar'               => date("H:i:s"),
            'tgl_bayar_konfirmasi'      => '1000-01-01',
            'waktu_bayar_konfirmasi'    => '00:00:00',
        ];

        $updatePK = [
            'expired_tgl_daftar'        => NULL,
            'expired_waktu_daftar'      => NULL,
        ];

        // Define mapping from ids to column names
        $idColumnMap = [
            // 1 => 'dt_bayar_spp1',
            2 => 'dt_bayar_spp2',
            3 => 'dt_bayar_spp3',
            4 => 'dt_bayar_spp4',
            5 => 'dt_bayar_daftar',
        ];

        // Define mapping from ids to column names
        $idColumnMap2 = [
            1 => 'awal_bayar_spp1',
            2 => 'awal_bayar_spp2',
            3 => 'awal_bayar_spp3',
            4 => 'awal_bayar_spp4',
            5 => 'awal_bayar_daftar',
            6 => 'awal_bayar_modul',
            7 => 'awal_bayar_infaq',
            8 => 'awal_bayar_lainnya',
        ];

        // Initialize data to update
        $dataUpdatePK = [];
        $dataUpdateBY = [];

        // Loop over each item in the cart
        foreach ($cart as $item) {
            // Get id and price from item
            $id = $item['id'];
            $price = $item['price'];

            // If there is a mapping for this id, add the price to the data to update
            if (isset($idColumnMap[$id])) {
                $dataUpdatePK[$idColumnMap[$id]] = date('Y-m-d H:i:s');
            }

            if (isset($idColumnMap2[$id])) {
                $dataUpdateBY[$idColumnMap2[$id]] = $price;
            }
        }

        $this->db->transStart();
        $this->bayar->insert($data_bayar);
        $bayar_id   = $this->bayar->insertID();
        $this->peserta_kelas->update($peserta_kelas_id,$dataUpdatePK);
        $this->peserta_kelas->update($peserta_kelas_id, $updatePK);
        $this->bayar->update($bayar_id, $dataUpdateBY);
        $this->cart->delete($cart_id);
        $response       = $this->generate_link($peserta_kelas_id, $cart_id, $bayar_id, $total, $expired_waktu, $peserta_nama, $peserta_email, $sender_bank, $account_type);

        $data           = json_decode($response);

        $bill_code      = $data->bill_payment->id;
        $link_url       = $data->link_url;
        $amount         = $data->bill_payment->amount;
        $unique_code    = $data->bill_payment->unique_code;     
        $account_number = $data->bill_payment->receiver_bank_account->account_number;
        $bank_code      = $data->bill_payment->receiver_bank_account->bank_code;

        if ($bank_code == 'bsm') {
            $bank_code = 'bsi';
        }

        $dtbill = [
            'bill_code'         => $bill_code,
            'bill_link'         => $link_url,
            'bill_amount'       => $amount,
            'bill_va'           => $account_number,
            'bill_bank'         => strtoupper($bank_code),
            'bill_unique_code'  => $unique_code,
            'bill_expired'      => $expired_waktu1
        ];
        
        $this->bill->insert($dtbill);
        
        $dtbillbayar     =[
            'flip_bill_id'  => $this->bill->insertID(),
        ];
        $this->bayar->update($bayar_id, $dtbillbayar);

        $this->db->transComplete();

        $aktivitas = 'Mendaftar dan telah melakukan input bukti pembayaran pada kelas ' . $data_kelas['nama_kelas'] .  ' via flip VA '.strtoupper($bank_code);

        if ($this->db->transStatus() === FALSE)
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'FAIL', $aktivitas);
        }
        else
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'BERHASIL', $aktivitas);
        }

        return $this->response->setJSON([
            'account_number' => $account_number,
            'bank_code' => strtoupper($bank_code)
        ]);
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
        $data_kelas         = $this->kelas->find($kelas_id);

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
        $ext = $image->guessExtension();
        $newName = $peserta_id."-".date('Ymd-His').'.'.$ext;
        $cart = json_decode($cart, true);

        $data_bayar = [
            'kelas_id'                  => $kelas_id,
            'bayar_peserta_id'          => $peserta_id,
            'bayar_peserta_kelas_id'    => $peserta_kelas_id,
            'status_konfirmasi'         => 'Proses',
            'awal_bayar'                => $total,
            'nominal_bayar'             => $total,
            'bukti_bayar'               => $newName,
            'tgl_bayar'                 => date("Y-m-d"),
            'waktu_bayar'               => date("H:i:s"),
            'keterangan_bayar'          => $note,
            'tgl_bayar_konfirmasi'      => '1000-01-01',
            'waktu_bayar_konfirmasi'    => '00:00:00',
        ];

        $updatePK = [
            'expired_tgl_daftar'        => NULL,
            'expired_waktu_daftar'      => NULL,
        ];

        // Define mapping from ids to column names
        $idColumnMap = [
            // 1 => 'dt_bayar_spp1',
            2 => 'dt_bayar_spp2',
            3 => 'dt_bayar_spp3',
            4 => 'dt_bayar_spp4',
            5 => 'dt_bayar_daftar',
        ];

        // Define mapping from ids to column names
        $idColumnMap2 = [
            1 => 'awal_bayar_spp1',
            2 => 'awal_bayar_spp2',
            3 => 'awal_bayar_spp3',
            4 => 'awal_bayar_spp4',
            5 => 'awal_bayar_daftar',
            6 => 'awal_bayar_modul',
            7 => 'awal_bayar_infaq',
            8 => 'awal_bayar_lainnya',
        ];

        // Initialize data to update
        $dataUpdatePK = [];
        $dataUpdateBY = [];

        // Loop over each item in the cart
        foreach ($cart as $item) {
            // Get id and price from item
            $id = $item['id'];
            $price = $item['price'];

            // If there is a mapping for this id, add the price to the data to update
            if (isset($idColumnMap[$id])) {
                $dataUpdatePK[$idColumnMap[$id]] = date('Y-m-d H:i:s');
            }

            if (isset($idColumnMap2[$id])) {
                $dataUpdateBY[$idColumnMap2[$id]] = $price;
            }
        }

        $this->db->transStart();
        $this->bayar->insert($data_bayar);
        $bayar_id   = $this->bayar->insertID();
        $this->peserta_kelas->update($peserta_kelas_id,$dataUpdatePK);
        $this->peserta_kelas->update($peserta_kelas_id, $updatePK);
        $this->bayar->update($bayar_id, $dataUpdateBY);
        $this->cart->delete($cart_id);
        $image->move('public/img/transfer', $newName);
        $this->db->transComplete();

        $aktivitas = 'Mendaftar dan telah melakukan input bukti pembayaran pada kelas ' . $data_kelas['nama_kelas'];

        if ($this->db->transStatus() === FALSE)
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'FAIL', $aktivitas);
        }
        else
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'BERHASIL', $aktivitas);
        }
        
        return $this->response->setJSON(['success' => 'Your operation was successful.']);
    }

    public function save_beasiswa()
    {
         // Get the POST data
        $beasiswa_code      = $this->request->getPost('beasiswa_code');
        $cart               = $this->request->getPost('cart');
        $total              = $this->request->getPost('total');
        $peserta_id         = $this->request->getPost('peserta_id');
        $peserta_kelas_id   = $this->request->getPost('peserta_kelas_id');
        $kelas_id           = $this->request->getPost('kelas_id');
        $cart_id            = $this->request->getPost('cart_id');
        $expired_waktu      = $this->request->getPost('expired_waktu');
        $expired_waktu      = \DateTime::createFromFormat('Y-m-d H:i:s', $expired_waktu);
        $data_kelas         = $this->kelas->find($kelas_id);
        $program_id         = $data_kelas['program_id'];

        $now                = new \DateTime();

        if (!$this->request->getPost('beasiswa_code')) {
            return $this->response->setJSON(['error' => 'Harap Masukan Kode Beasiswa.']);
        }

        if ($expired_waktu < $now) {
            return $this->response->setJSON(
                ['error' => 'Anda telah melampui batas waktu transfer, silahkan pilih kelas terlebih dahulu.']);
        }

        $beasiswa = $this->beasiswa->find_code($beasiswa_code, $peserta_id, $program_id);

        if (count($beasiswa) == NULL) {
            return $this->response->setJSON(['error' => 'Kode Beasiswa Tidak Ditemukan.']);
        } elseif(count($beasiswa) == 1) {

            $beasiswa_daftar= ' ';
            $beasiswa_spp1  = ' ';
            $beasiswa_spp2  = ' ';
            $beasiswa_spp3  = ' ';
            $beasiswa_spp4  = ' ';

            if ($beasiswa[0]['beasiswa_daftar'] == 1) {
                $beasiswa_daftar = ' Pendaftaran';
            }

            if ($beasiswa[0]['beasiswa_spp1'] == 1) {
                $beasiswa_spp1 = ' SPP-1';
            }

            if ($beasiswa[0]['beasiswa_spp2'] == 1) {
                $beasiswa_spp2 = ' SPP-2';
            }

            if ($beasiswa[0]['beasiswa_spp3'] == 1) {
                $beasiswa_spp3 = ' SPP-3';
            }

            if ($beasiswa[0]['beasiswa_spp4'] == 1) {
                $beasiswa_spp4 = ' SPP-4';
            }

            $data_bayar = [
                'kelas_id'                  => $kelas_id,
                'bayar_peserta_id'          => $peserta_id,
                'bayar_peserta_kelas_id'    => $peserta_kelas_id,
                'metode'                    => 'beasiswa',
                'beasiswa_id'               => $beasiswa[0]['beasiswa_id'],
                'status_bayar'              => 'Lunas',
                'status_bayar_admin'        => 'BEBAS BIAYA',
                'status_konfirmasi'         => 'Terkonfirmasi',
                'awal_bayar'                => '0',
                'nominal_bayar'             => '0',
                'tgl_bayar'                 => date("Y-m-d"),
                'waktu_bayar'               => date("H:i:s"),
                'keterangan_bayar'          => 'Bayar dengan kode beasiswa '.$beasiswa_code . ' free beasiswa untuk'.$beasiswa_daftar.$beasiswa_spp1.$beasiswa_spp2.$beasiswa_spp3.$beasiswa_spp4,
                'tgl_bayar_konfirmasi'      => date("Y-m-d"),
                'waktu_bayar_konfirmasi'    => date("H:i:s"),
                'validator'                 => 'AAIS Sistem',
                'bukti_bayar'               => 'beasiswa.png',
            ];

            $updateBeasiswa = [
                'beasiswa_status'    => 1,
                'beasiswa_used'      => date('Y-m-d H:i:s'),
            ];

            $this->db->transStart();
            $this->bayar->insert($data_bayar);

            $dataabsen = [
                'bckp_absen_peserta_id'     => $peserta_id,
                'bckp_absen_peserta_kelas'  => $kelas_id,
            ];
            $this->absen_peserta->insert($dataabsen);

            $dataujian = [
                'bckp_ujian_peserta'     => $peserta_id,
                'bckp_ujian_kelas'       => $kelas_id,
            ];
            $this->ujian->insert($dataujian);

            if ($beasiswa[0]['beasiswa_daftar'] == 1 && $beasiswa[0]['beasiswa_spp1'] == 1 && $beasiswa[0]['beasiswa_spp2'] == 1 && $beasiswa[0]['beasiswa_spp3'] == 1 && $beasiswa[0]['beasiswa_spp4'] == 1) {
                $spp_status = 'LUNAS';
            } else {
                $spp_status = 'BELUM LUNAS';
            }
            
            $updatePK = [
                'data_absen'                => $this->absen_peserta->insertID(),
                'data_ujian'                => $this->ujian->insertID(),
                'spp_status'                => $spp_status,
                'expired_tgl_daftar'        => NULL,
                'expired_waktu_daftar'      => NULL,
                'beasiswa_daftar'           => $beasiswa[0]['beasiswa_daftar'],
                'beasiswa_spp1'             => $beasiswa[0]['beasiswa_spp1'],
                'beasiswa_spp2'             => $beasiswa[0]['beasiswa_spp2'],
                'beasiswa_spp3'             => $beasiswa[0]['beasiswa_spp3'],
                'beasiswa_spp4'             => $beasiswa[0]['beasiswa_spp4'],
            ];
            
            $this->peserta_kelas->update($peserta_kelas_id, $updatePK);
            $this->beasiswa->update($beasiswa[0]['beasiswa_id'], $updateBeasiswa);
            $this->cart->delete($cart_id);
            $this->db->transComplete();
        }

        $aktivitas = 'Mendaftar dengan kode beasiswa pada kelas ' . $data_kelas['nama_kelas'];

        if ($this->db->transStatus() === FALSE)
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'FAIL', $aktivitas);
        }
        else
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'BERHASIL', $aktivitas);
        }
        
        return $this->response->setJSON(['success' => 'Your operation was successful.']);
    }

    public function cancel()
    {
         // Get the POST data
        $peserta_kelas_id   = $this->request->getPost('peserta_kelas_id');
        $cart_id            = $this->request->getPost('cart_id');

        $this->db->transStart();
        $this->cart->delete($cart_id);
        $this->peserta_kelas->delete($peserta_kelas_id);
        $this->db->transComplete();

        $aktivitas = 'Membatalkan kelas yg dipilih untuk pilih ulang kelas lain';

        if ($this->db->transStatus() === FALSE)
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'FAIL', $aktivitas);
        }
        else
        {
            /*--- Log ---*/
            $this->logging('Peserta', 'BERHASIL', $aktivitas);
        }
        
        $msg = [
            'sukses' => [
                'link' => '/daftar'
            ]
        ];
        echo json_encode($msg);
    }

    public function callback()
    {
        // Get the JSON data from the request body
        $json               = $this->request->getJSON();
        //Access the individual data fields from the JSON
        $id                 = $json->id;
        $bill_link          = $json->bill_link;
        $bill_link_id       = $json->bill_link_id;
        $bill_title         = $json->bill_title;
        $sender_name        = $json->sender_name;
        $sender_bank        = $json->sender_bank;
        $amount             = $json->amount;
        $status             = $json->status;
        $sender_bank_type   = $json->sender_bank_type;
        $created_at         = $json->created_at;

        if ($status == 'SUCCESSFUL') {
            $title_explode      = explode("-", $bill_title);
        
            $peserta_kelas_id   = $title_explode[0];
            $cart_id            = $title_explode[1];
            $bayar_id           = $title_explode[2];
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            $peserta_id         = $peserta_kelas['data_peserta_id'];
            $kelas_id           = $peserta_kelas['data_kelas_id'];

            $data_kelas         = $this->kelas->find($kelas_id);
            $peserta            = $this->peserta->find($peserta_id);

            $this->db->transStart();
            $updateBayar = [
                'status_bayar'              => 'Lunas',
                'status_bayar_admin'        => 'SESUAI BAYAR',
                'status_konfirmasi'         => 'Terkonfirmasi',
                'tgl_bayar_konfirmasi'      => date("Y-m-d"),
                'waktu_bayar_konfirmasi'    => date("H:i:s"),
                'validator'                 => 'Flip Payment Gateway',
            ];
            $this->bayar->update($bayar_id, $updateBayar);

            $bayar  = $this->bayar->find($bayar_id);
            $daftar = $bayar['awal_bayar_daftar'];
            $modul  = $bayar['awal_bayar_modul'];
            $spp1   = $bayar['awal_bayar_spp1'];
            $spp2   = $bayar['awal_bayar_spp2'];
            $spp3   = $bayar['awal_bayar_spp3'];
            $spp4   = $bayar['awal_bayar_spp4'];
            $infaq  = $bayar['awal_bayar_infaq'];
            $lainnya= $bayar['awal_bayar_lainnya'];

            if ($daftar != '0') {
                $dataabsen = [
                    'bckp_absen_peserta_id'     => $peserta_id,
                    'bckp_absen_peserta_kelas'  => $kelas_id,
                ];
                $this->absen_peserta->insert($dataabsen);
    
                $dataujian = [
                    'bckp_ujian_peserta'     => $peserta_id,
                    'bckp_ujian_kelas'       => $kelas_id,
                ];
                $this->ujian->insert($dataujian);
                $PKdaftar = [
                    'byr_daftar'            => $daftar,
                    'dt_konfirmasi_daftar'  => date('Y-m-d H:i:s'),
                    'data_absen'            => $this->absen_peserta->insertID(),
                    'data_ujian'            => $this->ujian->insertID(),
                    'expired_tgl_daftar'    => NULL,
                    'expired_waktu_daftar'  => NULL,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKdaftar);
            }

            if ($spp1 != '0') {
                $PKspp1 = [
                    'byr_spp1'            => $spp1,
                    'dt_konfirmasi_spp1'  => date('Y-m-d H:i:s')
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKspp1);
            }

            if ($spp2 != '0') {
                $PKspp2 = [
                    'byr_spp2'            => $spp2,
                    'dt_konfirmasi_spp2'  => date('Y-m-d H:i:s')
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKspp2);
            }

            if ($spp3 != '0') {
                $PKspp3 = [
                    'byr_spp3'            => $spp3,
                    'dt_konfirmasi_spp3'  => date('Y-m-d H:i:s')
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKspp3);
            }

            if ($spp4 != '0') {
                $PKspp4 = [
                    'byr_spp4'            => $spp4,
                    'dt_konfirmasi_spp4'  => date('Y-m-d H:i:s')
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKspp4);
            }

            if ($modul != '0') {
                $PKmodul = [
                    'byr_modul'            => $modul,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                $data_modul = [
                    'bayar_modul_id'        => $bayar_id,
                    'bayar_modul'           => $modul,
                    'status_bayar_modul'    => 'Lunas',
                ];
                $this->bayar_modul->insert($data_modul);
            }

            if ($lainnya != '0') {
                $data_lain = [
                    'lainnya_bayar_id'        => $bayar_id,
                    'bayar_lainnya'           => $lainnya,
                    'data_peserta_id_lain'    => $peserta_id,
                    'status_bayar_lainnya'    => 'Lunas',
                ];
                $this->bayar_lain->insert($data_lain);
            }

            if ($infaq != '0') {
                $data_infaq = [
                    'infaq_bayar_id'        => $bayar_id,
                    'bayar_infaq'           => $infaq,
                    'data_peserta_id_infaq' => $peserta_id
                ];
                $this->infaq->insert($data_infaq);
            }

            //Get data total bayar
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            $byr_daftar         = $peserta_kelas['byr_daftar'];
            $byr_modul          = $peserta_kelas['byr_modul'];
            $byr_spp1           = $peserta_kelas['byr_spp1'];
            $byr_spp2           = $peserta_kelas['byr_spp2'];
            $byr_spp3           = $peserta_kelas['byr_spp3'];
            $byr_spp4           = $peserta_kelas['byr_spp4'];

            $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
            $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
            $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
            $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
            $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];

            $payments = [
                [$byr_daftar, $beasiswa_daftar],
                [$byr_spp1, $beasiswa_spp1],
                [$byr_spp2, $beasiswa_spp2],
                [$byr_spp3, $beasiswa_spp3],
                [$byr_spp4, $beasiswa_spp4]
            ];
            
            $spp_status = 'LUNAS';
            
            foreach ($payments as $payment) {
                if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                    $spp_status = 'BELUM LUNAS';
                    break;
                }
            }

            $PKstatus = [
                'spp_status'  => $spp_status,
            ];
            $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);
            $this->cart->delete($cart_id);
            $this->db->transComplete();

            $aktivitas = 'Pendaftaran peserta '. $peserta['nis'].'-'.$peserta['nama_peserta'] .' pada kelas ' . $data_kelas['nama_kelas']. ' terkonfirmasi oleh flip';

            if ($this->db->transStatus() === FALSE)
            {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            }
            else
            {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }
        }
    }
}