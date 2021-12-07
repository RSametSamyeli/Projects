<?php include 'header.php'; 

$kullanicisor=$db->prepare("SELECT * FROM kullanici WHERE kullanici_id=:id");
$kullanicisor->execute(array(
  'id'=>$_GET['kullanici_id']
  ));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Kullanıcı Ayarları</h4>
    <p class="mg-b-0">Kullanıcı Ayarlar sayfasından kayıtlı kullanıcıların işlemlerini düzenleyebilirsiniz.</p>



    <p class="mg-b-0">

      <?php
      if ($_GET['durum']=='ok') {?> 

      <div class="alert alert-success alert-bordered pd-y-20 animated bounce" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="icon ion-ios-checkmark alert-icon tx-52 mg-r-20 tx-success"></i>
          <div class="mg-t-20 mg-sm-t-0">
            <h5 class="mg-b-2 tx-success">Başarılı!</h5>
            <p class="mg-b-0 tx-gray">İsteğiniz başarılı bir şekilde kayıt oldu.</p>
          </div>
        </div>
      </div>

      <?php } elseif ($_GET['durum']=='no')  {?>

      <div class="alert alert-danger alert-bordered pd-y-20 animated bounce" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="icon ion-ios-close alert-icon tx-52 tx-danger mg-r-20"></i>
          <div class="mg-t-20 mg-sm-t-0">
            <h5 class="mg-b-2 tx-danger">Hata!</h5>
            <p class="mg-b-0 tx-gray">Ne yazık ki, işleminiz yapılırken bir hata gerçekleşti ve kayıt edilmedi.</p>
          </div>
        </div>
      </div>

      <?php } ?>

    </p>



  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">



<!--Buraya Yapıştırılacak
form-group row row row row row row row
col-md-10 / col-md-10 
-->


<div>



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
</div>
</div>

<!--Burada Bitecek-->



</div>
</div>


<?php include 'footer.php'; ?>