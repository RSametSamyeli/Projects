<?php include 'header.php'; 

$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_id=:id");
$kullanicisor->execute(array(
  'id'=>$_GET['kullanici_id']
));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>

<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel br-profile-page">

  <div class="card shadow-base bd-0 rounded-0 widget-4">
    <div class="card-header ht-75">
      <div class="tx-24 hidden-xs-down">
        <a href="" class="mg-r-10"><i class="icon ion-ios-email-outline"></i></a>
        <a href=""><i class="icon ion-more"></i></a>
      </div>
    </div><!-- card-header -->
    <div class="card-body">
      <div class="card-profile-img">
        <img src="
        <?php if (count($kullanicicek['kullanici_resim'])>0){
          echo $kullanicicek['kullanici_resim'];
        }else{
          echo "/user.png";
        }?>" alt="">
      </div><!-- card-profile-img -->
      <h4 class="tx-normal tx-roboto tx-white"><?php echo $kullanicicek['kullanici_adsoyad'] ?></h4>
      <p class="mg-b-25"><?php echo $kullanicicek['kullanici_meslek'] ?></p>

      <p class="wd-md-500 mg-md-l-auto mg-md-r-auto mg-b-25"><?php echo $kullanicicek['kullanici_cv'] ?></p>

      <p class="mg-b-0 tx-24">

        <?php if (strlen($kullanicicek['kullanici_facebook'])>0) {?>
        <a href="<?php echo $kullanicicek['kullanici_facebook'] ?>" class="tx-white-8 mg-r-5"><i class="fa fa-facebook-official"></i></a>
        <?php } ?>

        <?php if (strlen($kullanicicek['kullanici_instagram'])>0) {?>
        <a href="<?php echo $kullanicicek['kullanici_instagram'] ?>" class="tx-white-8 mg-r-5"><i class="fa fa-instagram-official"></i></a>
        <?php } ?>

      </p>
    </div><!-- card-body -->
  </div><!-- card -->

  <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center shadow-base">
    <ul class="nav nav-outline active-info align-items-center flex-row" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#photos" role="tab">Kullanıcı Ayarları</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#posts" role="tab">Yorumları</a></li>
    </ul>
  </div>

  <div class="tab-content br-profile-body">


    <div class="tab-pane fade" id="posts">
      <div class="row">
        <div class="col-lg-8">

          <?php 

          $yorumsor=$db->prepare("SELECT * FROM yorumlar WHERE kullanici_id=:id order by yorum_id DESC");
          $yorumsor->execute(array(
            'id' => $_GET['kullanici_id']
          ));


          $say=0;

          while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) { $say++?>

          <div class="media-list bg-white rounded shadow-base" style="margin-bottom: 10px;">



            <div class="media pd-20 pd-xs-30">
              <img src="<?php echo $kullanicicek['kullanici_resim']; ?>" alt="" class="wd-40 rounded-circle">
              <div class="media-body mg-l-20">
                <div class="d-flex justify-content-between mg-b-10">
                  <div>
                    <h6 class="mg-b-2 tx-inverse tx-14"><?php echo $yorumcek['konu'] ?></h6>
                    <span class="tx-12 tx-gray-500"><?php echo $kullanicicek['kullanici_mail'] ?></span>
                  </div>

                  <?php 

                  $zaman=explode(" ",$yorumcek['yorum_zaman']); ?>

                  <span class="tx-12"><?php echo $zaman[0] ?></span>
                </div><!-- d-flex -->
                <p class="mg-b-20"><?php echo htmlspecialchars($yorumcek['yorum_detay']) ?></p>


                <div class="media-footer">
                  <div>
                    <a href="" class="mg-l-10"><i class="fa fa-comment"></i></a>
                    <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorumsil=ok" class="mg-l-10"><i class="fa fa-trash"></i></a>
                  </div>
                </div>


              </div>
            </div>
          </div>
          <?php  }

          ?>


        </div><!-- col-lg-8 -->
        <div class="col-lg-4 mg-t-30 mg-lg-t-0">
          <div class="card pd-20 pd-xs-30 shadow-base bd-0">
            <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">İletişim Bilgileri</h6>

            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Cep Telefon Numaras:</label>
            <p class="tx-info mg-b-25"><?php echo $kullanicicek['kullanici_gsm']; ?></p>

            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">E-Posta Adresi:</label>
            <p class="tx-inverse mg-b-25"><?php echo $kullanicicek['kullanici_mail']; ?></p>

            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Adres:</label>
            <p class="tx-inverse mg-b-25"><?php echo $kullanicicek['kullanici_adres']; ?> - <?php echo $kullanicicek['kullanici_ilce']; ?>/<?php echo $kullanicicek['kullanici_il']; ?></p>


          </div><!-- card -->
        </div><!-- col-lg-4 -->
      </div><!-- row -->
    </div><!-- tab-pane -->


    <div class="tab-pane fade active show" id="photos">
      <div class="row">
        <div class="col-lg-12">
          <div class="card pd-20 pd-xs-30 shadow-base bd-0 mg-t-30">



            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık ../netting/islem.php--> 
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">



              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ad-Soyad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telefon Numarası <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_gsm" value="<?php echo $kullanicicek['kullanici_gsm'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <br>
              <h4>Adres Bilgileri</h4><hr><br>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İl<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_il" value="<?php echo $kullanicicek['kullanici_il'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İlçe<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_ilce" value="<?php echo $kullanicicek['kullanici_ilce'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Adres<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_adres" value="<?php echo $kullanicicek['kullanici_adres'] ?>"  class="form-control col-md-11 col-xs-12">
                </div>
              </div>



              <h4>Üyelik Durumu</h4><hr><br>

              <?php 

              $zaman=explode(" ",$kullanicicek['kullanici_zaman']); ?>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Tarihi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="date" id="first-name" disabled="" name="kullanici_zaman" value="<?php echo $zaman[0] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yetki <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" disabled="" name="kullanici_yetki" value="<?php 
                  if ($kullanicicek['kullanici_yetki']==5) {
                    echo "Yönetici";
                  }else{
                    echo "Üye";
                  }

                  ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><i style="color: green">MD5 Şifre Değiştir</i><span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="kullanici_password" value="<?php echo $kullanicicek['kullanici_password'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail Adresi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" disabled="" id="first-name" name="kullanici_mail" value="<?php echo $kullanicicek['kullanici_mail'] ?>"   class="form-control col-md-11 col-xs-12">
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Durumu <span class="required">*</span>
                </label>              
                <div class="col-md-5 col-sm-6 col-xs-12">
                  <select id="heard" class="form-control" name="kullanici_durum" required">

                    <option value="1" <?php echo $kullanicicek['kullanici_durum'] == '1' ? 'selected=""' : '';?>>Aktif</option>

                    <option value="0" <?php echo $kullanicicek['kullanici_durum'] == '0' ? 'selected=""' : '';?>>Pasif</option>
                  </select>
                </div>
              </div>




              <input type="text" hidden="" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">


              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-8 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="kullaniciduzenle" class="btn btn-success">Güncelle</button>
                </div>
              </div>

            </form>
          </div><!-- card -->
        </div><!-- col-lg-8 -->
      </div><!-- row -->
    </div><!-- tab-pane -->
  </div><!-- br-pagebody -->

</div><!-- br-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->

<script src="../lib/jquery/jquery.js"></script>
<script src="../lib/popper.js/popper.js"></script>
<script src="../lib/bootstrap/bootstrap.js"></script>
<script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="../lib/moment/moment.js"></script>
<script src="../lib/jquery-ui/jquery-ui.js"></script>
<script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>
<script src="../lib/peity/jquery.peity.js"></script>

<script src="../js/bracket.js"></script>
</body>
</html>
