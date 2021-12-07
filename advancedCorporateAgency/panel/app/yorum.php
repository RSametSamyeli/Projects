<?php 

include 'header.php'; 

//Belirli veriyi seçme işlemi
$yorumsor=$db->prepare("SELECT * FROM yorumlar order by yorum_id DESC");
$yorumsor->execute();


?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Yorum İşlemleri</h4>
    <p class="mg-b-0">Bu bölüm de gönderilmiş yorumları görebilirsiniz. Aynı zaman da onay verebilir yada silebilirsiniz..</p>



    <p class="mg-b-0">

      <?php
      if ($_GET['sil']=='ok') {?> 

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

      <?php } elseif ($_GET['sil']=='no')  {?>

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
form-group row row row row row row
col-md-10 / col-md-10 
-->


<div>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">
          <th>S.No</th>
          <th>Ad Soyad</th>
          <th>E-Mail</th>
          <th>GSM</th>
          <th>Konu</th>
          <th>Mesaj</th>
          <th>Mesaj Tarihi</th>
          <th></th>
        </tr>
      </thead>

      <tbody>

        <?php 

        $say=0;

        while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) { $say++?>


        <tr>
         <td width="20"><?php echo $say ?></td>


         <?php if ($yorumcek['kullanici_id']==0) {?>
         <td><?php echo $yorumcek['adsoyad'] ?></td>
         <?php }else{ ?>
         <td><a href="../app/kullanici-duzenle.php?kullanici_id=<?php echo $yorumcek['kullanici_id']; ?>"><strong><?php echo $yorumcek['adsoyad'] ?></strong></a></td>
         <?php } ?>


         <!-- Yorum Sahibi Başlangıç -->
         <td><?php echo $yorumcek['email'] ?></td>
         <!-- Yorum Sahibi Bitiş -->
         <td><?php echo $yorumcek['gsm'] ?></td>
         <td><?php echo $yorumcek['konu'] ?></td>
         <td><?php echo htmlspecialchars($yorumcek['yorum_detay']) ?></td>


         <?php 

         $zaman=explode(" ",$yorumcek['yorum_zaman']); ?> 
         <td><?php echo $zaman[0] ?></td>

         <td><center><a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorumsil=ok"><button class="btn btn-danger btn-sm">Sil</button></a></center></td>
       </tr>



       <?php  }

       ?>


     </tbody>
   </table>

   <!-- Div İçerik Bitişi -->


 </div>

 <!--Burada Bitecek-->



</div>
</div>


<?php include 'footer.php'; ?>