<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include_once('../phpmailer/PHPMailerAutoload.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_POST)) { exit;}
$adsoyad	 = clean($_POST["adsoyad"]);
$telefon 	 = clean($_POST["telefon"]);
$email 		 = clean($_POST["email"]);
$konu 		 = clean($_POST["konu"]);
$mesaj 		 = clean($_POST["mesaj"]);
$tarih 		 = date("d.m.y H:i");
$code		 = clean($_POST["code"]);
$durum 		 = 0;
if(!isset($adsoyad) || !isset($telefon) || !isset($email) || !isset($konu) || !isset($mesaj)) { exit;}
if(empty($adsoyad) || empty($telefon) || empty($email) || empty($konu) || empty($mesaj)){
	echo $lang['mesaj']['bos_alan_birakmayin'];
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email'];
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu']; exit;
}else {
	
	$sql = $conn -> prepare("INSERT INTO mesajiletisim SET
	adsoyad 	= :adsoyad,
	telefon 	= :telefon,
	mail 		= :mail,
	konu 		= :konu,
	mesaj 		= :mesaj,
	tarih 		= :tarih,
	durum		= :durum
	");
	
	$ekle = $sql -> execute(array(
		"adsoyad" => $adsoyad,
		"telefon" => $telefon,
		"mail"    => $email,
		"konu"    => $konu,
		"mesaj"   => $mesaj,
		"tarih"   => $tarih,
		"durum"    => 0
		));
	if($ekle) { 
		echo 'done';
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->Host = $mailhost ;
		$mail->Port = $mailport;
		$mail->Username = $mailadres;
		$mail->Password = $mailsifre;
		$mail->AddAddress($mailadres);
		$mail->AddBCC($sslmi); 
		$mail->SetFrom($mailadres,$adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML(true);
		$mail->Subject = 'İletişim - '.$konu.'';
		$content = '
		<table width="100%" style="border-spacing:0; padding:10px; background:whiteSmoke;  font-family:Helvetica, Arial, sans-serif;">
				<tbody>
						<tr>
							<td align="center" style="padding-top:18px; margin-top:5px; padding-bottom:10px;">
								<table bgcolor="#FFF" width="670" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0; background:#fff; padding-bottom:15px; padding-left:15px; padding-right:15px;">
										<tbody>
											<tr>
												<td style="padding-top:5px; padding-bottom:5px; "><h1 style="width:100%; text-align:center;  font-weight:bold; color: #445359; background:#173759; color:#fff; padding-top:5px; padding-bottom:5px; font-size:22px;">'.ucfirsttr($set['seo']['t']).'</h1></td>
											</tr>
											<tr style="padding-top:10px; padding-bottom:5px;">
												<td style="border-bottom:1px solid #eee;"><h2 style="width:100%; text-align:left;  color: #445359; font-size:15px;">'.$adsoyad.' kişisinden mesaj aldınız. Mesaj Detayları Aşağıdadır</h2></td>
											</tr>
											<td align="left" style="padding-top:10px;">
												<table>
													<tbody cellpadding="0" cellspacing="0">
															<tr align="left">
																<td align="left"><span style="font-size:14px;  color: #445359; float:left; font-weight:bold; ">Telefon Numarası :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$telefon.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359;  float:left; font-weight:bold; ">E-Mail Adresi :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$email.'</span></td>
															</tr>
															
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Konu :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$konu.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359;  float:left; font-weight:bold; ">Mesaj :</span><span style="font-size:14px; margin-left:10px;  color: #445359; float:left; ">'.$mesaj.'</span></td>
															</tr>
													</tbody>
												</table>
											</td>
										</tbody>
								</table>
							</td>
						</tr>
				</tbody>
			</table>
			';
		$mail->MsgHTML($content);
		$mail->Send();
		
		#######
		
	
		
	
	} else { echo 'bir sorun oluştu'; }
}
?>