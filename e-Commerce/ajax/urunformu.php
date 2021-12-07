<?php include_once('../lab/function.php');
@include("../dil/".$set["lang"]["active"].".php");
include_once('../phpmailer/PHPMailerAutoload.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)) {  exit; }


$adsoyad = clean($_POST["adsoyad"]);
$telefon = clean($_POST["telefon"]);
$email = clean($_POST["email"]);
$konu = clean($_POST["konu"]);
$mesaj = clean($_POST["mesaj"]);
$code = clean($_POST["guvenlik"]);
$urunkodu = clean($_POST["urunkodu"]);
$tarih = date("d.m.y H:i");
$durum = 0;

## urun bul

$urunbul  = $conn -> query("select * from urun where kod = '".$urunkodu."'")->fetch();
$urunname = unserialize($urunbul['baslik']);
$urunsef  = unserialize($urunbul['sef']);
$urunlink = $map."/".$detaysef_urunler_link['tr']."/".$urunsef['tr']."-".$urunbul['id']; 

if(!isset($adsoyad) || !isset($telefon) || !isset($telefon) || !isset($email) || !isset($konu) || !isset($mesaj) || !isset($code)) { exit;}
if(empty($adsoyad) || empty($telefon) || empty($email) || empty($code) || empty($mesaj)){
	echo ''.$lang['mesaj']['bos_alan_birakmayin'].''; exit;
}elseif(empty($konu)){
	echo ''.$lang['mesaj']['bos_konu'].''; exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo ''.$lang['mesaj']['gecersiz_email'].''; exit;
}elseif ($_SESSION["guv"] != $code){
	echo ''.$lang['mesaj']['guvenlik_kodu'].''; exit;
}else {

	$sql = $conn -> prepare("INSERT INTO urunformu SET
	adsoyad 	= :adsoyad,
	telefon 	= :telefon,
	mail 		= :mail,
	konu 		= :konu,
	urunkodu	= :urunkodu,
	mesaj 		= :mesaj,
	tarih 		= :tarih,
	durum		= :durum
	");
	$ekle = $sql -> execute(array(
		"adsoyad" => $adsoyad,
		"telefon" => $telefon,
		"mail" => $email,
		"konu" => $konu,
		"urunkodu" => $urunkodu,
		"mesaj" => $mesaj,
		"tarih" => $tarih,
		"durum" => 0
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
		$mail->SMTPSecure = $sslmi;
		$mail->AddAddress($mailadres);
		$mail->SetFrom($mailadres,$adsoyad);
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML(true);
		$mail->Subject = 'Ürün Sipariş Formu';
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
												<td style="border-bottom:1px solid #eee;"><h2 style="width:100%; text-align:left;  color: #445359; font-size:15px;">'.$adsoyad.' kişisinden '.$tarih.' tarihinde ürün sipariş formu aldınız. Form  Detayları Aşağıdadır</h2></td>
											</tr>
											<td align="left" style="padding-top:10px;">
												<table>
													<tbody cellpadding="0" cellspacing="0">
															<tr align="left">
																<td align="left"><span style="font-size:14px;  color: #445359; float:left; font-weight:bold; ">Konu :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$konu.'</span></td>
															</tr>
															<tr align="left">
																<td align="left"><span style="font-size:14px;  color: #445359; float:left; font-weight:bold; ">Telefon Numarası :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$telefon.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359;  float:left; font-weight:bold; ">E-Mail Adresi :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$email.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Ürün Kodu :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$urunkodu.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Mesaj :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$mesaj.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Ürüne Git :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; "><a style="font-size:14px; color: #445359; " target="_blank" href="'.$urunlink.'">'.$urunname['tr'].'</a></span></td>
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
		
		} else {
		echo 'bir sorun oluştu'; 
		
		}
}
 ?>