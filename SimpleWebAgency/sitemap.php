<?php header('Content-type: application/xml; charset="utf8"',true); ?>



<urlset 



xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"

xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"

xmlns:example="http://www.example.com/schemas/example_schema">



<!-- namespace extension -->

<?php 

include "panel/app/fonksiyon.php";

include "panel/netting/baglan.php";





?>



<!-- Tekli Linkler -->

<url>

	<loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/hakkimizda</loc>

	<lastmod><?php echo date("Y-m-d"); ?></lastmod>

	<changefreq>daily</changefreq>

	<priority>1.00</priority>

</url>

<url>

	<loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/bize-ulasin</loc>

	<lastmod><?php echo date("Y-m-d"); ?></lastmod>

	<changefreq>daily</changefreq>

	<priority>1.00</priority>

</url>



<url>

	<loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/haberler</loc>

	<lastmod><?php echo date("Y-m-d"); ?></lastmod>

	<changefreq>daily</changefreq>

	<priority>1.00</priority>

</url>




<!-- Haber Linkler -->



<?php 



$iceriksor=$db->prepare("select * from icerik order by icerik_zaman DESC");
$iceriksor->execute();

while($icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC)) { ?>



<url>

	<loc>http://<?php echo $_SERVER['HTTP_HOST'];?>/haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?></loc>

	<lastmod><?php echo date("Y-m-d"); ?></lastmod>

	<changefreq>daily</changefreq>

	<priority>0.9</priority>

</url>



<?php } ?>



</urlset>