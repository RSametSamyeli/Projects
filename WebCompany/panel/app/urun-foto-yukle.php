<?php 

include 'header.php';


?>






<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">




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

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
           <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Çoklu Resim Yükleme İşlemleri</h4>
           <p class="mg-b-0">Bu bölüm de çoklu resim yükleme işlemi yapabilirsiniz. Yüklenecek resimlerin ana dizinine girerek tamamını tek seferde veya tek tek yükleme yapabilirsiniz.</p>

           <br> 

           <div align="right" class="col-md-12">

            <a class="btn btn-success" href="urun-galeri.php?urun_id=<?php echo $_GET['urun_id'];?>">
              <i class="fa fa-plus" aria-hidden="true"></i> Yüklenen Resimleri Gör</a>
            </div>
            <br>
            <br>

            <div class="x_content">


              <form action="../netting/urungaleri.php" class="dropzone" >

                <input type="hidden" name="urun_id" value="<?php echo $_GET['urun_id'];  ?>">

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
</div>
</div>

</div>
</div>
</div>
</div>
<!-- /page content -->



<?php include 'footer.php'; ?>
