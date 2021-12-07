<?php
include("../../lab/function.php");
include("../../php-graph-sdk/src/Facebook/Facebook.php");
include("../../php-graph-sdk/src/Facebook/autoload.php");


$fb = new Facebook\Facebook([
    'app_id' => $fbayar['appId'],
    'app_secret' => $fbayar['secret']
]);
 
$helper = $fb->getRedirectLoginHelper();
 
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
 
if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        header('location:/');
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}
 

$oAuth2Client = $fb->getOAuth2Client();

$tokenMetadata = $oAuth2Client->debugToken($accessToken);

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,gender,email,first_name,last_name,cover', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
 
$user = $response->getGraphUser();

$userId 	= $user['id']; 
$userName 	= $user['name'];
$firstName 	= $user['first_name'];
$lastName 	= $user['last_name'];
$userMail 	= $user['email'];
$tarih          = time();
$uyekontrol = $conn -> query("select * from users WHERE fbid = '".$userId."' ")->fetch();

	if($uyekontrol['fbid'] == $userId){ 
		  $_SESSION["m_oturum"]    = true;
		  $_SESSION["m_adsoyad"]   = $uyekontrol["ad"]." ".$uyekontrol["soyad"];
		  $_SESSION["m_user"] 	   = sef_link($userName);
		  $_SESSION["m_id"] 	   = $uyekontrol["id"];
		  $_SESSION['m_anahtar']   = md5($_SERVER['HTTP_USER_AGENT']);
		  $_SESSION['fboturum']    = true;
		  header("Location:".$map.'/');
	}else{
		$sql = $conn -> prepare("INSERT INTO users SET
			name		= :name,
			password	= :password,
			email		= :email,
			telefon		= :telefon,
			rutbe		= :rutbe,
			ad          = :ad,
			soyad		= :soyad,
			tarih		= :tarih,
			fbid		= :fbid
			");
			
		$ekle = $sql -> execute(array(
			"name"      => sef_link($userName),
			"password"  => "",
			"email"     => $userMail,
			"telefon"	=> "",
			"rutbe"		=> 0,
			"ad"		=> $firstName,
			"soyad"		=> $lastName,
			"tarih"		=> $tarih,
			"fbid"		=> $userId
			));
			if($ekle){ 
				$yeniuye = $conn -> query("select * from users WHERE fbID = '".$userId."' ")->fetch();
				$_SESSION["m_oturum"]    = true;
				$_SESSION["m_adsoyad"]   = $yeniuye["ad"]." ".$yeniuye["soyad"];
				$_SESSION["m_user"] 	 = $yeniuye['username'];
				$_SESSION["m_id"] 	   	 = $yeniuye["id"];
				$_SESSION['m_anahtar']   = md5($_SERVER['HTTP_USER_AGENT']);
				$_SESSION['fboturum']    = true;
				
				header("Location:".$map.'');
			}else{
				
				echo 'Bir Sorun Oluştu';
			}
	}
 
//$_SESSION['fb_access_token'] = (string) $accessToken;
 

?>
