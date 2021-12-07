<?php 
if( !defined("SABIT") ){ exit; }
include('phpmailer/PHPMailerAutoload.php');


error_reporting(0);
if($_SESSION["fs"]["siparisturu"] == 1 ){
	include('include/modules/odeme/kredisonuc.php');
	exit;
}

if(!isset($_SESSION["m_oturum"])){
	include('include/modules/404/404.php');
	exit;
}

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"])."")->fetch();
if(!$uyebul){
	include('include/modules/404/404.php');
	exit;
}



if(!isset($_SESSION["sonuc"])){
	header('location:/');
}


if($_SESSION["sonuc"]["durum"] == "success"){ 


	/**** Kupon Geçmişi Güncelle ****/
	foreach(@$_SESSION["fs"]["indirimkupon"] as $key){
		$kuponpasif = $conn-> prepare('UPDATE kupongecmisi set siparisid = ? ,durum = ?,userid = ?  where id = ? ');
		$kuponpasif -> execute(array($_SESSION["fs"]["oid"],0, $_SESSION["m_id"],$key));
	}

		
		
	/////*************** E-Mail ************************//////	
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->Host = $mailhost;
		$mail->Port = $mailport;
		$mail->Username = $mailadres;
		$mail->Password = $mailsifre;
		$mail->AddAddress($uyebul['email']);
		$mail->AddBCC($sslmi);
		$mail->SetFrom($mailadres,"".$set['seo']['t']."");
		$mail->CharSet = 'UTF-8';
		$mail->IsHTML(true);
		$mail->Subject = 'Sipariş Durumu';
		$mteslimatadresi = $conn -> query("select * from useraddress where id = ".intval($_SESSION["fs"]["teslimatadresi"]))->fetch();											
		$mtSehir 		 = $conn -> query("select * from il where ID = ".intval($mteslimatadresi['sehir']))->fetch();;
		$mtilce			 = $conn -> query("select * from ilce where ID = ".intval($mteslimatadresi['ilce']))->fetch();
		$m2faturaadresi  = $conn -> query("select * from useraddress where id = ".intval($_SESSION["fs"]["faturaadresi"]))->fetch();
		$m2tSehir 		 = $conn -> query("select * from il where ID = ".intval($m2faturaadresi['sehir']))->fetch();;
		$m2tilce		 = $conn -> query("select * from ilce where ID = ".intval($m2faturaadresi['ilce']))->fetch();			
		$kargoCek			    = $conn -> query("select * from kargo where id = ".intval($_SESSION["fs"]["kargo"]))->fetch();
		$content = '
		<table align="center" border="0" cellpadding="0" cellspacing="0" style="border:2px solid #ddd; padding:30px; width:600px">
			<thead>
				<tr>
					<th style="height:60px">
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:700px">
							<tbody>
								<tr>
									<th colspan="2" style="height:84px; width:200px"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:12px"><img src="'.$set['siteurl'].'/assets/images/logo.png" alt=""></span></span></th>
								</tr>
								
							</tbody>
						</table>
						<div style="clear:both">&nbsp;</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:90%">
							<tbody>
								<tr>
									<td colspan="2"><span style="font-family: arial, helvetica, sans-serif, serif, EmojiFont;"><span style="font-size:13px">Sayın<strong> '.$uyebul['ad'].' '.$uyebul['soyad'].'</strong></span></span></td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
								<td colspan="2">
									<span style="font-size:13px">
									Siparişiniz başarılı şekilde alınmıştır.Sipariş bilgileriniz aşağıdaki gibidir..<br>
									<br>
									İyi Alışverişler Dileriz.
									</span>
								</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<!--item-->
								<tr>
									<td >
										<table width="100%" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4; border-collapse:collapse; font-size:13px; font-family:arial; border:1px solid #D7D7D7">
											<tbody>
												<tr>
													<td style="padding-left:10px"><b>Ödeme Bilgileri</b> </td>
												</tr>
											</tbody>
										</table>
										<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff; border-left:1px solid #D7D7D7; font-size:12px; font-family:arial; border-right:1px solid #D7D7D7; padding:5px">
											<tbody>
													<tr>
														<td style="padding-left:5px">
															<table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
																<tbody>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Sipariş No </b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$_SESSION["fs"]["oid"].'</td>
																	</tr>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Ödeme Türü</b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$_SESSION["fs"]["odemeturu"].'</td>
																	</tr>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Kargo </b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$kargoCek['firmaadi'].'</td>
																	</tr>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Müşteri Notu </b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$_SESSION['fposts']["siparisnot"].'</td>
																	</tr>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Sipariş Saati </b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.date("d.m.Y H:i",time()).'</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													
											</tbody>
										</table>
										
									</td>
								</tr>
							
								<!--/item-->
								<tr>
									<td >
										<table width="100%" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4; border-collapse:collapse; font-size:13px; font-family:arial; border:1px solid #D7D7D7">
											<tbody>
												<tr>
													<td style="padding-left:10px"><b>Teslimat Bilgileri</b> </td>
												</tr>
											</tbody>
										</table>
										<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff; border-left:1px solid #D7D7D7; font-size:12px; font-family:arial; border-right:1px solid #D7D7D7; padding:5px">
											<tbody>
													<tr>
														<td style="padding-left:5px">
															<table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
																<tbody>
																	<tr>
																	<td width="180" valign="top" style="font-size:12px"><b>Adı Soyadı<b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																	<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																	<td valign="top" style="font-size:12px">'.$mteslimatadresi['adsoyad'].' </td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
														<tr>
														<td style="padding-left:5px">
															<table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
																<tbody>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Adres</b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$mteslimatadresi['name'].' - '.$mteslimatadresi['adres'].' - '.$mtSehir['ADI'].' - '.$mtilce['ADI'].' -  '.$mteslimatadresi['ulke'].' - '.$mteslimatadresi['postakodu'].' - '.$mteslimatadresi['telefon'].'</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
											</tbody>
										</table>
										
									</td>
								</tr>
								<!--/item-->
								<tr>
									<td >
										<table width="100%" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#F4F4F4; border-collapse:collapse; font-size:13px; font-family:arial; border:1px solid #D7D7D7">
											<tbody>
												<tr>
													<td style="padding-left:10px"><b>Fatura Bilgileri</b> </td>
												</tr>
											</tbody>
										</table>
										<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="background:#fff; border-left:1px solid #D7D7D7; font-size:12px; font-family:arial; border-right:1px solid #D7D7D7; padding:5px">
											<tbody>
													<tr>
														<td style="padding-left:5px">
															<table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
																<tbody>
																	<tr>
																	<td width="180" valign="top" style="font-size:12px"><b>Adı Soyadı<b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </b></b></td>
																	<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																	<td valign="top" style="font-size:12px">'.$m2faturaadresi['adsoyad'].' </td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
														<tr>
														<td style="padding-left:5px">
															<table height="25" align="left" cellpadding="0" cellspacing="0" border="0">
																<tbody>
																	<tr>
																		<td width="180" valign="top" style="font-size:12px"><b>Adres</b><font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td width="5" valign="top" style="font-size:12px">:<font style="font-family: arial, serif, EmojiFont;">&nbsp;</font> </td>
																		<td valign="top" style="font-size:12px">'.$m2faturaadresi['name'].' - '.$m2faturaadresi['adres'].' - '.$m2tSehir['ADI'].' - '.$m2tilce['ADI'].' -  '.$m2faturaadresi['ulke'].' - '.$m2faturaadresi['postakodu'].' - '.$m2faturaadresi['telefon'].'</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
											</tbody>
										</table>
									</td>	
								</tr>
								<!--/item-->
								<tr>
									<td>
										<table width="700" height="30" align="center" cellpadding="0" cellspacing="0" border="0" style="  border-collapse:collapse; font-size:12px; font-family:arial; border:1px solid #D7D7D7">
											<thead>
												<tr style="background:#F4F4F4; border:1px solid #D7D7D7">
													<td style="padding:10px"><b>Ürün</b> </td>
													<td style="padding:10px"><b>Adet</b> </td>
													<td style="padding:10px"><b>Birim Fiyat</b> </td>
													<td style="padding:10px"><b>Toplam Fiyat</b> </td>
												</tr>
											</thead>
											<tbody>
												'; 
												$genelToplam = 0;
												$indirimler  = 0;
												$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])."  AND siparisid = ".$_SESSION["fs"]["oid"]."  AND durum = 0");
												$kuponlarFetch = $kuponlar->fetchAll();
												if($kuponlar -> rowCount() >0 ) {
												foreach($kuponlarFetch as $row8){ 
														$indirimler  = $indirimler + $row8['tutar'];
													}
												}
												foreach(@$_SESSION["sepet"] as $row) { 
												$uruncek 	     = $conn -> query("SELECT * FROM urun where id = ".intval($row['sepetid']))->fetch();
												$genelToplam    += $row['adet'] * $row['arafiyat'];
													$content .= '<tr>
															<td style="padding:10px">'.$row['baslik'].'</td>
															<td style="padding:10px">'.$row['adet'].'</td>
															<td style="padding:10px">'.number_format($uruncek['yenifiyat'],2).' TL</td>
															<td style="padding:10px">'.number_format($row['adet'] * $row['arafiyat'] , 2 ).' TL</td>
														</tr>';
												}
												$kdv 			 = kdv_ekle(number_format($genelToplam,2),18);
												$anaTutar 	     = number_format($genelToplam,2)  + $_SESSION["fs"]['kargotutar'] ;
												$anaTutar        =  number_format($anaTutar,2) - number_format($indirimler,2);
												$content .= '<tr style="border-top:1px solid #eee">
														<td style="padding:4px"></td>
														<td style="padding:4px"></td>
														<td style="padding:4px;" ></td>
														<td style="padding:6px; text-align:right"><b>Ara Tutar : </b>'.number_format($genelToplam,2).' TL </td>
												</tr>';
												$content .= '<tr>
														<td style="padding:4px"></td>
														<td style="padding:4px"></td>
														<td style="padding:4px;" ></td>
														<td style="padding:6px; text-align:right"><b>Kdv : </b>'.number_format($kdv,2).' TL </td>
												</tr>';
												$content .= '<tr>
														<td style="padding:10px"></td>
														<td style="padding:10px"></td>
														<td style="padding:10px;" ></td>
														<td style="padding:6px; text-align:right"><b>Kargo : </b> '.number_format($_SESSION["fs"]['kargotutar'],2).' TL </td>
												</tr>';
												
												 if(!empty($_SESSION["fs"]["parapuan"])){ 
													$content .= '<tr>
															<td style="padding:10px"></td>
															<td style="padding:10px"></td>
															<td style="padding:10px;" ></td>
															<td style="padding:6px; text-align:right"><b>Puan Tutarı (-): </b> '.$_SESSION["fs"]["parapuan"].' TL </td>
														</tr>';
													
												}
												 if(!empty($_SESSION["fs"]["kredipuan"])){ 
													$content .= '<tr>
															<td style="padding:10px"></td>
															<td style="padding:10px"></td>
															<td style="padding:10px;" ></td>
															<td style="padding:6px; text-align:right"><b>Kredi Tutarı (-): </b> '.$_SESSION["fs"]["kredipuan"].' TL </td>
														</tr>';
													
												}
								
												if($kuponlar -> rowCount() >0 ) {  
													foreach($kuponlarFetch as $row5){ 
													$content .= '<tr>
															<td style="padding:10px"></td>
															<td style="padding:10px"></td>
															<td style="padding:10px;" ></td>
															<td style="padding:6px; text-align:right"><b>Kupon Tutarı (-): </b> '.number_format($row5['tutar'],2).' TL </td>
														</tr>';
													} 
												}
												if($_SESSION["fs"]["odemeturu"] == "Kapıda Ödeme"){
													$content .= '<tr>
														<td style="padding:10px"></td>
														<td style="padding:10px"></td>
														<td style="padding:10px;" ></td>
														<td style="padding:6px; text-align:right"><b>Kapıda Ödeme Fiyatı : </b> '.number_format($_SESSION["fs"]['kapidaodemefiyat'],2).' TL </td>
													</tr>';
												}
												$content .= '<tr>
														<td style="padding:10px;"></td>
														<td style="padding:10px;"></td>
														<td style="padding:10px;"></td>
														<td style="padding:6px; text-align:right"> <b>Genel Tutar : </b> '.number_format($anaTutar,2).' TL </b> </td>
												</tr>
											</tbody>
										</table>
									</td>
									
								</tr>
								
							</tbody>
						</table>
				
					</td>
				</tr>
	
			</tbody>
		</table>
			';
		$mail->MsgHTML($content);
		$mail->Send();
		
	
	//*************** E-Mail end ************************//	
	
	
	//*** Sip Sayısına At****///
	$stutar = 0 ;
	foreach(@$_SESSION["sepet"] as $row) { 
		$varyant 	 = $row['varyant'];
		if(count($varyant) > 0) {	 
			$varAra  = 0 ;
			for($i = 0; $i < count($varyant['varBaslik']); $i++) {
				$varTutar = $varyant['varTutar'][$i];
				$varTur   = $varyant['varTur'][$i];
				if($varTur == 1){
					$varAra  = number_format($row['arafiyat'],2) + $varTutar;
				}
				if($varTur == 0){
					$varAra  = $varAra - $varTutar;
				}
			}
			$birimfiyat = number_format($varAra,2);
		} else {
			$birimfiyat = number_format($row['arafiyat'],2);
		}
										
		$stutar = $row['adet'] * $birimfiyat;
		$sipsql = $conn -> prepare("INSERT INTO siparissayi SET 
			urunid       = :urun_id,
			adet	     = :adet,
			toplamtutar	 = :toplamtutar,
			tarih	 	 = :tarih,
			siparisid    = :siparisid,
			userid		 = :userid
			");
			
		 $sipsql-> execute(array(
			"urun_id" 		=> $row['sepetid'],
			"adet"			=> $row['adet'],
			"toplamtutar"	=> number_format($stutar,2),
			"tarih"			=> time(),
			"siparisid"	 	=> $_SESSION["fs"]["sipid"],
			"userid"		=> $_SESSION["fs"]["user_id"]
		)); 		
	}

	
	//*** Sip Sayısına At****///
	
	
	/**** Kredi Güncelle ****/
	if($main_settings['kredisistemi'] == 1){
		if(!empty($_SESSION["fs"]["kredipuan"])){ 
			## Transfer 
				$bakiyem 	 = $uyebul['uye_kredi'];
				$sepetTutar  = number_format($anaTutar,2);
				if($bakiyem >= $sepetTutar){
					$kalanbakiye = $bakiyem - $sepetTutar;
					$kalanbakiye = number_format($kalanbakiye,2);
					$gidenbakiye = $kalanbakiye; 
					
				}elseif($bakiyem <= $sepetTutar){
					$kalanbakiye = 0.00;
					$gidenbakiye =  $bakiyem; 
				}
				
				$sql = $conn -> prepare("INSERT INTO kredigecmisi SET 
				uye_id      = :uye_id,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma			
				");
				
				 $sql-> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_toplam" 	 => number_format($gidenbakiye,2),
					"puan_tarih"	 => time(),
					"durum"			 => 1,
					"kullanma" 		 => 1	
				)); 
				
				$puansifirla   = $conn -> exec("UPDATE users SET uye_kredi = ".number_format($kalanbakiye,2)." where id = ".$uyebul['id']." ");
				$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
				
		}
	}
		
		
		
	/**** Puan Güncelle ****/
	if($parapuan['puansistemi'] == 1){

		## Kazanmadan Önce Toplam Puandan Düş 
		if(!empty($_SESSION["fs"]["parapuan"])){	
			if($parapuan['yenisiparis'] == 1){
				## Transfer 
				$bakiyem 	 = puanconvert($uyebul['uye_puan']);
				$bakiyempuan = $uyebul['uye_puan'];
				$sepetTutar  = number_format($anaTutar,2);
				if($bakiyem >= $sepetTutar){
					$kalanbakiye = $bakiyem - $sepetTutar;
					$kalanbakiye = paraconvert($kalanbakiye);
					
				}elseif($bakiyem < $sepetTutar){
					$kalanbakiye = 0;
					
				}
				
				$sql = $conn -> prepare("INSERT INTO puangecmisi SET 
				uye_id      = :uye_id,
				puan_tur    = :puan_tur,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma			
				");
				 $sql-> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_tur"		 => 1,
					"puan_toplam" 	 => $kalanbakiye,
					"puan_tarih"	 => time(),
					"durum"			 => 0,
					"kullanma" 		 => 1	
				)); 
				
				$puansifirla   = $conn -> exec("UPDATE users SET uye_puan = ".$kalanbakiye." where id = ".$uyebul['id']." ");
				$uyebul = $conn -> query("select * from users where  id = ".intval($_SESSION["m_id"]))->fetch();
				
				

			
			}
		}else{
			## Normal Siparişten Puan Kazan ##
				$sql2 = $conn -> prepare("INSERT INTO puangecmisi SET 
				uye_id      = :uye_id,
				puan_tur    = :puan_tur,	
				puan_toplam = :puan_toplam,
				puan_tarih	= :puan_tarih,
				durum 		= :durum,
				kullanma    = :kullanma			
				");
				$ekle2 = $sql2 -> execute(array(
					"uye_id" 		 => $uyebul['id'],
					"puan_tur"		 => 1,
					"puan_toplam" 	 => $parapuan['yenisiparisdeger'],
					"puan_tarih"	 => time(),
					"durum"			 => 0,
					"kullanma" 		 => 0	
				)); 
				if($ekle2){
					$puanesitle   = $uyebul['uye_puan']  + $parapuan['yenisiparisdeger'];	
					$puanupdate   = $conn -> exec("UPDATE users SET uye_puan = $puanesitle where id = ".$uyebul['id']." ");	
				}
		}

	}



	/// **************** Puan End ************************//////	
}
seoyaz("Ödeme Durumu","","","");
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
</head>
<body>
<div id="main" class="main">
<?php include('include/sabit/header.php'); ?>
	<!--/header-->
	<div class="cihaniriboy-outer-page">
		
		<div class="custom-sepet-content">
			<div class="container">
				<div class="siparis-tamam-header">
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-location-arrow"></i>TESLİMAT BİLGİLERİ</h2>
								<p>Teslimat Bilgilerinizi Giriniz </p>
							</div>
							
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-credit-card-alt"></i>ÖDEME SEÇENEKLERİ</h2>
								<p>Ödeme Bilgilerinizi Giriniz</p>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-check" aria-hidden="true"></i>SİPARİŞ ONAYI</h2>
								<p>Siparişiniz Özeti </p>
							</div>
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
				</div>
				
				<div class="col-md-8 col-xs-12">
					<div class="odeme-sonuc">
					<?php if($_SESSION["fs"]["odemeturu"] == "kredikarti"){ ?>
						<?php if($_SESSION["sonuc"]["durum"] == "success"){  
									foreach(@$_SESSION["sepet"] as $row) { 
										$adet       = $row['adet'];
										$varyant  = $row['varyant'];
										//echo $varyantid;
										$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
										$sef      = unserialize($urunCek['sef']);
										$urunStok = $urunCek["stok"];
										$stokdus  =  $urunCek["stok"] - $adet;
										/* Ürün Stokdan Düş */
										$stoksql = $conn -> prepare("UPDATE urun SET stok = :stok WHERE id = :id ");
										$stoksql -> execute(array(
												"stok" => $stokdus,
												"id"      => intval($urunCek['id'])
											));
										/* Varyantları Güncelle */
										if(count($varyant) > 0) { 
											for($i = 0; $i < count($varyant['varid']); $i++) { 
												$urunvaryantlar = $conn -> query("select * from urunvaryants where  varyantdeger = ".intval($varyant['varid'][$i])." && urunid = " .intval($urunCek['id']));
												if($urunvaryantlar -> rowCount() > 0 ){
														foreach($urunvaryantlar->fetchAll() as $row6){ 
															if($row6['varyantdeger'] == intval($varyant['varid'][$i])){ 
																	$varyantstok      = $row6['varyantstok'];
																	$varyantstokdus   =  $varyantstok - $adet;
																	$varyantsql = $conn -> prepare("UPDATE urunvaryants SET varyantstok = :varyantstok WHERE varyantdeger = :varyantdeger && urunid = :urunid ");
																	$guncelle   = $varyantsql -> execute(array(
																			"varyantstok"  => $varyantstokdus,
																			"varyantdeger" => intval($varyant['varid'][$i]),
																			"urunid"	   => intval($urunCek['id'])
																		));
															}
														}
												}
											}
										}	
									
								}
						?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Siparişinizi Hazırlamaya Başladık..</span>
							</div>
							<div class="siparis-no">
								<h3>SİPARİŞ NUMARANIZ</h3>
								<span>#<?php echo $_SESSION["fs"]["oid"]; ?></span>
							</div>
							<div class="odeme-text">
								<span>Sipariş detaylarınızı içeren bilgilendirme mail <?php echo $uyebul['email']; ?> adresine gönderildi.</span>
								<span><?php echo date("d.m.Y H:i",$_SESSION["sonuc"]['date']); ?> tarihinde yapmış olduğunuz işlem sırasında kartınızdan <strong><?php echo number_format($_SESSION["sonuc"]["amount"],2); ?></strong> tutar çekilmiştir.</span>
							</div>
						<?php 
						 # SESSIONLARI SİL
						
						} else { ?>
							<div class="odeme-false">
								<div class="icon">
									<i class="fa fa-times" aria-hidden="true"></i>
								</div>
								<h4>İŞLEMİNİZ GERÇEKLEŞEMEDİ</h4>
								<span><?php echo date("d.m.Y H:i",$_SESSION["sonuc"]['date']);  ?> tarihinde yapmış olduğunuz işlem başarısız oldu. Hata kodu : <?php echo $_SESSION["sonuc"]["hata"]; ?></span>
							
							</div>
						<?php } ?>
						<div class="odeme-links">
							<a class="s" href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
							<a class="b" href="<?php echo $set['langurl']; ?>">Alışverişe Devam Et</a>
						</div>
						<?php  }else { 
						
							
							foreach($_SESSION["sepet"] as $row) { 
										$adet       = $row['adet'];
										$varyant  = $row['varyant'];
										$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									
										$sef      = unserialize($urunCek['sef']);
										$urunStok = $urunCek["stok"];
										$stokdus  = $urunCek["stok"] - $adet;
										
								
										$stoksql = $conn -> prepare("UPDATE urun SET stok = :stok WHERE id = :id ");
										$stoksql -> execute(array(
												"stok" => $stokdus,
												"id"      => intval($urunCek['id'])
											));
											
										/*  Varyant Stok Düş */
										if(count($varyant) > 0) { 
											for($i = 0; $i < count($varyant['varid']); $i++) { 
												$urunvaryantlar = $conn -> query("select * from urunvaryants where  varyantdeger = ".intval($varyant['varid'][$i])." && urunid = " .intval($urunCek['id']));
												if($urunvaryantlar -> rowCount() > 0 ){
														foreach($urunvaryantlar->fetchAll() as $row6){ 
															if($row6['varyantdeger'] == intval($varyant['varid'][$i])){ 
																	$varyantstok      = $row6['varyantstok'];
																	$varyantstokdus   =  $varyantstok - $adet;
																	$varyantsql = $conn -> prepare("UPDATE urunvaryants SET varyantstok = :varyantstok WHERE varyantdeger = :varyantdeger && urunid = :urunid ");
																	$guncelle   = $varyantsql -> execute(array(
																			"varyantstok"  => $varyantstokdus,
																			"varyantdeger" => intval($varyant['varid'][$i]),
																			"urunid"	   => intval($urunCek['id'])
																		));
															}
														}
												}
											}
										}	
									
								}
								

						?>
							<div class="odeme-success">
								<div class="icon">
									<i class="fa fa-check">	</i>
								</div>
								<h2>TEŞEKKÜRLER !</h2>
								<span>Siparişinizi Hazırlamaya Başladık..</span>
							</div>
							<div class="siparis-no">
								<h3>SİPARİŞ NUMARANIZ</h3>
								<span>#<?php echo $_SESSION["fs"]["oid"]; ?></span>
							</div>
							<div class="odeme-text">
								<span>Sipariş detaylarınızı içeren bilgilendirme mail <?php echo $uyebul['email']; ?> adresine gönderildi.</span>
								
							</div>
							
							<div class="odeme-links">
								<a class="s" href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>">Siparişlerim</a>
								<a class="b" href="<?php echo $set['langurl']; ?>">Alışverişe Devam Et</a>
							</div>
							
						<?php } ?>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12">
					<div class="sepet-page-right">
						<div class="mini-sepet">
							<div class="title">
								<span>Sipariş Özeti</span>
								<a href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</div>
							
							<div class="urun-list">
								<?php 
									$genelToplam = 0;
									$indirimler  = 0;
									$puan  = 0;
									$kdv = 0;
									$kargodurum  = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant  = $row['varyant'];
									if($urunCek['skargo'] == 1){
										$kargodurum = 1;
									}
									/* varyant hesapla */
										if(count($varyant) > 0) {	 
											$defvarPlus   = 0;
											$defvarMinus  = 0;
											$varAra 	  = $row['arafiyat'];
											$varAra       = str_replace(",","",$varAra);
											for($i = 0; $i < count($varyant['varBaslik']); $i++) {
												$varTutar = $varyant['varTutar'][$i];
												$varTur   = $varyant['varTur'][$i];
													if($varTur == 1){
														$defvarPlus  += $varTutar;
													}
													if($varTur == 0){
														$defvarMinus  += $varTutar;
													}	
											}
											$varAra = $varAra + $defvarPlus;
											$varAra = $varAra - $defvarMinus;
											
											$birimfiyat = $varAra;
										} else {
											$birimfiyat = $row['arafiyat'];
										}
										$kdv		 =  $kdv +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
										
										$genelToplam += $row['adet'] * $birimfiyat;
		
									?>
								<div class="urun-item">
									<div class="urun-img">
										<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
									</div>
									<div class="urun-infos">
										<div class="name">
											<span><?php echo $row['baslik']; ?></span>
											<?php 
											if(count($varyant) > 0) {	
												echo '<div class="right-varyants">';
												for($i = 0; $i < count($varyant['varBaslik']); $i++) {
													echo '
													<span class="var-desc">'.$varyant['varKat'][$i].' - '.$varyant['varBaslik'][$i].'</span>';
													if($varyant['varTutar'][$i] != 0.00 ){
														if($varyant['varTur'][$i] == 0){
															$varDurum  = '(-)';
															$varClass = 'varyant-eksi';
														}else{
															$varDurum  = '(+)';
															$varClass = 'varyant-arti';
														}
														echo '<span class="varyant-deger"> '.$varDurum.' <p class="'.$varClass.'">'.$varyant['varTutar'][$i].'</p></span>';
													}
													echo '<br/>';
												} 
												echo '</div>';
											}
											?>
											<span><?php echo $row['adet']; ?> Adet -  <?php echo number_format($row['adet'] * $birimfiyat , 2 ); ?> TL</span>
										</div>
									</div>
								</div>
								<?php  } ?>
							</div>
							
						</div>
						<div class="basket-right">
							<ul>
								<?php 
								$kuponlar = $conn->query("select * from kupongecmisi where siparisid = ".intval($_SESSION["fs"]["oid"])." && userid = ".intval($_SESSION["m_id"])." AND durum = 0");
									$kuponlarFetch = $kuponlar->fetchAll();
									if($kuponlar -> rowCount() >0 ) {
										foreach($kuponlarFetch as $row4){ 
											$indirimler  = $indirimler + $row4['tutar'];
										}
									}
								
								$anaTutar   =   $genelToplam  + $_SESSION["fs"]['kargotutar'] ;
								if($_SESSION["fs"]["kapidaodemefiyat"] != 0.00){
									$anaTutar   =  $anaTutar  + $_SESSION["fs"]["kapidaodemefiyat"];
								}
								$anaTutar   =  ($anaTutar -  $indirimler)  - ( $_SESSION["fs"]["parapuan"] );
								$anaTutar   =  $anaTutar  -  $_SESSION["fs"]["kredipuan"] ;
								?>
								
								<li><span>Sipariş Tutarı</span> <span class="tutar"><?php echo number_format($genelToplam,2); ?> TL</span></li>
								<li><span>Kdv</span> <span class="tutar"><?php echo $kdv; ?>  TL</span></li>
								<?php  if($_SESSION["fs"]["kapidaodemefiyat"] != 0.00){  ?>
								
								<li><span>Kapıda Ödeme Fiyatı </span> <span class="tutar"><?php echo $_SESSION["fs"]["kapidaodemefiyat"]; ?>  TL</span></li>
								
								<?php  } ?>
								<?php 
								 if(!empty($_SESSION["fs"]["parapuan"])){ 
									echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["parapuan"].'</span></li>';
								 }
								if(!empty($_SESSION["fs"]["kredipuan"])){ 
									echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.number_format($_SESSION["fs"]["kredipuan"],2).'</span></li>';
								 
								 }
								?>
								<?php if($kuponlar -> rowCount() >0 ) {  
										foreach($kuponlarFetch as $row5){ ?>
											<li>
												<span>Kupon Tutarı (-)</span>
												<span><?php echo number_format($row5['tutar'],2); ?> TL</span>
											</li>
										<?php } ?>
									<?php  } ?>
									
									<?php if($kargodurum ==0){?>
									<li><span>Kargo</span><span class="kargo-tutar"><?php echo $_SESSION["fs"]['kargotutar']; ?> TL</span></li>
									<?php  } ?>
									<?php if($_SESSION["fs"]["kredipuan"] >=  number_format($_SESSION["fs"]["toplamtutar"],2) ) {
										$toplamTutar = $_SESSION["fs"]["toplamtutar"] + $_SESSION["fs"]['kargotutar'];
									}else {
										$toplamTutar = $_SESSION["fs"]["toplamtutar"];
									}
									$toplamTutar = $toplamTutar;

									?>
								<li class="genel-toplam"><span>Sepet Toplamı</span>
									<span class="tutar"><?php echo number_format($toplamTutar ,2); ?> TL
								</span></li>
								<?php ?>
							</ul>
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
						
					</div>
				</div>
					
			</div>
		</div>
		
	</div>
	

	
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
</div>		
<?php _footer(); ?>
<?php _footer_last(); ?>
<?php

if($_SESSION["sonuc"]["durum"] == "success"){ 
	if(isset($_SESSION["fs"])){
		unset($_SESSION["fs"]);
	}

	unset($_SESSION["siparisid"]);  
	unset($_SESSION['fposts']["faturaadresi"]);
	unset($_SESSION['fposts']["teslimatadresi"]);
	unset($_SESSION['fposts']["kargosecenek"]);
	unset($_SESSION['fposts']["siparisnot"]);
	unset($_SESSION["sepet"]);
	unset($_SESSION["sonuc"]);
}
 ?>
 </body>
</html>