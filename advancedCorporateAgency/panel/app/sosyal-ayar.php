<?php 
include 'header.php';
include '../netting/baglan.php';
$ayarsor=$db->prepare("select * from ayar where ayar_id=?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);
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
form-group row row row
col-md-9 / col-md-9 
-->


<div>

                <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Facebook<span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" placeholder="Facebook adresinizi giriniz..." name="ayar_facebook" value="<?php echo $ayarcek['ayar_facebook']; ?>" class="form-control col-md-10 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Twitter<span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" placeholder="Twitter adresinizi giriniz..." name="ayar_twitter" value="<?php echo $ayarcek['ayar_twitter']; ?>" class="form-control col-md-10 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Youtube<span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" placeholder="Google adresinizi giriniz..." name="ayar_youtube" value="<?php echo $ayarcek['ayar_youtube']; ?>" class="form-control col-md-10 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Google<span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" placeholder="Google adresinizi giriniz..." name="ayar_google" value="<?php echo $ayarcek['ayar_google']; ?>" class="form-control col-md-10 col-xs-12">
                    </div>
                  </div>

                


                  

                  <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="sosyalayarkaydet" class="btn btn-primary">Güncelle</button>
                  </div>

                </form>



              </div>
<!--Burada Bitecek-->




  </div>
            </div>
            


            <?php include 'footer.php'; ?>