<?php 
include 'header.php';
include '../netting/baglan.php';
$hakkimizdasor=$db->prepare("select * from hakkimizda where hakkimizda_id=?");
$hakkimizdasor->execute(array(0));
$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

?>


<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">İletişim Ayarları</h4>
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
        </div><!-- d-flex -->
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
        </div><!-- d-flex -->
      </div>

      <?php } ?>

    </p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">



<!--Buraya Yapıştırılacak
form-group row row row row row
col-md-10 / col-md-10 
-->


<div>

  <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

    <div class="form-group row">
      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Başlık<span class="required">*</span>
      </label>
      <div class="col-md-10 col-sm-9 col-xs-12">
        <input type="text" id="first-name" required="required" name="hakkimizda_baslik" value="<?php echo $hakkimizdacek['hakkimizda_baslik']; ?>" class="form-control col-md-10 col-xs-12">
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-md-2 col-sm-3 col-xs-12" for="first-name">İçerik<br>
        
      </label>
      <div class="col-md-10 col-sm-9 col-xs-12">

        <textarea  class="ckeditor" id="editor1" name="hakkimizda_icerik"><?php echo $hakkimizdacek['hakkimizda_icerik']; ?></textarea>
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
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Video<span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">
      <input type="text" id="first-name" required="required" name="hakkimizda_video" value="<?php echo $hakkimizdacek['hakkimizda_video']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>



  <div class="form-group row">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Vizyon <span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">
      <input type="text" id="first-name" required="required" name="hakkimizda_vizyon" value="<?php echo $hakkimizdacek['hakkimizda_vizyon']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>

  <div class="form-group row">
    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Misyon <span class="required">*</span>
    </label>
    <div class="col-md-10 col-sm-9 col-xs-12">
      <input type="text" id="first-name" required="required" name="hakkimizda_misyon" value="<?php echo $hakkimizdacek['hakkimizda_misyon']; ?>" class="form-control col-md-10 col-xs-12">
    </div>
  </div>

  <div align="right" class="col-md-10 col-sm-9 col-xs-12 col-md-offset-3">
    <button type="submit" name="hakkimizdakaydet" class="btn btn-primary">Güncelle</button>
  </div>

</form>



</div>
<!--Burada Bitecek-->




</div>
</div>



<?php include 'footer.php'; ?>