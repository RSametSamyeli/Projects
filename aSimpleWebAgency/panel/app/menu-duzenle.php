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
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Menü İşlemleri</h4>
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
form-group row row row row row row row
col-md-10 / col-md-10 
-->


<div>

                <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


                  <input type="hidden" name="menu_id" value="<?php echo $_GET['menu_id']; ?>">


                  <div class="form-group row">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Üst Menü Seç</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">

                     <select class="select2_single form-control" required="" name="menu_ust" tabindex="-1">
                       <?php

                       if ($menucek['menu_ust']=="0") {?>

                       <option value="0" selected="selected">Üst Menü</option>


                       <?php } else {


                         $menu_id=$menucek['menu_ust'];
                         $secmenusor=$db->prepare("SELECT * from menu where menu_id=:menu_id");
                         $secmenusor->execute(array(
                          'menu_id' => $menu_id
                          ));
                         $secmenucek=$secmenusor->fetch(PDO::FETCH_ASSOC);
                         ?>

                         <option value="<?php echo $secmenucek['menu_id']; ?>" selected="selected";><?php echo $secmenucek['menu_ad']; ?></option>

                         <option value="0" >Üst Menü Yap</option>


                         <?php }

                         ?>



                         <?php 
                         $ustmenusor=$db->prepare("select * from menu where menu_ust=:menu_ust order by menu_sira");
                         $ustmenusor->execute(array(
                          'menu_ust' => 0
                          ));

                         while($ustmenucek=$ustmenusor->fetch(PDO::FETCH_ASSOC)) {
                          ?>

                          <option value="<?php echo $ustmenucek['menu_id']; ?>"><?php echo $ustmenucek['menu_ad']; ?></option>


                          <?php } ?>

                        </select>
                      </div>
                    </div>

                    <!-- selected="selected" -->



                    <div class="form-group row">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Menü Ad<span class="required">*</span>
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" id="first-name" required="required" name="menu_ad" value="<?php echo $menucek['menu_ad']; ?>" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Menü  Url<span class="required">*</span>
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" id="first-name"  name="menu_url" value="<?php echo $menucek['menu_url']; ?>" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Menü Detay <span class="required">*</span>
                      </label>
                      <div class="col-md-10 col-sm-9 col-xs-12">

                        <textarea  class="ckeditor" id="editor1" name="menu_detay"><?php echo $menucek['menu_detay']; ?></textarea>

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
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Menü Sıra<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                      <input type="text" id="first-name" required="required" name="menu_sira" value="<?php echo $menucek['menu_sira']; ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>




                  <div class="form-group row">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Menü Durum<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                     <select id="heard" class="form-control" name="menu_durum" required>
                      <option value="1">Aktif</option>
                      <option value="0">Pasif</option>

                    </select>
                  </div>
                </div>

                <div align="right" class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                  <button type="submit" name="menuduzenle" class="btn btn-primary">Kaydet</button>
                </div>

              </form>



            </div>

<!--Burada Bitecek-->




</div>
</div>


<?php include 'footer.php'; ?>