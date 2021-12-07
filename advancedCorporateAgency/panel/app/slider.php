<?php 

include 'header.php';

if(isset($_POST['arama'])) {

  $aranan=$_POST['aranan'];

  $slidersor=$db->prepare("select * from slider where slider_ad LIKE '%$aranan%' order by slider_durum DESC, slider_sira ASC limit 25");
  $slidersor->execute();
  $say=$slidersor->rowCount();

  
} else {


 $slidersor=$db->prepare("select * from slider order by slider_durum DESC, slider_sira ASC limit 25");
 $slidersor->execute();
 $say=$slidersor->rowCount();


}
?>


<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Slider Ayarları</h4>



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
form-group row row row row row
col-md-10 / col-md-10 
-->


<div>

<div align="right" class="col-md-12">
<a href="slider-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
</div><br>

  <div class="table-responsive">

<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <!--<th width="160" class="column-title">Slider Resim </th>-->
          <th class="column-title text-center" width="150">Slider Ad </th>
          <th class="column-title text-center">Açıklama </th>
          <th class="column-title text-center">Sıra </th>
          <th class="column-title text-center">Durum </th>
          <th width="80" class="column-title"></th>
          <th width="80" class="column-title"></th>


        </tr>
      </thead>

      <tbody>

        <?php 



        while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)) {
          ?>


          <tr>

            <!--<td><img width="200" height="100" src="../../<?php echo $slidercek['slider_resimyol']; ?>"></td>-->
            <td ><?php echo $slidercek['slider_ad']; ?></td>
            <td ><?php echo $slidercek['slider_aciklama']; ?></td>
            <td class="text-center"><?php echo $slidercek['slider_sira']; ?></td>
            <td class="text-center"><?php 

              if ($slidercek['slider_durum']=="1") {

               echo "AKTİF";
             } else {

              echo "PASİF";
            }

            ?></td>

            <td class="text-center"><a href="slider-duzenle.php?slider_id=<?php echo $slidercek['slider_id']; ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

            <td class="text-center"><a href="../netting/islem.php?slidersil=ok&slider_id=<?php echo $slidercek['slider_id']; ?>&slider_resimyol=<?php echo $slidercek['slider_resimyol']; ?>"><button style="width:80px;" class="btn btn-danger btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

          </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>

  </div>
  <!--Burada Bitecek-->




</div>
</div>



<?php include 'footer.php'; ?>