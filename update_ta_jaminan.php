<?

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require "connfile.php";
require "functionfile.php";
require "insertupdate.php";


if(isset($_GET['input_data'])){
	
	$input_data = $_GET['input_data'];
	$kode       = $_GET['kode'];
	
	$edit_input_data = str_replace("==="," ",$input_data,$count);
	
	$nSQ = "UPDATE TA_JAMINAN SET FS_NM_JAMINAN = '$edit_input_data' WHERE  FS_KD_JAMINAN = '$kode'";	
	$nRs = sqlsrv_query($ConSA,$nSQ);		
	
	echo 'OK'; 
}


?>