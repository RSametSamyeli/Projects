<?php 
include 'header.php';
include '../netting/baglan.php';

$videosor=$db->prepare("SELECT * from video where video_id=:video_id");
$videosor->execute(array(
  'video_id' => $_GET['video_id']
  ));
$videocek=$videosor->fetch(PDO::FETCH_ASSOC);

?>
<head>  
  <script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
</head>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Video İşlemleri</h4>
    <p class="mg-b-0">Eklemek istediğiniz videonun YouTube kodunu ekleyerek hızlıca video ekleyebilirsiniz.</p>



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


              <?php


              if ($_GET['youtube']=="ok") {

                ?>

                <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


                  <input type="hidden" name="video_id" value="<?php echo $videocek['video_id']; ?>">
                  <input type="hidden" name="video_resimyol" value="<?php echo $videocek['video_resimyol']; ?>">

                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Video Ad<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="first-name" required="required" name="video_ad" disabled="" value="<?php echo $videocek['video_ad']; ?>" class="form-control col-md-12 col-xs-12">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Yüklü Resim<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <img width="200" height="100" src="../../<?php echo $videocek['video_resimyol']; ?>">
                    </div>
                  </div>

                  

                  


                  <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Çekilen Video<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <iframe width="400" height="225" src="https://www.youtube.com/embed/<?php echo $videocek['video_code']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                  </div>



                

                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                   <a class="btn btn-success" href="video-yukle.php">Yeni Ekle</a>
                </div>

              </form>

              <?php } else {   ?>



              <form action="../netting/video.php" method="POST"  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


                <div class="form-group row">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Video Kodu<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" name="video_code" placeholder="Youtube Video Kodu..." class="form-control col-md-12 col-xs-12">
                  </div>
                </div>

                <div align="right" class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="videocek" class="btn btn-primary">Video Çek</button>
                </div>


                <?php } ?>

              </div>

<!--Burada Bitecek-->




</div>
</div>



<?php include 'footer.php'; ?>