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
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">İçerik İşlemleri</h4>
    <p class="mg-b-0">Bu bölüm de haber/içerik ayrıntılarını düzenleyebilirsiniz.</p>



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
form-group row row row row row row row row row row
col-md-10 / col-md-10 
-->
<div>
  <div>

    <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

     <div class="form-group row">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Yüklü Resim<span class="required">*</span>
      </label>
      <div class="col-md-10 col-sm-6 col-xs-12">
        <img width="200" height="100" src="../../<?php echo $icerikcek['icerik_resimyol']; ?>">
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
      </label>
      <div class="col-md-8 col-sm-3 col-xs-12">
        <input type="file" id="first-name"  name="icerik_resimyol"  class="form-control col-md-8 col-xs-12">
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Zaman<span class="required">*</span>
      </label>


      <div style="    margin-left: 16px;
      width: 632px;
      display: inline-flex;
      margin-right: 10px;">
      <?php $zaman=explode(' ',$icerikcek['icerik_zaman']); ?>
      <input type="date" id="first-name" value="<?php echo $zaman[0]; ?>" name="icerik_tarih" class="form-control col-md-4 col-xs-12">--



      <input type="time" id="first-name" value="<?php echo $zaman[1]; ?>" name="icerik_saat"  class="form-control col-md-4 col-xs-12"></div>
    </div>

  </div>

  <div class="form-group row">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Ad<span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">
      <input type="text" id="first-name" required="required" name="icerik_ad" value="<?php echo $icerikcek['icerik_ad']; ?>" class="form-control col-md-12 col-xs-12">
    </div>
  </div>


  <div class="form-group row">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik <span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">

      <textarea  class="ckeditor" id="editor1" name="icerik_detay"><?php echo $icerikcek['icerik_detay']; ?></textarea>

    </div>
  </div>

  <script type="text/javascript">


   CKEDITOR.replace( 'editor1',
   {
    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    forcePasteAsPlainText: true
  } 
  );
</script>

  <div class="form-group row">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Özet<span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">
      <input type="text" id="first-name" required="required" name="icerik_ozet" value="<?php echo $icerikcek['icerik_ozet']; ?>" class="form-control col-md-12 col-xs-12">
    </div>
  </div>

<div class="form-group row">
  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Keyword<span class="required">*</span>
  </label>
  <div class="col-md-10 col-sm-9 col-xs-12">
    <input type="text" id="first-name" required="required" name="icerik_keyword" value="<?php echo $icerikcek['icerik_keyword']; ?>" class="form-control col-md-12 col-xs-12">
  </div>
</div>


<div class="form-group row">
  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Durum<span class="required">*</span>
  </label>
  <div class="col-md-10 col-sm-9 col-xs-12">
   <select id="heard" class="form-control" name="icerik_durum" required>

     <?php 
     if ($icerikcek['icerik_durum']==1) {?>

     <option value="1">Aktif</option>
     <option value="0">Pasif</option>

     <?php

   } else {?>
   <option value="0">Pasif</option>
   <option value="1">Aktif</option>


   <?php }
   ?>


 </select>
</div>
</div>


<div class="form-group row">
  <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">İçerik Öne Çıkar<span class="required">*</span>
  </label>
  <div class="col-md-10 col-sm-9 col-xs-12">
   <select id="heard" class="form-control" name="icerik_onecikar" required>

     <?php 
     if ($icerikcek['icerik_onecikar']==1) {?>

     <option value="1">Evet</option>
     <option value="0">Hayır</option>

     <?php

   } else {?>
   <option value="0">Hayır</option>
   <option value="1">Evet</option>


   <?php }
   ?>


 </select>
</div>
</div>

<input type="hidden" name="icerik_id" value="<?php echo $icerikcek['icerik_id']; ?>">
<input type="hidden" name="icerik_resimyol" value="<?php echo $icerikcek['icerik_resimyol']; ?>">

<div align="right" class="col-md-12 col-sm-8 col-xs-12 col-md-offset-3">
  <button type="submit" name="icerikduzenle" class="btn btn-primary">Kaydet</button>
</div>

</form>





</div>

<!--Burada Bitecek-->




</div>
</div>



<?php include 'footer.php'; ?>