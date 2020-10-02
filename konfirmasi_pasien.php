<?
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require "connfile.php";
require "functionfile.php";
require "insertupdate.php";



if(isset($_POST['input_data'])){

		$input_data = $_POST['input_data'];
		
		$tIDT = fGlobal("FS_NM_PASIEN","TC_MR","FS_KD_IDENTITAS","$input_data","=","",DatabaseSA,$ConSA,"");
		
        $query    = " SELECT FS_NM_PASIEN AS FldD, FS_MR,FS_KD_IDENTITAS, FS_NM_PASIEN, FS_ALM_PASIEN, FS_KOTA_PASIEN, FS_TLP_PASIEN
						FROM tc_mr WHERE FS_KD_IDENTITAS = '". $input_data ."' ";
        $sql      = sqlsrv_query($ConSA, $query, array(), array('Scrollable' => 'static'));
        $ketemu   = sqlsrv_num_rows($sql);
        $data     = sqlsrv_fetch_array($sql);
		
		if ($ketemu > 0) {
            $json['peringatan'] = 0;  
			$json['nama'] = $tIDT;   
			$json['data'] = $data;
        }else{
            $json['peringatan'] = 1;
			$json['nama'] = '---';
        }
		
		/*
		$sql = "SELECT FS_NM_PASIEN AS FldD FROM tc_mr WHERE FS_MR = '". $input_data ."'";		
		$rstClient = $mysqli->query($sql);			
    	$rowClient = $rstClient->fetch_array();
    	if($rowClient['FldD']){
			$json['peringatan'] = 0;
		}else{
			$json['peringatan'] = 1;
		}   
		*/    
}

echo json_encode($json);




?>