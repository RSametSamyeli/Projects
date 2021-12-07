<?php require_once 'header.php';
?>


<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
  <div class="pd-30">
    <h4 class="tx-gray-800 mg-b-5">Yönetim Paneli</h4>
    <p class="mg-b-0">Samyeli Yönetim Paneline hoşgeldiniz. Sol tarafta ki menüyü kullanarak rahatlıkla işlem yapabilirsiniz.</p>
  </div><!-- d-flex -->

  <div class="br-pagebody mg-t-5 pd-x-30">
    <div class="row row-sm">

      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="bg-primary rounded overflow-hidden">
          <div class="pd-25 d-flex align-items-center">
            <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Kullanıcı Sayısı</p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">

                <?php 
                $kullanicisor=$db->prepare("SELECT * FROM kullanici");
                $kullanicisor->execute(array());
                $kullanicisayi = $kullanicisor->rowCount();
                echo $kullanicisayi;?>


              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- col-3 -->
      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="bg-danger rounded overflow-hidden">
          <div class="pd-25 d-flex align-items-center">
            <i class="ion ion-star tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Yorum Sayısı</p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">

                <?php   
                $yorumsor=$db->prepare("select * from yorumlar");
                $yorumsor->execute(array());
                $yorumsayi = $yorumsor->rowCount();
                echo $yorumsayi;
                ?>

              </p>
            </div>
          </div>
        </div>
      </div>


      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="bg-teal rounded overflow-hidden">
          <div class="pd-25 d-flex align-items-center">
            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Haber Sayısı</p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">


                <?php  
                $iceriksor=$db->prepare("SELECT * FROM icerik");
                $iceriksor->execute(array());
                $iceriksayi = $iceriksor->rowCount();
                echo $iceriksayi; ?>
              </p>
            </div>
          </div>
        </div>
      </div>




      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="bg-br-primary rounded overflow-hidden">
          <div class="pd-25 d-flex align-items-center">
            <i class="ion ion-image tx-60 lh-0 tx-white op-7"></i>
            <div class="mg-l-20">
              <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Referans Sayısı</p>
              <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">
                <?php   
                $referanssor=$db->prepare("select * from referans");
                $referanssor->execute(array());
                $referanssayi = $referanssor->rowCount();
                echo $referanssayi;
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>


      <?php 

      $ayarsor=$db->prepare("select * from ayar WHERE ayar_goooglemap");
      $ayarsor->execute(array());
      $ayarsayi=$ayarsor->rowCount();

      $hakkimizdasor=$db->prepare("select * from hakkimizda");
      $hakkimizdasor->execute(array());
      $haksayi=$hakkimizdasor->rowCount();

      if ($menusayi>=3) {
        $msayi=15;
        if ($menusayi>=5) {
         $msayi=20;
       }
     }

     if ($slidersayi>=2) {
      $ssayi=15;
      if ($slidersayi>=3) {
        $ssayi=20;
      }
    }

    if ($iceriksayi>=5) {
      $isayi=20;
      if ($iceriksayi>=10) {
       $isayi=30;
     }
   }

   if ($referanssayi>=5) {
    $usayi=15;
  }elseif ($referanssayi>=10) {
    $usayi=25;
  }

  if ($ayarsayi>0) {
    $maps=30;
  }
  if ($logosayi>0) {
    $lsayi=20;
  }
  if ($haksayi>0) {
    $hsayi=20;
  }

  $topla = $msayi + $ssayi + $isayi + $usayi + $maps + $lsayi + $hsayi;

  if ($topla>=100) {
    $topla=100;
  }
  ?>



</div><!-- row -->


</div>
<?php require_once 'footer.php'; ?>