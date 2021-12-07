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
form-group row row
col-md-9 / col-md-9 
-->


<div>

                <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telefon Numaranız<span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_tel" value="<?php echo $ayarcek['ayar_tel']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Gsm Numaranız <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_gsm" value="<?php echo $ayarcek['ayar_gsm']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Faks Numaranız <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_faks" value="<?php echo $ayarcek['ayar_faks']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail Adresiniz <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_mail" value="<?php echo $ayarcek['ayar_mail']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Adresiniz <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_adres" value="<?php echo $ayarcek['ayar_adres']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                   <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İlçe <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_ilce" value="<?php echo $ayarcek['ayar_ilce']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                   <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İl <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_il" value="<?php echo $ayarcek['ayar_il']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                   <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mesai Saatleri <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="ayar_mesai" value="<?php echo $ayarcek['ayar_mesai']; ?>" class="form-control col-md-11 col-xs-12">
                    </div>
                  </div>

                  <div align="right" class="col-md-11 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="iletisimayarkaydet" class="btn btn-primary">Güncelle</button>
                  </div>

                </form>



              </div>
<!--Burada Bitecek-->




  </div>
            </div>
            


            <?php include 'footer.php'; ?>