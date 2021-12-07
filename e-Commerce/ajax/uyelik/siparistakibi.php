 <?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)) { exit; }
$email          = clean($_POST["email"]);
$code		    = clean($_POST["code"]);
$sipno		    = clean($_POST["sipno"]);
if(!isset($email) || !isset($code) || !isset($sipno)) exit;

if(empty($email) || empty($code) || empty($sipno)){
	echo 'Boş Alan Bırakmayın';
	exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email'];
	exit;
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu']; 
	exit;
}else {
	$bul = $conn -> query("select * from siparis where oid = '".intval($sipno)."'")->fetch();
	if(!$bul){ 
	    echo 'Böyle Bir Sipariş Bulunamadı'; exit;
	}else{
		$sipdurum   	  = $conn -> query("select * from siptanimla where id = ".$bul['durum']."")->fetch();
		$sipdurumbaslik   = unserialize($sipdurum['baslik']);
		echo 'done|x|';
		echo '<div class="takip-table">
				<table class="table table-bordered table-datatables">
					<thead>
						<tr>
						
							<th>Sipariş No</th>
							<th>Sipariş Tarihi</th>
							<th>Sipariş Durumu</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>#'.$bul['oid'].'</td>
							<td>'.date('d.m.Y H:i',$bul['tarih']).'</td>
							<td>'.$sipdurumbaslik[$set['lang']['active']].'</td>
						</tr>
							
					</tbody>
				</table>
			</div>';
	}
}

?>