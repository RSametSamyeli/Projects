<?php
   include "../lab/function.php";
   include("../dil/".$set["lang"]['active'].".php");
   header("Content-type: text/xml; charset=utf8");
   echo '<?xml version="1.0" encoding="utf-8"?>
   <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
   <channel>
      <title>Date Feed Title</title>
      <link>https://saklicekmecem.com/</link>
      <description>Data Feeds Google</description>';
      $pubDate= date("D, d M Y H:i:s");
      $urunler  =  $conn -> query("SELECT * FROM urun");
      
   if( $urunler -> rowCount() > 0 ){
         
       foreach( $urunler as $row )
         {
			$rowX_baslik   = unserialize($row['baslik']);		
			$images       = unserialize($row['resimler']);		
			if(empty($rowX_desc['tr'])){
				$rowX_desc = $set['seo']['d'];
			}else{
				$rowX_desc 	   = unserialize($row['description']);
				$rowX_desc     = $rowX_desc['tr'];
			}
			$rowX_sef 	   = unserialize($row['sef']);
			$stok = '';
			$markabul = $conn -> query('select * from marka where id = '.intval($row['marka_id']))->fetch();
			$varyant  = $conn -> query('select * from urunvaryants where urunid = '.intval($row['id']))->fetch();
			$varyantdeger = $conn -> query('select * from varyant where kat_id = 104 && id = '.intval($varyant['varyantdeger']))->fetch();
			$vname = unserialize($varyantdeger['baslik']);
			$katbul  = $conn -> query("select * from kategori where id = ".intval($row['katid']))->fetch();
			$katname = unserialize($katbul['baslik']);;
		  echo '<item>
               <g:id>'.$row['id'].'</g:id>
			  
			   <title><![CDATA['.$rowX_baslik[$set['lang']['active']].']]></title>
               <link><![CDATA['.$map.'/'.$detaysef_urunler_link[$set['lang']['active']].'/'.$rowX_sef[$set['lang']['active']].'-'.$row['id'].']]></link>
               '; 
			   if($row['fiyat'] != 0.00){ 
				echo '
				<g:price>'.number_format($row['fiyat'],2).' TRY</g:price>
			   <g:sale_price>'.number_format($row['yenifiyat'],2).' TRY</g:sale_price>
				';
			   }else {
				   echo '<g:price>'.number_format($row['yenifiyat'],2).' TRY</g:price>';
			   }
			   echo '
			   
			   <description><![CDATA['.strip_tags($rowX_desc).']]></description>
               <g:image_link><![CDATA['.$set['siteurl'].'/uploads/urun/large/'.$images[0].']]></g:image_link>
			   <g:condition>new</g:condition>
			   <g:google_product_category>1604</g:google_product_category>
			   <g:adult>yes</g:adult> 
			    <g:age_group>adult</g:age_group> 
			    <g:size_system>EU</g:size_system> 
			   ';
			 
			   if($row['stok'] > 0) {
				   echo '<g:availability>in stock</g:availability>';
			   }else {
				     echo '<g:availability>out of stock</g:availability>';
				   
			   }
			   if($markabul){
				   $name = unserialize($markabul['baslik']);
				   echo '<g:brand>'.$name['tr'].'</g:brand>';
			   }
			    if(!empty($vname['tr'])){
				echo '<g:size>'.$vname['tr'].'</g:size>';
				}
			  echo '
			 
            </item>';
         }
   } 


	echo '
   </channel>
   </rss>';