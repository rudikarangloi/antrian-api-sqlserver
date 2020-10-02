<?

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require "connfile.php";
require "functionfile.php";
require "insertupdate.php";


//if(isset($_POST['input_data'])){
			
	$nSQ = "SELECT * FROM TA_JAMINAN ORDER BY FS_KD_JAMINAN";	
	$nRs = sqlsrv_query($ConSA,$nSQ);
	while ($mRo = sqlsrv_fetch_array($nRs))
	{
		
		$pasien[] = [
                'kode'  => $mRo['FS_KD_JAMINAN'],
                'nama'  => $mRo['FS_NM_JAMINAN']              
				
		];			
		
	}
	
	$data = convert_to_utf8_recursively($pasien);
	$json['data'] = $data;	
	echo json_encode($json); 



?>