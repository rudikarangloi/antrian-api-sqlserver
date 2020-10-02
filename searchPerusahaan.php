<?
require "connfile.php";
require "functionfile.php";
require "insertupdate.php";

//Report
	
	$response = array();
	$pasien = [];
	$iG=1;
	$FnD = "A";
	
	if(isset($_GET['q'])){
		$FnD = $_GET['q'];
	}else{
		$FnD = "A";
	}
	
	//FS_KD_JAMINAN 
	//FS_NM_JAMINAN
	
	$SyT ="WHERE (FS_NM_JAMINAN LIKE '%$FnD%' AND FS_NM_JAMINAN NOT LIKE '%OFF%' AND FS_NM_JAMINAN NOT LIKE  '%0FF%')";	
	
	$nSQ = "SELECT FS_KD_JAMINAN, FS_NM_JAMINAN, FS_KD_JAMINAN+':'+ FS_NM_JAMINAN AS KET FROM TA_JAMINAN  $SyT ORDER BY FS_KD_JAMINAN";
	//echo $nSQ;
	$nRs = sqlsrv_query($ConSA,$nSQ);
	while ($mRo = sqlsrv_fetch_array($nRs))
	{
		
		$pasien[] = [
                'title'  => $mRo[1],
                'text'   => $mRo[2],
                'noRm'   => $mRo[0]
				
		];			
		
	}
	
	
	
	$data = convert_to_utf8_recursively($pasien);	
	echo json_encode($data); 
	



?>
