<?php 
include 'header.php';
include '../netting/baglan.php';

$menusor=$db->prepare("SELECT * from menu where menu_id=:menu_id");
$menusor->execute(array(
  'menu_id' => $_GET['menu_id']
  ));
$menucek=$menusor->fetch(PDO::FETCH_ASSOC);

?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Kategori Ekle</h4>
    <p class="mg-b-0">Bu bölüm de istediğiniz gibi menü veya sayfa oluşturabilirsiniz.</p>



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
form-group row row row row row row row row row
col-md-9 / col-md-9 
-->


<div>
  <br />

  <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
  <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Ad <span class="required">*</span>
      </label>
      <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kategori_ad" placeholder="Kategori adını giriniz" required="required" class="form-control col-md-7 col-xs-12">
      </div>
    </div>




    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Sıra <span class="required">*</span>
      </label>
      <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="kategori_sira" placeholder="Sıra giriniz" required="required" class="form-control col-md-7 col-xs-12">
      </div>
    </div>





    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Durum<span class="required">*</span>
      </label>
      <div class="col-md-5 col-sm-6 col-xs-12">
       <select id="heard" class="form-control" name="kategori_durum" required>




        <option value="1">Aktif</option>



        <option value="0" >Pasif</option>



      </select>
    </div>
  </div>


  <input type="hidden" name="kategori_id" value="<?php echo $kategoricek['kategori_id'] ?>"> 


  <div class="ln_solid"></div>
  <div class="form-group row">
    <div align="right" class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
      <button type="submit" name="kategoriekle" class="btn btn-success">Kaydet</button>
    </div>
  </div>

</form>



</div>

<!--Burada Bitecek-->




</div>
</div>


<?php include 'footer.php'; ?>