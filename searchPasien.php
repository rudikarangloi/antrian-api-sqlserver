<?
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";

//Report
	
	$response = array();
	$pasien = [];
	$iG=1;
	$FnD = "TRI";
	
	if(isset($_GET['q'])){
		$FnD = $_GET['q'];
	}else{
		$FnD = "ABDULAH";		
	}
	//Sementara
	if($FnD =="ABDULAH"){
		$FnD = "5GUK";
	}
	
	$SyT ="WHERE (FS_NM_PASIEN LIKE '%$FnD%' OR FS_MR LIKE '%$FnD%')";
	
	$nSQ = "SELECT FS_MR, FS_NM_PASIEN, FS_ALM_PASIEN, FS_TEMP_LAHIR, FD_TGL_LAHIR, FB_JNS_KELAMIN, FS_KOTA_PASIEN
			FROM tc_mr $SyT ORDER BY FS_MR";
	//echo $nSQ;
	$nRs = sqlsrv_query($ConSA,$nSQ);
	while ($mRo = sqlsrv_fetch_array($nRs))
	{
		
		$pasien[] = [
                'title' => $mRo[1],
                'text' => $mRo[2],
                'noRm' => $mRo[0]
				
		];			
		
	}
	
	
	//echo json_encode($response); 
	$data = convert_to_utf8_recursively($pasien);	
	echo json_encode($data); 
	//echo( json_encode([   'status' => 'success',   'data' => $data], JSON_UNESCAPED_UNICODE) );	
	//echo json_last_error_msg(); // Print out the error if any
	//die(); // halt the script
	
	




?>
