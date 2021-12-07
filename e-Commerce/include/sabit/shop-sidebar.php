<?php if( !defined("SABIT") ){ exit; }  ?>
<ul class="hidden-print">
	<li><a <?php echo $get1 == $sef_profilim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>"><i class="fa fa-user"></i> Üyelik Bilgilerim</a></li>
	<li><a <?php echo $get1 == $sef_adres_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>"><i class="fa fa-map-signs" aria-hidden="true"></i> Adreslerim</a></li>
	<li><a <?php echo $get1 == $sef_sifre_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_sifre_link[$set['lang']['active']]; ?>"><i class="fa fa-key"></i> Şifremi Değiştir</a></li>
	<li><a <?php echo $get1 == $sef_siparislerim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>"><i class="fa fa-bell"></i>Siparişlerim</a></li>
	<li><a href="<?php echo $set['langurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>"><i class="fa fa-shopping-cart"></i>Alışveriş Sepetim</a></li>
	<li><a <?php echo $get1 == $sef_destek_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>"><i class="fa fa-life-ring"></i> Destek Taleplerim</a></li>
	<li><a <?php echo $get1 == $sef_kuponlarim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_kuponlarim_link[$set['lang']['active']]; ?>"><i class="fa fa-money" aria-hidden="true"></i>Kuponlarım</a></li>
	<li><a <?php echo $get1 == $sef_favorilerim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_favorilerim_link[$set['lang']['active']]; ?>"><i class="fa fa-heart" aria-hidden="true"></i>Favorilerim</a></li>
	<li><a <?php echo $get1 == $sef_fiyatalarm_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_fiyatalarm_link[$set['lang']['active']]; ?>"><i class="fa fa-clock-o" aria-hidden="true"></i>Fiyat Alarm Listem</a></li>
	<?php if($main_settings['kredisistemi'] == 1) {?>
	<li><a <?php echo $get1 == $sef_kredilerim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $sef_kredilerim_link[$set['lang']['active']]; ?>"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Kredilerim</a></li>
	<?php  } ?>
	<li><a <?php echo $get1 == $sef_havalebildirimi_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['langurl']; ?>/<?php echo $detaysef_havalebildirimi_link[$set['lang']['active']]; ?>"><i class="fa fa-university" aria-hidden="true"></i>Eft & Havale Bildirimi</a></li>
	<li><a href="#" class="log-out"><i class="fa fa-sign-out" aria-hidden="true"></i>Çıkış Yap</a></li>
</ul>