<?php if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
$veriler =  explode(",",$_POST["alldelete"]);
error_reporting(0);
if( count($veriler) < 1 ){ echo "Eksik veya Hatalı veri"; exit; }

## Cache Sil
rrmdir("../../cache/anasayfa");

 // Sayı Eşitlik Kontrolü 

$son = str_repeat("?,", count($veriler)-1).'?'; 
$query = $conn -> prepare("select * from blog where id IN (".$son.") ");
$query -> execute($veriler);
$dbsayi  = $query -> rowCount();
if( $dbsayi != count($veriler) ){ echo "hatalı veri."; exit;}

// Resimleri Sil

		foreach($query as $x){
			
			// Resimleri Sil
			$resimler = unserialize($x['resimler']);
			$basliklar = unserialize($x['baslik']);
			$pdfler 	= unserialize($x'planresimler']);
			foreach($resimler as $resim){
				if ( file_exists("../../uploads/blog/large/".$resim) ){
				 $resimsil = @unlink("../../uploads/blog/large/".$resim);
				 $resimsil = @unlink("../../uploads/blog/thumb/".$resim);
				}
			}
			## Pdf Sil
			foreach( $pdfler as $dil ){
				foreach( $dil as $x ){
					$pdfsil = $x['file'];
					@unlink("../../uploads/blog/dosya/{$pdfsil}");	
				}
			}
		
			// Logs		
			$log = $conn -> prepare("INSERT INTO log SET 
			 baslik 	 = :baslik,
			 kim 	 	 = :kim,
			 durum		 = :durum,
			 tur 		 = :tur,
			 tarih 		 = :tarih
			 ");

			$log -> execute(array(
				"baslik" 		=> $basliklar['tr'],
				"kim"			=> $_SESSION["admin_user"],
				"durum"			=> "silindi",
				"tur"			=> "blog",
				"tarih"	 		=> date("d.m.Y H:i")
			));
		}

foreach( $veriler as $x ){
	$sil_sql = $conn -> prepare("delete from blog where id = :id");
	$sil = $sil_sql -> execute(array("id" =>$x));
	if( !$sil){ echo "hata2"; exit; }
}

?>1