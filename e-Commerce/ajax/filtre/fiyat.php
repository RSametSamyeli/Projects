<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
include_once('../lab/function.php');
include("../dil/".$set["lang"]['active'].".php");
if(!isset($_GET)) { exit;}
$id		  = clean($_GET["katid"]);
$fiyatlar = clean($_GET["fiyatlar"]);
$fiyatlar = explode("-",$fiyatlar);
$min = number_format($fiyatlar[0],2);
$max =  number_format($fiyatlar[1],2);
$urunCek  = $conn -> query("SELECT * FROM urun WHERE katid = '".intval($id)."'  AND yenifiyat > $min AND yenifiyat < $max ");
if($urunCek -> rowCount() > 0 ){
	$i= -0.1;
	$iPlus = 0.2;
	foreach($urunCek as $row){ 
		$name      = unserialize($row['baslik']);
			$sef       = unserialize($row['sef']);	
			$images    = unserialize($row['resimler']);	
			 if(empty($images)){
				$anaresim = "default.jpg"; 	
			 }else{
				if(empty($row['vitrinresim'])){
					$anaresim = $images[0]; 	
				}else{
					$anaresim = $row['vitrinresim'];
				}
			 }
			$i += $iPlus; ?>
		<div class="col-md-4 col-xs-12 col-sm-4 change-grid col-sm-4 wow fadeIn" data-wow-delay="<?php echo $i; ?>s">
				<div class="product-item">
					<div class="product-image">
						<a title="<?php echo $name[$set['lang']['active']]; ?> " href="<?php echo $set["siteurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>">
							
							<div class="indirim">
								<?php if($row['fiyat'] != 0.00 ){ ?>
								<span>% <?php echo indirim(number_format($row['yenifiyat'],2),number_format($row['fiyat'],2)); ?></span>
								<?php } ?>
							</div>
							
							<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $anaresim;  ?>" alt="<?php echo $set["siteurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>" />
						</a>
					</div>
					<div class="product-detail">
						<div class="product-title">
							<a href="<?php echo $set["siteurl"]; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['id']; ?>"><span><?php echo $name[$set['lang']['active']]; ?></span></a>
						</div>	
						<div class="product-prices">
							<div class="new-price"><?php echo number_format($row['yenifiyat'],2);?> TL</div>
							<?php if($row['fiyat'] != 0.00 ){ ?>
							<div class="old-price"><?php echo number_format($row['fiyat'],2);?> TL</div>
							<?php  } ?>
						</div>
					</div>
				</div>
			</div>	
		<?php 	
	}
}

?>