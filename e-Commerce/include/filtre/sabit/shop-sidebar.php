<?php if( !defined("SABIT") ){ exit; }  ?>
<ul class="hidden-print">
	<li><a <?php echo $get1 == $sef_profilim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['siteurl']; ?>/<?php echo $sef_profilim_link[$set['lang']['active']]; ?>"><i class="fa fa-user"></i> Üyelik Bilgilerim</a></li>
	<li><a <?php echo $get1 == $sef_adres_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['siteurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>"><i class="fa fa-map-signs" aria-hidden="true"></i> Adreslerim</a></li>
	<li><a <?php echo $get1 == $sef_sifre_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['siteurl']; ?>/<?php echo $sef_sifre_link[$set['lang']['active']]; ?>"><i class="fa fa-key"></i> Şifremi Değiştir</a></li>
	<li><a <?php echo $get1 == $sef_siparislerim_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['siteurl']; ?>/<?php echo $sef_siparislerim_link[$set['lang']['active']]; ?>"><i class="fa fa-bell"></i>Siparişlerim</a></li>
	<li><a href="<?php echo $set['siteurl']; ?>/<?php echo $sef_sepet_link[$set['lang']['active']]; ?>"><i class="fa fa-shopping-cart"></i>Alışveriş Sepetim</a></li>
	<li><a <?php echo $get1 == $sef_destek_link[$set['lang']['active']] ? ' class="active"' : null;  ?> href="<?php echo $set['siteurl']; ?>/<?php echo $sef_destek_link[$set['lang']['active']]; ?>"><i class="fa fa-life-ring"></i> Destek Taleplerim</a></li>
	<li><a href="#" class="log-out"><i class="fa fa-sign-out" aria-hidden="true"></i>Çıkış Yap</a></li>
</ul>