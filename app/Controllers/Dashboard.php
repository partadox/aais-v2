<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$user  = $this->userauth(); // Return Array
		$level = $user['level'];

		//Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
		$list_angkatan      = $this->kelas->list_unik_angkatan();

		//Dashboard Admin
		if ($level == 1 || $level == 2 || $level == 3 || $level == 7) {
			
			$jml_konfrimasi     = $this->bayar->jml_bayar_proses();
			$jml_peserta        = $this->peserta->jml_peserta();
			$jml_kantor         = $this->kantor->jml_kantor();
			$jml_program        = $this->program->jml_program();
			$jml_kelas          = $this->kelas->jml_kelas();
			$jml_pengajar       = $this->pengajar->jml_pengajar();
			$jml_akun_pengajar  = $this->user->jml_akun_pengajar();
			$jml_akun_peserta   = $this->user->jml_akun_peserta();
	
			//Rekap SPP - Pie Chart
			$get_spp_belum_lunas= $this->peserta_kelas->pie_spp_belum_lunas($angkatan);
			$spp_belum_lunas    = $get_spp_belum_lunas->spp_status;
			$get_spp_lunas      = $this->peserta_kelas->pie_spp_lunas($angkatan);
			$spp_lunas          = $get_spp_lunas->spp_status;
			
			$get_spp_belum_lunas_ikhwan= $this->peserta_kelas->pie_spp_belum_lunas_ikhwan($angkatan);
			$spp_belum_lunas_ikhwan    = $get_spp_belum_lunas_ikhwan->spp_status;
			$get_spp_lunas_ikhwan      = $this->peserta_kelas->pie_spp_lunas_ikhwan($angkatan);
			$spp_lunas_ikhwan          = $get_spp_lunas_ikhwan->spp_status;
	
			$get_spp_belum_lunas_akhwat= $this->peserta_kelas->pie_spp_belum_lunas_akhwat($angkatan);
			$spp_belum_lunas_akhwat    = $get_spp_belum_lunas_akhwat->spp_status;
			$get_spp_lunas_akhwat      = $this->peserta_kelas->pie_spp_lunas_akhwat($angkatan);
			$spp_lunas_akhwat          = $get_spp_lunas_akhwat->spp_status;
	
			$db              = db_connect();
			$perlevel_ikhwan = $db->query('SELECT pl.nama_level, SUM(CASE WHEN pk.spp_status = "LUNAS" THEN 1 ELSE 0 END) AS lunas, SUM(CASE WHEN pk.spp_status = "BELUM LUNAS" THEN 1 ELSE 0 END) AS belum_lunas 
			FROM peserta_kelas pk
			JOIN program_kelas pgrm ON pk.data_kelas_id = pgrm.kelas_id
			JOIN peserta_level pl ON pgrm.peserta_level = pl.peserta_level_id
			WHERE pgrm.jenkel       = "IKHWAN"
			AND pgrm.angkatan_kelas ='.$angkatan.' GROUP BY pl.nama_level');
			$result_perlevel_ikhwan = $perlevel_ikhwan->getResult();
			foreach ($result_perlevel_ikhwan as $rslt) {
				$ikhwan_nama_level[]   =  "'" . $rslt->nama_level . "'" . ",";
				$ikhwan_lunas[]        = $rslt->lunas . ',';
				$ikhwan_belum_lunas[]  = $rslt->belum_lunas . ',';
			}
	
			$perlevel_akhwat = $db->query('SELECT pl.nama_level, SUM(CASE WHEN pk.spp_status = "LUNAS" THEN 1 ELSE 0 END) AS lunas, SUM(CASE WHEN pk.spp_status = "BELUM LUNAS" THEN 1 ELSE 0 END) AS belum_lunas 
			FROM peserta_kelas pk
			JOIN program_kelas pgrm ON pk.data_kelas_id = pgrm.kelas_id
			JOIN peserta_level pl ON pgrm.peserta_level = pl.peserta_level_id
			WHERE pgrm.jenkel       = "AKHWAT"
			AND pgrm.angkatan_kelas ='.$angkatan.' GROUP BY pl.nama_level');
			$result_perlevel_akhwat = $perlevel_akhwat->getResult();
			foreach ($result_perlevel_akhwat as $rslt) {
				$akhwat_nama_level[]   =  "'" . $rslt->nama_level . "'" . ",";
				$akhwat_lunas[]        = $rslt->lunas . ',';
				$akhwat_belum_lunas[]  = $rslt->belum_lunas . ',';
			}

			if ($result_perlevel_ikhwan != NULL) {
				if ($ikhwan_nama_level != NULL) {
					$ikhwan_nama_level = implode($ikhwan_nama_level);
				} else {
					$ikhwan_nama_level = '0';
				}
		
				if ($ikhwan_belum_lunas != NULL) {
					$ikhwan_belum_lunas = implode($ikhwan_belum_lunas);
				} else {
					$ikhwan_belum_lunas = '0';
				}
		
				if ($ikhwan_lunas != NULL) {
					$ikhwan_lunas = implode($ikhwan_lunas);
				} else {
					$ikhwan_lunas = '0';
				}
			} else {
				$ikhwan_nama_level = '0';
				$ikhwan_belum_lunas = '0';
				$ikhwan_lunas = '0';
			}
	
			//------------

			if ($result_perlevel_akhwat != NULL) {
				if ($akhwat_nama_level != NULL) {
					$akhwat_nama_level = implode($akhwat_nama_level);
				} else {
					$akhwat_nama_level = '0';
				}
		
				if ($akhwat_belum_lunas != NULL) {
					$akhwat_belum_lunas = implode($akhwat_belum_lunas);
				} else {
					$akhwat_belum_lunas = '0';
				}
		
				if ($akhwat_lunas != NULL) {
					$akhwat_lunas = implode($akhwat_lunas);
				} else {
					$akhwat_lunas = '0';
				}
			} else {
				$akhwat_nama_level = '0';
				$akhwat_belum_lunas = '0';
				$akhwat_lunas = '0';
			}
			
			$data = [
				'title'                 => 'Al-Haqq - Dashboard',
				'user'					=> $user,
				'angkatan'              => $angkatan,
				'list_angkatan'         => $list_angkatan,
				'angkatan_pilih'        => $angkatan,
				'konfirmasi'            => $jml_konfrimasi,
				'kantor'                => $jml_kantor,
				'program'               => $jml_program,
				'kelas'                 => $jml_kelas,  
				'peserta'               => $jml_peserta,
				'pengajar'              => $jml_pengajar,
				'akun_pengajar'         => $jml_akun_pengajar,
				'akun_peserta'          => $jml_akun_peserta,
				'spp_lunas'             => $spp_lunas,
				'spp_belum_lunas'       => $spp_belum_lunas,
				'spp_lunas_ikhwan'      => $spp_lunas_ikhwan,
				'spp_belum_lunas_ikhwan'=> $spp_belum_lunas_ikhwan,
				'spp_lunas_akhwat'      => $spp_lunas_akhwat,
				'spp_belum_lunas_akhwat'=> $spp_belum_lunas_akhwat,
				'ikhwan_nama_level'     => $ikhwan_nama_level,
				'ikhwan_lunas'          => $ikhwan_lunas,
				'ikhwan_belum_lunas'    => $ikhwan_belum_lunas,
				'akhwat_nama_level'     => $akhwat_nama_level,
				'akhwat_lunas'          => $akhwat_lunas,
				'akhwat_belum_lunas'    => $akhwat_belum_lunas,
			];
			
		}

		//Peserta
		if ($level == 4) {
			$data = [
				'title'                 => 'Al-Haqq - Dashboard',
				'user'					=> $user,
				'angkatan'              => $angkatan,
				'list_angkatan'         => $list_angkatan,
				'angkatan_pilih'        => $angkatan,
			];
		}
		//Pengajar

		
		return view('panel/dashboard', $data);
		//var_dump($result_perlevel_akhwat);
	}
}