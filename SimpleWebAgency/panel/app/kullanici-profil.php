<?php 
include 'header.php';
include '../netting/baglan.php';

$iceriksor=$db->prepare("SELECT * from icerik where icerik_id=:icerik_id");
$iceriksor->execute(array(
  'icerik_id' => $_GET['icerik_id']
  ));
$icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC);

?>
<head>  
  <script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
</head>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Yönetici Kullanıcı</h4>
    <p class="mg-b-0">Bu bölüm de yönetici kullanıcı bilgilerinizi değiştirebilirsiniz.</p>



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
form-group row row row row row row row row row row row row
col-md-10 / col-md-10 
-->


<div>
 <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Resmi<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

      <?php 
      if (strlen($kullanicicek['kullanici_resim'])>0) {?>

      <img width="150"  src="../../<?php echo $kullanicicek['kullanici_resim']; ?>">

      <?php } else {?>


      <img width="150"  src="../../dimg/kullanici-resim-yok.jpg">


      <?php } ?>

      
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="file" id="first-name"  name="kullanici_resim"  class="form-control col-md-10 col-xs-12">
    </div>
  </div>

  <input type="hidden" name="eski_yol" value="<?php echo $kullanicicek['kullanici_resim']; ?>">
  <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">


  <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
    <button type="submit" name="kresimduzenle" class="btn btn-primary">Güncelle</button>
  </div>

</form>





<!-- ######################################## -->





<hr>
<form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Adı<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="first-name" required="required" disabled="" name="kullanici_ad" value="<?php echo $kullanicicek['kullanici_ad']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Ad Soyad<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="first-name" required="required"  name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>

  <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">


  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Şifre<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="password" id="first-name" required="required"  name="kullanici_password" value="<?php echo $kullanicicek['kullanici_password']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>








  <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
    <button type="submit" name="kullaniciprofilkaydet" class="btn btn-primary">Güncelle</button>
  </div>

</form>



</div>

<!--Burada Bitecek-->




</div>
</div>



<?php include 'footer.php'; ?>