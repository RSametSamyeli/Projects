<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) exit;
$id 	= clean($_POST["id"]);
$sebep 	= clean($_POST["sebep"]);

$bul	 = $conn -> query("select * from siparis where id = ".intval($id))->fetch();
if(!$bul){ exit; }
if(!isset($id) && !isset($sebep)) { exit; }
$iadesql  = $conn-> prepare('UPDATE siparis set iadesebep = ? , iade = ?  where id = ? ');
$iadesonuc = $iadesql -> execute(array($sebep,1,$id));
if($iadesonuc){
	echo 'done';	
}else {
   echo 'db error';	
}

?>