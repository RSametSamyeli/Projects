<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)){ exit; }

$id  	  = clean($_POST["id"]);
$user_id  = clean($_POST["user_id"]);
$mesaj	  = clean($_POST["mesaj"]);
$tarih	  = time();

if(!isset($user_id) || !isset($id) || !isset($mesaj) ) {
	exit;
}



$sql = $conn -> prepare("INSERT INTO destekcevap SET
	user_id		= :user_id,
	destek_id	= :destek_id,
	mesaj		= :mesaj,
	tarih		= :tarih	
	");
	
$ekle = $sql -> execute(array(
	"user_id"	=> $user_id,
	"destek_id"	=> $id,
	"mesaj"		=> $mesaj,
	"tarih"		=> $tarih
	));
	
	if($ekle) { 
		echo 'done';
		$durumsql = $conn -> prepare("UPDATE destek SET durum = ? WHERE id  = ?");
		$durumsql -> execute(array(1,$id));
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}

?>