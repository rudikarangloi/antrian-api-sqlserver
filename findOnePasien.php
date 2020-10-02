<?php
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";


$FS_KD_IDENTITAS = $_POST['nik'];
$data = array();



//if((strlen($FS_KD_IDENTITAS) == 16) && (!empty($FS_KD_IDENTITAS)){
if(strlen($FS_KD_IDENTITAS) == 16 && !empty($FS_KD_IDENTITAS)){
	$FS_MR            = fGlobal("FS_MR","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");
	$FS_NM_PASIEN     = fGlobal("FS_NM_PASIEN","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");
	$FS_ALM_PASIEN    = fGlobal("FS_ALM_PASIEN","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");
	$FS_KOTA_PASIEN   = fGlobal("FS_KOTA_PASIEN","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");
	$FS_TEMP_LAHIR    = fGlobal("FS_TEMP_LAHIR","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");
	$FD_TGL_LAHIR     = fGlobal("FD_TGL_LAHIR","TC_MR","FS_KD_IDENTITAS","$FS_KD_IDENTITAS","=","",DatabaseSA,$ConSA,"");

	$data['FS_MR']          = (isset($FS_MR) ? $FS_MR:'-'); 
	$data['FS_NM_PASIEN']   = (isset($FS_NM_PASIEN) ? $FS_NM_PASIEN:'-'); 
	$data['FS_ALM_PASIEN']  = (isset($FS_ALM_PASIEN) ? $FS_ALM_PASIEN:'-'); 
	$data['FS_KOTA_PASIEN'] = (isset($FS_KOTA_PASIEN) ? $FS_KOTA_PASIEN:'-'); 
	$data['FS_TEMP_LAHIR']  = (isset($FS_TEMP_LAHIR) ? $FS_TEMP_LAHIR:'-'); 
	$data['FD_TGL_LAHIR']   = (isset($FD_TGL_LAHIR) ? $FD_TGL_LAHIR:'-'); 
}else{
   	$data['FS_MR']          = '';
	$data['FS_NM_PASIEN']   = '';
	$data['FS_ALM_PASIEN']  = '';
	$data['FS_KOTA_PASIEN'] = '';
	$data['FS_TEMP_LAHIR']  = '';
	$data['FD_TGL_LAHIR']   ='';

}

//echo strlen($FS_KD_IDENTITAS);
//echo json_encode($data);
echo $FS_MR."***".$FS_NM_PASIEN."***".$FS_ALM_PASIEN."***".$FS_KOTA_PASIEN."***".$FS_TEMP_LAHIR."***".$FD_TGL_LAHIR;





?>