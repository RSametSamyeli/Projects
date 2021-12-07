<div class="modal fade" id="adrespop">
	  <div class="modal-dialog modal-lg">
		  <div class="modal-content">
			  <div class="modal-header">
				<a class="close" data-dismiss="modal">×</a>
				<h3>Sipariş Öncesi</h3>
			  </div>
			  <div class="modal-body">
					<div class="tamamla-sol">
						<div class="adres-secimi">
							<div class="title">
								<i class="fa fa-map-signs" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Adres Bilgileri</h3>
									<span>Tercih Ettiğiniz Adresleri Seçin</span>
								</div>
							</div>
							<div class="secim-content">
								<?php if($adreslerCount > 0) { ?>
								<div class="col-sm-6 col-xs-12">
									<div class="adres-select">
										<h5>Teslimat Adresi</h5>
										<select name="teslimatadresi" class="form-control teslimat-adresi" id="">
											<?php foreach($adreslerFetch as $row){?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>  - <?php echo $row['adres']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="adres-select">
										<h5>Fatura Adresi</h5>
										<select name="faturaadresi" class="form-control fatura-adresi" id="">
											<?php foreach($adreslerFetch as $row){?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> - <?php echo $row['adres']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="adres-disable">
									<label>
										<input type="checkbox" name="adres_disable" value="adresdisable">
										  Fatura bilgilerim teslimat bilgilerim ile aynı olsun
									</label>
								</div>
								<?php  } else { ?>
									<div class="adres-tanimla">
										Kayıtlı Adres Bulunmuyor. <a href="<?php echo $set['siteurl']; ?>/<?php echo $sef_adres_link[$set['lang']['active']]; ?>/ekle">Adres Eklemek İçin Tıklayın.</a>
									</div>
								<?php } ?>
							</div>
						</div>
						<!--/adres-->
						<?php if($kargolarCount > 0 ) {?>
						<div class="kargo-secimi">
							<div class="title">
								<i class="fa fa-truck" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Kargo Seçenekleri</h3>
									<span>Tercih Ettiğiniz Kargoyu Seçiniz</span>
								</div>
							</div>
							<div class="kargo-list">
								
								<ul>
									<?php 
									
									$i = 0;
									foreach($kargolarFetch as $row) { 
									$i++;
									$kampanya_durum = $row['kampanya_durum'];
									$kampanya_toplam = $row['kampanya_toplam'];
									if($kampanya_durum == 1){
										if( number_format($genelToplam,2) >= number_format($kampanya_toplam,2)) {
											$kargoucret = $row['kampanya_ucret'];
										}else{
											$kargoucret = $row['kargoucret'];
										}
									}else{
										$kargoucret = $row['kargoucret'];
									}
									?>
									<li>
										<label>
											<div class="kargoinput">
												<input type="radio" <?php echo $i == 1 ? ' checked ' : null; ?> id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" name="kargosecenek" />
											</div>
											<div class="kargoimg">
												<img src="<?php echo $set['siteurl']; ?>/uploads/kargo/<?php echo $row['image']; ?>" alt="<?php echo $row['firmaadi']; ?>" />
											</div>
											<div class="kargoname">
												<?php echo $row['firmaadi']; ?> - <div class="kargo-price"><?php echo $kargoucret; ?></div> TL
											</div>
										</label>
									</li>
									 <?php } ?>
								</ul>
								
							</div>
						</div>
						<?php  } ?>
						<!--/kargo-->
						<div class="siparis-notu">
							<div class="title">
								<i class="fa fa-pencil" aria-hidden="true"></i>
								<div class="title-right">
									<h3>Sipariş Notu</h3>
									<span>Sipariş ile belirtmek istediğiniz notlar.</span>
								</div>
							</div>
							<textarea name="siparisnot" class="form-control" id="" cols="0" rows="0"></textarea>
						</div>
					</div>
			  </div>
			  <div class="modal-footer">
				<a class="btn btn-primary" data-dismiss="modal">Kapat</a>
			  </div>
			  <input type="hidden" name="kdv" value="<?php echo $kdv; ?>" />
			  <input type="hidden" name="kdvsiztutar" value="<?php echo number_format($genelToplam,2); ?>"  />
			  <input type="hidden" name="oid" value="<?php  echo $oid; ?>">	
		  </div>
	  </div>
</div>