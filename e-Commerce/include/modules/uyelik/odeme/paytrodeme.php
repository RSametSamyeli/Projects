<?php  if( !defined("SABIT") ){ exit; } 
if(!empty($get2)) exit;
include('ajax/sozlesme/sozlesme.php');
$paytr    = unserialize($main_settings['paytr']);
if(count(@$_SESSION["sepet"]) < 1){
	header('location:'.$sef_sepet_link[$set['lang']['active']]);
	exit;
}


## Seo 
$unx_seo 	 = unserialize($sef_odeme['seo']);
$title		 = $unx_seo[$set['lang']['active']]['title'];
$keywords	 = $unx_seo[$set['lang']['active']]['keywords'];
$description = $unx_seo[$set['lang']['active']]['description'];

## F-T Adres
if(isset($_POST["teslimatadresi"])){
	if(isset($_POST["adres_disable"])){
		$_SESSION['fposts']["faturaadresi"] = $_POST["teslimatadresi"];
	}else {
		$_SESSION['fposts']["faturaadresi"] = $_POST["faturaadresi"];
	}
	$_SESSION['fposts']["teslimatadresi"] = $_POST["teslimatadresi"];
	$_SESSION['fposts']["kargosecenek"]   = $_POST["kargosecenek"];
	$_SESSION['fposts']["siparisnot"]     = $_POST["siparisnot"];
		
}


## Kargo Ücret 
	$kar = $_SESSION['fposts']["kargosecenek"];
	$kargobul  = $conn -> query("select * from kargo where id = ".intval($kar))->fetch();
	$kargofiyat = $kargobul['kargoucret']; 


## Uye kontrol 
if(!isset($_SESSION["m_oturum"])){
	 header("Location: ".$sef_uyelik_link[$set['lang']['active']]."");
	 exit;
}

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }


$adresCek  	= $conn -> query("select * from useraddress where id = ".intval($_SESSION['fposts']["teslimatadresi"]))->fetch();
$tSehir 	= $conn -> query("select * from il where ID = ".intval($teslimatadresi['sehir']))->fetch();
$tilce		= $conn -> query("select * from ilce where ID = ".intval($teslimatadresi['ilce']))->fetch();

## Adresler
$adresler      = $conn -> query("select * from useraddress where user_id = ".intval($uyebul['id'])); 
$adreslerCount =  $adresler -> rowCount();
$adreslerFetch =  $adresler -> fetchAll();

## Kargolar 
$kargolar 	   = $conn -> query("select * from kargo where durum = 1 order by sira asc");
$kargolarCount = $kargolar-> rowCount();
$kargolarFetch = $kargolar -> fetchAll(); 

## Bankalar - Eft
$bankalar = $conn -> query("select * from banka order by sira asc");

## Ödeme Durumlar ##
$odemehavale   = $conn->query("select id,ad,durum from payments where id = 1")->fetch();
$odemesanalpos = $conn->query("select id,ad,durum from payments where id = 2")->fetch();
$odemekapida   = $conn->query("select id,ad,durum from payments where id = 3")->fetch();
$odemecepbank  = $conn->query("select id,ad,durum from payments where id = 4")->fetch();
$odememobil    = $conn->query("select id,ad,durum from payments where id = 4")->fetch();

	
$oid  = $_SESSION['fposts']["oid"];


seoyaz("".$title."","".$description."","".$keywords ."",""); 



## Sepet Hesaplama 
$genelToplam = 0;
$indirimler  = 0;
$kdvler  	 = 0;
if(isset($_SESSION["m_oturum"])){ 
	$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1");
	$kuponlarFetch = $kuponlar->fetchAll();
	if($kuponlar -> rowCount() >0 ) {
		foreach($kuponlarFetch as $row){ 
			$indirimler  = $indirimler + $row['tutar'];
		}
	}
}

								
$b_array  = array();


foreach(@$_SESSION["sepet"] as $row) { 
	$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
	$sef = unserialize($urunCek['sef']);
	$varyant  = $row['varyant'];

	
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
		$birimfiyat   = str_replace(",","",$birimfiyat);
		$genelToplam += $row['adet'] * $birimfiyat;
		$kdvler		 =   $kdvler +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
		//$b_array[] 	  = array( $row['baslik'] , $birimfiyat, $row['adet'] );
		$b_array[] 	  = array( $row['baslik'] , $birimfiyat, $row['adet'] );
		
}

	## Kargo Ücret 
	if(isset($_POST['kargosecenek'])){
		$kar 		  = clean($_POST['kargosecenek']);
		$kargobul     = $conn -> query("select * from kargo where  id = ".intval($_SESSION['fposts']["kargosecenek"]))->fetch();
		$kampanya_durum   =  $kargobul['kampanya_durum'];
		$kampanya_toplam  =  $kargobul['kampanya_toplam'];
		if($kampanya_durum == 1){
			if( number_format($genelToplam,2) >= number_format($kampanya_toplam,2) ) {
				$kargofiyat = $kargobul['kampanya_ucret'];
			}else{
				$kargofiyat = $kargobul['kargoucret'];
			}
		}else{
			$kargofiyat     = $kargobul['kargoucret'];
		}	
	}else{
		if(isset($_SESSION["fs"]["gizlikargo"])){
			$kargofiyat = $_SESSION["fs"]["gizlikargo"];
		}else{
			$kargofiyat = $kargofiyat;
		}
	}
	
	
	$anaTutar   =    $genelToplam   + $kargofiyat; 
	$anaTutar   =    $anaTutar      - $indirimler;
	$anaTutar   =    $anaTutar;
	$anaTutar2   =    $anaTutar;
	


$paytramount = $anaTutar2  * 100; 
## Paytr  Başlangıç
$merchant_id 	 = ''.$paytr['test'].'';
$merchant_key 	 = ''.$paytr['key'].'';
$merchant_salt	 = ''.$paytr['salt'].'';
$email 			 = $uyebul['email'];
$payment_amount	 = $paytramount; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
$merchant_oid    = $oid;
$user_name 		 = $uyebul['ad']." ".$uyebul['soyad'];	
$user_address    = $adresCek['adres']." ".$tSehir['ADI']." ".$tilce['ADI']." - ".$adresCek['postakodu']." - ".$adresCek['ulke']; 	
$user_phone 	 = $uyebul['telefon'];	
$merchant_ok_url   = $set['siteurl'].'/include/modules/odeme/odeme_basarili.php';
$merchant_fail_url = $set['siteurl'].'/include/modules/odeme/odeme_hata.php';

$user_basket = base64_encode(json_encode($b_array));

if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	} elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	
$user_ip		 = $ip;
$timeout_limit   = "30";
$debug_on 		 = 1;
$test_mode 		 = 1;
if($taksitkontrol == 1){
	$no_installment	 = 1;	
}else{
	$no_installment	 = 0;	
}


$max_installment = 0;
$currency 		 = "TL";
$hash_str		 = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
$paytr_token	 = base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
$post_vals	= array(
			'merchant_id'=>$merchant_id,
			'user_ip'=>$user_ip,
			'merchant_oid'=>$merchant_oid,
			'email'=>$email,
			'payment_amount'=>$payment_amount,
			'paytr_token'=>$paytr_token,
			'user_basket'=>$user_basket,
			'debug_on'=>$debug_on,
			'no_installment'=>$no_installment,
			'max_installment'=>$max_installment,
			'user_name'=>$user_name,
			'user_address'=>$user_address,
			'user_phone'=>$user_phone,
			'merchant_ok_url'=>$merchant_ok_url,
			'merchant_fail_url'=>$merchant_fail_url,
			'timeout_limit'=>$timeout_limit,
			'currency'=>$currency,
            'test_mode'=>$test_mode
		);	
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = @curl_exec($ch);

	if(curl_errno($ch))
		die("PAYTR IFRAME connection error. err:".curl_error($ch));
		
	
	curl_close($ch);
	
	$result=json_decode($result,1);
		
	if($result['status']=='success')
		$token=$result['token'];
	else
		//die("PAYTR IFRAME failed. reason:".$result['reason']);
		header('location:'.$sef_sepet_link[$set['lang']['active']]);
	#########################################################################	
	
	
	
	
		
?>
</head>
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/odeme.css" />
<link rel="stylesheet" href="<?php echo $set['siteurl']; ?>/assets/css/keypad.css" />
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
						<div class="step-blok active">
							<div class="sepet-header">
								<h2><i class="fa fa-credit-card-alt"></i>ÖDEME SEÇENEKLERİ</h2>
								<p>Ödeme Bilgilerinizi Giriniz</p>
							</div>
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
					<div class="col-sm-12 col-md-4">
						<div class="step-blok">
							<div class="sepet-header">
								<h2><i class="fa fa-check" aria-hidden="true"></i>SİPARİŞ ONAYI</h2>
								<p>Siparişiniz Özeti </p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-xs-12">
					<div class="tamamla-sol">
						<div class="odemeler">
							<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
							<iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
							<script>iFrameResize({},'#paytriframe');</script>
							<!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş -->
						</div>
					</div>
				</div>
				<!--/left-->
				<div class="col-md-4 col-xs-12 hide">
					<div class="sepet-page-right">
						<div class="sip-done">
							<button type="submit">SİPARİŞİ TAMAMLA <i class="fa fa-chevron-right"></i></button>
			
						</div>
						<div class="mini-sepet">
							<div class="title">
								<span>Sipariş Özeti</span>
								<a href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</div>
							
							<div class="urun-list">
								<?php 
									$genelToplam = 0;
									$indirimler  = 0;
									foreach(@$_SESSION["sepet"] as $row) { 
									$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
									$sef = unserialize($urunCek['sef']);
									$varyant  = $row['varyant'];
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
										$birimfiyat = str_replace(",","",$birimfiyat);
										$genelToplam += $row['adet'] * $birimfiyat;
									?>
								<div class="urun-item">
									<div class="urun-img">
										<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
									</div>
									<div class="urun-infos">
										<div class="name">
											<span><?php echo $row['baslik']; ?> - <?php echo $urunCek['kod']; ?></span>
											<?php 
											if(count($varyant) > 0) {	
												$varyantidler    = array();
												$varyantturler   = array();
												$varyantFiyatlar = array();
												$varyantAciklama = array();
												echo '<div class="right-varyants">';
												for($i = 0; $i < count($varyant['varBaslik']); $i++) {
													$varyantidler[]  = $varyant['varid'][$i];		
													echo '<span class="var-desc">'.$varyant['varKat'][$i].' - '.$varyant['varBaslik'][$i].'</span>';
													if($varyant['varTutar'][$i] != 0.00 ){
														$varyantFiyatlar[]   = $varyant['varTutar'][$i];
														$varyantturler[]     = $varyant['varTur'][$i];														
														if($varyant['varTur'][$i] == 0){
															$varDurum  = '(-)';
														}else{
															$varDurum  = '(+)';
														}
														$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i].' - '.$varDurum.' '.$varyant['varTutar'][$i];	
														echo '<span class="varyant-deger"> '.$varDurum.' <p>'.$varyant['varTutar'][$i].'</p></span>';
													}else{
														$varyantFiyatlar[] = '';
														$varyantturler[]   = '';
														$varyantAciklama[]   = $varyant['varKat'][$i]." - ".$varyant['varBaslik'][$i];	
													}
													
													echo '<br/>';
												} 
												echo '</div>';
											
											}else{
												$varyantidler[]    = '';
												$varyantturler[]   = '';
												$varyantFiyatlar[] = '';
												$varyantturler[]   = '';
												$varyantAciklama[] = '';		 											
											}	
											$varyantidBirlestir        = implode(",",$varyantidler);
											$varyantfiyatBirlestir 	   = implode(",",$varyantFiyatlar);
											$varyantturBirlestir   	   = implode(",",$varyantturler);
											$varyantAciklamaBirlestir  = implode(",",$varyantAciklama);
											$urunid[] 	   = $row['sepetid'];
											$uvaryantid[] 	   = $varyantidBirlestir;
											$varyanttutarlar[$row['sepetid']][] = $varyantfiyatBirlestir;
											$varyantturler[$row['sepetid']][]   = $varyantturBirlestir;
											$uvaryant[] = $varyantAciklamaBirlestir;
											$adet[] 	= $row['adet'];
											$baslik[] 	= $row['baslik'];
											?>
											<span><?php echo $row['adet']; ?> Adet -  <?php echo number_format($row['adet'] * $birimfiyat , 2 ); ?> TL</span>
										</div>
									</div>
								</div>
									<input type="hidden" name="urunid[]" value="<?php echo $row['sepetid']; ?>" />
									<input type="hidden" name="uvaryant[]" value="<?php echo $varyantAciklamaBirlestir; ?>" />
									<input type="hidden" name="varyantid[]" value="<?php echo $varyantidBirlestir; ?>" />
									<input type="hidden" name="varyanttutarlar[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantfiyatBirlestir; ?>" />
									<input type="hidden" name="varyantturler[<?php echo $row['sepetid']; ?>][]" value="<?php echo $varyantturBirlestir; ?>" />
									<input type="hidden" name="baslik[]" value="<?php echo $row['baslik']; ?>" />
									<input type="hidden" name="adet[]" value="<?php echo $row['adet']; ?>" />
								<?php  } ?>
							</div>
						</div>
						<?php 
						?>
						<div class="basket-right hide">
							<ul>
								<li><span>Sipariş Tutarı</span> <p>TL</p> <span class="tutar tutar-hesap">  <?php echo number_format($genelToplam,2); ?> </span></li>
								<li><span>Kdv</span> <p>TL</p><span class="tutar"><?php echo number_format($kdvler,2); ?>  </span></li>
								<li class="li-kapida-odeme"><span>Kapıda Ödeme Tutarı</span> <p>TL</p><span class="kapida-odeme tutar-hesap">0.00 </span> </li>
								<li><span>Kargo</span> <p>TL</p><span class="kargo-tutar tutar-hesap"><?php echo number_format($kargofiyat,2); ?> </span></li>
								
								<?php 
								## indirimler
								if(isset($_SESSION["fs"]["puan"])){
									echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["puan"].'</span></li>';
								}
								if(isset($_SESSION["fs"]["kredi"])){
									echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["kredi"].'</span></li>';
								}
								if(isset($_SESSION["m_oturum"])){
									
									if($kuponlar -> rowCount() >0 ) {
										
										foreach($kuponlarFetch as $row){
											echo '<li><input type="hidden" name="indirimkupon[]" value="'.$row['id'].'"  /><span>Kupon Tutarı (-) </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
										}
									}
								}
								?>
							
								<li class="genel-toplam"><span>Sepet Toplamı</span><p>TL</p><span class="tutar"><?php echo number_format($anaTutar,2); ?> </span></li>	
							</ul>
						
							<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
						</div>
						
					</div>
				</div>
				   	<input type="hidden" name="odemeturu" class="odemeturu"/>
					<input type="hidden" name="teslimatadresi" value="<?php echo $_SESSION['fposts']["teslimatadresi"]; ?>" />
					<input type="hidden" name="faturaadresi" value="<?php echo $_SESSION['fposts']["faturaadresi"]; ?>" />
					<input type="hidden" name="kargosecenek" value="<?php echo $_SESSION['fposts']["kargosecenek"]; ?>" />
					<input type="hidden" name="siparisnot" value="<?php echo $_SESSION['fposts']["siparisnot"]; ?>" />
					<input type="hidden" name="kdv" value="<?php echo $kdvler; ?>" />
					<input type="hidden" name="kapidaodemefiyat" value="" />
					<input type="hidden" name="kapidaodemeturu" value="" />
					<input type="hidden" name="kargotutar" value="<?php  echo $kargofiyat; ?>" />
					<input type="hidden" name="kdvsiztutar" value="<?php echo number_format($genelToplam,2); ?>"  />
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $uyebul['id']; ?>" />
					<input type="hidden" class="amount" name="toplamtutar" id="i-amount" value="<?php echo number_format($anaTutar,2); ?>" />	
					<?php 
						// Halk Bank Gerekli Alanlar
						$clientId   = $anapos['magazano'];            
						$okUrl      = $set['siteurl']."/ajax/odeme/odeme.php";
						$failUrl    = $set['siteurl']."/ajax/odeme/odeme.php";     
						$rnd        =  microtime();   
						$storekey   = "".$anapos['storekey']."";        
						$storetype  = "3d"; 
						$amount     = number_format($anaTutar,2);	
						$hashstr    = $clientId . $oid . $amount . $okUrl . $failUrl . $rnd  . $storekey;
						$hash 	    = base64_encode(pack('H*',sha1($hashstr)));
						
						// Halk Bank Gerekli Alanlar
						?>
						<input type="hidden" name="clientid" value="<?php  echo $clientId ?>">
						<input type="hidden" name="okUrl" value="<?php  echo $okUrl ?>">
						<input type="hidden" name="failUrl" value="<?php  echo $failUrl ?>">
						<input type="hidden" name="rnd" value="<?php  echo $rnd ?>" >
						<input type="hidden" name="hash" value="<?php  echo $hash ?>" >
						<input type="hidden" name="storetype" value="3d" >		
						<input type="hidden" name="lang" value="tr">
						<input type="hidden" name="currency" value="949">
					    <input type="hidden" name="amount" value="<?php echo number_format($anaTutar,2); ?>">
					    <input type="hidden" name="oid" value="<?php  echo $oid; ?>">	
						<input type="hidden" name="siparisturu" value="0" />	
			</div>
		</div>
	</div>
<?php include('include/sabit/footer.php'); ?>	
	<!--/footer-->
	<?php include('include/sabit/sozlesmeler.php'); ?>	
<!--/modals-->	
</div>		
<?php var_dump($merchant_oid); ?>
<?php _footer(); ?>
<?php _footer_last(); ?>
<?php 

$_SESSION["fs"]["sipid"] 	    = $oid;
$_SESSION["fs"]["oid"] 		    = $oid;
$_SESSION["fs"]["user_id"] 	    = $uyebul['id'];
$_SESSION["sonuc"]['date']	    = time();
$_SESSION["sonuc"]["amount"]    = $anaTutar2;
$_SESSION["fs"]["toplamtutar"]  = $anaTutar2;
$_SESSION["fs"]['kargotutar']   = $kargofiyat;

## anadurum 0 
$bul3 	  = $conn -> query("select * from siparis where anadurum = 0 && user_id = ".$uyebul['id']." && oid != '".$merchant_oid ."'");
if($bul3 -> rowCount() > 0 ){
	foreach($bul3 as $row){
		$sipsil = $conn -> prepare("delete from siparis where id = :id");
		$sipsil  -> execute(array("id" =>$row['id']));
	}
}

$bul2 	  = $conn -> query("select * from siparis where anadurum = 0 && oid = '".$oid."'")->fetch();
if(!$bul2) {
	$insert = $conn -> prepare("INSERT INTO siparis SET 
		 odemeturu	 	= :odemeturu,
		 urunid		 	= :urunid,
		 baslik		 	= :baslik,
		 uvaryant   	= :uvaryant,
		 varyantid   	= :varyantid,
		 varyantturler	= :varyantturler,
		 varyanttutarlar = :varyanttutarlar,
		 adet		 	= :adet,
		 durum		 	= :durum,
		 tarih       	= :tarih,
		 toplamtutar	= :toplamtutar, 
		 ip			 	= :ip,
		 user_id	 	= :user_id,
		 teslimatadresi = :teslimatadresi,
		 faturaadresi   = :faturaadresi,
		 kargo			= :kargo,
		 siparisnot		= :siparisnot,
		 kdv			= :kdv,
		 kargotutar     = :kargotutar,
		 kdvsiztutar	= :kdvsiztutar,
		 oid			= :oid,
		 kapidaodemefiyat = :kapidaodemefiyat,
		 kapidaodemeturu  = :kapidaodemeturu,
		 siparisturu	  = :siparisturu,
		 anadurum		  = :anadurum
		 ");
		 
		$ekle = $insert -> execute(array(
			"odemeturu" 	=> "kredikarti",
			"urunid" 		=> serialize($urunid),
			"baslik" 		=> serialize($baslik),
			"uvaryant"		=> serialize($uvaryant),
			"varyantid"		=> serialize($uvaryantid),
			"varyantturler"	=> serialize($varyantturler),
			"varyanttutarlar"	=> serialize($varyanttutarlar),
			"adet"		 	=> serialize($adet),
			"durum" 		=> 0,
			"tarih"			=> time(),
			"toplamtutar"	=> $anaTutar2,
			"ip"			=> $ip,
			"user_id"		=> $uyebul['id'],
			"teslimatadresi" => $_SESSION['fposts']["teslimatadresi"],
			"faturaadresi"   => $_SESSION['fposts']["faturaadresi"],
			"kargo"			 => $_SESSION['fposts']["kargosecenek"],
			"siparisnot"	 => $_SESSION['fposts']["siparisnot"],
			"kdv"			 => $kdvler,
			"kargotutar"	 => $kargofiyat,
			"kdvsiztutar"	   => $genelToplam,
			"oid"			   => intval($oid),	
			"kapidaodemefiyat" => 0,
			"kapidaodemeturu"  => 0,
			"siparisturu"	   => 0,
			"anadurum"		  => 0
			));		
}

		?>
 </body>
</html>