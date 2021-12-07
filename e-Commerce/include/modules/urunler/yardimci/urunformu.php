<?php if( !defined("SABIT") ){ exit; } ?>
	<div class="cihaniriboy-urun-form clearfix">
		<div class="cihaniriboy-success-msg-content">
			<div class="cihaniriboy-succes-message animated">
				<div class="ci-icon-content">
					<i class="fa fa-check"></i>
				</div>
				<div class="ci-success-text">
					<?php echo $lang['mesaj']["bayi_ok"]; ?>
				</div>
			</div>
		</div>
	<div class="form-absolute animate_start d4 clearfix">	
		<form action="#" id="urunform" method="POST">
			<div class="form-group">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				 <label><?php echo $lang['iletisim']['adsoyad']; ?></label>	
				  <input class="form-control input-sm" type="text" name="adsoyad">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				 <label><?php echo $lang['iletisim']['telefon']; ?></label>	
				  <input class="form-control input-sm" id="phone" name="telefon" type="text">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				 <label>E-Mail</label>	
				  <input class="form-control input-sm" name="email" type="text">
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				 <label><?php echo $lang['iletisim']['konu']; ?></label>	
				  <select name="konu" class="selectboxit" data-first-option="false">
					<option value=""><?php echo $lang['iletisim']['konu']; ?></option>
					<option value="Siparis"><?php echo $lang['iletisim']['siparis']; ?></option>
					<option value="Destek"><?php echo $lang['iletisim']['destek']; ?></option>
					<option value="Şikayet"><?php echo $lang['iletisim']['sikayet']; ?></option>
					<option value="Öneri"><?php echo $lang['iletisim']['oneri']; ?></option>
				  </select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				 <label><?php echo $lang['yardimci']['urun_kodu']; ?></label>	
				  <input class="form-control input-sm" name="urunkodu" placeholder="<?php echo $bul["kod"];?>" id="disabledInput" type="text" disabled>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 <label><?php echo $lang['iletisim']['mesaj']; ?></label>	
				  <textarea name="mesaj"></textarea>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="cihaniriboy-form-gonder">
					<div class="form-sag">
						<span><?php echo $lang['iletisim']['guvenlik_kodu']; ?></span>
						<?php $md5 = md5(rand(0,999));  
							  $pass = substr($md5, 10, 4); 
							  $_SESSION["guv"] = true;
							  $_SESSION["guv"] = $pass;
								?>
						<div class="codem"><?php echo $pass; ?></div>
						<div class="g-input"><input type="text" name="guvenlik" /><input type="hidden" name="urunkodu"  value="<?php echo $bul['kod'];?>"/></div>
							<div class="g-send">
								<button type="submit" class="g-gonder"><?php echo $lang['yardimci']['gonder']; ?></button>
							</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="urun-errors">
					
				</div>
			</div>
			<div class="clear"></div>
		</form>
		</div>
	</div>