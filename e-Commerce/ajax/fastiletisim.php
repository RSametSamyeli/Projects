<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include_once('../phpmailer/class.phpmailer.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}

$adsoyad = clean($_POST["fast_adsoyad"]);
$email   = clean($_POST["fast_mail"]);
$mesaj   = clean($_POST["fast_mesaj"]);
$tarih   = date("d.m.y H:i");
$durum   = 0;
if(!isset($adsoyad) || !isset($email) || !isset($mesaj)) { exit;}
if(empty($adsoyad) || empty($email) || empty($mesaj)){
	echo $lang['mesaj']['bos_alan_birakmayin']; exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
		echo $lang['mesaj']['gecersiz_email']; exit;
}else {
	$ekle = $conn -> prepare("INSERT INTO mesajiletisim (adsoyad,mail,mesaj,tarih,durum) VALUES (?,?,?,?,?)");
	$ekle -> execute(array($adsoyad,$email,$mesaj,$tarih,0));
	if($ekle) { 
			echo 'done';
		/*---- Smtp ----*/
		/*	$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Host = $mailhost ;
			$mail->Port = $mailport;
			$mail->SMTPSecure = 'tsl';
			$mail->Username = $mailadres;
			$mail->Password = $mailsifre;
			$mail->SMTPAuth = true;
			$mail->IsHTML(true);
			$mail->AddAddress($mailadres);
			$mail->SetFrom($email,$adsoyad);
			$mail->CharSet = 'UTF-8';
			$mail->SetLanguage("tr", "phpmailer/language");
			$mail->Encoding="base64";
			$mail->Subject = 'Hızlı İletişim ( '.$adsoyad.' )';
			$mail->Body ="
			<table>
				<tr>
					<td>
						<table>
							<tr><td colspan='3'><h4 style='color:#4a4a49'>Gönderen (Ad Soyad)</h4></td></tr>
							<tr><td>".$adsoyad."</td></tr>
							<tr><td colspan='3'><h4 style='color:#4a4a49'>E-Mail Adresi</h4></td></tr>
							<tr><td>".$email."</td></tr>
							<tr><td colspan='3'><h4 style='color:#4a4a49'>Mesaj</h4></td></tr>
							<tr><td>".$mesaj."</td></tr>
							<tr><td colspan='3'><h4 style='color:#4a4a49'>Tarih</h4></td></tr>
							<tr><td>".$tarih."</td></tr>
						</table>
					</td>
				</tr>
			</table>		
				" ;  
			$mail->Send();*/
	} else { echo 'bir sorun oluştu'; }
}
 ?>