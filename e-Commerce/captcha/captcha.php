<?php 
session_start(); 
$width = 95; 
$height = 30; 
$im = imagecreate($width, $height); 
$bg = imagecolorallocate($im, 55,62,74); 

// generate random string 
$len = 5; 
$chars = '0123456789'; 
$string = ''; 
for ($i = 0; $i < $len; $i++) { 
$pos = rand(0, strlen($chars)-1); 
$string .= $chars{$pos}; 
} 

$_SESSION['GKod'] = md5($string); 

// write the text 
$text_color = imagecolorallocate($im, 250, 250, 250); 
$rand_x = 20; 
$rand_y = 7; 
imagestring($im, 18, $rand_x, $rand_y, $string, $text_color); 

header ("Content-type: image/png"); 
imagepng($im); 
?> 
