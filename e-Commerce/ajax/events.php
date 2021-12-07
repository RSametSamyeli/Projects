<?php
	if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/index.php"); exit; }
	if(!isset($_POST)){
		exit;
	}
	include('../lab/function.php');
	$takvim = $conn -> query('SELECT * FROM takvim');
    $datas = array();
	
	foreach($takvim as $row){
	   $name      = unserialize($row['baslik']);	
	   $aciklama  = unserialize($row['aciklama']);	
	   $aciklama = html_entity_decode($aciklama[$set['lang']['active']]);
	   $start = $row['tarih'];
	   $eventsArray['id'] =  $row['id'];
	   $eventsArray['title'] = $name[$set['lang']['active']];
	   $eventsArray['start'] = $start;
	   $eventsArray['description'] = $aciklama;
	   $eventsArray['resim'] = '<img src="'.$set['siteurl'].'/uploads/takvim/'.$row['resimler'].'" alt="'.$name[$set['lang']['active']].'" />';
	   $events[] = $eventsArray;
	}
	
	echo json_encode($events);

?>