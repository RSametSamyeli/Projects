<?php if( !defined("SABIT") ){ exit; } 

?>
	<div class="kredi-karti">
			<div class="kredikarti-left">
				<div class="kart-bilgileri">
					<div class="form">
						<div class="form-group">
							<div class="col-sm-12 no-padding">
								<label>Kart Sahibinin Adı Soyadı</label>
							</div>
							<div class="col-sm-12 no-padding">
								<input type="text" class="form-control" id="cardadsoyad"  autocomplete="off"  name="cardadsoyad" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 no-padding">
								<label>Kredi Kartı Numarası</label>
							</div>
							<div class="col-sm-12 no-padding">
								<input type="text" class="form-control" maxlength="19" autocomplete="off" id="cardNumber" name="pan" />
							</div>
						</div>
						
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
									<label>Ay</label>
										<select class="form-control" id="ccAy" name="Ecom_Payment_Card_ExpDate_Month">
											<?php for($i = 1; $i <= 12; $i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											}?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Yıl</label>
										<select class="form-control" id="ccYil"  name="Ecom_Payment_Card_ExpDate_Year">
											<?php for($i = 2017; $i < 2036; $i++){
												echo '<option value="'.$i.'">'.$i.'</option>';
											}?>
												
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Cvc</label>
										<input type="text" autocomplete="off" onkeypress="return numbersonly(this, event)" maxlength="4" class="form-control" id="cvcNumber" autocomplete="off"   name="cv2" />
									
									</div>
								</div>
								
								<div class="ucdcontent">
									<div class="ucd-wrap">
										<label for="3d">
											<input type="checkbox" class="ucd" name="ucd" id="3d" value="ucs"/> <span> 3D Duvarını Kullanmak İstiyorum</span>
										</label>
										<a href="javascriptv:void(0)" data-toggle="popover2" data-placement="top" >?</a>
									</div>
								</div>	
								
							</div>
							
							<input type="hidden" name="force3ds" id="force3ds" />
							<input type="hidden" name="binNumber" id="binNumber" value="" />		
							<input type="hidden" name="cardAssociation" id="cardAssociation"  value="" />
							<input type="hidden" name="cardFamily" id="cardFamily" />
							<input type="hidden" name="bankName" id="bankName" />
							<input type="hidden" name="cardType" id="cardType" />
						
					</div>
				</div>
				<div class="taksit-tablosu">
					<div class="title"><h3>TAKSİT SEÇENEKLERİ</h3></div>
					<div class="taksitler">
						Taksit seçenekleri, kredi kartı bilgilerinizi girdikten sonra gelecektir.
					</div>
				
				</div>
			</div>
			<div class="kredi-karti-right hidden-xs hidden-sm">
				<div class="kredi-karti-content" id="kredi-karti-content">
					<div class="front" id="front">
						<span class="cartLogo"></span>
						<span class="cartNo"></span>
						<span class="cartDate">
							<em class="ay">05</em>/<em class="yil">2020</em>
						</span>
						<span class="cartName">Ad Soyad</span>
						<span class="cartType"></span>
					</div>
					<div class="back" id="back">
						<span class="cardCvc"></span>
					</div>
				</div>
			</div>
		</div>