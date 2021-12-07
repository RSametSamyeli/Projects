<?php if( !defined("SABIT") ){ exit; }

if( (empty($get2)) || ( $get2 == $lang['yardimci']['sayfa'] ) ){  
	## With cat && without cat
	if($def["albumleme"] != "pasif") {
		if($def["galerisablon"] != "isotope") {
			include "include/modules/galeri/kat/galeri.php";	
		}else{
			include "include/modules/galeri/isotope/isotope.php";	
		}
	}else{
		include "include/modules/galeri/unkat/tekgaleri.php";
	}
}else if( (!empty($get3)) && ( $get3 != $lang['yardimci']['sayfa'] ) ){ 
		if($def["galeridetay"] == "v1"){
			include "include/modules/galeri/detay/detay.php";
		}else if($def["galeridetay"] == "v2"){
			include "include/modules/galeri/detay/detay2.php";
		}else{
			include "include/modules/galeri/detay.php";
		}
		
}else if( (!empty($get2)) && ( $get2 != $lang['yardimci']['sayfa'] ) ){ 
	if($def["albumleme"] != "pasif") { 
		include "include/modules/galeri/kat/album.php";
	}else{
		if($def["galeridetay"] == "v1"){ 
			include "include/modules/galeri/unkat/tekdetay.php";
		}else{
			include "include/modules/galeri/unkat/tekdetay2.php";
		}
		
	}
	
}else{
		echo 'ana yer 4';
	## With cat && without cat
	/*
	if($def["albumleme"] != "pasif") {
		include "include/modules/galeri/galeri.php";
	}else{
		include "include/modules/galeri/unkat/tekgaleri.php";
	}
	*/
}
?>

