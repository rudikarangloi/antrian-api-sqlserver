<?
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";

$fHos = gethostbyaddr($_SERVER['REMOTE_ADDR']);


//Find data =============
$tIDT = fGlobal("fs_nm_user","th_user","fs_kd_user","NANA","=","",DatabaseSA,$ConSA,"");
//select fs_nm_user from th_user where fs_kd_user='NANA';
echo $tIDT;
//=======================


//Insert data =======================
$gTBL = "th_user";
		
$gFLD = "";
$gVAL = "";
		
$gFLD = "fs_kd_user";
$gVAL = "'RUD'";
		
$gFLD.= ", fs_nm_user";
$gVAL.= ", 'RUDI KURNIAWAN'";
		
$gFLD.= ", FS_PASSWORD";
$gVAL.= ", '77799'";
		
$gFLD.= ", FB_ADMIN";
$gVAL.= ", '7'";
		
$gFLD.= ", FS_KD_USER_BILLING";
$gVAL.= ", 'ALP'";

$gFLD.= ", FS_KD_GROUP";
$gVAL.= ", 'OFF'";
		
$gFLD.= ", FS_KD_LAYANAN";
$gVAL.= ", '0F808'";
//InsertGLOBAL($gTBL,$gFLD,$gVAL,DatabaseSA,$ConSA);

//=======================
echo "<P>";
echo date("Y-m-d");

echo "<P>";
$PrmA = fGlobal("fn_kd_mr","t_parameter","fn_kd_mr","%","LIKE","",DatabaseSA,$ConSA,"");
		$PrmB = $PrmA+1;
		$tNEW = substr(str_repeat('0',6).$PrmA,-6,6);
		$gMR = "620101200".$tNEW;
		echo $gMR;
	




?>