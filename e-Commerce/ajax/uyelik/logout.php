<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){ header("location:/"); exit; }
if( !defined("SABIT") ){ exit; }
if(!isset($_POST)) { echo 'hata-5'; exit;}
if($_SESSION["m_oturum"]){
	unset($_SESSION['m_oturum']);
	unset($_SESSION['m_adsoyad']);
	unset($_SESSION['m_user']);
	unset($_SESSION['m_id']);
	unset($_SESSION['m_anahtar']);
	unset($_SESSION['fboturum']);
	echo 'done';
}


?>