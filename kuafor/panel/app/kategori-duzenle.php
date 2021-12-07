<?php 
include 'header.php';
include '../netting/baglan.php';

$kategorisor=$db->prepare("SELECT * FROM kategori where kategori_id=:id");
$kategorisor->execute(array(
  'id' => $_GET['kategori_id']
  ));

$kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);


?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Kategori Düzenle</h4>
    <p class="mg-b-0">Bu bölüm de istediğiniz gibi kategori düzenlemesi yapabilirsiniz.</p>



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
form-group row row row row row row row row
col-md-10 / col-md-10 
-->


<div>
  <br />


  <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim<br>313x103 px<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <?php 
                    if (strlen($kategoricek['kategori_logo'])>0) {?>

                    <img width="200"  src="../../<?php echo $kategoricek['kategori_logo']; ?>">

                    <?php } else {?>


                    <img width="200"  src="../../dimg/logo-yok.png">


                    <?php } ?>

                    
                  </div>
                </div>

                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" id="first-name"  name="kategori_logo"  class="form-control col-md-11 col-xs-12">
                  </div>
                </div>

                <input type="hidden" name="eski_yol" value="<?php echo $kategoricek['kategori_logo']; ?>">
                <input type="hidden" name="kategori_id" value="<?php echo $kategoricek['kategori_id'] ?>"> 

                <div align="right" class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="kategori_logoduzenle" class="btn btn-primary">Güncelle</button>
                </div>

              </form>

  <br>
  <hr>
  <br>

  <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
  <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

    

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Ad <span class="required">*</span>
      </label>
      <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kategori_ad" value="<?php echo $kategoricek['kategori_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
      </div>
    </div>

    
    

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Sıra <span class="required">*</span>
      </label>
      <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kategori_sira" value="<?php echo $kategoricek['kategori_sira'] ?>" required="required" class="form-control col-md-7 col-xs-12">
      </div>
    </div>





    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Durum<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
       <select id="heard" class="form-control" name="kategori_durum" required>



                   <!-- Kısa İf Kulllanımı 

                    <?php echo $kategoricek['kategori_durum'] == '1' ? 'selected=""' : ''; ?>

                  -->




                  <option value="1" <?php echo $kategoricek['kategori_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>



                  <option value="0" <?php if ($kategoricek['kategori_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                  <!-- <?php 

                   if ($kategoricek['kategori_durum']==0) {?>


                   <option value="0">Pasif</option>
                   <option value="1">Aktif</option>


                   <?php } else {?>

                   <option value="1">Aktif</option>
                   <option value="0">Pasif</option>

                   <?php  }

                   ?> -->


                 </select>
               </div>
             </div>


             <input type="hidden" name="kategori_id" value="<?php echo $kategoricek['kategori_id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group row">
              <div align="right" class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="kategoriduzenle" class="btn btn-success">Güncelle</button>
              </div>
            </div>

          </form>



        </div>

        <!--Burada Bitecek-->




      </div>
    </div>


    <?php include 'footer.php'; ?>