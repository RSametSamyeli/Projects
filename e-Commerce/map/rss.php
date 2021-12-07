<?php
   include "../lab/function.php";
   include("../dil/".$set["lang"]['active'].".php");
   header("Content-type: text/xml; charset=utf8");
   echo '<?xml version="1.0" encoding="utf-8"?>
   <rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
   <channel>
      <title>'.$set['seo']['t'].'</title>
      <link>'.$map.'</link>
      <description>'.$set['seo']['d'].'</description>';
      $pubDate= date("D, d M Y H:i:s");
      $urunler  =  $conn -> query("SELECT * FROM urun");
	  $projeler =  $conn -> query("SELECT * FROM proje");
	  $haberler =  $conn -> query("SELECT * FROM haber");
	  $sayfalar =  $conn -> query("SELECT * FROM sayfa");
      
   if( $urunler -> rowCount() > 0 ){
         
       foreach( $urunler as $row )
         {
			$rowX_baslik   = unserialize($row['baslik']);		
			$rowX_aciklama = unserialize($row['aciklama']);		
			$rowX_sef 	   = unserialize($row['sef']);
			
            echo '<item>
               <title>'.$rowX_baslik[$set['lang']['active']].'</title>
               <link>'.$map.'/'.$detaysef_urunler_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'/'.$row['id'].'</link>
               <description><![CDATA['.strip_tags(html_entity_decode($rowX_aciklama[$set['lang']['active']])).']]></description>
               <pubDate>'.$pubDate.'</pubDate>
            </item>';
         }
   } 
 if( $projeler -> rowCount() > 0 ){
         
       foreach( $projeler as $row )
         {
			$rowX_baslik   = unserialize($row['baslik']);		
			$rowX_aciklama = unserialize($row['aciklama']);		
			$rowX_sef 	   = unserialize($row['sef']);
			
            echo '<item>
               <title>'.$rowX_baslik[$set['lang']['active']].'</title>
               <link>'.$map.'/'.$detaysef_projeler_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'/'.$row['id'].'</link>
               <description><![CDATA['.strip_tags(html_entity_decode($rowX_aciklama[$set['lang']['active']])).']]></description>
               <pubDate>'.$pubDate.'</pubDate>
            </item>';
         }
   }
 if( $haberler -> rowCount() > 0 ){
         
       foreach( $haberler as $row )
         {
			$rowX_baslik   = unserialize($row['baslik']);		
			$rowX_aciklama = unserialize($row['aciklama']);		
			$rowX_sef 	   = unserialize($row['sef']);
			
            echo '<item>
               <title>'.$rowX_baslik[$set['lang']['active']].'</title>
               <link>'.$map.'/'.$detaysef_haber_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'/'.$row['id'].'</link>
               <description><![CDATA['.strip_tags(html_entity_decode($rowX_aciklama[$set['lang']['active']])).']]></description>
               <pubDate>'.$pubDate.'</pubDate>
            </item>';
         }
   }    
    if( $sayfalar -> rowCount() > 0 ){
         
       foreach( $sayfalar as $row )
         {
			$rowX_baslik   = unserialize($row['baslik']);		
			$rowX_aciklama = unserialize($row['aciklama']);		
			$rowX_sef 	   = unserialize($row['sef']);
			
            echo '<item>
               <title>'.$rowX_baslik[$set['lang']['active']].'</title>
               <link>'.$map.'/'.$detaysef_kurumsal_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'/'.$row['id'].'</link>
               <description><![CDATA['.strip_tags(html_entity_decode($rowX_aciklama[$set['lang']['active']])).']]></description>
               <pubDate>'.$pubDate.'</pubDate>
            </item>';
         }
   }   
   echo '<item>
               <title>'.$sef_iletisim_baslik[$set['lang']['active']].'</title>
               <link>'.$map.'/'.$sef_iletisim_link[$set['lang']['active']].'</link>
               <pubDate>'.$pubDate.'</pubDate>
            </item>';
   echo '<footer>'.$set['seo']['d'].'</footer>
   </channel>
   </rss>';