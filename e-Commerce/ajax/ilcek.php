<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
if(!isset($_POST)) { exit;}

	$ilId = intval($_POST['ilId']);
	if(!isset($ilId)) { exit;}
	$rv = '';
	if(!empty($ilId)){
		$query = $conn -> query('select * from ilce where IL_ID = "'.$ilId.'"');
		foreach($query as $ilce) {
			$rv .= '<option value="'. $ilce['ID'].'">'.$ilce['ADI'].'</option>';	
		}
		
		echo $rv;
	}else{
		$query = $conn -> query('select * from il');
		foreach($query as $il) {
			$rv .= '<option value="'. $il['ID'].'">'.$il['ADI'].'</option>';	
		}
		echo $rv;
	}
	
	
?>