<?php
$xID = "4328";
//$xID = "24287";
$xPS = "rsu41iman902";
//$xPS = "rsu991863mrjn";
#$xPP = "1402R001";
#$xPP = "1402R001";

#echo base64_encode('trs-transportasi');
#Server Develove
#$BaseURL = "http://dvlp.bpjs-kesehatan.go.id:8081";
$BaseURL = "https://new-api.bpjs-kesehatan.go.id";
#$BaseURL = "http://dvlp.bpjs-kesehatan.go.id";
$BasPORT = "8080";
$ServNMA = "new-vclaim-rest";
#$ServNMA = "devwslokalrest";

#Server Real
#$BaseURL = "http://172.16.2.16:80";
#$ServNMA = "";
#RefPoliBPJS($BaseURL,$ServNMA,$xID,$xPS);
$redON = "E5E9E2";

function fJenisBAYAR($nX)
{
	$NmArr = array ('','UMUM','BPJS','JAMKESDA','JAMKESMAS','PERUSAHAAN');
	return $NmArr[$nX];
}

function fBackCLRfRM($tNum)
{
	$tNum = $tNum%2;
	if ($tNum==0) {return "background: #D8F7CA";}
	if ($tNum!=0) {return "background: #ffffff";}
}

function fJenisUser($nX)
{
	$NmArr = array ('Reguler','Administrator');
	return $NmArr[$nX];
}

function fAksesUser($nX)
{
	$NmArr = array ('ReadOnly','ReadWrite');
	return $NmArr[$nX];
}

function parseRM($xG)
{
	$xGR="";
	$xG = str_replace(" ","",$xG);
	if ($xG!=''){
		$xGR = substr($xG,0,7)."-".substr($xG,7,2).".".substr($xG,-6,6);
	}
	else{
	}
	return $xGR;
}

function convert_to_utf8_recursively($dat){
                      if( is_string($dat) ){
                         return mb_convert_encoding($dat, 'UTF-8', 'UTF-8');
                      }
                      elseif( is_array($dat) ){
                         $ret = [];
                         foreach($dat as $i => $d){
                           $ret[$i] = convert_to_utf8_recursively($d);
                         }
                         return $ret;
                      }
                      else{
                         return $dat;
                      }
                }  

function unParseRM($xG)
{
	$xGR="";
	if ($xG){
		$xGR = str_replace("-","",str_replace(".","",$xG));
	}
	else{
	}
	return $xGR;
}

function unParseTGL($gD)
{
	$eTg = explode('-',$gD);
	$TgD = $eTg[2]."-".$eTg[1]."-".$eTg[0];
	return $TgD;
}

function prosTND($xG)
{
	$xP = 0;
	switch ($xG) {
		case '1':		#Standar
			$xP = 0;
			break;
		case '2':		#Cito
			$xP = 8;
			break;
		case '3':		#Standar2
			$xP = 33.33;
			break;
		case '4':		#CIto2
			$xP = 46.67;
			break;
		case '5':		#ASA I (30%)
			$xP = 0;
			break;
		case '6':		#ASA II(35%)
			$xP = 16.48;
			break;
		case '7':		#ASA III (40%)
			$xP = 18.85;
			break;
		case 'A':		#ASA 1(30%)CYTO
			$xP = 0;
			break;
		case 'B':		#ASA 2(35%)CYTO
			$xP = 0;
			break;
		case 'C':		#ASA 3(40%)CYTO
			$xP = 0;
			break;
		case 'D':		#ASA 4(45%)CYTO
			$xP = 0;
			break;
		case 'E':		#ASA 5(50%)CYTO
			$xP = 0;
			break;
		case 'G':		#DR.ANASTESI1/4%
			$xP = 0;
			break;
	}
	return $xP;
}

function parseTGL($xB)
{
	$xG="";
	if ($xB!=""){
		$xG = explode("-",$xB);
		$xG = $xG[2]."-".$xG[1]."-".$xG[0];
	}
	return $xG;
}

function parseTglFRM($xA,$xB,$xC)
{
	return $xC.'-'.substr('0'.$xB,-2,2).'-'.substr('0'.$xA,-2,2);
}

function RefPoliBPJS($BaseURL,$ServNMA,$xID,$xPS)
{
	$sCrt = "";
	$sIdc = $xID;
	$sKey = $xPS;
	$sNom = "0001863326316";
	date_default_timezone_set('UTC');
	
	//SIGNATURE
	$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
	$tdata = $sIdc."&".$tStamp;
	$signature = hash_hmac('sha256', $tdata, $sKey, true);
	$encodedSignature = base64_encode($signature);
	//END 
	
	if ($sCrt=='ktp'){
		$sNik="nik/";
	}
	else {
		$sNik="";
	}
	
	$url = $BaseURL."/".$ServNMA."/peserta/peserta/";
	$url.= $sNik;
	$url.= $sNom;
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,array("Accept: application/json\r\n" . "X-cons-id: ".$sIdc."\r\n" . "X-Timestamp: $tStamp\r\n" . "X-Signature: $encodedSignature"));
	curl_setopt($curl, CURLOPT_GET, true);
	$json_response = curl_exec($curl);
	curl_close($curl);
	
	$ArrData = json_decode($json_response, true);
	$ArrCode = $ArrData[metadata]['code']; 
	$ArrMess = $ArrData[metadata]['message']; 
	
	echo $json_response." XXXXX";
}

//=======================//
date_default_timezone_set('Asia/Jakarta');
ini_set('max_execution_time', 300);

require "configfile.php";

function fBackCLR($tNum)
{
	$tNum = $tNum%2;
	if ($tNum==0) {return "bgcolor='#F4F1F1'";}
	if ($tNum!=0) {return "";}
}

function fBackTBL($tNum)
{
	$tNum = $tNum%2;
	if ($tNum==0) {return "DCF8E4";}
	if ($tNum!=0) {return "fff";}
}

function fConvertToRupiah($Angka)
{
	return number_format($Angka, 2, ",", ".");
}

function fConvertToRupiahBulat($Angka)
{
	return number_format($Angka, 0, ",", ".");
}

function fConvertDateShort($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return substr("00".$mD,-2,2)."-".substr("00".$mB,-2,2)."-".$mT;
}

function fConvertDateShortBln($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return substr("00".$mD,-2,2)." ".fNmBulanShort($mB)." ".$mT;
}

function fConvertDateLongBln($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return substr("00".$mD,-2,2)." ".fNmBulanLong($mB)." ".$mT;
}

function fConvertDateSimple($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return substr("00".$mD,-2,2)."/".substr("00".$mB,-2,2)."/".$mT;
}

function fConvertDateSimpleStrip($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return substr("00".$mD,-2,2)."-".substr("00".$mB,-2,2)."-".$mT;
}

function fConvertDateSimpleX($mDt)
{
	$mDt = split("-",$mDt);
	$mD = (int)$mDt[2];
	$mB = (int)$mDt[1];
	$mT = (int)$mDt[0];
	return $mD."/".$mB."/".substr($mT,-2,2);
}

function fNmBulanShort($nX)
{
	$NmBulan = array ('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
	return $NmBulan[$nX];
}

function fNmHari($nX)
{
	$NmHari = array ('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
	return $NmHari[$nX];
}

function fNmBulanLong($nX)
{
	$NmBulan = array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	return $NmBulan[$nX];
}

function fUserType($nX)
{
	$UserType = array ('Creator','Administrator','Pelayanan','Verifikasi');
	return $UserType[$nX];
}

function fTerbilang($angka)
{
	return terbilang($angka)." rupiah";
}

function terbilang($angka)
{
    // pastikan kita hanya berususan dengan tipe data numeric
    $angka = (float)$angka;
     
    // array bilangan
    // sepuluh dan sebelas merupakan special karena awalan 'se'
    $bilangan = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
    );
     
    // pencocokan dimulai dari satuan angka terkecil
    if ($angka < 12) {
        // mapping angka ke index array $bilangan
        return $bilangan[$angka];
    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'tujuh'
        $hasil_bagi = (int)($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
        //return sprintf('seratus %s', terbilang($angka - 100))." rupiah";
        return sprintf('seratus %s', terbilang($angka - 100));
    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
        $hasil_bagi = (int)($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif terbilang(250)
        //return trim(sprintf('seribu %s', terbilang($angka - 1000)))." rupiah";
        return trim(sprintf('seribu %s', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR
        // @#$%^ WT*
         
        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int)($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int)($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else {
        return '......';
    }
}

function fConvertToNumeric($Angka)
{
	if ($Angka=="")
	{
		return 0;
	}
	else
	{
		$CnvR = str_replace('.', '',$Angka);
		$CnvR = str_replace(',', '.',$CnvR);
		return $CnvR;
	}
}

function fHiSplitT2K($DataG,$xChr)
{
	$cTtK="";
	foreach (count_chars($DataG, 1) as $i => $val)
	{if (chr($i)==$xChr) {$cTtK = $val;}}
	return $cTtK;
}

function fGlobal($nFldD,$nTbl,$nFldF,$nSyR,$fArtM,$nOdr,$NmDB,$NmCon,$fShow)
{
	$fGlobal="";
	$JmLa=fHiSplitT2K($nFldD,":");
	$JmLb=fHiSplitT2K($nFldF,":");
	
	$fArtM = str_replace("Like", "LIKE",$fArtM);
	$fArtM = str_replace("like", "LIKE",$fArtM);
	
	if ($JmLb > 0 )
	{
		$SxR = explode(':', $nFldF);
		$SyR = explode(':', $nSyR);
		if ($fArtM!="") {$ArT = explode(':', $fArtM);}
		for ($iGL=0; $iGL<=$JmLb; $iGL++)
		{
			if ($fArtM!="") {$fOpr=$ArT[$iGL];} else {$fOpr="LIKE";}
			
			if ($iGL==0)
			{$zFldF = $SxR[$iGL]." ".$fOpr." '".$SyR[$iGL]."'";}
			else
			{$zFldF = $zFldF." AND ".$SxR[$iGL]." ".$fOpr." '".$SyR[$iGL]."'";}
		}
	}
	else
	{
		if ($fArtM!="") {$fOpr=$fArtM;} else {$fOpr="LIKE";}
		$zFldF= $nFldF." ".$fOpr." '".$nSyR."'";
	}
	
	$nFldD = str_replace("IfNull", "IFNULL",$nFldD);
	$nFldD = str_replace("Ifnull", "IFNULL",$nFldD);
	$nFldD = str_replace("ifnull", "IFNULL",$nFldD);
	
	$nFldD = str_replace("sum", "SUM",$nFldD);
	$nFldD = str_replace("Sum", "SUM",$nFldD);
	
	$nFldD = str_replace("Count", "COUNT",$nFldD);
	$nFldD = str_replace("count", "COUNT",$nFldD);
	
	$nFldD = str_replace("Max", "MAX",$nFldD);
	$nFldD = str_replace("max", "MAX",$nFldD);
	
	$nFldD = str_replace("Min", "MIN",$nFldD);
	$nFldD = str_replace("min", "MIN",$nFldD);
	
	$nFldD = str_replace("Desc", "DESC",$nFldD);
	$nFldD = str_replace("desc", "DESC",$nFldD);

	$nFldD = str_replace("Limit", "LIMIT",$nFldD);
	$nFldD = str_replace("limit", "LIMIT",$nFldD);
	
	if ($nOdr!="") { $nOdr=" ORDER BY ".$nOdr;}
	if ($JmLa > 0) {$SQGL="SELECT ".str_replace(":", ", ",$nFldD)." FROM ".strtolower($nTbl)." WHERE ".$zFldF.$nOdr;}
	else {$SQGL="SELECT ".str_replace(":", ", ",$nFldD)." AS FldD FROM ".strtolower($nTbl)." WHERE ".$zFldF.$nOdr;}
	if ($fShow!="") {echo $SQGL."<br>";}
	
	$nRstGlo = sqlsrv_query($NmCon,$SQGL);
	while($mRowGlo = sqlsrv_fetch_array($nRstGlo))
	{
		if ($JmLa > 0)
		{
			$Sx=explode(':',$nFldD);
			for ($iGL=0; $iGL<=$JmLa; $iGL++)
			{
				if ($iGL==0)
					{$zFldD=$mRowGlo[$Sx[$iGL]];}
				else
					{$zFldD=$zFldD.":".$mRowGlo[$Sx[$iGL]];}
			}
			return $zFldD;
		}
		else
		{
			return $mRowGlo['FldD'];
		}
	}
}

function atasiKutif($TxT)
{
	//return mysql_real_escape_string($TxT);
	return $TxT;
}

function fMessage($rKD)
{
	$rKD = (int)$rKD;
	switch ($rKD) 
	{
	case 0:
		echo "";
		break;
	case 1:
		$NmMess = "User anda belum aktif, silahkan hubungi administrator untuk aktivasi..!";
		break;
	case 2:
		$NmMess = "Password tidak sesuai...!";
		break;
	case 3:
		$NmMess = "User tidak ditemukan...!";
		break;
	case 4:
		$NmMess = "Error user session...!";
		break;
	case 5:
		$NmMess = "Anda tidak melakukan aktivitas dalam waktu 60 menit, Sistem melakukan logout otomatis...!";
		break;
	case 6:
		$NmMess = "User sudah terpakai, silahkan coba yang lain...!";
		break;
	case 7:
		$NmMess = "Data user berhasil direkam, silahkan hubungi administrator untuk aktivasi...!";
		break;
	case 8:
		$NmMess = "Data user berhasil direkam...!";
		break;
	case 9:
		$NmMess = "Penambahan data baru berhasil...!";
		break;
	case 10:
		$NmMess = "Perubahan data berhasil...!";
		break;
	case 11:
		$NmMess = "Rekam data dibatalkan, password lama tidak sesuai...!";
		break;
	case 12:
		$NmMess = "Penghapusan berhasil...!";
		break;
	case 13:
		$NmMess = "Perubahan kata kunci berhasil..!";
		break;
	case 14:
		$NmMess = "Pembatalan berhasil...!";
		break;
	case 15:
		$NmMess = "Proses berhasil...!";
		break;
	}
	return $NmMess;
}

function fJnsKelamin($nX)
{
	$NmJenis = array ('LAKI-LAKI','PEREMPUAN');
	return $NmJenis[$nX];
}

function datediff($tgl1, $tgl2)
{
	$tgl1 = (is_string($tgl1) ? strtotime($tgl1) : $tgl1);
	$tgl2 = (is_string($tgl2) ? strtotime($tgl2) : $tgl2);
	$diff_secs = abs($tgl2-$tgl1);
	$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	
	return array( 
	"year" => date("Y", $diff) - $base_year,
	"month_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	"month" => date("n", $diff) - 1,
	"day_total" => floor($diff_secs / (3600 * 24)),
	"day" => date("j", $diff) - 1,
	"hour_total" => floor($diff_secs / 3600),
	"hour" => date("G", $diff),
	"minute_total" => floor($diff_secs / 60),
	"minute" => (int) date("i", $diff),
	"second_total" => $diff_secs,
	"second" => (int) date("s", $diff)."&nbsp; ");
}

#$nSep = "1402R00110170000033";
#$sCrT = "noKartu";
#$sCrT = "tglSep";

#echo InfoGlobalSEP($nSep,"tglSep",$BaseURL,$BasPORT,$xID,$xPS).".......xxxxxxxxxxxxx.........";

function InfoGlobalSEP($nSep,$sCrT,$BaseURL,$BasPORT,$sIdc,$sKey)
{
	date_default_timezone_set('UTC');
	$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
	$tdata = $sIdc."&".$tStamp;
	$signature = hash_hmac('sha256', $tdata, $sKey, true);
	$encodedSignature = base64_encode($signature);
	
	$url = $BaseURL.":".$BasPORT."/devWsLokalRest/SEP/".$nSep;
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,array("Content-Type: Application/x-www-form-urlencoded\r\n" . "X-cons-id: ".$sIdc."\r\n" . "X-Timestamp: $tStamp\r\n" . "X-Signature: $encodedSignature"));
	curl_setopt($curl, CURLOPT_GET, true);
	$json_response = curl_exec($curl);
	curl_close($curl);
	
	$ArrData = json_decode($json_response, true);
	$ArrCode = $ArrData[metadata]['code']; 
	$ArrMess = $ArrData[metadata]['message']; 
	
	if($ArrCode=="200")
	{
		if ($sCrT=="noKartu"){return $ArrData[response]['peserta']['noKartu'];}
		else if ($sCrT=="tglSep"){return $ArrData[response]['tglSep'];}
		
		else {return "Kriteria tidak jelas..!!";}
		/*
		$nomSep = $ArrData[response]['noSep'];
		$nomKrt = $ArrData[response]['peserta']['noKartu'];
		$nmaPsr = $ArrData[response]['peserta']['nama'];
		$TglLhr = fConvertDateShort($ArrData[response]['peserta']['tglLahir']);
		$JnsKlm = $ArrData[response]['peserta']['sex'];
		$PolTjn = $ArrData[response]['poliTujuan']['nmPoli'];
		
		#$FasKes = $ArrData[response]['provPelayanan']['nmProvider']." --> loading Fasekes 1 Kecamatan";
		$FasKes = $ArrData[response]['provRujukan']['nmProvider'];
		
		$DiagAw = $ArrData[response]['diagAwal']['kdDiag'];
		$TglSep = fConvertDateShort($ArrData[response]['tglSep']);
		$JnsPsr = $ArrData[response]['peserta']['jenisPeserta']['nmJenisPeserta'];
		#echo $JnsPsr."<br>";
		$NomoMR = $ArrData[response]['peserta']['noMr'];
		$StaCOB = $ArrData[response]['statusCOB']['namaCOB'];
		
		$JnsRwt = $ArrData[response]['jnsPelayanan'];
		#echo $JnsRwt;
		
		if ($JnsRwt=="Jalan" || $JnsRwt=="Inap") 
		{$JnsRwt="Rawat ".$JnsRwt;}
		else
		{$JnsRwt="IGD";}
		$KlsRwt = $ArrData[response]['klsRawat']['nmKelas'];
		$Catatn = $ArrData[response]['catatan'];
		*/
	}
	else
	{
		return $ArrMess;
	}
}

function fAmbilGetDate($nVr)
{
	if ($nVr!="")
	{
		/*
		[seconds] => 40			Numeric representation of seconds						: 0 to 59	
		[minutes] => 58			Numeric representation of minutes						: 0 to 59
		[hours]   => 21			Numeric representation of hours							: 0 to 23
		[mday]    => 17			Numeric representation of the day of the month			: 1 to 31
		[wday]    => 2			Numeric representation of the day of the week			: 0 (for Sunday) through 6 (for Saturday)
		[mon]     => 6			Numeric representation of a month						: 1 through 12
		[year]    => 2003		A full numeric representation of a year, 4 digits		: Examples: 1999 or 2003
		[yday]    => 167		Numeric representation of the day of the year			: 0 through 365
		[weekday] => Tuesday	A full textual representation of the day of the week	: Sunday through Saturday
		[month]   => June		A full textual representation of a month, such as January or March		: January through December	
		[0]       => 1055901520	Seconds since the Unix Epoch, similar to the values returned by time() and used by date(). 	: System Dependent, typically -2147483648 through 2147483647. 
		*/
		$mArr = getdate();
		return $mArr[$nVr];
	}
}

function QryJAMINAN($gCB,$tB)
{
	$JmN = "";
	if ($gCB)
	{
		if ($gCB=='1') {
			$JmN = "AND ".$tB."FS_KD_JAMINAN ='001'";
		}
		if ($gCB=='2') {
			$JmN = "AND (".$tB."FS_KD_JAMINAN ='148' OR ".$tB."FS_KD_JAMINAN ='149' OR ".$tB."FS_KD_JAMINAN ='150' OR ".$tB."FS_KD_JAMINAN ='155')";
		}
		if ($gCB=='3') {
			$JmN = "AND ".$tB."FS_KD_JAMINAN ='093'";
		}
		if ($gCB=='4') {
			$JmN = "AND ".$tB."FS_KD_JAMINAN ='090'";
		}
		if ($gCB=='5') {
			$JmN = "AND ".$tB."FS_KD_JAMINAN <> '001' AND ".$tB."FS_KD_JAMINAN <>'148' AND ".$tB."FS_KD_JAMINAN <>'149' AND ".$tB."FS_KD_JAMINAN <>'150' AND ".$tB."FS_KD_JAMINAN <>'155' AND ".$tB."FS_KD_JAMINAN <>'093' AND ".$tB."FS_KD_JAMINAN <>'090'";
		}
	}
	return $JmN;
}

$ArrKCS = array("RD001"=>"01", "RJ001"=>"02", "RJ002"=>"15", "RJ003"=>"14", "RJ004"=>"16", "RJ005"=>"05", "RJ006"=>"17", "RJ007"=>"04", "RJ008"=>"26", "RJ009"=>"09", "RJ010"=>"13", "RJ011"=>"22", "RJ012"=>"19", "RJ013"=>"28", "RJ014"=>"21", "RJ015"=>"24", "RJ016"=>"25", "RJ017"=>"26", "RJ018"=>"27", "RJ019"=>"29", "RJ020"=>"04", "RJ021"=>"32", "RJ022"=>"33", "RJ023"=>"34", "RJ024"=>"35", "RJ026"=>"36");
$ArrLAY = array("RD"=>"INSTALASI GAWAT DARURAT", "RJ"=>"INSTALASI RAWAT JALAN", "RI"=>"INSTALASI RAWAT INAP", "UP"=>"UNIT PENUNJANG");

function eReaplace($X){
	$X = str_replace("LANAN ","",$X);
	$X = str_replace("AKASIA ","",$X);
	$X = str_replace("BENGKIRAI ","",$X);
	$X = str_replace("ICU/ICCU/NICU/PICU ","",$X);
	$X = str_replace("MERANTI ","",$X);
	$X = str_replace("PERINATOLOGI ","",$X);
	$X = str_replace("ULIN ","",$X);
	$X = str_replace("SINDUR ","",$X);
	
	return $X;
}

?>