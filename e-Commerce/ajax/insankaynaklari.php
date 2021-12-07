<?php
include_once('../class.upload.php');
include_once('../lab/function.php');
include_once('../phpmailer/PHPMailerAutoload.php');
include("../dil/".$set["lang"]['active'].".php");
if( !defined("SABIT") ){ exit; } 
if(!isset($_POST)){ echo 'Hata'; exit;}
$pdf= new upload($_FILES['pdf']);


## Bilgiler
$adsoyad = clean($_POST["adsoyad"]);
$telefon = clean($_POST["telefon"]);
$email = clean($_POST["email"]);
$pozisyon = clean($_POST["pozisyon"]);
$adres = clean($_POST["adres"]);
$code = clean($_POST["code"]);
$rand = rand(0,9);
$durum = 0;
$tarih = date("d.m.Y H:i");
$linkal = '';	
##  File

if(!isset($adsoyad) || !isset($telefon) || !isset($email) || !isset($pozisyon) || !isset($adres)  || !isset($code)) { exit;}
if(empty($adsoyad) || empty($telefon) || empty($email) || empty($code) || empty($pozisyon) || empty($adres)){
	echo $lang['mesaj']['bos_alan_birakmayin']; exit;
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	echo $lang['mesaj']['gecersiz_email']; exit;
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu'];  exit;
}elseif(!isset($_POST["hizmetkosul"])){
	echo $lang['mesaj']['sozlesme_kabul'];  exit;
}else{
	if ( $pdf->uploaded ){
	  $pdf->allowed = array('application/x-pdf',
	  'application/pdf',
	  'application/msword',
	  'application/acrobat',
	  'applications/vnd.pdf',
	  'text/pdf',
	  'text/x-pdf'); 
	  $pdf ->file_new_name_body = substr(base64_encode(uniqid(true)), 0, 20);
	  $pdf->Process('../uploads/cw/');
	    if ( !$pdf->processed ){
			echo 'Dosya Türünü Kontrol Ediniz'; exit;
		}
	$uzanti = $pdf->file_dst_name;
	$linkal = $set['siteurl']."/uploads/cw/".$uzanti;
	}
	
	## DB Kayıt
	$sql = $conn -> prepare("INSERT INTO mesajkaynak SET
	adsoyad 	= :adsoyad,
	telefon 	= :telefon,
	mail 		= :mail,
	adres 		= :adres,
	pozisyon	= :pozisyon,
	tarih 		= :tarih,
	cw			= :cw,
	durum		= :durum
	");
	$ekle = $sql -> execute(array(
		"adsoyad" => $adsoyad,
		"telefon" => $telefon,
		"mail" => $email,
		"adres" => $adres,
		"pozisyon" => $pozisyon,
		"tarih" => $tarih,
		"cw" => $pdf->file_dst_name,
		"durum" => 0
		));
		
	if($ekle){
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
		$mail->Subject = 'İnsan Kaynakları Başvuru Formu';
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
												<td style="border-bottom:1px solid #eee;"><h2 style="width:100%; text-align:left;  color: #445359; font-size:15px;">'.$adsoyad.' kişisinden '.$tarih.' tarihinde başvuru form aldınız. Form  Detayları Aşağıdadır</h2></td>
											</tr>
											<td align="left" style="padding-top:10px;">
												<table>
													<tbody cellpadding="0" cellspacing="0">
															<tr align="left">
																<td align="left"><span style="font-size:14px;  color: #445359; float:left; font-weight:bold; ">Pozisyon :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$pozisyon.'</span></td>
															</tr>
															<tr align="left">
																<td align="left"><span style="font-size:14px;  color: #445359; float:left; font-weight:bold; ">Telefon Numarası :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$telefon.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359;  float:left; font-weight:bold; ">E-Mail Adresi :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$email.'</span></td>
															</tr>
															
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Adres :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$adres.'</span></td>
															</tr>
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359; float:left;  font-weight:bold; ">Cw Link :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; "><a style="font-size:14px; color: #445359; " target="_blank" href="'.$linkal.'">Cv İncele</a></span></td>
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
		
	}else{
		echo 'Bir Sorun Oluştu';
	}
}


?>