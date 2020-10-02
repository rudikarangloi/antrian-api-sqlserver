<?
function InsertGLOBAL($gTBL,$gFLD,$gVAL,$gDataBase,$gCon)
{
	CallConnection($gDataBase,$gCon);
	$SQGB="INSERT INTO $gTBL (".$gFLD.") values(".$gVAL.")";
	//echo $SQGB."<br>";
	//$rsGB= sqlsrv_query($ConSA,$SQGB);
	$rsGB = sqlsrv_query($gCon,$SQGB);
}

function fHiSplitT2KX($DataG,$xChr)
{
	$cTtK="";
	foreach (count_chars($DataG, 1) as $i => $val)
	{if (chr($i)==$xChr) {$cTtK = $val;}}
	return $cTtK;
}

function UpdateGLOBAL($gTBL,$gDTA,$gIdX,$gSyR,$gOpR,$gDataBase,$gCon)
{
	$JmL=fHiSplitT2KX($gIdX,":");
	if ($JmL > 0)
	{
		$gID = explode(':',$gIdX);
		$gSY = explode(':',$gSyR);
		$gOP = explode(':',$gOpR);
		
		$gUpD= "";
		for ($iG=0; $iG<=$JmL; $iG++)
		{
			if ($iG > 0) {$gAd=" AND ";} else {$gAd="";}
			$gUpD.= $gAd.$gID[$iG]." ".$gOP[$iG]." ".$gOP[$iG];
		}
	} else {$gUpD=$gIdX.$gOpR.$gSyR;}
	
	CallConnection($gDataBase,$gCon);
	$SQGB="UPDATE $gTBL SET ".$gDTA." WHERE ".$gUpD;
	$rsGB= sqlsrv_query($gCon,$SQGB) or die(mysql_error());
	
}
?>