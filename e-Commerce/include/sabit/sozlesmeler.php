<?php if( !defined("SABIT") ){ exit; }  ?>	
	<div id="myModal" class="modal fade sozlesme-modal" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			  <div class="modal-header">
				
					<h4 class="modal-title">Ön Bilgilendirme Formu</h4>
			  </div>
			  <div class="modal-body">
				<?php echo html_entity_decode($onsozlesme); ?>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Kapat </button>
			  </div>
		</div>

	  </div>
	</div>
	<!-- Modal2 -->
	<div id="myModal2" class="modal fade sozlesme-modal" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			
				<h4 class="modal-title">Mesafeli Satış Sözleşmesini </h4>
		  </div>
		  <div class="modal-body">
					<?php 
			$tb1 = "<table class='table table-condensed' style='1px solid red;'>
				<tbody>	
					<tr>
						<td>
							<p>Ürün Bilgileri</p>
						</td>
						<td>
							<p>Adet</p>
						</td>
						<td>
							<p>Birim Fiyat</p>
						</td>
						<td>
							<p>Toplam Fiyat</p>
						</td>
					</tr>
					";
					$genelToplam = 0;
					foreach(@$_SESSION["sepet"] as $row) { 
					$genelToplam += $row['adet'] * $row['arafiyat'];
					$urunCek  = $conn -> query("select * from urun where id =  " .intval($row['sepetid']))->fetch();
					$sef = unserialize($urunCek['sef']);
						 $tb1 .= '<tr>
								<td><p>'.$row['baslik'].'</p></td>
								<td><p>'.$row['adet'].'</p></td>
								<td><p>'.number_format($row['arafiyat'],2).' TL</p></td>
								<td><p>'.number_format($row['adet'] * $row['arafiyat'] , 2 ).' TL</p></td>
							</tr>';
						  }
					
					$tb1 .= '
					<tr>
						
						<td>
							
							<td colspan="2">
								<p>&nbsp;&nbsp;&nbsp;&nbsp; Ara Tutar</p>
							</td>
							<td width="132">
								<p>'.number_format($genelToplam,2).' TL</p>
							</td>
						</td>
					</tr>
					<tr>
						
						<td>
							
							<td colspan="2">
								<p>&nbsp;&nbsp;&nbsp;&nbsp; Kdv </p>
							</td>
							<td width="132">
								<p>'.number_format($kdv,2).' TL</p>
							</td>
						</td>
					</tr>
					<tr>
						<td>
							
							<td colspan="2">
								<p>&nbsp;&nbsp;&nbsp;&nbsp; Kargo Tutar</p>
							</td>
							<td width="132">
								<p>'.number_format($kargofiyat,2).' TL</p>
							</td>
						</td>
					</tr>
					<tr>
						<td>
							
							<td colspan="2">
								<p>&nbsp;&nbsp;&nbsp;&nbsp; Genel Toplam (KDV dahil)</p>
							</td>
							<td width="132">
								<p>'.number_format($anaTutar,2).' TL</p>
							</td>
						</td>
					</tr>';
					$tb1 .="</tbody></table>";
			$ssozlesme = html_entity_decode($satissozlesme);

			$arr1  = array('{%ALICI_ADISOYAD%}','{%ALICI_ADRES%}','{%ALICI_TELEFON%}','{%ALICI_EMAIL%}','{%SEPET_BILGILERI%}');

			$arr2  = array(
			'<font color="red">'.$uyebul['ad'].' '.$uyebul['soyad'].'</font>',
			'<font color="red">'.$uyebul['adres'].'</font>',
			'<font color="red">'.$uyebul['telefon'].'</font>',
			'<font color="red">'.$uyebul['email'].'</font>',
			$tb1
			);
			$regx = str_replace($arr1,$arr2,$ssozlesme);
			echo $regx;  ?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Kapat </button>
		  </div>
		</div>

	  </div>
	</div>