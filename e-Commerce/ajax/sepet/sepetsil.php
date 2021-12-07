<?php  
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if(!isset($_POST)) { exit;}
$id = clean($_POST["id"]);
if(isset($_SESSION["sepet"])){ 
	unset($_SESSION["sepet"][$id]);
	echo 'done|x|';
	$genelToplam = 0;
	$indirimler    = 0;
	$puan  = 0;
	$kredi = 0;
	if(isset($_SESSION["m_oturum"])){ 
		$kuponlar = $conn->query("select * from kupongecmisi where userid = ".intval($_SESSION["m_id"])." AND durum = 1");
		$kuponlarFetch = $kuponlar->fetchAll();
		if($kuponlar -> rowCount() >0 ) {
			foreach($kuponlarFetch as $row){ 
				$indirimler  = $indirimler + $row['tutar'];
			}
		}
		$uyebul = $conn -> query("select * from users where id = ".intval($_SESSION["m_id"]))->fetch();
		if(isset($_SESSION["fs"]["puan"])){ 
			$puan = $_SESSION["fs"]["puan"];
		}
		if(isset($_SESSION["fs"]["kredi"])){ 
			$kredi = $_SESSION["fs"]["kredi"];
		}
	}

	foreach($_SESSION["sepet"] as $row){
		$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
		$genelToplam += $row['adet'] * $row['arafiyat'];
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
	$kdv 	  = kdv_ekle($genelToplam,18);
	$anaTutar =  $genelToplam;
	$anaTutar =  ($anaTutar - $indirimler )  - ( $puan );
	$anaTutar =  $anaTutar - $kredi;
	echo '<li class="border-none">
			<div class="toplam-fiyat">
				<div class="fiyat-item"><span>Sipariş Tutarı  </span><em>:</em><span class="ara-fiyat">'.number_format($genelToplam,2) .' TL</span></div>
				';
				if(isset($_SESSION["m_oturum"])){
									
					if($kuponlar -> rowCount() >0 ) {
						
						foreach($kuponlarFetch as $row){
							echo '<li><span>Kupon Tutarı </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
						}
					}
				}
				echo '<div class="fiyat-item"><span>Kdv  </span><em>:</em><span class="kdv"><p>'.$kdv.'</p> TL</span></div>
				
				<div class="fiyat-item"><span class="genel-tutar">Sepet Toplamı  </span><em>:</em><span class="genel-tutar">'.number_format($anaTutar,2).' TL</span> </div>
											
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
	echo '<li><span>Sipariş Tutarı</span> <p>TL</p> <span class="tutar">'.number_format($genelToplam,2).'</span></li>
		  '; 
		  	
			if(isset($_SESSION["m_oturum"])){
				if(isset($_SESSION["fs"]["puan"])){
					echo '<li class="li-puan li-kupon'.$uyebul['uye_puan'].'"><span>Puan Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.puanconvert($uyebul['uye_puan']).'</span></li>';
				}	
				if(isset($_SESSION["fs"]["kredi"])){
					echo '<li class="li-kredi li-kredi'.paraconvert($uyebul['uye_puan']).'"><span>Kredi Tutarı (-) </span><p> TL</p><span class="indirim-hesap">'.$uyebul['uye_kredi'].'</span></li>';
				}				
				if($kuponlar -> rowCount() >0 ) {
					
					foreach($kuponlarFetch as $row){
						echo '<li class="li-kupon'.$row['id'].'"><span>Kupon Tutarı <a href="#" id="'.$row['id'].'" class="kupon-sil">[Sil]</a> </span><p>TL</p><span class="indirim-hesap">'.$row['tutar'].'</span></li>';
					}
				}
				
			}
		  echo'
		  <li><span>Kdv</span> <p> TL</p><span class="tutar">'.$kdv.' </span></li>
		  
		  <li class="genel-toplam"><span>Sepet Toplamı</span> <p>TL</p><span class="tutar">'.number_format($anaTutar,2).' </span></li>';
}


?>