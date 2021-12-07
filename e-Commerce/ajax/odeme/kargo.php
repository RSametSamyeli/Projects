<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }

if(!isset($_POST)) { exit;}


$id    = clean($_POST["id"]);
if(!$id) { exit; }
$kargobul  = $conn -> query("select * from kargo where  id = ".intval($id))->fetch();
if(!$kargobul) { exit; }

$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
if(!$uyebul){ exit; }


	


if(isset($_SESSION["sepet"])){  

	echo 'done|x|';
	$genelToplam = 0;
	$indirimler    = 0;
	$kdv = 0;
	$puan  = 0;
	$kredi = 0;
	$kargodurum = 0;
	if(isset($_SESSION["fs"]["puan"])){ 
		$puan = $_SESSION["fs"]["puan"];
	}
	if(isset($_SESSION["fs"]["kredi"])){ 
		$kredi = $_SESSION["fs"]["kredi"];
	}
	if(isset($_SESSION["m_oturum"])){ 
		$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1");
		$kuponlarFetch = $kuponlar->fetchAll();
		if($kuponlar -> rowCount() >0 ) {
			foreach($kuponlarFetch as $row){ 
				$indirimler  = $indirimler + $row['tutar'];
			}
		}
	}
	foreach($_SESSION["sepet"] as $row){
		$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
		if($urunCek['skargo'] == 1){
			$kargodurum = 1;
		}
		$varyant  = $row['varyant'];
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
		$kdv	 =  $kdv +  kdv_ekle($row['adet'] * $birimfiyat,$urunCek['kdv']);
		$genelToplam += $row['adet'] * $birimfiyat;
		$sef = unserialize($urunCek['sef']);
		
		
		
		echo '<li class="sepet-item basket'.$row['sepetid'].'">
				<div class="figure">
					<a href="'.$map.'/'.$detaysef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['sepetid'].'">
						<img src="'.$set['siteurl'].'/uploads/urun/thumb/'.$row['urunresmi'].'" alt="'.$row['baslik'].'">
					</a>
				</div>
				<div class="detail">
					<div class="urun-name">
						'.$row['baslik'].'
					</div>
					<div class="urun-adet"> <span>'.$row['adet'].'</span>  x  </div>
					<div class="urun-fiyat"> <span>'.$row['arafiyat'].'</span> TL</div>
				</div>
				<div class="remove-sepet">
					<a href="#" id="'.$row['sepetid'].'"><i class="fa fa-remove"></i></a>
				</div>
			</li>	';
	}
	
	/*  Kargo Kampanya Kontrol */
	$kampanya_durum  = $kargobul['kampanya_durum'];
	$kampanya_toplam = $kargobul['kampanya_toplam'];
	if($kampanya_durum == 1){
		if( number_format($genelToplam,2) >= number_format($kampanya_toplam,2) ) {
			$kargofiyat = $kargobul['kampanya_ucret'];
		}else{
			$kargofiyat  = $kargobul['kargoucret'];
		}
	}else{
		$kargofiyat     = $kargobul['kargoucret'];
	}
	
	if($kargodurum ==1){
		$kargofiyat = 0;
	}
	
	
	
	$anaTutar = $genelToplam + $kdv;
	$anaTutar =  $genelToplam + $kargofiyat ;
	$anaTutar =  ( $anaTutar - $indirimler) - ( $puan );
	$anaTutar =  $anaTutar - $kredi;
	echo '<li class="border-none">
			<div class="toplam-fiyat">
				<div class="fiyat-item"><span>Sipariş Tutarı  </span><em>:</em><span class="ara-fiyat">'.number_format($genelToplam,2) .' TL</span></div>
				<div class="fiyat-item"><span>Kdv  </span><em>:</em><span class="kdv"><p>'.$kdv.'</p> TL</span></div>
				';
					if($kargodurum != 1){ 
						echo '<div class="fiyat-item"><span>Kargo  </span><em>:</em><span class="kdv"><p>'.$kargofiyat.'</p> TL</span></div>';
					}else{ 
						echo '<div class="fiyat-item hide"><span>Kargo  </span><em>:</em><span class="kdv"><p>'.$kargofiyat.'</p> TL</span></div>';
					}
				echo '
				';
				
				if(isset($_SESSION["m_oturum"])){				
					if($kuponlar -> rowCount() >0 ) {
						foreach($kuponlarFetch as $row){
							echo '<li><span>Kupon Tutarı </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
						}
					}
				}
				
				echo '<div class="fiyat-item"><span class="genel-tutar">Sepet Toplamı  </span><em>:</em><span class="genel-tutar">'.number_format($anaTutar,2).' TL</span> </div>
											
			</div>
		</li>
		<li class="border-none">
			<div class="sepete-git">
				<a href="'.$set['siteurl'].'/'.$sef_sepet_link[$set['lang']['active']].'">'.$lang['yardimci']['sepetegit'].'</a>
			</div>
		</li>';
	echo '|x|';
	echo count(@$_SESSION["sepet"]);
	echo '|x|';
	echo '<li><span>Sipariş Tutarı</span> <p>TL</p><span class="tutar">'.number_format($genelToplam,2).' </span></li>
		  <li class="kdv-li"><span>Kdv</span> <p>TL</p> <span class="tutar">'.$kdv.'  </span></li>
		  ';  
			if($kargodurum != 0){
				echo  '<li class="hide"><span>Kargo x</span> <p>TL</p><span class="kargo-tutar">'.$kargofiyat.' </span></li>';
			}else{
				echo  '<li><span>Kargo</span> <p>TL</p><span class="kargo-tutar">'.$kargofiyat.' </span></li>';
			}
		   
		  
		  if(isset($_SESSION["fs"]["puan"])){
			echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["puan"].'</span></li>';
		  }
		  if(isset($_SESSION["fs"]["kredi"])){
			echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_kredi']).'"><span>Kredi Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$_SESSION["fs"]["kredi"].'</span></li>';
		  }
		  if(isset($_SESSION["m_oturum"])){
				if($kuponlar -> rowCount() >0 ) {
					foreach($kuponlarFetch as $row){
						echo '<li><input type="hidden" name="indirimkupon[]"  value="'.$row['tutar'].'"/><span>İndirim Tutarı (-)  </span><p>TL</p><span class="indirim-hesap tutar-hesap">'.$row['tutar'].'</span></li>';
					}
				}
			}
		 echo '<li class="genel-toplam"><span>Sepet Toplamı</span><span class="tutar">'.number_format($anaTutar,2).' TL</span></li>';
		  
}


 ?>