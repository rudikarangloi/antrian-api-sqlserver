<?

//Koneksi localhost
define('HostnameSA','DESKTOP-G6CU5O0');
//Koneksi Server
//define('HostnameSA','WINDOWS-GLRDQ3P');
define('DatabaseSA','rsgold');
define('UsernameSA','blud');
define('PasswordSA','simblud');

$PARAMS = array();
$OPTION = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );		

$connectionInfo = array( "UID"=>UsernameSA,
                         "PWD"=>PasswordSA,
                         "Database"=>DatabaseSA);

$ConSA = sqlsrv_connect(HostnameSA,$connectionInfo);
if ($ConSA==false)
{
	echo "Could not connect.\n";
	die( print_r( sqlsrv_errors(), true));
}

function CallConnection($gDatabase,$gCon)
{
}

CallConnection(DatabaseSA,$ConSA);
?>