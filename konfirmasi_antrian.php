<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require "connfile.php";
require "functionfile.php";
require "insertupdate.php";

extract($_POST);
extract($_GET);

//if(isset($_POST['input_data'])){
//if(isset($_GET['input_data'])){
if(isset($_GET['nik'])){
	
	$arrData = $_POST['arrData'];
	
	$nik                      = (isset($_GET['nik']) ? $_GET['nik']:'');      //$arrData['nik'];
	$no_rm                    = (isset($_GET['no_rm']) ? $_GET['no_rm']:'');	  //$arrData['no_rm'];
	$nama                     = (isset($_GET['nama']) ? $_GET['nama']:'');        //$arrData['nama'];
	$alamat                   = (isset($_GET['alamat']) ? $_GET['alamat']:'');    //$arrData['alamat'];
	$alamatKtp                = (isset($_GET['alamatKtp']) ? $_GET['alamatKtp']:'');    //$arrData['alamatKtp'];
	$alamatKota               = (isset($_GET['alamatKota']) ? $_GET['alamatKota']:'');  //$arrData['alamatKota'];
	$tempatlahir              = (isset($_GET['tempatlahir']) ? $_GET['tempatlahir']:'');  //$arrData['tempatlahir'];
	$tanggallahir             = (isset($_GET['tanggallahir']) ? $_GET['tanggallahir']:'');   //$arrData['tanggallahir'];
	$kodeBooking              = (isset($_GET['kodeBooking']) ? $_GET['kodeBooking']:'');   //$arrData['kodeBooking'];	
	$antrianDate              = (isset($_GET['antrianDate']) ? substr($_GET['antrianDate'],0,10) : '');	 //$arrData['antrianDate'];
	$antrianNo                = (isset($_GET['antrianNo']) ? $_GET['antrianNo']:'');   //$arrData['antrianNo'];
	$kode_layanan             = (isset($_GET['kode_layanan']) ? $_GET['kode_layanan']:'');  //$arrData['kode_layanan'];
	$noKartuPesertaBPJS       = (isset($_GET['noKartuPesertaBPJS']) ? $_GET['noKartuPesertaBPJS']:'');   //$arrData['noKartuPesertaBPJS'];
	$jenisPesertaBPJS         = (isset($_GET['jenisPesertaBPJS']) ? $_GET['jenisPesertaBPJS']:'');   //$arrData['jenisPesertaBPJS']; 
	$kodejenisPesertaBPJS 	  = (isset($_GET['telpPesertaBPJS']) ? $_GET['telpPesertaBPJS']:'');   //$arrData['telpPesertaBPJS'];
	$kodePerusahaan           = (isset($_GET['kodePerusahaan']) ? $_GET['kodePerusahaan']:'');  //$arrData['kodePerusahaan'];
	$jenis_antrian_poliklinik = (isset($_GET['jenis_antrian_poliklinik']) ? $_GET['jenis_antrian_poliklinik']:'');  	//$arrData['jenis_antrian_poliklinik'];   	//Jika 1 = BPJS,2=Perusahaan,3=Umum
		
	if($jenis_antrian_poliklinik='1'){
		
		//148 = BPJS kesehatan non PBI
		//149 = BPJS kesehatan PBI
		//150 = BPJS Kobar sehat (Jamkesda)
		//155 = BPJS ketenagakerjaan
		
		//kode 22 adalah dari bridging BPJS
		//kode 3 Kelas 1 PNS daerah
		//kode 13 Kelas 2 Pegawai Swasta
		//Untuk non PBI ?? , Jamkesda ??, ketenagakerjaan ??
		
		
		switch ($kodejenisPesertaBPJS) {
		  case "22":
			$kode_jaminan = "149";
			break;
		  case "3":
			$kode_jaminan = "155";
			break;
		  case "13":
			$kode_jaminan = "155";
			break;
		  default:
			$kode_jaminan = "148";
		}
		
			
		
		
	}elseif ($jenis_antrian_poliklinik='2'){
		
		$kode_jaminan = $kodePerusahaan;
		
	}else{
		
		$kode_jaminan = '001';
		
	}
	$jenispasien = $arrData['jenispasien'];
	//$jenispasien = '1';
		
	
	$msg = "Hallo : ". $_POST['input_data'].' => '.$arrData['nama'].' => '.$arrData['alamat'].' => '.$arrData['jenispasien'];
	
	$json['msg'] =  $msg ;
	
	//echo $msg;
	//exit;
	
	//Insert Ke Tabel REGISTRASI, dan untuk pasien baru pindahkan tc_mr_develop ke tc_mr
	
	if(!empty($jenispasien)){
		
		//Get Number otomatis
		$PrmA = fGlobal("fn_kd_mr","t_parameter","fn_kd_mr","%","LIKE","",DatabaseSA,$ConSA,"");
		$PrmB = $PrmA+1;
		$tNEW = substr(str_repeat('0',6).$PrmA,-6,6);
		$gMR = "620101200".$tNEW;	
			
		//Update table	t_parameter
		$SQ ="UPDATE t_parameter SET fn_kd_mr=".$PrmB;
		$Rs = sqlsrv_query($ConSA,$SQ);
		
		$sql = "INSERT INTO TC_MR
					(FS_MR ,FD_TGL_MR ,FS_KD_PEG ,FS_NM_ALIAS ,FS_NM_PASIEN ,FS_ALM_PASIEN
					,FS_ALM2_PASIEN ,FS_KOTA_PASIEN ,FS_KD_POS_PASIEN ,FS_TLP_PASIEN,FS_KD_IDENTITAS,FS_KD_KELURAHAN
					,FS_TEMP_LAHIR,FD_TGL_LAHIR,FS_GOL_DARAH,FB_JNS_KELAMIN ,FB_ASING,FS_KD_AGAMA,FS_KD_PEKERJAAN_DK
					,FS_KD_PENDIDIKAN_DK,FS_KD_STATUS_KAWIN_DK,FS_KD_SUKU,FS_NM_KELUARGA,FS_HUB_KELUARGA,FS_ALM_KELUARGA
					,FS_ALM2_KELUARGA,FS_KOTA_KELUARGA,FS_KD_POS_KELUARGA,FS_TLP_KELUARGA,FS_KD_BAGIAN,FS_GOLONGAN
					,FS_MR_IBU,FS_KD_PETUGAS,FS_TINGGI_BADAN,FS_BERAT_BADAN,FB_BERKAS_TEBAL
					,FS_NM_WALI ,FS_KD_RUANGAN)
				SELECT $gMR ,FD_TGL_MR ,FS_KD_PEG ,FS_NM_ALIAS ,FS_NM_PASIEN ,FS_ALM_PASIEN
					,FS_ALM2_PASIEN ,FS_KOTA_PASIEN ,FS_KD_POS_PASIEN ,FS_TLP_PASIEN,FS_KD_IDENTITAS,FS_KD_KELURAHAN
					,FS_TEMP_LAHIR,FD_TGL_LAHIR,FS_GOL_DARAH,FB_JNS_KELAMIN ,FB_ASING,FS_KD_AGAMA,FS_KD_PEKERJAAN_DK
					,FS_KD_PENDIDIKAN_DK,FS_KD_STATUS_KAWIN_DK,FS_KD_SUKU,FS_NM_KELUARGA,FS_HUB_KELUARGA,FS_ALM_KELUARGA
					,FS_ALM2_KELUARGA,FS_KOTA_KELUARGA,FS_KD_POS_KELUARGA,FS_TLP_KELUARGA,FS_KD_BAGIAN,FS_GOLONGAN
					,FS_MR_IBU,FS_KD_PETUGAS,FS_TINGGI_BADAN,FS_BERAT_BADAN,FB_BERKAS_TEBAL
					,FS_NM_WALI ,FS_KD_RUANGAN
				FROM TC_MR_DEV WHERE FS_KD_IDENTITAS = '$nik';";
				
		$rsGB = sqlsrv_query($ConSA,$sql);
		
		
		$sql = "DELETE FROM TC_MR_DEV WHERE FS_KD_IDENTITAS = '$nik' ";
		$rsGB = sqlsrv_query($ConSA,$sql);
		
	}	

	//-----------------
	
	$AskPrint="Y";
	$PrmA = fGlobal("fn_registrasi_masuk","t_parameter","fn_registrasi_masuk","%","LIKE","",DatabaseSA,$ConSA,"");
	$PrmB = $PrmA+1;
	$tNEW = substr(str_repeat('0',10).$PrmA,-10,10);
	$tREG = $tNEW;
	
	$SQ ="UPDATE t_parameter SET fn_registrasi_masuk=".$PrmB;
	$Rs = sqlsrv_query($ConSA,$SQ);	
	//-----------------
	
	$tanggal_hari_ini = date("Y-m-d");
	
	$fNoRM = $no_rm;
	$fTgLM = $antrianDate;	
	$fJaMM = date("h:i:s");
	$gUsER = 'AntApp';
	$fLaYK = $kode_layanan;
	$fInPK = '';
	$fKlSK = '006';
		
	$fKnJK = fGlobal("isnull(max(fn_kunjunganke),0)","ta_registrasi","fs_mr",$fNoRM,"=","",DatabaseSA,$ConSA,"");
	$fKnJK++;
	
	$fMsKK = '8';	
	$fTrFK = '10';  // [REGISTRASI ONE DAY CARE (ODC)]  -> Cek dan tanyakan
	
	$nTrFK = fGlobal("fn_karcis","ta_karcis","fs_kd_karcis",$fTrFK,"=","",DatabaseSA,$ConSA,"");
	
	$fTuNK = 0;	
	$fSiSK = $nTrFK-$fTuNK;	
	//Kode rujukan
	$fRjKK = '';	
	$fIbUK = '';	
	$RekSIS= "1031.0101";
	$RekBYR= "1011.011";
	$fJmNK = $kode_jaminan;
	$fAnAM= '';
	$fSmFK='';
	
	//Untuk BPJS	
	$fLakA = '0';
	$fLokA = '';	
	$fDiAK = '';
	
	$fDiAK = '';
	$fRjNK = '';
	$fRjPK = '';
	$fBpJK = $noKartuPesertaBPJS;
	$fFskK = '';
	$fFskD = '';
	$fTgLR = $tanggal_hari_ini;	
	$fJaMR = $fJaMM;
	$fCatA='';		
			
		
		$gTBL = "ta_registrasi";
		$gFLD = "";
		$gVAL = "";
		$gFLD = "fs_kd_reg";
		$gVAL = "'$tREG'";
		$gFLD.= ", fs_mr";
		$gVAL.= ", '".$fNoRM."'";
		$gFLD.= ", fd_tgl_masuk";
		$gVAL.= ", '".$fTgLM."'";
		$gFLD.= ", fs_jam_masuk";
		$gVAL.= ", '".$fJaMM."'";
		$gFLD.= ", fs_kd_petugas";
		$gVAL.= ", '".$gUsER."'";
		
		$gFLD.= ", fs_kd_layanan";
		$gVAL.= ", '".$fLaYK."'";
		
		$gFLD.= ", fs_kd_layanan_akhir";
		$gVAL.= ", '".$fLaYK."'";
		
		$gFLD.= ", fs_kd_jenis_inap";
		$gVAL.= ", '".$fInPK."'";
		
		$gFLD.= ", fs_kd_kelas";
		$gVAL.= ", '".$fKlSK."'";
		
		$gFLD.= ", fn_kunjunganke";
		$gVAL.= ", ".$fKnJK;
		
		$gFLD.= ", fs_kd_cara_masuk_dk";
		$gVAL.= ", '".$fMsKK."'";
		
		###################
		$gFLD.= ", fs_kd_karcis";
		$gVAL.= ", '".$fTrFK."'";
		
		$gFLD.= ", fn_karcis";
		$gVAL.= ", ".$nTrFK;
		
		$gFLD.= ", fn_karcis_bayar";
		$gVAL.= ", ".$fTuNK;
		
		$gFLD.= ", fn_karcis_sisa";
		$gVAL.= ", ".$fSiSK;
		###################
		
		
		$gFLD.= ", fs_kd_rujukan";
		$gVAL.= ", '".$fRjKK."'";
		
		$gFLD.= ", fs_reg_ibu";
		$gVAL.= ", '".$fIbUK."'";
		
		$gFLD.= ", fs_kd_rek_sisa";
		$gVAL.= ", '".$RekSIS."'";
		
		$gFLD.= ", fs_kd_rek_bayar";
		$gVAL.= ", '".$RekBYR."'";
		
		$gFLD.= ", fs_nm_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_alm_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_alm2_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_kota_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_hub_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_id_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_kd_jaminan";
		$gVAL.= ", '".$fJmNK."'";
		
		$gFLD.= ", fb_dari_bawah";
		$gVAL.= ", 0";
		
		$gFLD.= ", fs_umur";
		$gVAL.= ", '045-00-25'";
		
		$gFLD.= ", fs_jam_keluar";
		$gVAL.= ", '".$fJaMM."'";
		
		$gFLD.= ", fs_kd_status_penjamin";
		$gVAL.= ", ''";
		
		$gFLD.= ", fs_ket_anamnesa";
		$gVAL.= ", '".$fAnAM."'";
		
		$gFLD.= ", fs_kd_smf";
		$gVAL.= ", '".$fSmFK."'";
		
		$gFLD.= ", fd_tgl_void";
		$gVAL.= ", '3000-01-01'";
		
		$gFLD.= ", fs_jam_void";
		$gVAL.= ", ''";
		
		$gFLD.= ", fd_tgl_keluar";
		$gVAL.= ", '3000-01-01'";
		
		$gFLD.= ", fs_jam_selesai_tdk";
		$gVAL.= ", ''";
		
		$gFLD.= ", fn_ld";
		$gVAL.= ", 0";
		
		$gFLD.= ", FS_KD_KWITANSI";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_JAMINAN_SUBSIDI";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_JAMINAN_SISA";
		$gVAL.= ", ''";
		
		$gFLD.= ", FN_TOTAL";
		$gVAL.= ", '".$nTrFK."'";
		
		$gFLD.= ", FN_SUBSIDI";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_KLAIM";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_TUNAI";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_SISA";
		$gVAL.= ", 0";
		
		$gFLD.= ", FS_KD_REK_SUBSIDI_YANKES";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_KLAIM_YANKES";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_TUNAI_YANKES";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_SISA_YANKES";
		$gVAL.= ", ''";
		
		$gFLD.= ", FN_TOTAL_OBAT";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_SUBSIDI_OBAT";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_KLAIM_OBAT";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_TUNAI_OBAT";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_SISA_OBAT";
		$gVAL.= ", 0";
		
		$gFLD.= ", FN_SISA_KLAIM";
		$gVAL.= ", 0";
		
		$gFLD.= ", FS_KD_KASIR";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_SUBSIDI_OBAT";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_KLAIM_OBAT";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_TUNAI_OBAT";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_REK_SISA_OBAT";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KET";
		$gVAL.= ", ''";
		
		$gFLD.= ", FN_PIUTANG";
		$gVAL.= ", 0";
		
		$gFLD.= ", FS_KD_PROSEDUR_MASUK";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_KD_PETUGAS_VOID";
		$gVAL.= ", ''";
		
		$gFLD.= ", FN_KARTU_KE";
		$gVAL.= ", 0";
	
		$gFLD.= ", FD_TGL_KARTU";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_CETAK_LIST_KE";
		$gVAL.= ", 1";
	
		$gFLD.= ", FS_KD_JENIS_BAYAR";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_KD_BIN";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_KD_BANK";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_SUBSIDI_PIUTANG";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_KLAIM_PIUTANG";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_TUNAI_PIUTANG";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_SISA_PIUTANG";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_DEPOSIT_YANKES";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_DEPOSIT_OBAT";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_DEPOSIT_PIUTANG";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_KD_REK_SUBSIDI_PIUTANG";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_KD_REK_KLAIM_PIUTANG";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_KD_REK_TUNAI_PIUTANG";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_KD_REK_SISA_PIUTANG";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_TINGGI_BADAN";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_BERAT_BADAN";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_JAM_TDK";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_STATUS_TDK";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_TIME_ISO";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_TIME_ISO2";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_LAMA_ISO_DETIK";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_TIME1_ISO";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_TIME1_ISO2";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_LAMA1_ISO_DETIK";
		$gVAL.= ", 0";
	
		$gFLD.= ", FN_SIMPAN_KALI";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_KD_PETUGAS_CANCEL_OUT";
		$gVAL.= ", ''";
	
		$gFLD.= ", FD_TGL_CANCEL_OUT";
		$gVAL.= ", ''";
	
		$gFLD.= ", FS_JAM_CANCEL_OUT";
		$gVAL.= ", ''";
	
		$gFLD.= ", FN_CANCEL_OUT";
		$gVAL.= ", 0";
	
		$gFLD.= ", FS_KD_MEDIS";
		$gVAL.= ", ''";
	
		$gFLD.= ", ToBLUD";
		$gVAL.= ", 0";
		
				
		InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);
		
		$gTBL = "ta_registrasi_bpjs";
		$gFLD = "";
		$gVAL = "";
		
		$gFLD = "fs_kd_reg";
		$gVAL = "'$tREG'";
		
		$gFLD.= ", fs_mr";
		$gVAL.= ", '".$fNoRM."'";
		
		$gFLD.= ", fd_tgl_masuk";
		$gVAL.= ", '".$fTgLM."'";
		
		$gFLD.= ", fs_jam_masuk";
		$gVAL.= ", '".$fJaMM."'";
		
		$gFLD.= ", FS_BPJS_NO_SEP";
		$gVAL.= ", ''";
		
		$gFLD.= ", FS_LAKALANTAS";
		$gVAL.= ", '".$fLakA."'";
		
		$gFLD.= ", FS_LAKALANTAS_LOKASI";
		$gVAL.= ", '".$fLokA."'";
		
		$gFLD.= ", FS_KD_DIAGNOSA";
		$gVAL.= ", '".$fDiAK."'";
		
		$gFLD.= ", FS_NORUJUK";
		$gVAL.= ", '".$fRjNK."'";
		
		$gFLD.= ", FS_NOPPKRUJUK";
		$gVAL.= ", '".$fRjPK."'";
		
		$gFLD.= ", FS_NOKARTUBPJS";
		$gVAL.= ", '".$fBpJK."'";
		
		$gFLD.= ", FS_NOPPKRUJUK_AWAL";
		$gVAL.= ", '".$fFskK."'";
		
		$gFLD.= ", FS_NMPPKRUJUK_AWAL";
		$gVAL.= ", '".$fFskD."'";
		
		$gFLD.= ", FD_TGLRUJUK";
		$gVAL.= ", '".$fTgLR."'";
		
		$gFLD.= ", FD_JAMRUJUK";
		$gVAL.= ", '".$fJaMR."'";
		
		$gFLD.= ", FS_CATATAN_KHUSUS";
		$gVAL.= ", '".$fCatA."'";
		
			
		InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);
		
			
		$gTBL = "ta_antrian";
		$gFLD = "";
		$gVAL = "";
		$gFLD = "FS_KD_ANTRIAN";
		$gVAL = "'$kodeBooking'";
		$gFLD.= ", FD_TGL_ANTRIAN";
		$gVAL.= ", '".$antrianDate."'";
		$gFLD.= ", FN_NO_ANTRIAN";
		$gVAL.= ", '".$antrianNo."'";
		$gFLD.= ", FS_KD_LAYANAN";
		$gVAL.= ", '".$kode_layanan."'";
		$gFLD.= ", FS_KD_DAFTAR";
		$gVAL.= ", '".$tREG."'";
		$gFLD.= ", FN_ANTRIAN";
		$gVAL.= ", 0";
		$gFLD.= ", FB_STATUS";
		$gVAL.= ", 0";
		
		InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);
		
		$Jns = 0;
		
		#ta_trs_billing
		$gTBL = "ta_trs_billing";
		$gFLD = "";
		$gVAL = "";
		$gFLD = "FS_KD_TRS";
		$gVAL = "'REG".$tREG."'";
		$gFLD.= ", FN_JENIS_TRS";
		$gVAL.= ", '".$Jns."'";
		$gFLD.= ", FD_TGl_TRS";
		$gVAL.= ", '".$fTgLM."'";
		$gFLD.= ", FS_JAM_TRS";
		$gVAL.= ", '".$fJaMM."'";
		$gFLD.= ", FS_KD_PETUGAS";
		$gVAL.= ", '".$gUsER."'";
		$gFLD.= ", FS_KD_REG";
		$gVAL.= ", '".$tREG."'";
		$gFLD.= ", FS_KD_LAYANAN";
		$gVAL.= ", '".$fLaYK."'";
		$gFLD.= ", FS_KD_KELAS";
		$gVAL.= ", '".$fKlSK."'";
		$gFLD.= ", FN_SUB_TOTAL";
		$gVAL.= ", '".$nTrFK."'";
		$gFLD.= ", FN_DISKON";
		$gVAL.= ", 0";
		$gFLD.= ", FN_HARGA_DISKON";
		$gVAL.= ", '".$nTrFK."'";
		$gFLD.= ", FN_TAX";
		$gVAL.= ", 0";
		$gFLD.= ", FN_BIAYA";
		$gVAL.= ", 0";
		$gFLD.= ", FN_TOTAL";
		$gVAL.= ", '".$nTrFK."'";
		$gFLD.= ", FN_TUNAI";
		$gVAL.= ", '".$fTuNK."'";
		$gFLD.= ", FN_SISA";
		$gVAL.= ", '".$fSiSK."'";
		$gFLD.= ", FN_DIJAMIN";
		$gVAL.= ", 0";
		$gFLD.= ", FN_TOTAL_DIJAMIN";
		$gVAL.= ", 0";
		$gFLD.= ", FS_FILLER";
		$gVAL.= ", ''";
		$gFLD.= ", FS_KETERANGAN";
		$gVAL.= ", 'Biaya registrasi masuk.'";
		$gFLD.= ", FS_KETERANGAN2";
		$gVAL.= ", 'Non Operatif'";
		$gFLD.= ", FB_CETAK";
		$gVAL.= ", 'False'";
		
		InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);
		
		#T_HdrTrans
		$gTBL = "t_hdrTrans";
		$gFLD = "";
		$gVAL = "";
		
		$gFLD = "FS_NO_BUKTI";
		$gVAL = "'XREG".$tREG."'";
		$gFLD.= ", FD_TGL_TRANS";
		$gVAL.= ", '".$fTgLM."'";
		$gFLD.= ", FS_JAM_TRANS";
		$gVAL.= ", '".$fJaMM."'";
		$gFLD.= ", FS_KETERANGAN";
		$gVAL.= ", 'REG:".$tREG."/".$tNmP."'";
		$gFLD.= ", FS_KD_PETUGAS";
		$gVAL.= ", '".$gUsER."'";
		$gFLD.= ", FB_APPROVE";
		$gVAL.= ", '0'";
		$gFLD.= ", FS_KETERANGAN1";
		$gVAL.= ", '-'";
		$gFLD.= ", FS_KETERANGAN2";
		$gVAL.= ", '-'";
		InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);
	//-----------------
	
	
	
}else{	
	$json['msg'] = 'Kosong';	
}

//echo json_encode($json);
header("location:form_scan_qr.php?peringatan=$json");
?>