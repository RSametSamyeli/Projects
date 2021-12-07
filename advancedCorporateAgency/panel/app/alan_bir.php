<?php 
include 'header.php';
include '../netting/baglan.php';
$alanbirsor=$db->prepare("select * from alanbir where alanbir_id=?");
$alanbirsor->execute(array(0));
$alanbircek=$alanbirsor->fetch(PDO::FETCH_ASSOC);

$alanikisor=$db->prepare("select * from alaniki where alaniki_id=?");
$alanikisor->execute(array(0));
$alanikicek=$alanikisor->fetch(PDO::FETCH_ASSOC);

?>


<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Metinsel İfadeler İşlemleri</h4>
    <p class="mg-b-0">Bu bölüm de istediğiniz gibi düzenleme yapabilirsiniz.</p>



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
form-group row row row row row row row row row row row
col-md-11 / col-md-11 
-->


<div>
               <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim<br>313x103 px<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <?php 
                    if (strlen($alanbircek['alanbir_logo'])>0) {?>

                    <img width="200"  src="../../<?php echo $alanbircek['alanbir_logo']; ?>">

                    <?php } else {?>


                    <img width="200"  src="../../dimg/logo-yok.png">


                    <?php } ?>

                    
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" id="first-name"  name="alanbir_logo"  class="form-control col-md-11 col-xs-12">
                  </div>
                </div>

                <input type="hidden" name="eski_yol" value="<?php echo $alanbircek['alanbir_logo']; ?>">

                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="alanbir_logoduzenle" class="btn btn-primary">Güncelle</button>
                </div>

              </form>




              
              <!-- ######################################## -->

             <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Konu Başlığı<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="alanbir_baslik" value="<?php echo $alanbircek['alanbir_baslik']; ?>" class="form-control col-md-11 col-xs-12">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Konu İçeriği<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="alanbir_detay" value="<?php echo $alanbircek['alanbir_detay']; ?>" class="form-control col-md-11 col-xs-12">
                  </div>
                </div>
                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="genelalanbirkaydet" class="btn btn-primary">Güncelle</button>
                </div>

              </form>




<hr>

               <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim<br>313x103 px<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <?php 
                    if (strlen($alanikicek['alaniki_logo'])>0) {?>

                    <img width="200"  src="../../<?php echo $alanikicek['alaniki_logo']; ?>">

                    <?php } else {?>


                    <img width="200"  src="../../dimg/logo-yok.png">


                    <?php } ?>

                    
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" id="first-name"  name="alaniki_logo"  class="form-control col-md-11 col-xs-12">
                  </div>
                </div>

                <input type="hidden" name="eski_yol" value="<?php echo $alanikicek['alaniki_logo']; ?>">

                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="alaniki_logoduzenle" class="btn btn-primary">Güncelle</button>
                </div>

              </form>




              
              <!-- ######################################## -->




              <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Konu Başlığı<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="alaniki_baslik" value="<?php echo $alanikicek['alaniki_baslik']; ?>" class="form-control col-md-11 col-xs-12">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Konu İçeriği<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" name="alaniki_detay" value="<?php echo $alanikicek['alaniki_detay']; ?>" class="form-control col-md-11 col-xs-12">
                  </div>
                </div>
                <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="genelalanikikaydet" class="btn btn-primary">Güncelle</button>
                </div>

              </form>



            </div>

<!--Burada Bitecek-->




</div>
</div>


<?php include 'footer.php'; ?>