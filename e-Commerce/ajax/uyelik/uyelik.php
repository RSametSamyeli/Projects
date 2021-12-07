<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
if(!isset($_POST)) { exit; }
$username       = "";
$email          = clean($_POST["email"]);
$sifre     	    = clean($_POST["sifre"]);
$sifreteyit     = clean($_POST["sifreteyit"]);
$ad             = clean($_POST["ad"]);
$soyad          = clean($_POST["soyad"]);
$tarih          = time();
$ip             = $_SERVER['REMOTE_ADDR'];
$code		    = clean($_POST["code"]);
$yenisifre      = md5(sha1($sifre));
$telefon		= clean($_POST["telefon"]);


$uyeBul = $conn -> query("SELECT * FROM users WHERE email = '".$email."' AND Kayit = '1'");



if(!isset($email) || !isset($sifre) || !isset($sifreteyit) || !isset($ad) || !isset($soyad) || !isset($code)) { exit;}

if( empty($ad) || empty($soyad) || empty($sifre) || empty($sifreteyit) || empty($telefon)){
	echo $lang['mesaj']['bos_alan_birakmayin'];
	exit;
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
	echo $lang['mesaj']['gecersiz_email'];
	exit;
}elseif($_SESSION["GKod"] != md5($code)){
	echo $lang['mesaj']['guvenlik_kodu']; 
	exit;
}elseif($sifre !=  $sifreteyit){
	echo $lang['mesaj']['sifreler_eslesmiyor'];
	exit;
}elseif($uyeBul -> rowCount() > 0 ){
	echo $lang['mesaj']['retry_user'];
	exit;	
}elseif(!isset($_POST["kosul"])){
	echo $lang['mesaj']['sozlesme'];
	exit;
}elseif(strlen($sifre) < 6 || strlen($sifre) > 12){
	echo $lang['mesaj']['min_sifre'];
	exit;
}elseif(strlen($sifreteyit) < 6 || strlen($sifreteyit) > 12){
	echo $lang['mesaj']['min_sifre'];
	exit;
}
	
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->Host = $mailhost ;
		$mail->Port = $mailport;
		$mail->Username = $mailadres;
		$mail->Password = $mailsifre;
		$mail->SMTPSecure = $sslmi;
		$mail->AddAddress($email);
		$mail->SetFrom($mailadres,"".$set['seo']['t']."");
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML(true);
		$mail->Subject = 'Üyeliğiniz Tamamlandı.';
		$content = '
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="border:2px solid #ddd; width:600px">
			<thead>
				<tr>
					<th style="height:60px">
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:700px">
							<tbody>
								<tr>
									<th colspan="2" style="height:119px; width:200px"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:12px"><img src="'.$set['siteurl'].'/assets/images/logo.png" alt=""></span></span></th>
								</tr>
								<tr>
									<th style="background-color:rgb(0,0,0); height:50px"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="color:#e3097e"><span style="font-size:16px"><strong>Hoşgeldiniz</strong></span></span></span></th>
								</tr>
							</tbody>
						</table>
						<div style="clear:both">&nbsp;</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>&nbsp; 
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:90%">
							<tbody>
								<tr>
									<td colspan="2"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px">Sayın<strong> Kullanıcı</strong></span></span></td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
								<td colspan="2">
									<span style="font-size:13px">
									<a href="'.$set['siteurl'].'" target="_blank" rel="noopener noreferrer">'.$set['siteurl'].'</a>&nbsp;Üyeliğiniz başarılı bir şekilde tamamlanmıştır.<br>
									<br>
									İyi Alışverişler Dileriz.
									</span>
								</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2">
									<span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;">
										<span style="font-size:13px"><strong>Üye Bilgileri</strong></span>
									</span>
									</td>
								</tr>
								
								<tr>
									<td><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px"><strong>E-Posta adresi :</strong></span></span></td>
									<td><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px">'.$email.'</span></span></td>
								</tr>
								<tr>
									<td style="width:100px"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px"><strong>Şifreniz:</strong></span></span></td>
									<td><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px">'.$sifre.'</span></span></td>
								</tr>
							</tbody>
						</table>
						<p>&nbsp;</p>
					</td>
				</tr>
					<tr>
						<td style="height:70px">
							<div style="clear:both">
								<div>&nbsp;</div>
								<div>
									<table align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:20.8px; text-align:center; width:90%">
										<tbody>
											<tr>
												<td>
													
													<p> Üyelik bilgilerinizi güncelleyerek sipariş verebilirsiniz</p>
													<div>&nbsp;</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div>&nbsp;</div>
							</div>
							<div style="clear:both; text-align:center">
								<table align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:23.1111px; text-align:center; width:631.111px">
									<tbody>
										<tr>
											
										</tr>
									</tbody>
								</table>
								<p style="text-align:center"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:12px">Copyright&nbsp;© 2017 '.$set['seo']['t'].'.&nbsp;| Tüm hakları saklıdır.<br>
								<a href="mailto:" target="_blank" rel="noopener noreferrer" style="line-height:20.8px"></a></span></span><br>
								&nbsp;</p>
							</div>
						</td>
					</tr>
			</tbody>
		</table>
			';
		$mail->MsgHTML($content);
		$mail->Send();
		
/* Kayıt */
$sql = $conn -> prepare("INSERT INTO users SET
	name		= :name,
	password	= :password,
	email		= :email,
	telefon		= :telefon,
	rutbe		= :rutbe,
	ad          = :ad,
	soyad		= :soyad,
	tarih		= :tarih,
	adres		= :adres,
	kayit		= :kayit
	");
	
$ekle = $sql -> execute(array(
	"name"      => $username,
	"password"  => $yenisifre,
	"email"     => $email,
	"telefon"	=> $telefon,
	"rutbe"		=> 0,
	"ad"		=> $ad,
	"soyad"		=> $soyad,
	"tarih"		=> $tarih,
	"adres"		=> "",
	"kayit"		=> 1		
	));
	
	if($ekle) { 
		echo 'done';
		$_SESSION["m_oturum"] = true;	
		$_SESSION["m_user"]   = $username;
		$_SESSION["m_id"] 	  = $conn ->lastInsertId(); 	
		$_SESSION['m_anahtar'] 	 = md5($_SERVER['HTTP_USER_AGENT']);	
		$eklenenid   =  $conn ->lastInsertId();
		$uyebul 	 =  $conn -> query("select * from users where id = '".intval($eklenenid)."'")->fetch();
		## Sms Aktif İse 
		if($smsAyar['durum'] == 1){
			## netgsm	
			if($smsAyar['firmaid'] == 0){
				$mesaj = html_entity_decode($smsAyar['hosgeldin']);
				$arr1  = array('{%ad%}','{%soyad%}');
				$arr2  = array($ad,$soyad);
				$mesaj  = str_replace($arr1,$arr2,$mesaj);
				$mesaj = rawurlencode($mesaj); 	
				netgsm($mesaj,$telefon);
			}
		}

		## Para Puan
		if($parapuan['puansistemi'] == 1){
			if($parapuan['yeniuyelik'] == 1){
				## Update
				$sql = $conn -> prepare("INSERT INTO puangecmisi SET 
				uye_id      = :uye_id,
				puan_tur    = :puan_tur,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma			
				");
				$ekle = $sql-> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_tur"		 => 0,
					"puan_toplam" 	 => $parapuan['yeniuyelikdeger'],
					"puan_tarih"	 => time(),
					"durum"			 => 0,
					"kullanma" 		 => 0	
				)); 
				if($ekle){
					$puanesitle   = $uyebul['uye_puan']  + $parapuan['yeniuyelikdeger'];	
					$puanupdate   = $conn -> exec("UPDATE users SET uye_puan = $puanesitle where id = ".$uyebul['id']." ");	
				}
									
			}
		}
	}else{
		echo 'Kayıt Olunurken Bir Sorun Oluştu';
	}
?>