<?php 
require_once "../lab/function.php";
include("../dil/".$set["lang"]['active'].".php");
$urunler      =  $conn -> query("SELECT * FROM urun");
$projeler     =  $conn -> query("SELECT * FROM proje");
$haberler     =  $conn -> query("SELECT * FROM haber");
$sayfalar     =  $conn -> query("SELECT * FROM sayfa");
$bloglar      =  $conn -> query("SELECT * FROM blog");
$etkinlikler  =  $conn -> query("SELECT * FROM etkinlik");
$duyurular    =  $conn -> query("SELECT * FROM duyuru");
$hizmetler    =  $conn -> query("SELECT * FROM hizmet");
$date = date("Y-m-d");

header("Content-Type: text/xml;charset=UTF-8");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";?>

<urlset 
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php 
echo '
<url>
	<loc>https://www.saklicekmecem.com</loc>
	 <changefreq>Daily</changefreq>
</url>';
			

if( $urunler -> rowCount() > 0 ){
	foreach( $urunler as $row ){
		$rowX_sef = unserialize($row['sef']);
		echo '<url>
				<loc>'.$map.'/'.$detaysef_urunler_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'-'.$row['id'].'</loc>
				<lastmod>'.$date.'</lastmod>
				 <changefreq>always</changefreq> 
				  <priority>0.5</priority> 
			</url>';
	}
}


if( $sayfalar -> rowCount() > 0 ){
	foreach( $sayfalar as $row ){
		$rowX_sef = unserialize($row['sef']);
		echo '<url>
				 <loc>'.$map.'/'.$detaysef_kurumsal_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'-'.$row['id'].'</loc>
				 <lastmod>'.$date.'</lastmod>
				  <changefreq>always</changefreq> 
				  <priority>0.5</priority> 
			 </url>';
	}
}


	echo '
		<url>
			<loc>'.$map.'/'.$sef_iletisim_link[$set['lang']['active']].'</loc>
			 <changefreq>Daily</changefreq>
			  <priority>0.5</priority> 
		</url>';
echo '</urlset>';
?>