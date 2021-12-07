<?php
ob_start();
session_start();
include '../netting/baglan.php';
date_default_timezone_set('Europe/Istanbul');


//Yorum
$yorumsor=$db->prepare("SELECT * FROM yorumlar where yorum_onay=:yorum_onay");
$yorumsor->execute(array(
  'yorum_onay'=>0
  ));


//Belirli veriyi seçme işlemi
$ayarsor=$db->prepare("SELECT * FROM ayar WHERE ayar_id=:id");
$ayarsor->execute(array(
  'id'=>0
  ));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

$kullanicisor=$db->prepare("select * from kullanici where kullanici_ad=:ad");
$kullanicisor->execute(array(
  'ad' => $_SESSION['kullanici_ad']
  ));

$say=$kullanicisor->rowCount();

if ($say==0) {

 header("Location:login.php?durum=izinsiz");
 exit;
}

$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <!-- Twitter -->
  <meta name="twitter:site" content="@sametsamyeli2">
  <meta name="twitter:creator" content="@sametsamyeli2">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Samyeli CMS">
  <meta name="twitter:description" content=" Samyeli Profesyonel Yönetim Sistemi">
  <meta name="twitter:image" content="http://bracketplus.themepixels.me/img/bracketplus-social.png">

  <!-- Facebook -->
  <meta property="og:url" content="http://sametsamyeli.com">
  <meta property="og:title" content="Samyeli Profesyonel Yönetim Sistemi">
  <meta property="og:description" content="Tamamen Profesyonel Olarak Hazırlanmış Samyeli Yönetim Sistemi">

  <!-- Meta -->
  <meta name="description" content="Tamamen Profesyonel Olarak Hazırlanmış Samyeli Yönetim Sistemi">
  <meta name="author" content="Samet Samyeli">

  <title><?php echo $ayarcek['ayar_title'] ?> Yönetim Paneli</title>

  <!-- vendor css -->
  <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="../lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="../lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="../lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="../lib/chartist/chartist.css" rel="stylesheet">
  <!--CK Editor-->
  <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <!-- Bracket CSS -->
  <link rel="stylesheet" href="../css/bracket.css">
  <!-- Dropzone.js -->
  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <!-- Dropzone.js -->
  <script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">


</head>

<body>

  <?php include 'sidebar.php'; ?>

  <!-- ########## START: HEAD PANEL ########## -->
  <div class="br-header">
    <div class="br-header-left">
      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
      <nav class="nav">

<!-- Yorum Bildirim
        <div class="dropdown">
          <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
            <i class="icon ion-ios-email-outline tx-24"></i>


            <?php if ($yorumcek['yorum_onay']==0) {?>

            <!-- start: if statement --
            <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
            <!-- end: if statement --
            <?php  } ?>-->


          </a>
          <div class="dropdown-menu dropdown-menu-header wd-300 pd-0-force">
            <div class="d-flex align-items-center justify-content-between pd-y-10 pd-x-20 bd-b bd-gray-200">
            </div><!-- d-flex -->

            <div class="media-list"></div><!-- media-list -->
          </div><!-- dropdown-menu -->
        </div>


        <div class="dropdown">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name hidden-md-down"><?php echo $kullanicicek['kullanici_adsoyad']; ?></span>
            <img src="http://via.placeholder.com/64x64" class="wd-32 rounded-circle" alt="">
            <span class="square-10 bg-success"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-header wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a href="kullanici-profil.php"><i class="icon ion-star"></i> Kullanıcı Paneli</a></li>
              <li><a href="logout.php"><i class="icon ion-power"></i> Çıkış Yap</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </nav>
      <!-- navicon-right -->
    </div><!-- br-header-right -->
  </div><!-- br-header -->

