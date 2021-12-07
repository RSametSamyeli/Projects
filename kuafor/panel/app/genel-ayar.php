<?php 
include 'header.php';
include '../netting/baglan.php';
$ayarsor=$db->prepare("select * from ayar where ayar_id=?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);
?>


<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Genel Ayarlar</h4>
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
    


<!--Buraya Yapıştırılacak-->
<div>

               <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Logo<br>313x103 px<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">

                    <?php 
                    if (strlen($ayarcek['ayar_logo'])>0) {?>

                    <img width="200"  src="../../<?php echo $ayarcek['ayar_logo']; ?>">

                    <?php } else {?>


                    <img width="200"  src="../../dimg/logo-yok.png">


                    <?php } ?>

                    
                  </div>
                </div>

                <div class="form-group row row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="file" id="first-name"  name="ayar_logo"  class="form-control col-md-10 col-xs-12">
                  </div>
                </div>

                <input type="hidden" name="eski_yol" value="<?php echo $ayarcek['ayar_logo']; ?>">

                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="logoduzenle" class="btn btn-primary">Güncelle</button>
                </div>

              </form>




              
              <!-- ######################################## -->





              <hr><br>
              <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site Adresi<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="ayar_siteurl" value="<?php echo $ayarcek['ayar_siteurl']; ?>" class="form-control col-md-10 col-xs-12">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site Başlığı <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="ayar_title" value="<?php echo $ayarcek['ayar_title']; ?>" class="form-control col-md-10 col-xs-12">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site Açıklaması <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="ayar_description" value="<?php echo $ayarcek['ayar_description']; ?>" class="form-control col-md-10 col-xs-12">
                  </div>
                </div>



                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site Antar Kelimeler <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="ayar_keywords" value="<?php echo $ayarcek['ayar_keywords']; ?>" class="form-control col-md-10 col-xs-12">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site Yazar <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="ayar_author" value="<?php echo $ayarcek['ayar_author']; ?>" class="form-control col-md-10 col-xs-12">
                  </div>
                </div>

                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="genelayarkaydet" class="btn btn-primary">Güncelle</button>
                </div>

              </form>



            

<!--Burada Bitecek-->




  </div>
            </div>
            


            <?php include 'footer.php'; ?>