<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)){ exit; }


$user_id     = clean($_POST["user_id"]);
$siparisid	 = clean($_POST["siparisid"]);
$bankaid     = clean($_POST["bankaid"]);
$detay	     = clean($_POST["detay"]);
$tarih	     = time();

if(!isset($user_id) || !isset($bankaid) || !isset($detay) || !isset($siparisid)  ) {
	exit;
}

if(empty($bankaid) || empty($siparisid)) {
	echo 'Boş Alan Bırakmayınız';
	exit;
}

$sql = $conn -> prepare("INSERT INTO havalebildirimi SET
	user_id		= :user_id,
	siparis_id	= :siparis_id,
	banka_id	= :banka_id,
	tarih		= :tarih,
	detay		= :detay,
	durum		= :durum	
	");
	
$ekle = $sql -> execute(array(
	"user_id"	 => $user_id,
	"siparis_id" => $siparisid,
	"banka_id"	 => $bankaid,	
	"tarih"		 => $tarih,
	"detay"		 => $detay,
	"durum"		 => 0
	));
	
	if($ekle) { 
		echo 'done';
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}

?>