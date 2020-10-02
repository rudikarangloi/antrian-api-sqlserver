<?
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";


// $FS_MR         = "620101200000013";
// FD_TGL_MR      = Tanggal daftar/now
// $FS_NM_PASIEN   = "Rudi k"
// $FS_ALM_PASIEN = "JL. REGINAL MENDAWAI, SUKAMARA"
// $FS_TLP_PASIEN = 081390290285092
// $FS_KD_IDENTITAS = 317203090198098294
// $FS_TEMP_LAHIR =  Jakarta
// $FD_TGL_LAHIR = 09-01/1987
// $FB_JNS_KELAMIN = laki = 1 , 0 = perempuan
// $FS_KD_AGAMA = I/K/R ...
// $FS_MR_IBU = "Nama Ibu"

$NoRM="620101200XXXXXX";

$FS_MR           = '';
$FD_TGL_MR       = date("Y-m-d");
$FS_NM_PASIEN    = $_POST['FS_NM_PASIEN'];
$FS_ALM_PASIEN   = $_POST['FS_ALM_PASIEN'];
$FS_ALM2_PASIEN  = $_POST['FS_ALM2_PASIEN'];
$FS_TLP_PASIEN   = $_POST['FS_TLP_PASIEN'];
$FS_KD_IDENTITAS = $_POST['FS_KD_IDENTITAS'];
$FS_TEMP_LAHIR   = $_POST['FS_TEMP_LAHIR'];
$FD_TGL_LAHIR    = $_POST['FD_TGL_LAHIR'];
$FB_JNS_KELAMIN  = $_POST['FB_JNS_KELAMIN'];
$FS_KD_AGAMA     = $_POST['FS_KD_AGAMA'];
$FS_MR_IBU       = $_POST['FS_MR_IBU'];

$eTgL  = explode("/",$FD_TGL_LAHIR);
$fTgLL = $eTgL[2]."-".$eTgL[1]."-".$eTgL[0];

//$fTgLL = $FD_TGL_LAHIR;
//"Islam","Katolik","Protestan","Budha","Hindu","Konghucu"

switch ($FS_KD_AGAMA) {
       case 'Islam':
		  $var3 = 'I';
          break;
       case 'Katolik':
          $var3 = 'K';
          break;
       case 'Protestan':
          $var3 = 'P';
          break;
	   case 'Budha':
          $var3 = 'B';
          break;
	   case 'Hindu':
          $var3 = 'H';
          break;      
       case 'Konghucu':
          $var3 = 'C';
          break;
}

$FS_KD_AGAMA = $var3;

$fTgLM = date("Y-m-d");
$gUsER = "J_app";


	


//Get Number otomatis
$PrmA = fGlobal("fn_kd_mr","t_parameter_dev","fn_kd_mr","%","LIKE","",DatabaseSA,$ConSA,"");
$PrmB = $PrmA+1;
$tNEW = substr(str_repeat('0',6).$PrmA,-6,6);
//$gMR = "620101200".$tNEW;
$gMR = "REG/RSSI/".$tNEW;

	
//Update table	t_parameter
$SQ ="UPDATE t_parameter_dev SET fn_kd_mr=".$PrmB;
$Rs = sqlsrv_query($ConSA,$SQ);
		
$gTBL = "tc_mr_dev";
$gFLD = "";
$gVAL = "";
		
$gFLD = "fs_mr";
$gVAL = "'".$gMR."'";
		
$gFLD.= ", FS_MR_IBU";
$gVAL.= ", '".unParseRM($FS_MR_IBU)."'";
		
$gFLD.= ", FS_NM_ALIAS";
$gVAL.= ", '".$FS_NM_PASIEN."'";
		
$gFLD.= ", FS_NM_PASIEN";
$gVAL.= ", '".$FS_NM_PASIEN."'";
		
$gFLD.= ", FS_ALM_PASIEN";
$gVAL.= ", '".$FS_ALM_PASIEN."'";

$gFLD.= ", FS_ALM2_PASIEN";
$gVAL.= ", '".$FS_ALM2_PASIEN."'";
				
$gFLD.= ", FS_KOTA_PASIEN";
$gVAL.= ", ''";
		
$gFLD.= ", FS_KD_POS_PASIEN";
$gVAL.= ", ''";
		
$gFLD.= ", FS_KD_KELURAHAN";
$gVAL.= ", ''";		
		
$gFLD.= ", FS_TEMP_LAHIR";
$gVAL.= ", '".$FS_TEMP_LAHIR."'";
	
$gFLD.= ", FD_TGL_LAHIR";
$gVAL.= ", '".$fTgLL."'";
		
$gFLD.= ", FB_JNS_KELAMIN";
$gVAL.= ", '".$FB_JNS_KELAMIN."'";
		
$gFLD.= ", FS_KD_STATUS_KAWIN_DK";
$gVAL.= ", '1'";
		
$gFLD.= ", FS_KD_PEKERJAAN_DK";
$gVAL.= ", 'X'";
		
$gFLD.= ", FS_KD_PENDIDIKAN_DK";
$gVAL.= ", 'X'";
		
$gFLD.= ", FS_KD_AGAMA";
$gVAL.= ", '".$FS_KD_AGAMA."'";
	
$gFLD.= ", FS_KD_SUKU";
$gVAL.= ", 'X'";
		
$gFLD.= ", FB_ASING";
$gVAL.= ", '0'";
		
$gFLD.= ", FS_GOL_DARAH";
$gVAL.= ", ''";
		
$gFLD.= ", FS_TLP_PASIEN";
$gVAL.= ", '".$FS_TLP_PASIEN."'";
	
$gFLD.= ", FS_KD_IDENTITAS";
$gVAL.= ", '".$FS_KD_IDENTITAS."'";
		
$gFLD.= ", FD_TGL_MR";
$gVAL.= ", '".$fTgLM."'";
		
$gFLD.= ", FS_KD_PEG";
$gVAL.= ", ''";
	
$gFLD.= ", FS_NM_KELUARGA";
$gVAL.= ", ''";
	
$gFLD.= ", FS_HUB_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_TLP_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_ALM_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_ALM2_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_KOTA_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_KD_POS_KELUARGA";
$gVAL.= ", ''";
		
$gFLD.= ", FS_KD_BAGIAN";
$gVAL.= ", ''";

$gFLD.= ", FS_KD_PETUGAS";
$gVAL.= ", '".$gUsER."'";			
		
			
InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);

//=======================
echo $gMR;



?>