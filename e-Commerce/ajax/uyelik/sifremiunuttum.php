<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }

$email 	= clean($_POST["email"]);



	
$uyebul		 = $conn -> query("select * from users where rutbe = 0 and email = '".$email."' ")->fetch();


$sifree		 = rand(100,99999999); 
$yenisifre   = md5(sha1($sifree));
$code		 = clean($_POST["code"]);

	if(!isset($code) || !isset($email)  ) { exit;}

	if(empty($email) ||  empty($code) ) {
		echo $lang['mesaj']['bos_alan_birakmayin'];
		exit;
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
		echo $lang['mesaj']['gecersiz_email'];
		exit;
	}elseif($_SESSION["GKod"] != md5($code)){
		echo $lang['mesaj']['guvenlik_kodu']; 
		exit;
	}elseif(!$uyebul){ 
		echo $lang['mesaj']['email_kayitsiz'];
		exit;
	}

	$uyekontrol = $conn -> query("select * from users WHERE id = ".intval($uyebul['id'])."")->fetch();
	if(!$uyekontrol) { exit;}
	
	$sql = $conn -> prepare("update users SET 
	  password	= :password
	  where 	id = :id
	 ");
	
	$ekle = $sql-> execute(array(
		"password"    => $yenisifre,
		"id" 	  => intval($uyebul['id'])
	)); 
	if($sql){

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
		$mail->SetFrom($mailadres,$uyekontrol['ad']." ".$uyekontrol['soyad']);
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML(true);
		$mail->Subject = 'Yeni Şifreniz';
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
												<td style="border-bottom:1px solid #eee;"><h2 style="width:100%; text-align:left;  color: #445359; font-size:15px;">Yeni Şifreniz ile İşlemlere Devam Edebilirsiniz</h2></td>
											</tr>
											<td align="left" style="padding-top:10px;">
												<table>
													<tbody cellpadding="0" cellspacing="0">
															
															<tr>
																<td align="left"><span style="font-size:14px;  color: #445359;  float:left; font-weight:bold; ">Şifreniz :</span><span style="font-size:14px; margin-left:10px; color: #445359; float:left; ">'.$sifree.'</span></td>
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
		echo 'done';
	}else{
		echo 'sql sırasında sorun olustu';
	}


?>