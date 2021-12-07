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
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Ürün Ekle</h4>
    <p class="mg-b-0">Bu bölüm de istediğiniz gibi ürün oluşturabilirsiniz.</p>



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
form-group row row row row row row row row row row
col-md-9 / col-md-9 
-->


<div>
  <br />

  <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
  <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">



    <!-- Kategori seçme başlangıç -->


    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Seç<span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-6">

        <?php  

        $urun_id=$uruncek['kategori_id']; 

        $kategorisor=$db->prepare("select * from kategori where kategori_ust=:kategori_ust order by kategori_sira");
        $kategorisor->execute(array(
          'kategori_ust' => 0
        ));

        ?>
        <select class="select2_multiple form-control" required="" name="kategori_id" >


         <?php 

         while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) {

           $kategori_id=$kategoricek['kategori_id'];

           ?>

           <option  value="<?php echo $kategoricek['kategori_id']; ?>"><?php echo $kategoricek['kategori_ad']; ?></option>

           <?php } ?>

         </select>
       </div>
     </div>


     <!-- kategori seçme bitiş -->


     <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Ad <span class="required">*</span>
      </label>
      <div class="col-md-7 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="urun_ad" placeholder="Ürün adını giriniz" required="required" class="form-control col-md-10 col-xs-12">
      </div>
    </div>

    <!-- Ck Editör Başlangıç -->

    <div class="form-group row">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Detay <span class="required">*</span>
      </label>
      <div class="col-md-7 col-sm-6 col-xs-12">

        <textarea  class="ckeditor" id="editor1" name="urun_detay"></textarea>
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

  <!-- Ck Editör Bitiş -->


  <div class="form-group row">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Fiyat <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="first-name" name="urun_fiyat" placeholder="Ürün fiyat giriniz"  class="form-control col-md-10 col-xs-12">
    </div>
  </div>
<!--
              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Video <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_video" placeholder="Ürün video giriniz" class="form-control col-md-10 col-xs-12">
                </div>
              </div>-->

              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Keyword <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_keyword" placeholder="Ürün keyword giriniz" required="required" class="form-control col-md-10 col-xs-12">
                </div>
              </div>
<!--
              <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Stok <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_stok" placeholder="Ürün stok giriniz" required="required" class="form-control col-md-10 col-xs-12">
                </div>
              </div>
            -->


            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Durum<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
               <select id="heard" class="form-control" name="urun_durum" required>


                <option value="1" >Aktif</option>
                <option value="0" >Pasif</option>
                


              </select>
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group row">
            <div align="right" class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" name="urunekle" class="btn btn-success">Kaydet</button>
            </div>
          </div>

        </form>



      </div>

      <!--Burada Bitecek-->




    </div>
  </div>


  <?php include 'footer.php'; ?>