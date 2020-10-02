<?
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";

//Report
	
	$response = array();
	$courses = [];
	$iG=1;
	$FnD = "TRI";
	
	if(isset($_GET['q'])){
		$FnD = $_GET['q'];
	}else{
		$FnD = "PASIEN";
	}
	
	
	$SyT ="WHERE (FS_NM_PASIEN LIKE '%$FnD%')";
	
	$nSQ = "SELECT FS_MR, FS_NM_PASIEN, FS_ALM_PASIEN, FS_TEMP_LAHIR, FD_TGL_LAHIR, FB_JNS_KELAMIN, FS_KOTA_PASIEN
			FROM tc_mr $SyT ORDER BY FS_MR";
	//echo $nSQ;
	$nRs = sqlsrv_query($ConSA,$nSQ);
	while ($mRo = sqlsrv_fetch_array($nRs))
	{
		
		array_push($response, 
        array(
            'FS_MR'=>$mRo[0], 
            'FS_NM_PASIEN'=>str_replace(",","-",$mRo[1]),
			'FS_ALM_PASIEN'=>str_replace(",","-",$mRo[2])
            ) 
        );
		
		$courses[] = [
                'title'        => $mRo[1],
                'text' => $mRo[2]
				
		];			
		//echo $mRo[0] ." >> ". str_replace(",","-",$mRo[1])." >> ". str_replace(",","-",$mRo[2])."<br>";
		$iG++;
	}
	
	//mb_convert_encoding($data['name'], 'UTF-8', 'UTF-8');
	//echo json_encode($response); 
	$data = convert_to_utf8_recursively($courses);	
	echo json_encode($data); 
	//echo( json_encode([   'status' => 'success',   'data' => $data], JSON_UNESCAPED_UNICODE) );	
	//echo json_last_error_msg(); // Print out the error if any
	//die(); // halt the script
	
	




?>
