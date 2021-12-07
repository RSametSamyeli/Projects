<?php if( !defined("SABIT") ){ exit; } 
$anakats  = $conn -> query("select * from kategori where modul = 'urunler' and ustid = 0 order by sira asc");
function header_menu($ustid){
	global $conn,$set,$sef_urunler_link;
	$katsorgu = $conn -> query("select * from kategori where modul = 'urunler' and ustid = ".intval($ustid)." order by sira asc");	
	$katsorguCount = $katsorgu -> rowCount();
	if($katsorguCount > 0){
		echo '<ul>';
			foreach($katsorgu as $row){
				$name      = unserialize($row['baslik']);
				$sef       = unserialize($row['sef']);
				$altmenu = $conn -> query("select * from kategori where ustid = '".intval($row['id'])."'");
				echo '<li '; 
				if($altmenu  -> rowCount() > 0){
					echo ' class="has"';
				}
				echo '><a href="'.$set['siteurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'">'.$name[$set['lang']['active']].' </a> ';
					header_menu($row['id']);
				echo '</li>';
			}
		echo '</ul>';
	}
}

?>


<nav id="cihaniriboy-mobile"><ul></ul></nav>	
	<div class="header hidden-print">
		
		<div class="m-search-content visible-xs visible-sm">
			<form action="<?php echo $set['siteurl']; ?>/">
				<input type="text" name="s" placeholder="Ne Aramıştınız ? " />
			</form>
			<a href="#" class="mfs-close"><i class="fa fa-remove"></i></a>
		</div>
		
		<div class="header-top">
			<div class="container">
				<div class="top-left hidden-xs">
					<span>Hoşgeldiniz, Hesaplı Giyimin Adresi</span>
				</div>
				<div class="top-right">
					<div class="login">
						<?php if(!isset($_SESSION["m_oturum"])) {  ?>
						<a class="sep" href="<?php echo $set['siteurl']; ?>/<?php echo $sef_uyelik_link[$set['lang']['active']]; ?>"><i class="fa fa-user visible-xs" aria-hidden="true"></i><span>GİRİŞ</span></a>
						<a class="sep" href="<?php echo $set['siteurl']; ?>/<?php echo $sef_uyelik_link[$set['lang']['active']]; ?>"><i class="fa fa-user-plus visible-xs" aria-hidden="true"></i><span>ÜYE OL</span></a>
						<a href="#"><span>SİPARİŞ TAKİBİ</span></a>
						<?php  } else { 
						$uyeCek = $conn -> query("SELECT * FROM users WHERE id = ".intval($_SESSION["m_id"]))->fetch();
						?>
							<div class="cihaniriboy-uyelik">
								<button class="dropdown-toggle" type="button" data-toggle="dropdown">
									Hoşgeldin <strong><?php echo $uyeCek['ad']. " " .$uyeCek['soyad']; ?></strong>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu uyelik_roles">
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_hesap_link[$set['lang']['active']]; ?>"><i class="fa fa-cog"></i><?php echo $sef_hesap_baslik[$set['lang']['active']]; ?></a></li>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sifre_link[$set['lang']['active']]; ?>"><i class="fa fa-lock" aria-hidden="true"></i><?php echo $sef_sifre_baslik[$set['lang']['active']]; ?> </a></li>
									<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>"><i class="fa fa-list" aria-hidden="true"></i><?php echo $sef_siparislerim_baslik[$set['lang']['active']]; ?></a></li>
									<li><a href="#" class="log-out"><i class="fa fa-sign-in"></i><?php echo $lang['yardimci']['cikis']; ?></a></li>
								</ul>
							</div>	
							
						<?php } ?>
					</div>

					
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="container">
				<div class="bottom-content">
					<div class="mobile-left hidden-md hidden-lg">
						<div class="hamburger-box">
							<div class="hamburger-inner"></div>
						</div>
						<div class="mobile-search">
							<a href="#"><i class="fa fa-search"></i></a>
						</div>
					</div>
					<div class="logo">
						<a href="/" title="<?php echo $set['seo']['t']; ?>">
							<img src="<?php echo $set['siteurl']; ?>/assets/images/logo.png" alt="<?php echo $set['seo']['t']; ?>" />
						</a>
					</div>
					<!--/logo-->
					<!--/menu-->
					<div class="search hidden-xs hidden-sm">
						<div class="search-content">
							<form action="<?php echo $set['siteurl']; ?>/">
								<input type="text"  class="form-control" placeholder="Aradığınız Ürünü Yazın.." name="s"/>
								<button type="submit">
									<i></i>
								</button>
							</form>
						</div>
					</div>
					<!--/search-->
						<div class="header-sepet">
							<div class="sepet-icon">
								<a href="#"  class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<div class="spt-img"><span class="badge badge-info" id="sepetsayi"><?php echo count(@$_SESSION["sepet"])?></span></div>
									<div class="sepet-text hidden-xs">
										<i class="fa fa-angle-down"></i>
										Sepetim
									</div>
								</a>
								<div class="dropdown-menu" id="first-sepet-ul">
										<div class="overlay-sepet"><img src="<?php echo $set['siteurl']; ?>/assets/images/ajax.gif" alt="loading" /></div>
										<ul class="sepet-ul">
											<?php if(count(@$_SESSION["sepet"]) > 0) {?>
											<li class="dropdown-title"><h2><?php echo $lang['yardimci']['urun_siparisleri']; ?></h2></li>
											<?php 
												$genelToplam = 0;
												foreach(@$_SESSION["sepet"] as $row) {
												
												$genelToplam += $row['adet'] * $row['arafiyat'];
												$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
												$varyantCek = $conn -> query("select * from varyant where id = ".intval($row['varyant']))->fetch();
												$vName = unserialize($varyantCek['baslik']);
												$sef   = unserialize($urunCek['sef']);
											?>
											<li class="sepet-item basket<?php echo $row['sepetid']; ?>">
												<div class="figure">
													<a href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_urunler_link[$set['lang']['active']]; ?>/<?php echo $sef[$set['lang']['active']]."-".$row['sepetid']; ?>">
														<img src="<?php echo $set['siteurl']; ?>/uploads/urun/thumb/<?php echo $row['urunresmi']; ?>" alt="<?php echo $row['baslik']; ?>">
													</a>
												</div>
												<div class="detail">
													<div class="urun-name">
														<?php echo $row['baslik']; ?> 
														<?php if(!empty($row['varyant'])){ ?>
														- <?php echo $vName[$set['lang']['active']]; ?>
														<?php } ?>
													</div>
													<div class="urun-adet"> <span><?php echo $row['adet']; ?></span>  x  </div>
													<div class="urun-fiyat"> <span><?php echo $row['arafiyat']; ?></span> <?php echo $lang['yardimci']['tl']; ?></div>
												</div>
												<div class="remove-sepet">
													<a href="#" id="<?php echo $row['sepetid']; ?>"><i class="fa fa-remove"></i></a>
												</div>
											</li>								
											<?php  } ?> 
											<li class="border-none">
												<div class="toplam-fiyat">
													<?php 
													$kdv 	 = kdv_ekle(number_format($genelToplam,2),18);
													$anaTutar =    number_format($genelToplam,2)  + $kdv ;
													?>
													<div class="fiyat-item"><span>Sipariş Tutarı   </span><em>:</em><span class="ara-fiyat"> <?php echo number_format($genelToplam,2); ?> TL</span></div>
													<div class="fiyat-item"><span>Kdv  </span><em>:</em><span class="kdv"><p> <?php echo $kdv; ?></p> TL</span></div>
													<div class="fiyat-item"><span class="genel-tutar">Sepet Toplamı  </span><em>:</em><span class="genel-tutar genel-tutar-sonuc"><?php echo number_format($anaTutar,2); ?> TL</span></div>
											
													
												</div>
											</li>
											<li class="border-none">
												<div class="sepete-git">
													<a href="<?php echo $set['siteurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>"><?php echo $lang['yardimci']['sepetegit']?></a>
												</div>
											</li>
											<?php } else{ ?>
											<li>
												<div class="sepet-yok">
													<?php echo $lang['yardimci']['sepeturunyok']?>
												</div>
											</li>
											<?php }  ?>	
										</ul>
										
									</div>
								</div>
						</div>
				</div>
				<div class="menu-content">
					<div class="container">
						<div class="inner">
							<div class="menu hidden-xs hidden-sm">
								<ul>
									<li><a href=""><i class="fa fa-home"></i></a></li>
									<?php foreach($anakats as $row) {
										$name      = unserialize($row['baslik']);
										$sef       = unserialize($row['sef']);	
										echo '<li><a href="'.$set['siteurl'].'/'.$sef_urunler_link[$set['lang']['active']].'/'.$sef[$set['lang']['active']].'-'.$row['id'].'">'.$name[$set['lang']['active']].'</a> '; 
										header_menu($row['id']);
										echo '</li>';
										}
								 ?>
								 </ul>
								<?php  ?>
							</div>
						</div>
					<!--/menu-->
					</div>
				</div>
				<!--/menu content-->
			</div>
		</div>
	</div>	
	